<?php

namespace App\Http\Controllers;

use App\Subscription;
use App\User;
use App\Validators\SubscriptionValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        if ($request->subscription_plan === Subscription::PLAN_MONTHLY) {
            $subscriptionPlan = Subscription::PLAN_MONTHLY;
        } else {
            $subscriptionPlan = Subscription::PLAN_YEARLY;
        }

        try {
            /** @var \Stripe\Subscription $subscription */
            $user->newSubscription(Subscription::PLAN_NAME, $subscriptionPlan)
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
     * Update a subscription.
     *
     * @param Request $request
     * @return \Stripe\Subscription
     */
    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$this->subscriptionValidator->update()->with($request->all())->passes()) {
            return redirect()->route('account.subscription')->withErrors($this->subscriptionValidator->errors());
        }

        $subscriptionPlan = $request->subscription_plan === Subscription::PLAN_MONTHLY ? Subscription::PLAN_MONTHLY : Subscription::PLAN_YEARLY;

        /** @var Subscription $subscription */
        $subscription = $user->subscription(Subscription::PLAN_NAME);

        if (is_null($subscription)) {
            $errors = new MessageBag([
                'subscription_error' => trans('home.you_do_not_have_an_active_subscription'),
            ]);

            return redirect()->route('account.subscription')->withErrors($errors);
        }

        if ($subscription->stripe_plan === $subscriptionPlan) {
            $errors = new MessageBag([
                'subscription_error' => trans('home.you_cannot_update_subscription_plan_to_same_active'),
            ]);

            return redirect()->route('account.subscription')->withErrors($errors);
        }

        try {
            $subscription->swap($subscriptionPlan);
        } catch (\Exception $exception) {
            $errors = new MessageBag([
                'stripe_error' => trans('home.stripe_processing_error'),
            ]);

            return redirect()->route('account.subscription')->withErrors($errors);
        }

        // Response
        if ($subscriptionPlan === Subscription::PLAN_MONTHLY) {
            $successMessage = 'home.subscription_updated_from_yearly_to_monthly';
        } else {
            $successMessage = 'home.subscription_updated_from_monthly_to_yearly';
        }

        return redirect()->route('account.subscription')->withSuccess(trans($successMessage));
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
}
