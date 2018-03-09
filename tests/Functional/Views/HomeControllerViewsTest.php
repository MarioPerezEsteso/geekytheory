<?php

namespace Tests\Functional\Views;

use App\User;
use Tests\TestCase;

class HomeControllerViewsTest extends TestCase
{
    /**
     * Test administrator user can visit the Home.
     */
    public function testUserAdministratorCanVisitHome()
    {
        // Prepare
        /** @var User $user */
        $user = factory(User::class)->create();

        // Request
        $response = $this->actingAs($user)->call('GET', 'home');

        // Asserts
        $response->assertStatus(200);
        $response->assertResponseIsView('home.home.home');
    }

    /**
     * Test non administrator user can't visit the Home.
     */
    public function testUserNonAdministratorCannotVisitHome()
    {
        // Prepare
        /** @var User $user */
        $user = factory(User::class)->create(['is_admin' => false,]);

        // Request
        $response = $this->actingAs($user)->call('GET', 'home');

        // Asserts
        $response->assertStatus(404);
    }

    /**
     * Test non administrator user can't visit the Home.
     */
    public function testNonLoggedUserCannotVisitHome()
    {
        // Request
        $response = $this->call('GET', 'home');

        // Asserts
        $response->assertStatus(302);
    }
}
