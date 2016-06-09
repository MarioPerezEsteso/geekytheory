<?php

namespace App\Validators\Base;

use Illuminate\Validation\Factory;

abstract class LaravelValidator extends AbstractValidator
{
    /**
     * Validator
     *
     * @var Factory
     */
    protected $validator;

    public function __construct(Factory $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Pass the data and the rules to the validator
     *
     * @return bool
     */
    public function passes()
    {
        $validator = $this->validator->make($this->data, $this->rules);
        if ($validator->fails()) {
            $this->errors = $validator->messages();
            return false;
        }
        return true;
    }
}