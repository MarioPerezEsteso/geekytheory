<?php

namespace Tests\Functional;

use App\Course;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Tests\Helpers\Response;
use Tests\Helpers\TestUtils;
use Tests\TestCase;

class CourseControllerTest extends TestCase
{
    /**
     * Courses endpoint.
     *
     * @var string
     */
    protected $coursesEndpoint = 'cursos';

    /**
     * Single course endpoint.
     */
    protected $singleCourseUrl = 'curso/{slug}';

    /**
     * Join course endpoint.
     *
     * @var string
     */
    protected $joinCoursePostEndpoint = 'curso/{id}/matriculacion';

    /**
     * Test page single course ok.
     */
    public function testVisitPageGetSingleCourseOk()
    {
        // Prepare
        $teacher = factory(User::class)->create();
        $courses = TestUtils::createCoursesWithChaptersAndLessons($teacher, 1, 3, 5);
        $course = $courses->first();

        // Request
        $response = $this->call('GET', TestUtils::createEndpoint($this->singleCourseUrl, ['slug' => $course->slug]));

        // Asserts
        $response->assertStatus(200);
        $response->assertResponseIsView('courses.course');
        $response->assertResponseHasData('course');
        $response->assertResponseDataHasRelationLoaded('course', 'teacher');
        $response->assertResponseDataHasRelationLoaded('course', 'chapters', 3);
        $response->assertResponseDataHasRelationLoaded('course.chapters', 'lessons', 5);
    }

    /**
     * Test get single course that does not exist throws a not found error.
     */
    public function testGetSingleCourseErrorNotFound()
    {
        // Request
        $response = $this->call('GET', TestUtils::createEndpoint($this->singleCourseUrl, ['slug' => 'course-that-does-not-exist']));

        // Asserts
        $response->assertStatus(404);
    }

    /**
     * Test get single course that exists but is not published throws a not found error.
     *
     * @dataProvider getCourseStatuses
     * @param string $status
     */
    public function testGetSingleCourseNotPublishedErrorNotFound($status)
    {
        // Prepare
        $teacher = factory(User::class)->create();
        $courses = TestUtils::createCoursesWithChaptersAndLessons($teacher, 1, 1, 1, ['status' => $status]);
        $course = $courses->first();

        // Request
        $response = $this->call('GET', TestUtils::createEndpoint($this->singleCourseUrl, ['slug' => $course->slug]));

        $response->assertStatus(404);
    }

    /**
     * Provider for method testGetSingleCourseNotPublishedErrorNotFound.
     *
     * @return array
     */
    public static function getCourseStatuses()
    {
        return [['draft'], ['pending'], ['scheduled'], ['deleted']];
    }

    /**
     * Test join course ok.
     *
     * @dataProvider getJoinCourseOkTestData
     * @param $courseFree
     * @param $subscriptionFree
     */
    public function testJoinCourseOk($courseFree, $subscriptionFree)
    {
        // Prepare
        /** @var Collection $courses */
        $courses = TestUtils::createCoursesWithChaptersAndLessons(null, 1, 1, 1, ['free' => $courseFree]);
        /** @var Course $course */
        $course = $courses->first();

        /** @var User $pupil */
        if (!$subscriptionFree) {
            list($pupil, $subscription) = TestUtils::createUserAndSubscription();
        } else {
            $pupil = factory(User::class)->create([]);
        }

        // Request
        /** @var Response $response */
        $response = $this->actingAs($pupil)->call('POST', TestUtils::createEndpoint($this->joinCoursePostEndpoint, ['id' => $course->id,]));

        // Asserts
        $response->assertRedirect(TestUtils::createEndpoint($this->singleCourseUrl, ['slug' => $course->slug]));

        $response->assertSessionHas(['success' => trans('public.joined_course_ok')]);

        $this->assertDatabaseHas('users_courses', [
            'user_id' => $pupil->id,
            'course_id' => $course->id,
        ]);
    }

