<?php

namespace Tests\Unit\Validators;

use App\User;
use \App\Validators\UserValidator;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

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
        $this->users[0] = factory(User::class)->create([
            'password' => bcrypt('123456'),
        ]);

        $this->users[1] = factory(User::class)->create([
            'password' => bcrypt('123456'),
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
     * Test create with invalid data.
     */
    public function testCreateValidationError()
    {
        $examples = $this->getInvalidCreateData();
        foreach ($examples as $example) {
            $data = $example['data'];
            $validationErrorKeys = $example['validationErrorKeys'];
            $validator = new UserValidator(App::make('validator'));
            $passes = $validator->with($data)->passes();
            $this->assertFalse($passes);
            $this->assertEquals(
                count($validationErrorKeys),
                count($validator->errors()),
                "Expected " . implode(',', $validationErrorKeys) . " but received " . implode(',', array_keys($validator->errors()->toArray()))
            );
            foreach ($validationErrorKeys as $validationErrorKey) {
                $this->assertArrayHasKey($validationErrorKey, $validator->errors()->toArray());
            }
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
     */
    public function testUpdateValidationError()
    {
        $examples = $this->getInvalidUpdateData();
        foreach ($examples as $example) {
            $data = $example['data'];
            $validationErrorKeys = $example['validationErrorKeys'];
            $validator = new UserValidator(App::make('validator'));
            $passes = $validator->with($data)->update($this->users[0]->id)->passes();
            $this->assertFalse($passes);
            $this->assertEquals(
                count($validationErrorKeys),
                count($validator->errors()->toArray()),
                "Expected " . implode(',', $validationErrorKeys) . " but received " . implode(',', array_keys($validator->errors()->toArray()))
            );
            foreach ($validationErrorKeys as $validationErrorKey) {
                $this->assertArrayHasKey($validationErrorKey, $validator->errors()->toArray());
            }
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
    public function getInvalidCreateData()
    {
        return [
            [
                'data' => [
                    'name' => 'Alice',
                    'email' => $this->users[0]->email,
                ],
                'validationErrorKeys' => ['email', 'username'],
            ],
            [
                'data' => [
                    'name' => 'Mario',
                    'email' => 'whatever@geekytheory.com',
                    'username' => 'mario_perez'
                ],
                'validationErrorKeys' => ['username'],
            ],
            [
                'data' => [
                    'name' => 'Alice',
                    'email' => $this->users[0]->email,
                    'username' => 'alice2'
                ],
                'validationErrorKeys' => ['email'],
            ],
            [
                'data' => [
                    'email' => $this->users[0]->email,
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
    public function getInvalidUpdateData()
    {
        return [
            [ // Test input 1
                'data' => [
                    'name' => 'Alice',
                    'email' => 'bliblibli@geekytheory.com',
                ],
                'validationErrorKeys' => ['username'],
            ],
            [ // Test input 2
                'data' => [
                    'name' => 'Mario',
                    'email' => 'blablabla@geekytheory.com',
                    'username' => 'mario perez'
                ],
                'validationErrorKeys' => ['username']
            ],
            [ // Test input 3
                'data' => [
                    'name' => 'Mario',
                    'email' => 'tititi@geekytheory.com',
                    'username' => 'mario_perez'
                ],
                'validationErrorKeys' => ['username']
            ],
            [ // Test input 4
                'data' => [
                    'name' => 'Alice',
                    'email' => $this->users[1]->email,
                    'username' => 'alice2'
                ],
                'validationErrorKeys' => ['email']
            ],
            [ // Test input 5
                'data' => [
                    'email' => 'alice@geekytheory.com',
                    'username' => 'a'
                ],
                'validationErrorKeys' => ['name', 'username']
            ],
        ];
    }
}