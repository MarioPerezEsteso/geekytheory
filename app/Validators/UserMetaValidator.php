<?php

namespace App\Validators;

use App\Validators\Base\LaravelValidator;
use App\Validators\Base\ValidableInterface;

class UserMetaValidator extends LaravelValidator implements ValidableInterface
{
    /**
     * Validation rules for creating the metadata of a User.
     */
    protected $rules = [
	];

    /**
     * Modify the rules for updating the metadata of a User.
     *
     * @param null $id
     * @return $this|ValidableInterface
     */
    public function update($id = null)
    {
        return $this;
    }
}