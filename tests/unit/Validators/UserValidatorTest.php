<?php

use \App\Validators\UserValidator;

class UserValidatorTest extends TestCase
{
    /**
     * Set up test
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        // Create two users
        factory(App\User::class)->create([
            'name' => 'Alice',
            'email' => 'alice@geekytheory.com',
            'password' => bcrypt('123456'),
            'username' => 'alice',
        ],
        [
            'name' => 'Bob',
            'email' => 'bob@geekytheory.com',
            'password' => bcrypt('123456'),
            'username' => 'bob',
        ]);
    }

    /**
     * Test create with valid data.
     * 
     * @dataProvider getValidCreateData
     */
    public function testValidationOk($data)
    {
        $validator = new UserValidator(App::make('validator'));
        $passes = $validator->with($data)->passes();
        $this->assertTrue($passes);
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
                    'name' => 'Alice',
                    'email' => 'alice.geek@geekytheory.com',
                    'username' => 'alicegeek',
                ],
            ],
            [ // Test input 2
                [
                    'name' => 'Mario',
                    'email' => 'mario@geekytheory.com',
                    'username' => 'mario010203'
                ],
            ],
            [ // Test input 3
                [
                    'name' => 'Alice',
                    'email' => 'alice2@geekytheory.com',
                    'username' => 'alice2'
                ],
            ],
        ];
    }

    /**
     * Test create with valid data.
     * 
     * @dataProvider getInvalidCreateData
     */
    public function testValidationError($data, $validationErrorKeys)
    {
        $validator = new UserValidator(App::make('validator'));
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
    public static function getInvalidCreateData()
    {
        return [
            [ // Test input 1
                [
                    'name' => 'Alice',
                    'email' => 'alice@geekytheory.com',
                ],
                'validationErrorKeys' => ['email', 'username'],
            ],
            [ // Test input 2
                [
                    'name' => 'Mario',
                    'email' => 'mario@geekytheory.com',
                    'username' => 'mario perez'
                ],
                'validationErrorKeys' => ['username'],
            ],
            [ // Test input 3
                [
                    'name' => 'Mario',
                    'email' => 'mario@geekytheory.com',
                    'username' => 'mario_perez'
                ],
                'validationErrorKeys' => ['username'],
            ],
            [ // Test input 4
                [
                    'name' => 'Alice',
                    'email' => 'alice@geekytheory.com',
                    'username' => 'alice2'
                ],
                'validationErrorKeys' => ['email'],
            ],
            [ // Test input 5
                [
                    'email' => 'alice@geekytheory.com',
                    'username' => 'a'
                ],
                'validationErrorKeys' => ['name', 'email', 'username'],
            ],
        ];
    }
}