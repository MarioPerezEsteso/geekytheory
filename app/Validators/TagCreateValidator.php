<?php

namespace App\Validators;

use App\Validators\Base\LaravelValidator;
use App\Validators\Base\ValidableInterface;

class TagCreateValidator extends LaravelValidator implements ValidableInterface
{
    /**
     * Validation rules for creating a new Tag
     *
     * @var array
     */
    protected $rules = array(
        'tag'   => 'required|unique:tags',
        'slug'  => 'required|unique:tags',
    );

}