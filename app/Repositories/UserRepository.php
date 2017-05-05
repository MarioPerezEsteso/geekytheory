<?php

namespace App\Repositories;

use Auth;
use App\User;

class UserRepository extends Repository implements UserRepositoryInterface
{

    /**
     * Model class name
     *
     * @var string
     */
    protected $modelClassName = 'App\User';

    /**
     * Find user by its username.
     *
     * @param $username
     * @return User
     */
    public function findUserByUsername($username)
    {
        return call_user_func_array("{$this->modelClassName}::where", array('username', $username))->firstOrFail();;
    }

    /**
     * Get current logged in user.
     *
     * @return User
     */
    public function getCurrentUser()
    {
        return Auth::user();
    }

}