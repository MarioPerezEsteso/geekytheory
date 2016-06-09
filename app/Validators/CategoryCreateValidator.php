<?php

namespace App\Validators;

use App\Validators\Base\LaravelValidator;
use App\Validators\Base\ValidableInterface;

class CategoryCreateValidator extends LaravelValidator implements ValidableInterface
{
    /**
     * Validation rules for creating a new Category
     *
     * @var array
     */
    protected $rules = array(
        'category'  => 'required|unique:categories',
        'slug'      => 'required|unique:categories',
        'image'     => 'mimes:jpeg,gif,png',
    );
}