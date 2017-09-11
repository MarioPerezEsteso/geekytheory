<?php

namespace Tests\Functional;

use App\User;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    /**
     * Register POST url.
     *
     * @var string
     */
    protected $registerUrl = 'register';

    /**
     * URL to redirect on register.
     *
     * @var string
     */
    protected $urlToRedirectOnRegister = 'http://localhost/cuenta';

    /**
     * Test redirect to login if user is not authenticated
     */
    public function testRegisterOk()
    {
        // Config
        $faker = \Faker\Factory::create();

        // Prepare
        $registrationData = [
            'name' => $faker->name,
            'email' => $faker->email,
            'password' => $faker->password(6),
        ];

        // Request
        $response = $this->call('POST', $this->registerUrl, $registrationData);

        // Asserts
        $response->assertStatus(302);

        $response->assertHeader('location', $this->urlToRedirectOnRegister);

        $this->assertDatabaseHas('users', [
            'name' => $registrationData['name'],
            'email' => $registrationData['email'],
            'username' => formatNameToUsername($registrationData['name']),
        ]);
    }

    /**
     * Test register user with the same name of another user already registered user creates a username
     * with a number as suffix.
     */
    public function testRegisterUserWithAlreadyExistentNameCreatesUsernameWithSuffix()
    {
        // Config
        $faker = \Faker\Factory::create();
        $userData = [
            'name' => $faker->name,
            'email' => $faker->email,
            'password' => $faker->password(6),
        ];
        $userData['username'] = formatNameToUsername($userData['name']);

        // Prepare
        factory(User::class)->create($userData);

        // Register user with the same name.
        $registrationData = [
            'name' => $userData['name'],
            'email' => $faker->email,
            'password' => $faker->password(6),
        ];

        // Request
        $response = $this->call('POST', $this->registerUrl, $registrationData);

        // Asserts
        $response->assertStatus(302);

        $response->assertHeader('location', $this->urlToRedirectOnRegister);

        // We append a suffix to username because it was already in the database
        $this->assertDatabaseHas('users', [
            'name' => $registrationData['name'],
            'email' => $registrationData['email'],
            'username' => formatNameToUsername($registrationData['name']) . '1',
        ]);
    }

    /**
     * Test register an email that already exists in the database.
     */
    public function testRegisterAlreadyExistentError()
    {

    }

    /**
     * Test user registration with form validation errors.
     */
    public function testRegisterUserWithFormValidationErrors()
    {

    }
}