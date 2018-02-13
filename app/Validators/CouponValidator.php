<?php

namespace App\Validators;

use App\Validators\Base\LaravelValidator;
use App\Validators\Base\ValidableInterface;

class CouponValidator extends LaravelValidator implements ValidableInterface
{
    /**
     * Validation rules for a Coupon
     */
    protected $rules = array(
        'coupon' => 'required',
    );

    /**
     * Rules for updating a Coupon
     *
     * @param null $id
     * @return self
     */
    public function update($id = null)
    {
        return $this;
    }
}