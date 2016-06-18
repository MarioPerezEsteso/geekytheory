<?php

namespace App\Validators;

use App\Validators\Base\LaravelValidator;
use App\Validators\Base\ValidableInterface;

class ArticleValidator extends LaravelValidator implements ValidableInterface
{
    /**
     * Validation rules for creating an Article.
     */
    protected $rules = array();

    /**
     * Modify the rules for updating an Article.
     *
     * @param null $id
     * @return $this|ValidableInterface
     */
    public function update($id = null)
    {
        return $this;
    }
}