<?php

namespace Tests\Functional\Views;

use App\User;
use Tests\Helpers\TestUtils;
use Tests\TestCase;

class CourseControllerViewsTest extends TestCase
{
    /**
     * Single course endpoint.
     */
    protected $singleCourseUrl = 'curso/{slug}';

    /**
     * Test page single course ok.
     *
     * @dataProvider providerTestVisitPageGetSingleCourseOk
     * @param boolean $userLoggedIn
     */
    public function testVisitPageGetSingleCourseOk($userLoggedIn)
    {
        // Prepare
        $teacher = factory(User::class)->create();
        $courses = TestUtils::createCoursesWithChaptersAndLessons($teacher, 1, 3, 5);
        $course = $courses->first();

        // Request
        if ($userLoggedIn) {
            $user = factory(User::class)->create();
            $this->actingAs($user);
        }

        $response = $this->call('GET', TestUtils::createEndpoint($this->singleCourseUrl, ['slug' => $course->slug]));

        // Asserts
        $response->assertStatus(200);
        $response->assertResponseIsView('courses.single');
        $response->assertResponseHasData('userHasJoinedCourse');
        $response->assertResponseDataItemHasValue('userHasJoinedCourse', false);
        $response->assertResponseHasData('course');
        $response->assertResponseDataHasRelationLoaded('course', 'teacher');
        $response->assertResponseDataHasRelationLoaded('course', 'chapters', 3);
        $response->assertResponseDataHasRelationLoaded('course.chapters', 'lessons', 5);
    }

    /**
     * Data provider for testVisitPageGetSingleCourseOk.
     *
     * @return array
     */
    public function providerTestVisitPageGetSingleCourseOk(): array
    {
        return [
            'user logged in' => [true],
            'user not logged in' => [false],
        ];
    }

    /**
     * Test user enrolled in course visits page single course ok.
     */
    public function testVisitPageGetSingleCourseWhenUserHasJoinedCourseOk()
    {
        // Prepare
        $user = factory(User::class)->create();
        $courses = TestUtils::createCoursesWithChaptersAndLessons(null, 1, 3, 5);
        $course = $courses->first();

        TestUtils::enrollUserInCourse($user, $course);

        // Request
        $response = $this->actingAs($user)->call('GET', TestUtils::createEndpoint($this->singleCourseUrl, ['slug' => $course->slug]));

        // Asserts
        $response->assertStatus(200);
        $response->assertResponseIsView('courses.single');
        $response->assertResponseHasData('userHasJoinedCourse');
        $response->assertResponseDataItemHasValue('userHasJoinedCourse', true);
        $response->assertResponseHasData('course');
        $response->assertResponseDataHasRelationLoaded('course', 'teacher');
        $response->assertResponseDataHasRelationLoaded('course', 'chapters', 3);
        $response->assertResponseDataHasRelationLoaded('course.chapters', 'lessons', 5);
    }
}
