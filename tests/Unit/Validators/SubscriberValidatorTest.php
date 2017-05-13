<?php

use App\Validators\SubscriberValidator;

class SubscriberValidatorTest extends TestCase
{
    /**
     * @return array
     */
    protected $subscribers;

    /**
     * Set up test
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        // Create two subscribers
        $this->subscribers[0] = factory(App\Subscriber::class)->create([
            'email' => 'alice@geekytheory.com',
        ]);

        $this->subscribers[1] = factory(App\Subscriber::class)->create([
            'email' => 'bob@geekytheory.com',
        ]);
    }

    /**
     * Test create with valid data.
     * 
     * @dataProvider getValidCreateData
     * @param array $data
     */
    public function testValidationOk($data)
    {
        $validator = new SubscriberValidator(App::make('validator'));
        $passes = $validator->with($data)->passes();
        $this->assertTrue($passes);
    }

    /**
     * Test create with invalid data.
     *
     * @dataProvider getInvalidCreateData
     * @param array $data
     * @param $validationErrorKeys
     */
    public function testValidationError($data, $validationErrorKeys)
    {
        $validator = new SubscriberValidator(App::make('validator'));
        $passes = $validator->with($data)->passes();
        $this->assertFalse($passes);
        $this->assertEquals(count($validationErrorKeys), count($validator->errors()));
        foreach ($validationErrorKeys as $validationErrorKey) {
            $this->assertArrayHasKey($validationErrorKey, $validator->errors()->toArray());
        }
    }

    /**
     * Returns invalid data.
     * 
     * @return array
     */
    public static function getValidCreateData()
    {
        return [
            [ // Test input 1
                [
                    'email' => 'alice@domain.com',
                    'token' => hash_hmac('sha256', str_random(40), 'someRandomString'),
                    'activated' => false,
                ],
            ],
            [ // Test input 2
                [
                    'email' => 'mario@geekytheory.com',
                    'token' => hash_hmac('sha256', str_random(40), 'someRandomString'),
                    'activated' => false,
                ],
            ],
            [ // Test input 3
                [
                    'email' => 'alice2@geekytheory.com',
                    'token' => hash_hmac('sha256', str_random(40), 'someRandomString'),
                    'activated' => true,
                ],
            ],
        ];
    }

    /**
     * Returns invalid data.
     * 
     * @return array
     */
    public static function getInvalidCreateData()
    {
        return [
            [ // Test input 1
                [
                    'email' => 'alice@geekytheory.com',
                    'token' => false,
                    'activated' => 'true',
                ],
                'validationErrorKeys' => ['email', 'token', 'activated'],
            ],
            [ // Test input 2
                [
                    'email' => 'bob@geekytheory.com',
                ],
                'validationErrorKeys' => ['email', 'token'],
            ],
        ];
    }

}