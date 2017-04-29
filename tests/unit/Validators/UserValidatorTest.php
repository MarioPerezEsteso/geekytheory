<?php

use \App\Validators\UserValidator;

class UserValidatorTest extends TestCase
{
    /**
     * @return array
     */
    protected $users;

    /**
     * Set up test
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        // Create two users
        $this->users[0] = factory(App\User::class)->create([
            'name' => 'Alice',
            'email' => 'alice@geekytheory.com',
            'password' => bcrypt('123456'),
            'username' => 'alice',
        ]);

        $this->users[1] = factory(App\User::class)->create([
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
     * @param array $data
     */
    public function testValidationOk($data)
    {
        $validator = new UserValidator(App::make('validator'));
        $passes = $validator->with($data)->passes();
        $this->assertTrue($passes);
    }

    /**
     * Test create with valid data.
     * 
     * @dataProvider getInvalidCreateData
     * @param array $data
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
     * Test update with valid data.
     *
     * @dataProvider getValidUpdateData
     * @param array $data
     */
    public function testUpdateValidationOk($data)
    {
        $validator = new UserValidator(App::make('validator'));
        $passes = $validator->with($data)->update($this->users[0]->id)->passes();
        $this->assertTrue($passes);
    }

    /**
     * Test update with invalid data.
     * 
     * @dataProvider getInvalidUpdateData
     * @param array $data
     * @param array $data
     */
    public function testUpdateValidationError($data, $validationErrorKeys)
    {
        $validator = new UserValidator(App::make('validator'));
        $passes = $validator->with($data)->update($this->users[0]->id)->passes();
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
     * Returns valid update data.
     * 
     * @return array
     */
    public static function getValidUpdateData()
    {
        return [
            [ // Test input 1
                [
                    'name' => 'Alice Pérez',
                    'email' => 'alice@geekytheory.com',
                    'username' => 'alice',
                ],
            ],
            [ // Test input 2
                [
                    'name' => 'Alice',
                    'email' => 'alice@geekytheory.com',
                    'username' => 'mario010203'
                ],
            ],
            [ // Test input 3
                [
                    'name' => 'Alice',
                    'email' => 'alice2@geekytheory.com',
                    'username' => 'alice'
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
                    'name' => 'Alice',
                    'email' => 'alice@geekytheory.com',
                ],
                'validationErrorKeys' => ['username'],
            ],
            [ // Test input 2
                [
                    'name' => 'Mario',
                    'email' => 'mario@geekytheory.com',
                    'username' => 'mario perez'
                ],
                'validationErrorKeys' => ['username']
            ],
            [ // Test input 3
                [
                    'name' => 'Mario',
                    'email' => 'mario@geekytheory.com',
                    'username' => 'mario_perez'
                ],
                'validationErrorKeys' => ['username']
            ],
            [ // Test input 4
                [
                    'name' => 'Alice',
                    'email' => 'bob@geekytheory.com',
                    'username' => 'alice2'
                ],
                'validationErrorKeys' => ['email']
            ],
            [ // Test input 5
                [
                    'email' => 'alice@geekytheory.com',
                    'username' => 'a'
                ],
                'validationErrorKeys' => ['name', 'username']
            ],
        ];
    }
}