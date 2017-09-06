<?php

namespace Tests\Functional;

use App\User;
use Illuminate\Support\Facades\Auth;
use Tests\Helpers\TestConstants;
use Tests\Helpers\TestUtils;
use Tests\TestCase;

class LessonControllerTest extends TestCase
{
    /**
     * Lesson endpoint.
     *
     * @var string
     */
    protected $lessonEndpoint = 'curso/{courseSlug}/{lessonSlug}';

    /**
     * Test visit a lesson page ok returns the correct view and data.
     *
     * @dataProvider getVisitPageLessonOkTestCases
     * @param boolean $loggedUser
     * @param boolean $subscriptionActive
     */
    public function testVisitPageCourseFreeLessonFreeOk($loggedUser, $subscriptionActive)
    {
        // Prepare
        $courses = TestUtils::createCoursesWithChaptersAndLessons(null, 1, 1, 1, ['free' => true,]);
        $course = $courses->first();
        $chapter = $course->chapters->first();
        $lesson = TestUtils::addLessonToCourseChapter($chapter, ['free' => true,]);

        if ($loggedUser) {
            $user = factory(User::class)->create(['can_login' => true]);
            $this->be($user);
            if ($subscriptionActive) {
                // TODO: mock active subscription
            }
        }

        // Request
        $response = $this->call('GET', TestUtils::createEndpoint($this->lessonEndpoint, [
            'courseSlug' => $course->slug,
            'lessonSlug' => $lesson->slug,
        ]));

        // Asserts
        $response->assertStatus(200);
        $response->assertResponseIsView('courses.lesson');
        $response->assertResponseHasData('course');
        $response->assertResponseDataModelHasValues('course', $course->attributesToArray());
        $response->assertResponseHasData('lesson');
        $response->assertResponseDataModelHasValues('lesson', $lesson->attributesToArray());
        $response->assertResponseDataHasRelationLoaded('course', 'chapters', 1);
        $response->assertResponseDataHasRelationLoaded('course.chapters', 'lessons', 2);

        // Specific asserts for the different view shown
        $response->assertResponseHasData('showHeaderTemplate');
        if (!$loggedUser) {
            $response->assertResponseDataItemHasValue('showHeaderTemplate', TestConstants::MODEL_LESSON_TEMPLATE_HEADER_REGISTER);
        } else if ($loggedUser && $subscriptionActive) {
            $response->assertResponseDataItemHasValue('showHeaderTemplate', TestConstants::MODEL_LESSON_TEMPLATE_HEADER_VIDEO);
        } else if ($loggedUser && !$subscriptionActive) {
            $response->assertResponseDataItemHasValue('showHeaderTemplate', TestConstants::MODEL_LESSON_TEMPLATE_HEADER_VIDEO);
        }
    }

    public function testVisitPageCoursePaidLessonFreeOk($loggedUser)
    {

    }


    public function testVisitPageCoursePaidLessonPaidOk($loggedUser)
    {

    }

    /**
     * Get an array of course statuses.
     *
     * @return array
     */
    public static function getVisitPageLessonOkTestCases()
    {
        // First item: loggedUser
        // Second item: subscriptionActive
        return [[false, false,], [true, false,], [true, true,],];
    }

    /**
     * Test visit page of a course lesson throws 404 not found error when course slug does not exist.
     */
    public function testVisitPageLessonCourseIsNotFound()
    {
        // Prepare
        $courses = TestUtils::createCoursesWithChaptersAndLessons();
        $course = $courses->first();
        $chapter = $course->chapters->first();
        $lesson = $chapter->lessons->first();

        // Request
        $response = $this->call('GET', TestUtils::createEndpoint($this->lessonEndpoint, [
            'courseSlug' => 'this-course-slug-does-not-exist',
            'lessonSlug' => $lesson->slug,
        ]));

        // Asserts
        $response->assertStatus(404);
    }

    /**
     * Test visit page of a course lesson throws 404 not found error when lesson slug does not exist in that course.
     */
    public function testVisitPageLessonIsNotFound()
    {
        $courses = TestUtils::createCoursesWithChaptersAndLessons();
        $course = $courses->first();

        // Request
        $response = $this->call('GET', TestUtils::createEndpoint($this->lessonEndpoint, [
            'courseSlug' => $course->slug,
            'lessonSlug' => 'this-lesson-does-not-exist',
        ]));

        // Asserts
        $response->assertStatus(404);
    }

}