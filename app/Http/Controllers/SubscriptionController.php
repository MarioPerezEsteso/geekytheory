<?php

namespace App\Http\Controllers;

use App\Subscription;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;
use Stripe\Error\Card;

class SubscriptionController extends Controller
{

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

        if ($user->hasSubscriptionActive()) {
            $errors = new MessageBag([
                'subscription_error' => trans('home.subscription_already_active'),
            ]);

            return redirect()->route('account.subscription')->withErrors($errors);
        }

        $subscriptionPlan = Subscription::PLAN_YEARLY;
        $subscriptionPlanName = Subscription::PLAN_YEARLY_NAME;

        if ($request->subscription_plan === 'monthly') {
            $subscriptionPlan = Subscription::PLAN_MONTHLY;
            $subscriptionPlanName = Subscription::PLAN_MONTHLY_NAME;
        }

        try {
            /** @var \Stripe\Subscription $subscription */
            $user->newSubscription($subscriptionPlanName, $subscriptionPlan)
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
}
