<?php

namespace App\Repositories;

interface UserRepositoryInterface
{

    public function findUserByUsername ($username);

}