<?php

namespace Tests\Functional;

use App\User;
use App\UserMeta;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    /**
     * Account profile page URL.
     *
     * @var string
     */
    protected $accountProfilePageUrl = '/cuenta/perfil';

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
     *
     * @dataProvider providerUserMeta
     * @param boolean $withUserMeta
     */
    public function testLoggedUserVisitAccountProfilePageOk($withUserMeta)
    {
        // Prepare
        $user = factory(User::class)->create([
            'name' => 'Mario',
            'username' => 'mario',
            'email' => 'mario@domain.com',
            'password' => bcrypt('123456'),
            'can_login' => true,
        ]);

        if ($withUserMeta) {
            $userMeta = factory(UserMeta::class)->create([
                'user_id' => $user->id,
            ]);
        }

        // Request
        $response = $this->actingAs($user)->call('GET', $this->accountProfilePageUrl);

        // Asserts
        $response->assertStatus(200);
        $response->assertViewIs('account.profile.profile');
        $response->assertResponseHasData('userProfile');
        $response->assertResponseDataModelHasValues('userProfile', $user->attributesToArray());

        if (!$withUserMeta) {
            $response->assertResponseDataHasRelationLoaded('userProfile', 'userMeta', 0);
        } else {
            $response->assertResponseDataHasRelationLoaded('userProfile', 'userMeta', 1);
            $response->assertResponseDataModelHasValues('userProfile.userMeta', $userMeta->attributesToArray());
        }

    }

    /**
     * Provider for testLoggedUserVisitAccountProfilePageOk
     *
     * @return array
     */
    public function providerUserMeta()
    {
        return [
            'without user meta' => [false],
            'with user meta' => [true],
        ];
    }

    /**
     * Test delete success.
     */
    public function testDeleteSuccess()
    {

    }
}
