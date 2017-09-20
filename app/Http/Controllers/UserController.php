<?php

namespace App\Http\Controllers;

use App\UserMeta;
use Illuminate\Http\Request;
use App\User;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Validators\UserValidator;
use App\Validators\UserMetaValidator;
use Illuminate\Support\MessageBag;

class UserController extends Controller
{
    /**
     * User validator
     *
     * @var UserValidator
     */
    private $userValidator;

    /**
     * User meta validator
     *
     * @var UserMetaValidator
     */
    private $userMetaValidator;

    /**
     * UserController constructor.
     *
     * @param UserValidator $userValidator
     * @param UserMetaValidator $userMetaValidator
     */
    public function __construct(UserValidator $userValidator, UserMetaValidator $userMetaValidator)
    {
        $this->userValidator = $userValidator;
        $this->userMetaValidator = $userMetaValidator;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = User::with('userMeta')->findOrFail(Auth::id());

        // The $user variable cant be sent as 'user' because there is already a 'user' 
        // variable shared to all the views.
        return view('account.profile.profile', ['userProfile' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = User::with('userMeta')->findOrFail(Auth::id());

        $userValidatorPasses = $this->userValidator->update($user->id)->with($request->user)->passes();
        $userMetaValidatorPasses = $this->userMetaValidator->update($user->id)->with($request->usermeta)->passes();
        if (!$userValidatorPasses || !$userMetaValidatorPasses) {
            $errors = new MessageBag();
            $errors->merge($this->userValidator->errors());
            $errors->merge($this->userMetaValidator->errors());

            return redirect()->route('account.profile')->withErrors($errors)->withInput();
        } else {
            $user->update($request->user);
            if (!empty($request->usermeta)) {
                if (!$user->userMeta) {
                    $userMeta = new UserMeta($request->usermeta);
                    $userMeta->user_id = $user->id;
                    $userMeta->save();
                } else {
                    $user->userMeta()->update($request->usermeta);
                }
            }
        }

        return redirect()->route('account.profile')->withSuccess(trans('auth.user_update_success'));
    }

    /**
     * Show screen to change the password of a user.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editPassword()
    {
        return view('account.profile.changePassword');
    }

    /**
     * Format username to be alphanumeric
     *
     * @param string $username
     * @return string
     */
    public static function formatUsername($username)
    {
        $username = normalizeChars($username);
        return preg_replace("/[^a-zA-Z0-9]+/", "", $username);
    }
}
