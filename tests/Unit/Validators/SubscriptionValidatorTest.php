<?php

namespace Tests\Unit\Validators;

use App\Validators\SubscriptionValidator;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class SubscriptionValidatorTest extends TestCase
{
    /**
     * Test create with valid data.
     *
     * @dataProvider getValidData
     * @param array $data
     */
    public function testValidationOk($data)
    {
        $validator = new SubscriptionValidator(App::make('validator'));
        $passes = $validator->with($data)->passes();
        $this->assertTrue($passes);
    }

    /**
     * Test create with invalid data.
     *
     * @dataProvider getInvalidData
     * @param array $data
     * @param $validationErrorKeys
     */
    public function testValidationError($data, $validationErrorKeys)
    {
        $validator = new SubscriptionValidator(App::make('validator'));
        $passes = $validator->with($data)->passes();
        $this->assertFalse($passes);
        $this->assertEquals(count($validationErrorKeys), count($validator->errors()));
        foreach ($validationErrorKeys as $validationErrorKey) {
            $this->assertArrayHasKey($validationErrorKey, $validator->errors()->toArray());
        }
    }

    /**
     * Test update with valid data.
     *
     * @dataProvider getValidData
     * @param array $data
     */
    public function testValidationUpdateOk($data)
    {
        $validator = new SubscriptionValidator(App::make('validator'));
        $passes = $validator->with($data)->update()->passes();
        $this->assertTrue($passes);
    }

    /**
     * Test update with invalid data.
     *
     * @dataProvider getInvalidData
     * @param array $data
     * @param $validationErrorKeys
     */
    public function testValidationUpdateError($data, $validationErrorKeys)
    {
        $validator = new SubscriptionValidator(App::make('validator'));
        $passes = $validator->with($data)->update()->passes();
        $this->assertFalse($passes);
        $this->assertEquals(count($validationErrorKeys), count($validator->errors()));
        foreach ($validationErrorKeys as $validationErrorKey) {
            $this->assertArrayHasKey($validationErrorKey, $validator->errors()->toArray());
        }
    }

    /**
     * Returns valid data.
     *
     * @return array
     */
    public static function getValidData()
    {
        return [
            [
                [
                    'stripe_token' => 'thisisatoken',
                    'subscription_plan' => 'monthly',
                ],
            ],
            [
                [
                    'stripe_token' => 'andThisIsAnotherOne123456',
                    'subscription_plan' => 'yearly',
                ],
            ],
        ];
    }

    /**
     * Returns invalid data.
     *
     * @return array
     */
    public static function getInvalidData()
    {
        return [
            [
                [
                    'stripe_token' => null,
                    'subscription' => 'thisfieldisnotvalid',
                ],
                'validationErrorKeys' => ['stripe_token', 'subscription_plan',],
            ], [
                [
                    'stripe_token' => null,
                    'subscription_plan' => 'monthly',
                ],
                'validationErrorKeys' => ['stripe_token',],
            ], [
                [
                    'stripe_token' => null,
                    'subscription_plan' => 'yearly',
                ],
                'validationErrorKeys' => ['stripe_token',],
            ], [
                [
                    'stripe_token' => 'whatever',
                    'subscription_plan' => 'thisIsNotASubscriptionPlan',
                ],
                'validationErrorKeys' => ['subscription_plan',],
            ],
        ];
    }
}
