<?php

namespace Tests\Functional;

use App\User;
use App\UserMeta;
use Faker\Factory;
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
     * Account profile POST URL.
     */
    protected $accountProfilePostUrl = '/account/profile';

    /**
     * Change password page URL.
     *
     * @var string
     */
    protected $accountChangePasswordPageUrl = '/cuenta/perfil/contrasena';

    /**
     * Change password POST URL.
     */
    protected $accountChangePasswordPostUrl = '/account/profile/password';

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
     * @dataProvider providerTestLoggedUserVisitAccountProfilePageOk
     * @param boolean $withUserMeta
     */
    public function testLoggedUserVisitAccountProfilePageOk($withUserMeta)
    {
        // Prepare
        $user = factory(User::class)->create([
            'name' => 'Mario',
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
     * Provider for testLoggedUserVisitAccountProfilePageOk.
     *
     * @return array
     */
    public function providerTestLoggedUserVisitAccountProfilePageOk()
    {
        return [
            'without user meta' => [false],
            'with user meta' => [true],
        ];
    }

    /**
     * Test users can update their profiles.
     *
     * @dataProvider providerTestUpdateUserProfileOk
     * @param array $userData
     * @param array $userMetadata
     * @param boolean $userHasMetadata
     */
    public function testUpdateUserProfileOk($userData, $userMetadata, $userHasMetadata)
    {
        // Prepare
        /** @var User $user */
        $user = factory(User::class)->create();

        if ($userHasMetadata) {
            /** @var UserMeta $userMeta */
            $userMeta = factory(UserMeta::class)->create([
                'user_id' => $user->id,
            ]);
        }

        $requestData['user'] = $userData;
        $requestData['usermeta'] = $userMetadata;

        // Request
        $response = $this->actingAs($user)->call('POST', $this->accountProfilePostUrl, $requestData);

        // Asserts
        $response->assertRedirect($this->accountProfilePageUrl);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $userData['name'],
            'username' => $userData['username'],
            'email' => $userData['email'],
            'receive_newsletter' => array_key_exists('receive_newsletter', $userData) && $userData['receive_newsletter'] == 'on',
        ]);

        if (!$userHasMetadata && empty($userMetadata)) {
            $this->assertDatabaseMissing('user_meta', ['user_id' => $user->id,]); // 1
        } else if (!$userHasMetadata && !empty($userMetadata)) {
            $this->assertDatabaseHas('user_meta', array_merge(['user_id' => $user->id,], $userMetadata)); // 3
        } else if ($userHasMetadata && empty($userMetadata)) {
            $this->assertDatabaseHas('user_meta', $userMeta->attributesToArray()); // 2
        } else if ($userHasMetadata && !empty($userMetadata)) {
            $this->assertDatabaseHas('user_meta', array_merge(['user_id' => $user->id,], $userMetadata)); // 4
        }

        $response->assertSessionHas('success');
    }

    /**
     * Provider for testUpdateUserProfileOk.
     *
     * @return array
     */
    public function providerTestUpdateUserProfileOk()
    {
        $faker = Factory::create();
        $userMetadata = [
            'biography' => $faker->text,
            'job' => $faker->text,
            'twitter' => $faker->url,
            'instagram' => null,
            'facebook' => null,
            'github' => $faker->url,
            'youtube' => $faker->url,
            'googleplus' => $faker->url,
            'stackoverflow' => null,
            'bitbucket' => $faker->url,
            'linkedin' => $faker->url,
            'tumblr' => $faker->url,
            'twitch' => $faker->url,
            'vimeo' => null,
        ];

        return [
            'User data without metadata and no previous metadata existent' => [[
                'name' => $faker->name,
                'email' => $faker->email,
                'username' => str_random(),
                'receive_newsletter' => 'on',
            ], [], false,],
            'User data without metadata and previous metadata existent' => [[
                'name' => $faker->name,
                'email' => $faker->email,
                'username' => str_random(),
            ], [], true,],
            'User data with metadata and no previous metadata existent' => [[
                'name' => $faker->name,
                'email' => $faker->email,
                'username' => str_random(),
                'receive_newsletter' => 'on',
            ], $userMetadata, false,],
            'User data with metadata and previous metadata existent' => [[
                'name' => $faker->name,
                'email' => $faker->email,
                'username' => str_random(),
            ], $userMetadata, true,],
        ];
    }

    /**
     * Test validation error on profile update.
     */
    public function testUpdateUserProfileErrorValidations()
    {
        // Prepare
        $user = factory(User::class)->create();

        $requestData = [
            'user' => [],
            'usermeta' => [
                'twitter' => '@geekytheory',
                'instagram' => 'geekytheory',
                'facebook' => 'GeekyTheory',
                'biography' => 'This text is longer than 255 characters and will not pass the validation. The 
                                biography cannot have more than 255 characters and this text has more than that
                                quantity so the validation will fail showing an error message in the 
                                biography attribute.',
            ],
        ];

        // Request
        $response = $this->actingAs($user)->call('POST', $this->accountProfilePostUrl, $requestData);

        // Asserts
        $response->assertStatus(302);
        $response->assertRedirect($this->accountProfilePageUrl);
        $response->assertSessionHasErrors([
            'name',
            'username',
            'email',
            'twitter',
            'instagram',
            'facebook',
            'biography',
        ]);

        // Check that user and user meta haven't been modified
        $this->assertDatabaseHas('users', $user->attributesToArray());
        $this->assertDatabaseMissing('user_meta', ['user_id' => $user->id,]);
    }

    /**
     * Test that a non-logged user can't update a profile.
     */
    public function testUpdateUserProfileErrorForbidden()
    {
        // Request
        $response = $this->call('POST', $this->accountProfilePostUrl, []);

        // Assert redirect to login
        $response->assertStatus(302);
        $response->assertRedirect('login');
    }

    /**
     * Test logged user can visit the account page to change the password.
     */
    public function testLoggedUserVisitsChangePasswordPageOk()
    {
        // Prepare
        $user = factory(User::class)->create();

        // Request
        $response = $this->actingAs($user)->call('GET', $this->accountChangePasswordPageUrl);

        // Asserts
        $response->assertStatus(200);
        $response->assertViewIs('account.profile.changePassword');
    }

    /**
     * Test non logged user visits change password page and is redirected to login.
     */
    public function testNonLoggedUserVisitsChangePasswordPageRedirectsToLogin()
    {
        // Request
        $response = $this->call('GET', $this->accountChangePasswordPageUrl);

        // Asserts
        $response->assertStatus(302);
        $response->assertRedirect('login');
    }

    /**
     * Test update password ok.
     */
    public function testUpdatePasswordOk()
    {
        // Config
        $currentPassword = '123456789';
        $newPassword = 'abcdef123456';

        // Prepare
        $user = factory(User::class)->create([
            'password' => bcrypt($currentPassword),
        ]);

        $requestData = [
            'currentpassword' => $currentPassword,
            'newpassword' => $newPassword,
        ];

        $response = $this->actingAs($user)->call('POST', $this->accountChangePasswordPostUrl, $requestData);

        // Asserts
        $response->assertStatus(302);
        $response->assertRedirect($this->accountChangePasswordPageUrl);
        $response->assertSessionHas('success', trans('home.password_changed'));
    }

    /**
     * Test update password throws an error if the current one is incorrect.
     */
    public function testUpdatePasswordCurrentIsIncorrectError()
    {
        // Config
        $currentPassword = '123456789';
        $newPassword = 'abcdef123456';

        // Prepare
        $user = factory(User::class)->create([
            'password' => bcrypt($currentPassword),
        ]);

        $requestData = [
            'currentpassword' => 'thisisnotthepassword',
            'newpassword' => $newPassword,
        ];

        $response = $this->actingAs($user)->call('POST', $this->accountChangePasswordPostUrl, $requestData);

        // Asserts
        $response->assertStatus(302);
        $response->assertRedirect($this->accountChangePasswordPageUrl);
        $response->assertSessionHasErrors('password');
        $response->assertSessionMissing('success');
    }

    /**
     * Test update password with invalid data returns errors.
     */
    public function testUpdatePasswordValidationError()
    {
        // Config
        $currentPassword = '123456789';
        $newPassword = '123';

        // Prepare
        $user = factory(User::class)->create([
            'password' => bcrypt($currentPassword),
        ]);

        $requestData = [
            'currentpassword' => '123456789',
            'newpassword' => $newPassword,
        ];

        $response = $this->actingAs($user)->call('POST', $this->accountChangePasswordPostUrl, $requestData);

        // Asserts
        $response->assertStatus(302);
        $response->assertRedirect($this->accountChangePasswordPageUrl);
        $response->assertSessionHasErrors('password');
        $response->assertSessionMissing('success');
    }

    /**
     * Test that a non-logged user can't update a password.
     */
    public function testNonLoggedUserUpdatePasswordRedirectsToLogin()
    {
        $response = $this->call('POST', $this->accountChangePasswordPostUrl);

        // Asserts
        $response->assertStatus(302);
        $response->assertRedirect('login');
    }

    /**
     * Test delete success.
     */
    public function testDeleteSuccess()
    {

    }
}
