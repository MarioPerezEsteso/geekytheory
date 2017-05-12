<?php

namespace App\Validators;

use App\Validators\Base\LaravelValidator;
use App\Validators\Base\ValidableInterface;

class SubscriberValidator extends LaravelValidator implements ValidableInterface
{   
    /**
     * Validation rules for creating a Subscriber.
     */
    protected $rules = [
        'email' => 'required|email|unique:subscribers,email',
    ];

    /**
     * Modify the rules for updating a Subscriber.
     *
     * @param null $id
     * @return $this|ValidableInterface
     */
    public function update($id = null)
    {
        return $this;
    }
}