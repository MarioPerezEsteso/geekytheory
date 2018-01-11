<?php

namespace Tests\Functional\Views;

use App\User;
use Tests\Helpers\Response;
use Tests\Helpers\TestUtils;
use Tests\TestCase;

class AccountControllerViewsTest extends TestCase
{
    /**
     * Single course endpoint.
     */
    protected $accountUrl = 'cuenta';

    /**
     * Test page single course ok.
     *
     * @dataProvider providerTestVisitPageAccountOk
     * @param boolean $subscriptionActive
     */
    public function testVisitPageAccountOk($subscriptionActive)
    {
        // Config
        $numberOfCourses = 3;

        // Prepare
        if ($subscriptionActive) {
            list($user, $subscription) = TestUtils::createUserAndSubscription();
        } else {
            $user = factory(User::class)->create();
        }

        TestUtils::createCoursesWithChaptersAndLessons(null, $numberOfCourses);
        TestUtils::createCoursesWithChaptersAndLessons(null, $numberOfCourses, 1, 1, ['status' => 'scheduled']);

        // Request
        $this->actingAs($user);

        /** @var Response $response */
        $response = $this->call('GET', $this->accountUrl);

        // Asserts
        // @TODO: test that published and scheduled courses are being shown in the view.
        $response->assertStatus(200);
        $response->assertResponseIsView('account.index');
        $response->assertResponseDataItemHasValue('userHasSubscriptionActive', $subscriptionActive);
        $response->assertResponseHasData('courses');
    }

    /**
     * Data provider for testVisitPageGetSingleCourseOk.
     *
     * @return array
     */
    public function providerTestVisitPageAccountOk(): array
    {
        return [
            'user has subscription' => [true],
            'user has not subscription' => [false],
        ];
    }

    /**
     * Test that only logged users can visit the account page.
     */
    public function testVisitPageAccountNotLoggedInRedirectsToLogin()
    {
        // Request
        $response = $this->call('GET', $this->accountUrl);

        // Asserts
        $response->assertRedirect($this->loginUrl);
    }
}
