<?php

namespace App\Http\Controllers;

use App\Subscription;
use App\User;
use App\Validators\SubscriptionValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\MessageBag;
use Stripe\Error\Card;

class SubscriptionController extends Controller
{
    /** @var SubscriptionValidator */
    protected $subscriptionValidator;

    /**
     * Controller constructor.
     *
     * @param SubscriptionValidator $subscriptionValidator
     */
    public function __construct(SubscriptionValidator $subscriptionValidator)
    {
        $this->subscriptionValidator = $subscriptionValidator;
    }

    /**
     * Show subscription page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        /** @var User $loggedUser */
        $loggedUser = Auth::user();

        return view('account.subscriptions.subscription', compact('loggedUser'));
    }

    /**
     * Create a new subscription.
     *
     * @param Request $request
     * @return \Stripe\Subscription
     */
    public function store(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$this->subscriptionValidator->with($request->all())->passes()) {
            return redirect()->route('account.subscription')->withErrors($this->subscriptionValidator->errors());
        }

        if ($user->hasSubscriptionActive()) {
            $errors = new MessageBag([
                'subscription_error' => trans('home.subscription_already_active'),
            ]);

            return redirect()->route('account.subscription')->withErrors($errors);
        }

        try {
            /** @var \Stripe\Subscription $subscription */
            $user->newSubscription(Subscription::PLAN_NAME, Subscription::PLAN_MONTHLY)
                ->skipTrial()
                ->create($request->stripe_token, [
                    'email' => $user->email,
                    'metadata' => [
                        'ip' => getClientIPAddress(),
                    ]
                ]);
        } catch (\Exception $exception) {
            $errors = new MessageBag();
            if ($exception instanceof Card) {
                $stripeCode = $exception->getStripeCode();
                switch ($stripeCode) {
                    case 'card_declined':
                        $errorMessage = trans('home.credit_card_not_valid');
                        break;
                    case 'incorrect_cvc':
                        $errorMessage = trans('home.credit_card_cvv_incorrect');
                        break;
                    case 'expired_card':
                        $errorMessage = trans('home.credit_card_expired');
                        break;
                    case 'incorrect_zip':
                        $errorMessage = trans('home.incorrect_zip');
                        break;
                    case 'processing_error':
                    default:
                        $errorMessage = trans('home.stripe_processing_error');
                        break;
                }
                $errors->add('stripe_error', $errorMessage);
            } else {
                $errors->add('stripe_error', trans('home.stripe_processing_error'));
            }

            return redirect()->route('account.subscription')->withErrors($errors);
        }

        // Response
        return redirect()->route('account.subscription')->withSuccess(trans('home.subscription_created'));
    }

    /**
     * Show subscription payment method view.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showPaymentMethod(Request $request)
    {
        /** @var User $loggedUser */
        $loggedUser = Auth::user();

        if (!$loggedUser->hasSubscriptionActive()) {
            return redirect()->route('account.subscription');
        }

        return view('account.subscriptions.paymentMethod', compact('loggedUser'));
    }

    /**
     * Update user card.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function updateCard(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user->hasSubscriptionActive()) {
            return redirect()
                ->route('account.subscription.payment-method')
                ->withErrors(new MessageBag(['subscription' => trans('home.subscription_needed_to_update_card')]));
        }

        if (!$this->subscriptionValidator->validateCreditCardUpdate()->with($request->all())->passes()) {
            return redirect()
                ->route('account.subscription.payment-method')
                ->withErrors(new MessageBag(['validation' => trans('home.subscription_error_updating_card')]));
        }

        try {
            $user->updateCard($request->stripe_token);
        } catch (\Exception $exception) {
            $errors = new MessageBag();
            if ($exception instanceof Card) {
                $stripeCode = $exception->getStripeCode();
                switch ($stripeCode) {
                    case 'card_declined':
                        $errorMessage = trans('home.credit_card_not_valid');
                        break;
                    case 'incorrect_cvc':
                        $errorMessage = trans('home.credit_card_cvv_incorrect');
                        break;
                    case 'expired_card':
                        $errorMessage = trans('home.credit_card_expired');
                        break;
                    case 'incorrect_zip':
                        $errorMessage = trans('home.incorrect_zip');
                        break;
                    case 'processing_error':
                    default:
                        $errorMessage = trans('home.stripe_processing_error');
                        break;
                }
                $errors->add('stripe_error', $errorMessage);
            } else {
                $errors->add('stripe_error', trans('home.stripe_processing_error'));
            }

            return redirect()->route('account.subscription.payment-method')->withErrors($errors);
        }

        return redirect()->route('account.subscription.payment-method')->withSuccess(trans('home.subscription_card_updated'));
    }

    /**
     * Cancel a subscription.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function cancel(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        if (!Hash::check($request->password, $user->password)) {
            return redirect()->route('account.subscription')->withErrors(
                new MessageBag([
                    'password' => 'home.password_incorrect',
                ])
            );
        }

        /** @var Subscription $subscription */
        $subscription = $user->subscription(Subscription::PLAN_NAME);

        if (is_null($subscription) || !$subscription->active()) {
            return redirect()->route('account.subscription')->withErrors(
                new MessageBag([
                    'subscription_error' => trans('home.subscription_needed_to_cancel_it')
                ])
            );
        }

        $subscription->cancelNow();

        return redirect()->route('account.subscription')->withSuccess('home.subscription_canceled');
    }
}