    /**
     * Test that the teacher of the course can join in.
     *
     * @dataProvider providerTestTeacherCanJoinCourseOk
     * @param boolean $courseFree
     * @param boolean $subscriptionFree
     */
    public function testTeacherCanJoinCourseOk($courseFree, $subscriptionFree)
    {
        // Prepare
        /** @var User $teacher */
        $teacher = factory(User::class)->create([]);

        /** @var Collection $courses */
        $courses = TestUtils::createCoursesWithChaptersAndLessons($teacher, 1, 1, 1, ['free' => $courseFree]);
        /** @var Course $course */
        $course = $courses->first();

        if (!$subscriptionFree) {
            // @TODO: subscribe user to paid plan
        }

        // Request
        /** @var Response $response */
        $response = $this->actingAs($teacher)->call('POST', TestUtils::createEndpoint($this->joinCoursePostEndpoint, ['id' => $course->id,]));

        // Asserts
        $response->assertStatus(200);

        $response->assertExactJson(['joined' => 1]);

        $this->assertDatabaseHas('users_courses', [
            'user_id' => $teacher->id,
            'course_id' => $course->id,
        ]);
    }

    /**
     * Data provider for testJoinCourseOk and testTeacherCanJoinCourseOk
     *
     * @return array
     */
    public static function providerTestTeacherCanJoinCourseOk()
    {
        return [
            'Free course and free subscription' => [true, true,],
            'Free course and premium subscription' => [true, false],
            'Premium course and premium subscription' => [false, false,]
        ];
    }

    /**
     * Test that a user can't join a course that has not been published.
     *
     * @dataProvider getJoinCourseNonPublishedErrorTestData
     * @param string $courseStatus
     */
    public function testJoinCourseNonPublishedError($courseStatus)
    {
        // Prepare
        /** @var Collection $courses */
        $courses = TestUtils::createCoursesWithChaptersAndLessons(null, 1, 1, 1, ['status' => $courseStatus]);

        /** @var Course $course */
        $course = $courses->first();

        /** @var User $pupil */
        $pupil = factory(User::class)->create([]);

        // Request
        /** @var Response $response */
        $response = $this->actingAs($pupil)->call('POST', TestUtils::createEndpoint($this->joinCoursePostEndpoint, ['id' => $course->id,]));

        // Asserts
        $response->assertStatus(200);

        $response->assertExactJson([
            'joined' => 0,
            'error' => trans('public.course_does_not_exist'),
        ]);

        $this->assertDatabaseMissing('users_courses', [
            'user_id' => $pupil->id,
            'course_id' => $course->id,
        ]);
    }

    /**
     * Data provider for testJoinCourseNonPublishedError.
     *
     * @return array
     */
    public static function getJoinCourseNonPublishedErrorTestData()
    {
        return [
            'Course status draft' => ['draft'],
            'Course status pending' => ['pending'],
            'Course status scheduled' => ['scheduled'],
            'Course status deleted' => ['deleted'],
        ];
    }

    /**
     * Test a user can't join a course that does not exist.
     */
    public function testJoinCourseThatDoesNotExistError()
    {
        // Prepare
        /** @var User $pupil */
        $pupil = factory(User::class)->create([]);

        // Request
        /** @var Response $response */
        $response = $this->actingAs($pupil)->call('POST', TestUtils::createEndpoint($this->joinCoursePostEndpoint, ['id' => 999,]));

        // Asserts
        $response->assertStatus(404);
    }

    /**
     * Test that a user with free subscription can't join a premium course.
     */
    public function testJoinPremiumCourseWithFreeSubscriptionError()
    {
        // Prepare
        /** @var Collection $courses */
        $courses = TestUtils::createCoursesWithChaptersAndLessons(null, 1, 1, 1, ['free' => false]);
        /** @var Course $course */
        $course = $courses->first();
        /** @var User $pupil */
        $pupil = factory(User::class)->create([]);

        // Request
        /** @var Response $response */
        $response = $this->actingAs($pupil)->call('POST', TestUtils::createEndpoint($this->joinCoursePostEndpoint, ['id' => $course->id,]));

        // Asserts
        $response->assertStatus(200);

        $response->assertExactJson([
            'joined' => 0,
            'error' => trans('public.you_must_be_premium_subscriber'),
        ]);

        $this->assertDatabaseMissing('users_courses', [
            'user_id' => $pupil->id,
            'course_id' => $course->id,
        ]);
    }

    /**
     * Test join course redirects to login if user is not logged in.
     */
    public function testJoinCourseNonLoggedUserNotAuthorized()
    {
        // Prepare
        /** @var Collection $courses */
        $courses = TestUtils::createCoursesWithChaptersAndLessons();
        /** @var Course $course */
        $course = $courses->first();

        // Request
        /** @var Response $response */
        $response = $this->call('POST', TestUtils::createEndpoint($this->joinCoursePostEndpoint, ['id' => $course->id,]));

        // Asserts
        $response->assertRedirect('login');
    }
}
