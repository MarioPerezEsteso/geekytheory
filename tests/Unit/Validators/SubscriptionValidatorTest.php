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
                ],
                'validationErrorKeys' => ['stripe_token',],
            ], [
                [
                    'stripe_token' => null,
                ],
                'validationErrorKeys' => ['stripe_token',],
            ], [
                [
                    'stripe_token' => null,
                ],
                'validationErrorKeys' => ['stripe_token',],
            ],
        ];
    }
}
