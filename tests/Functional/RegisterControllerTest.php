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
    protected $registerUrlPost = 'register';

    /**
     * Register GET url.
     *
     * @var string
     */
    protected $registerUrlGet = '/registro';

    /**
     * URL to redirect on register.
     *
     * @var string
     */
    protected $urlToRedirectOnRegister = '/cuenta';

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
        $response = $this->call('POST', $this->registerUrlPost, $registrationData);

        // Asserts
        $response->assertStatus(302);

        $response->assertHeader('location', $this->getUrlWithBase($this->urlToRedirectOnRegister));

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
        $response = $this->call('POST', $this->registerUrlPost, $registrationData);

        // Asserts
        $response->assertStatus(302);

        $response->assertHeader('location', $this->getUrlWithBase($this->urlToRedirectOnRegister));

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
        // Config
        $faker = \Faker\Factory::create();
        $userData = [
            'name' => $faker->name,
            'email' => $faker->email,
            'password' => $faker->password(6),
        ];

        // Prepare
        factory(User::class)->create($userData);

        // Register user with the same name.
        $registrationData = $userData;

        // Request
        $response = $this->call('POST', $this->registerUrlPost, $registrationData);

        // Asserts
        $response->assertStatus(302);

        $response->assertSessionHasErrors('email');

        $response->assertHeader('location', $this->getUrlWithBase($this->registerUrlGet));
    }

    /**
     * Test user registration with form validation errors.
     *
     * @dataProvider getInvalidRegistrationData
     * @param array $registrationData
     * @param array $sessionErrorKeys
     */
    public function testRegisterUserWithFormValidationErrors($registrationData, $sessionErrorKeys)
    {
        // Request
        $response = $this->call('POST', $this->registerUrlPost, $registrationData);

        // Asserts
        $response->assertStatus(302);

        $response->assertSessionHasErrors($sessionErrorKeys);

        $response->assertHeader('location', $this->getUrlWithBase($this->registerUrlGet));
    }

    /**
     * Returns an array with an example of invalid data.
     */
    public static function getInvalidRegistrationData()
    {
        return [
            [
                [   // Registration data
                    'name' => '',
                    'email' => 'mario@domain.com',
                    'password' => '123456',
                ],
                [   // Validation error keys
                    'name',
                ],
            ],
            [
                [   // Registration data
                    'name' => 'John',
                    'email' => 'aliasdomain.com',
                    'password' => '123',
                ],
                [   // Validation error keys
                    'email',
                    'password',
                ],
            ],
            [
                [   // Registration data
                    'name' => '            ',
                    'email' => '',
                    'password' => '123456',
                ],
                [   // Validation error keys
                    'name',
                    'email',
                ],
            ],
        ];
    }
}
