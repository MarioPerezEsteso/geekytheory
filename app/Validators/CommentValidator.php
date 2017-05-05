<?php

namespace App\Validators;

use App\Validators\Base\LaravelValidator;
use App\Validators\Base\ValidableInterface;

class CommentValidator extends LaravelValidator implements ValidableInterface
{
    /**
     * Validation rules for creating an Comment.
     */
    protected $rules = array(
        'post_id' => 'required',
        'author_name' => 'required|max:255',
        'author_email' => 'required|max:255',
        'author_url' => 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
        'body' => 'required',
        'approved' => 'required',
        'spam' => 'required',
    );

    /**
     * Modify the rules for updating a Comment.
     *
     * @param null $id
     * @return $this|ValidableInterface
     */
    public function update($id = null)
    {
        return $this;
    }
}