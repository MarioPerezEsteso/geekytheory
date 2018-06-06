<?php

namespace Tests\Functional\Views;

use App\User;
use Carbon\Carbon;
use Tests\Helpers\Response;
use Tests\Helpers\TestUtils;
use Tests\TestCase;

class CourseControllerViewsTest extends TestCase
{
    /**
     * View all courses endpoint.
     *
     * @var string
     */
    protected $allCoursesUrl = 'cursos';

    /**
     * Single course endpoint.
     *
     * @var string
     */
    protected $singleCourseUrl = 'curso/{slug}';

    /**
     * Test visit courses page and view courses ok.
     */
    public function testVisitPageCoursesOk()
    {
        // Prepare
        $premiumCourses = TestUtils::createCoursesWithChaptersAndLessons(null, 1, 3, 5, ['free' => false, 'status' => 'published']);
        $freeCourses = TestUtils::createCoursesWithChaptersAndLessons(null, 1, 4, 7, ['free' => true, 'status' => 'published']);
        $scheduledCourses = TestUtils::createCoursesWithChaptersAndLessons(null, 1, 3, 5, ['free' => false, 'status' => 'scheduled']);

        // Request
        /** @var Response $response */
        $response = $this->call('GET', $this->allCoursesUrl);

        // Asserts
        $response->assertStatus(200);
        $response->assertResponseIsView('web.courses.index');
        $response->assertResponseHasData('premiumCourses');
        $response->assertResponseDataCollectionHasNumberOfItems('premiumCourses', 1);
        $response->assertResponseDataCollectionItemHasValues('premiumCourses', 0, $premiumCourses->get(0)->attributesToArray());
        $response->assertResponseDataCollectionHasNumberOfItems('freeCourses', 1);
        $response->assertResponseDataCollectionItemHasValues('freeCourses', 1, $freeCourses->get(0)->attributesToArray());
        $response->assertResponseDataCollectionHasNumberOfItems('scheduledCourses', 1);
        $response->assertResponseDataCollectionItemHasValues('scheduledCourses', 2, $scheduledCourses->get(0)->attributesToArray());
        $response->assertResponseDataHasRelationLoaded('premiumCourses', 'chapters', 3);
//        $response->assertResponseDataHasRelationLoaded('premiumCourses.chapters', 'lessons', 5);
        $response->assertResponseDataHasRelationLoaded('freeCourses', 'chapters', 4);
//        $response->assertResponseDataHasRelationLoaded('freeCourses.chapters', 'lessons', 7);
        $response->assertResponseDataHasRelationLoaded('scheduledCourses', 'chapters', 3);
//        $response->assertResponseDataHasRelationLoaded('scheduledCourses.chapters', 'lessons', 5);
    }

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
