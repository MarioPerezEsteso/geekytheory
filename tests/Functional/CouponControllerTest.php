<?php

namespace Tests\Functional;

use App\User;
use Tests\Helpers\Response;
use Tests\TestCase;

class CouponControllerTest extends TestCase
{
    /**
     * Coupon validation endpoint.
     *
     * @var string
     */
    protected $validateCouponEndpoint = 'coupon/validate';

    /**
     * Test get single course that does not exist throws a not found error.
     *
     * @dataProvider providerTestCheckCoupons
     * @param string $coupon
     * @param array $response
     */
    public function testCheckCoupons(string $coupon, array $couponResponse)
    {
        // Prepare
        $user = factory(User::class)->create();

        // Request
        $response = $this->actingAs($user)->call('POST', $this->validateCouponEndpoint, ['coupon' => $coupon,]);

        // Asserts
        $response->assertExactJson($couponResponse);
    }

    /**
     * Data provider for testCheckValidCoupons
     *
     * @return array
     */
    public function providerTestCheckCoupons()
    {
        return [
            [
                'coupon' => 'test-coupon-1-month',
                'couponResponse' => [
                    'status' => 'valid',
                    'percent_off' => 50,
                    'duration' => 'repeating',
                    'duration_in_months' => 1,
                    'applied_at' => null,
                    'ends_at' => null,
                ],
            ],
        ];
    }

    /**
     * Test check coupon redirects to login if user is not logged in.
     */
    public function testCheckCouponNonLoggedUserNotAuthorized()
    {
        /** @var Response $response */
        $response = $this->call('POST', $this->validateCouponEndpoint);

        // Asserts
        $response->assertRedirect('login');
    }
}
