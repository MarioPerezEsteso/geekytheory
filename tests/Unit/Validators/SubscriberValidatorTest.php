<?php

namespace Tests\Unit\Validators;

use App\Subscriber;
use App\Validators\SubscriberValidator;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

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
        $this->subscribers[0] = factory(Subscriber::class)->create();

        $this->subscribers[1] = factory(Subscriber::class)->create();
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
     * Test create with invalid data because of duplicated email.
     */
    public function testDuplicatedEmailValidationOnCreateError()
    {
        $data = [
            'email' => $this->subscribers[0]->email,
            'token' => hash_hmac('sha256', str_random(40), 'someRandomString'),
            'active' => false,
            'token_expires_at' => \Carbon\Carbon::now()->addHours(24),
        ];

        $validator = new SubscriberValidator(App::make('validator'));
        $passes = $validator->with($data)->passes();
        $this->assertFalse($passes);
        $this->assertEquals(1, count($validator->errors()));
        $this->assertArrayHasKey('email', $validator->errors()->toArray());
    }

    /**
     * Test update with valid data.
     *
     * @dataProvider getValidUpdateData
     * @param array $data
     */
    public function testValidationUpdateOk($data)
    {
        $validator = new SubscriberValidator(App::make('validator'));
        $passes = $validator->with($data)->update($this->subscribers[0]->id)->passes();
        $this->assertTrue($passes);
    }

    /**
     * Test update with invalid data.
     *
     * @dataProvider getInvalidUpdateData
     * @param array $data
     * @param $validationErrorKeys
     */
    public function testValidationUpdateError($data, $validationErrorKeys)
    {
        $validator = new SubscriberValidator(App::make('validator'));
        $passes = $validator->with($data)->update($this->subscribers[0]->id)->passes();
        $this->assertFalse($passes);
        $this->assertEquals(count($validationErrorKeys), count($validator->errors()));
        foreach ($validationErrorKeys as $validationErrorKey) {
            $this->assertArrayHasKey($validationErrorKey, $validator->errors()->toArray());
        }
    }

    /**
     * Test update with invalid data because of duplicated email.
     */
    public function testDuplicatedEmailValidationOnUpdateError()
    {
        $data = [
            'email' => $this->subscribers[0]->email,
            'token' => hash_hmac('sha256', str_random(40), 'someRandomString'),
            'active' => false,
            'token_expires_at' => \Carbon\Carbon::now()->addHours(24),
        ];

        $validator = new SubscriberValidator(App::make('validator'));
        $passes = $validator->with($data)->update($this->subscribers[1]->id)->passes();
        $this->assertFalse($passes);
        $this->assertEquals(1, count($validator->errors()));
        $this->assertArrayHasKey('email', $validator->errors()->toArray());
    }

    /**
     * Returns valid data.
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
                    'active' => false,
                    'token_expires_at' => \Carbon\Carbon::now()->addHours(24),
                ],
            ],
            [ // Test input 2
                [
                    'email' => 'mario@geekytheory.com',
                    'token' => hash_hmac('sha256', str_random(40), 'someRandomString'),
                    'active' => false,
                    'token_expires_at' => \Carbon\Carbon::now()->addHours(24),
                ],
            ],
            [ // Test input 3
                [
                    'email' => 'alice.mail.updated@geekytheory.com',
                    'token' => hash_hmac('sha256', str_random(40), 'someRandomString'),
                    'active' => true,
                    'token_expires_at' => \Carbon\Carbon::now()->addHours(24),
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
                    'active' => 'true',
                    'token_expires_at' => \Carbon\Carbon::now()->addHours(24),
                ],
                'validationErrorKeys' => ['email', 'token', 'active'],
            ],
            [ // Test input 2
                [
                    'email' => 'bob@geekytheory.com',
                ],
                'validationErrorKeys' => ['email', 'token', 'token_expires_at'],
            ],
        ];
    }

    /**
     * Returns valid update data.
     *
     * @return array
     */
    public static function getValidUpdateData()
    {
        return [
            [ // Test input 1
                [
                    'email' => 'alice@domain.com',
                    'token' => hash_hmac('sha256', str_random(40), 'someRandomString'),
                    'active' => false,
                    'token_expires_at' => \Carbon\Carbon::now()->addHours(24),
                ],
            ],
            [ // Test input 2
                [
                    'email' => 'mario@geekytheory.com',
                    'token' => hash_hmac('sha256', str_random(40), 'someRandomString'),
                    'active' => true,
                    'token_expires_at' => \Carbon\Carbon::now()->addHours(24),
                ],
            ],
            [ // Test input 3
                [
                    'email' => 'alice2@geekytheory.com',
                    'token' => hash_hmac('sha256', str_random(40), 'someRandomString'),
                    'active' => true,
                    'token_expires_at' => \Carbon\Carbon::now()->addHours(24),
                ],
            ],
        ];
    }

    /**
     * Returns invalid data.
     *
     * @return array
     */
    public static function getInvalidUpdateData()
    {
        return [
            [ // Test input 1
                [
                    'email' => 'testinput1@geekytheory.com',
                    'token' => false,
                    'active' => 'true',
                ],
                'validationErrorKeys' => ['token', 'active', 'token_expires_at'],
            ],
            [ // Test input 2
                [
                    'email' => 'wachufleiva@geekytheory.com',
                    'token_expires_at' => 'monday'
                ],
                'validationErrorKeys' => ['token', 'token_expires_at'],
            ],
            [ // Test input 3
                [
                    'email' => 'testinput3@geekytheory.com',
                    'token_expires_at' => 'monday'
                ],
                'validationErrorKeys' => ['token', 'token_expires_at'],
            ],
            [ // Test input 4
                [
                    'email' => 'alice_updated@geekytheory.com',
                    'token' => 'abdagsgsg121212',
                    'token_expires_at' => null,
                    'active' => 'no'
                ],
                'validationErrorKeys' => ['active', 'token_expires_at'],
            ],
        ];
    }

}