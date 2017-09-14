<?php

namespace Tests\Functional;

use App\User;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    /**
     * Account profile page URL.
     *
     * @var string
     */
    protected $accountProfilePageUrl = 'cuenta/perfil';

    /**
     * Test that user not logged in can't visit the account profile page.
     */
    public function testVisitUserAccountProfilePageRedirectsToLogin()
    {
        $response = $this->call('GET', $this->accountProfilePageUrl);
        $response->assertRedirect('login');
    }

    /**
     * Test that a logged user can visit its account profile page.
     */
    public function testLoggedUserVisitAccountProfilePageOk()
    {
        // Prepare
        $userAttributes = [
            'name' => 'Mario',
            'username' => 'mario',
            'email' => 'mario@domain.com',
            'password' => bcrypt('123456'),
            'can_login' => true,
        ];
        $user = factory(User::class)->create($userAttributes);

        // Request
         $response = $this->actingAs($user)->call('GET', $this->accountProfilePageUrl);

        // Asserts
        $response->assertStatus(200);
        $response->assertViewIs('account.profile.profile');
        $response->assertResponseHasData('userProfile');
        $response->assertResponseDataModelHasValues('userProfile', $user->attributesToArray());
        $response->assertResponseDataHasRelationLoaded('userProfile', 'userMeta', 0);
    }

    /**
     * Test delete success.
     */
    public function testDeleteSuccess()
    {

    }
}
