<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
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
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id = null)
    {
        if (!$id) {
            $user = User::with('userMeta')->findOrFail(Auth::id());
        } else {
            $user = User::with('userMeta')->findOrFail($id);
        }

        // The $user variable cant be sent as 'user' because there is already a 'user' 
        // variable shared to all the views.
        return view('home.profile.profile', ['userProfile' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::with('userMeta')->findOrFail($id);

        $userValidatorPasses = $this->userValidator->update($id)->with($request->user)->passes();
        $userMetaValidatorPasses = $this->userMetaValidator->update($id)->with($request->usermeta)->passes();
        if (!$userValidatorPasses || !$userMetaValidatorPasses) {
            $errors = new MessageBag();
            $errors->merge($this->userValidator->errors());
            $errors->merge($this->userMetaValidator->errors());

            return Redirect::to('home/profile/' . $user->id)->withErrors($errors);
        } else {
            $user->update($request->user);
            $user->userMeta()->update($request->usermeta);
        }

        return Redirect::to('home/profile/' . $user->id)->withSuccess(trans('auth.user_update_success'));
    }
}
