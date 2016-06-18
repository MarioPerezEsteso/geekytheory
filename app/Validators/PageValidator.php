<?php

namespace App\Validators;

use App\Validators\Base\LaravelValidator;
use App\Validators\Base\ValidableInterface;

class PageValidator extends LaravelValidator implements ValidableInterface
{
    /**
     * Validation rules for creating a Page.
     */
    protected $rules = array();

    /**
     * Modify the rules for updating a Page.
     *
     * @param null $id
     * @return $this|ValidableInterface
     */
    public function update($id = null)
    {
        return $this;
    }
}