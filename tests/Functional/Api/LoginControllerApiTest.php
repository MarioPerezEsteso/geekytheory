<?php

use Laravel\Passport\ClientRepository;

class LoginControllerApiTest extends TestCase
{
    /**
     * Academia login endpoint
     *
     * @var string
     */
    protected $academiaLoginEndpoint = 'api/academia/login';

    /**
     * Test user login ok and redirect to /home
     */
    public function testUserLoginOk()
    {
        $user = factory(App\User::class)->create([
            'name' => 'Alice',
            'email' => 'alice@geekytheory.com',
            'password' => bcrypt('123456'),
            'username' => 'alice@geekytheory.com',
            'can_login' => true,
        ]);

        $response = $this->call('POST', $this->academiaLoginEndpoint, [
            'email' => $user->email,
            'password' => '123456',
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'token'
        ]);
    }

    /**
     * Test login error wrong credentials.
     */
    public function testLoginErrorWrongCredentials()
    {
        $user = factory(App\User::class)->create([
            'name' => 'Alice',
            'email' => 'alice@geekytheory.com',
            'password' => bcrypt('123456'),
            'username' => 'alice',
            'can_login' => false,
        ]);

        $response = $this->call('POST', $this->academiaLoginEndpoint, [
            'email' => $user->email,
            'password' => 'abcdef',
        ]);

        $response->assertStatus(422);

        $response->assertExactJson([
            'email' => trans('auth.failed'),
        ]);
    }

    /**
     * Test user that is banned (can_login = false) receives an error on login.
     */
    public function testUserCanNotLoginWrongCredentialsError()
    {
        $user = factory(App\User::class)->create([
            'name' => 'Alice',
            'email' => 'alice@geekytheory.com',
            'password' => bcrypt('123456'),
            'username' => 'alice',
            'can_login' => false,
        ]);

        $response = $this->call('POST', $this->academiaLoginEndpoint, [
            'email' => $user->email,
            'password' => '123456',
        ]);

        $response->assertStatus(422);

        $response->assertExactJson([
            'email' => trans('auth.failed')
        ]);
    }
}
