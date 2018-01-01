<?php

namespace App\Validators;

use App\Validators\Base\LaravelValidator;
use App\Validators\Base\ValidableInterface;

class SubscriptionValidator extends LaravelValidator implements ValidableInterface
{
    /**
     * Validation rules for creating a Subscription.
     */
    protected $rules = [
        'stripe_token' => 'required',
    ];

    /**
     * Modify the rules for updating a Subscription.
     *
     * @param null $id
     * @return $this|ValidableInterface
     */
    public function update($id = null)
    {
        return $this;
    }

    /**
     * Modify te rules for updating a Subscription credit card.
     *
     * @return $this
     */
    public function validateCreditCardUpdate()
    {
        $this->rules = [
            'stripe_token' => 'required',
        ];

        return $this;
    }
}
