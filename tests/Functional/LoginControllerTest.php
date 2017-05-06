<?php

class LoginControllerTest extends TestCase
{
    /**
     * Test redirect to login if user is not authenticated.
     */
    public function testRedirectToLoginIfUserNotAuthenticated()
    {
		$response = $this->call('GET', 'home');
        $response->assertRedirect('login');
    }
}
