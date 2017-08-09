<?php

namespace Tests\Functional;

use App\User;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    /**
     * Test redirect to login if user is not authenticated
     */
    public function testRedirectToLoginIfUserNotAuthenticated()
    {
		$response = $this->call('GET', 'home');
        $response->assertRedirect('login');
    }

    /**
     * Test user login ok and redirect to /home
     */
    public function testUserLoginOk()
    {
        $user = factory(User::class)->create([
            'name' => 'Alice',
            'email' => 'alice@geekytheory.com',
            'password' => bcrypt('123456'),
            'username' => 'alice',
            'can_login' => true,
        ]);

        $response = $this->call('POST', 'login', [
            'email' => $user->email,
            'password' => '123456',
        ]);

        $response->assertRedirect('home');
    }

    /**
     * Test user can not login
     */
    public function testUserCanNotLoginError()
    {
        $user = factory(User::class)->create([
            'name' => 'Alice',
            'email' => 'alice@geekytheory.com',
            'password' => bcrypt('123456'),
            'username' => 'alice',
            'can_login' => false,
        ]);

        $response = $this->call('POST', 'login', [
            'email' => $user->email,
            'password' => '123456',
        ]);

        // If the user has the can_login field to false, we throw the error
        // saying that the credentials are wrong, and not the one saying that
        // the user is banned.
        $response->assertSessionHasErrors(['email']);
    }

    /**
     * Test user can not login with wrong credentials
     */
    public function testUserCanNotLoginWrongCredentialsError()
    {
        $user = factory(User::class)->create([
            'name' => 'Alice',
            'email' => 'alice@geekytheory.com',
            'password' => bcrypt('123456'),
            'username' => 'alice',
            'can_login' => true,
        ]);

        $response = $this->call('POST', 'login', [
            'email' => $user->email,
            'password' => 'abcdef',
        ]);

        // If the user has the can_login field to false, we throw the error
        // saying that the credentials are wrong, and not the one saying that
        // the user is banned.
        $response->assertSessionHasErrors(['email']);
    }

    /**
     * Test redirect to homepage when a logged user does a logout
     */
    public function testUserLogoutRedirectToHomePage()
    {
        $user = factory(User::class)->create([
            'name' => 'Alice',
            'email' => 'alice@geekytheory.com',
            'password' => bcrypt('123456'),
            'username' => 'alice',
        ]);

        $response = $this->actingAs($user)->call('GET', 'logout');

        $response->assertRedirect('/');
    }
}
