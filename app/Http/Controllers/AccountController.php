<?php

namespace App\Http\Controllers;

use App\Course;
use App\User;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    /**
     * Show the index page of the account section.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $courses = Course::getPublishedAndScheduled()->get();

        /** @var User $user */
        $user = Auth::user();
        $userHasSubscriptionActive = $user->hasSubscriptionActive();

        return view('account.index', compact('courses', 'userHasSubscriptionActive'));
    }
}
