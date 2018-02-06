<?php

namespace App\Http\Controllers;

use App\Coupon;
use App\Validators\CouponValidator;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /** @var CouponValidator */
    private $couponValidator;

    /**
     * CouponController constructor.
     * @param CouponValidator $couponValidator
     */
    public function __construct(CouponValidator $couponValidator)
    {
        $this->couponValidator = $couponValidator;
    }

    /**
     * Check validity of a Coupon.
     *
     * @param Request $request
     * @return array
     */
    public function checkCoupon(Request $request)
    {
        if (!$this->couponValidator->with($request->all())->passes()) {
            return [
                'status' => Coupon::STATUS_INVALID,
            ];
        }

        $coupon = (new Coupon())->getFromStripe($request->coupon);

        return $coupon->jsonSerialize();
    }
}
