<?php

namespace App\Http\Controllers;

use App\Subscription;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
}
