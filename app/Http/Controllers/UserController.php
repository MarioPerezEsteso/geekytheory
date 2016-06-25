<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Validator;

class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * UserController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->repository = $userRepository;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id = null)
    {
        $user = null;
        if (!$id) {
            $user = $this->repository->getCurrentUser();
        } else {
            $user = $this->repository->findOrFail($id);
        }
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
        $user = $this->repository->findOrFail($id);

        $rules = array(
            'name'      => 'required',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'username'  => 'required|unique:users,username,' . $user->id,
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('home/profile/' . $user->id)->withErrors($validator->messages());
        } else {
            $user->update($request->except('_token'));
        }

        return Redirect::to('home/profile/' . $user->id)->withSuccess(trans('auth.user_update_success'));
    }

    /**
     * Get a Gravatar URL or complete image tag for a specified email address.
     *
     * @param string $email The email address
     * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
     * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
     * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
     * @return String containing Gravatar URL
     * @source http://gravatar.com/site/implement/images/php/
     */
    public static function getGravatar($email, $s = '100', $d = 'mm', $r = 'g')
    {
        $url = '//www.gravatar.com/avatar/';
        $url .= md5(strtolower(trim($email)));
        $url .= "?s=$s&d=$d&r=$r";
        return $url;
    }
}
