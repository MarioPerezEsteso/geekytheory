<?php

namespace App\Repositories;

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
     * Find user by its username
     *
     * @param $username
     * @return User
     */
    public function findUserByUsername($username)
    {
        return call_user_func_array("{$this->modelClassName}::where", array('username', $username))->firstOrFail();;
    }
}