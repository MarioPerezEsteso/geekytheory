<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Stripe\Stripe;

class Coupon extends Model
{
    /**
     * Statuses of a Coupon.
     */
    const STATUS_VALID = 'valid';
    const STATUS_INVALID = 'invalid';
    const STATUS_REDEEMED = 'redeemed';
    const STATUS_EXPIRED = 'expired';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'percent_off',
        'duration',
        'duration_in_months',
        'applied_at',
        'ends_at',
    ];

    /**
     * Get coupon from Stripe.
     *
     * @param string $coupon
     * @return $this
     */
    public function getFromStripe(string $coupon): Coupon
    {
        try {
            $stripeCoupon = self::retrieve($coupon);

            if ($stripeCoupon->valid === true) {
                $this->fill(
                    [
                        'status' => Coupon::STATUS_VALID,
                        'percent_off' => $stripeCoupon->percent_off,
                        'duration' => $stripeCoupon->duration,
                        'duration_in_months' => $stripeCoupon->duration_in_months,
                        'applied_at' => null,
                        'ends_at' => null,
                    ]
                );
            } else if (!is_null($stripeCoupon->max_redemptions)
                && $stripeCoupon->max_redemptions == $stripeCoupon->times_redeemed) {
                $this->status = self::STATUS_REDEEMED;
            } else if (Carbon::createFromTimestamp($stripeCoupon->redeem_by)->lessThan(Carbon::now())) {
                $this->status = self::STATUS_EXPIRED;
            } else {
                $this->status = self::STATUS_INVALID;
            }
        } catch (\Exception $exception) {
            $this->status = self::STATUS_INVALID;
        }

        return $this;
    }

    /**
     * Retrieve coupon from Stripe.
     *
     * @param string $coupon
     * @return \Stripe\Coupon
     */
    public static function retrieve(string $coupon)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        return \Stripe\Coupon::retrieve($coupon);
    }

}
