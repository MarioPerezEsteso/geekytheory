<?php

namespace App\Validators;

use App\Validators\Base\LaravelValidator;
use App\Validators\Base\ValidableInterface;

class UserValidator extends LaravelValidator implements ValidableInterface
{
    /**
     * Validation rules for creating a User.
     */
    protected $rules = [
		'name' => 'required',
		'email' => 'required|email|unique:users,email',
		'username' => 'required|unique:users,username',
		'nicename' => 'required|unique:users,nicename',
	];

    /**
     * Modify the rules for updating a User.
     *
     * @param null $id
     * @return $this|ValidableInterface
     */
    public function update($id = null)
    {
        return [
			'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'username' => 'required|unique:users,username,' . $id,
		];
    }
}