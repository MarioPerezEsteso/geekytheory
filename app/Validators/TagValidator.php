<?php

namespace App\Validators;

use App\Http\Controllers\Controller;
use App\Validators\Base\LaravelValidator;
use App\Validators\Base\ValidableInterface;

class TagValidator extends LaravelValidator implements ValidableInterface
{
    /**
     * Validation rules for creating a Tag
     */
    protected $rules = array(
        'tag' => 'required|unique:tags',
        'slug' => 'required|unique:tags',
    );

    /**
     * Modify the rules for updating a Tag
     *
     * @param null $id
     * @return self
     */
    public function update($id = null)
    {
        $this->rules = array(
            'tag' => 'required|unique:tags,tag,' . $id,
            'slug' => 'required|unique:tags,slug,' . $id,
        );
        return $this;
    }

}