<?php

namespace App\Validators;

use App\Http\Controllers\Controller;
use App\Validators\Base\LaravelValidator;
use App\Validators\Base\ValidableInterface;

class CategoryValidator extends LaravelValidator implements ValidableInterface
{
    /**
     * Validation rules for creating a new Category
     */
    protected $rules = array(
        'category' => 'required|unique:categories',
        'slug' => 'required|unique:categories',
        'image' => 'mimes:jpeg,gif,png',
    );

    /**
     * Modify the rules for updating a Category
     *
     * @param null $id
     * @return self
     */
    public function update($id = null)
    {
        $this->rules = array(
            'category' => 'required|unique:categories,category,' . $id,
            'slug' => 'required|unique:categories,slug,' . $id,
            'image' => 'mimes:jpeg,gif,png',
        );
        return $this;
    }
}