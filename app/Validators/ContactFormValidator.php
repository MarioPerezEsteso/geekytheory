<?php

namespace App\Validators;

use App\Validators\Base\LaravelValidator;
use App\Validators\Base\ValidableInterface;
use Exception;

class ContactFormValidator extends LaravelValidator implements ValidableInterface
{
    /**
     * Validation rules for submitting a contact form.
     */
    protected $rules = [
        'name' => 'required',
        'email' => 'required|email',
        'formMessage' => 'required'
    ];

    /**
     * @param null $id
     * @return ValidableInterface|void
     * @throws Exception
     */
    function update($id = null)
    {
        throw new Exception('Contact forms cannot be updated');
    }
}