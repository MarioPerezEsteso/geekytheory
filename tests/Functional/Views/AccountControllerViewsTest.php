<?php

namespace Tests\Functional\Views;

use App\User;
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

        $courses = TestUtils::createCoursesWithChaptersAndLessons(null, $numberOfCourses);

        // Request
        $this->actingAs($user);

        $response = $this->call('GET', $this->accountUrl);

        // Asserts
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
}
