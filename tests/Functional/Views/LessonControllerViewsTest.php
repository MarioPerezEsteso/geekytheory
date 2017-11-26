<?php

namespace Tests\Functional\Views;

use App\User;
use Tests\Helpers\TestConstants;
use Tests\Helpers\TestUtils;
use Tests\TestCase;

class LessonControllerViewsTest extends TestCase
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
     * @dataProvider getVisitPageLessonTestCases
     * @param array $example
     */
    public function testVisitPageLessonOk($example)
    {
        // Prepare
        $courses = TestUtils::createCoursesWithChaptersAndLessons(null, 1, 1, 1, ['free' => $example['courseFree'],]);
        $course = $courses->first();
        $chapter = $course->chapters->first();

        if ($example['lessonFree']) {
            $expectedLessons = 2;
            $lesson = TestUtils::addLessonToCourseChapter($chapter, ['free' => true,]);
        } else {
            $expectedLessons = 1;
            $lesson = $chapter->lessons->first();
        }

        if ($example['loggedUser']) {
            if ($example['subscriptionActive']) {
                list($user, $subscription) = TestUtils::createUserAndSubscription();
            } else {
                $user = factory(User::class)->create();
            }
            $this->actingAs($user);
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
        $response->assertResponseDataHasRelationLoaded('course.chapters', 'lessons', $expectedLessons);

        // Specific asserts for the different view shown
        $response->assertResponseHasData('showHeaderTemplate');
        if (!$example['loggedUser']) {
            $response->assertResponseDataItemHasValue('showHeaderTemplate', TestConstants::MODEL_LESSON_TEMPLATE_HEADER_REGISTER);
        } else if ($example['loggedUser'] && $example['subscriptionActive']) {
            $response->assertResponseDataItemHasValue('showHeaderTemplate', TestConstants::MODEL_LESSON_TEMPLATE_HEADER_VIDEO);
        } else if ($example['loggedUser'] && !$example['subscriptionActive']) {
            if ($example['courseFree'] || $example['lessonFree']) {
                $response->assertResponseDataItemHasValue('showHeaderTemplate', TestConstants::MODEL_LESSON_TEMPLATE_HEADER_VIDEO);
            } else {
                $response->assertResponseDataItemHasValue('showHeaderTemplate', TestConstants::MODEL_LESSON_TEMPLATE_HEADER_GOPREMIUM);
            }
        }
    }

    /**
     * Get an array of course statuses.
     *
     * @return array
     */
    public static function getVisitPageLessonTestCases()
    {
        return [
            [[
                'loggedUser' => false,
                'subscriptionActive' => false,
                'courseFree' => true,
                'lessonFree' => true,
            ],],
            [[
                'loggedUser' => true,
                'subscriptionActive' => false,
                'courseFree' => true,
                'lessonFree' => true,
            ],],
            [[
                'loggedUser' => true,
                'subscriptionActive' => true,
                'courseFree' => true,
                'lessonFree' => true,
            ],],
            [[
                'loggedUser' => false,
                'subscriptionActive' => false,
                'courseFree' => false,
                'lessonFree' => true,
            ],],
            [[
                'loggedUser' => true,
                'subscriptionActive' => false,
                'courseFree' => false,
                'lessonFree' => true,
            ],],
            [[
                'loggedUser' => true,
                'subscriptionActive' => true,
                'courseFree' => false,
                'lessonFree' => true,
            ],],
            [[
                'loggedUser' => false,
                'subscriptionActive' => false,
                'courseFree' => false,
                'lessonFree' => false,
            ],],
            [[
                'loggedUser' => true,
                'subscriptionActive' => false,
                'courseFree' => false,
                'lessonFree' => false,
            ],],
            [[
                'loggedUser' => true,
                'subscriptionActive' => true,
                'courseFree' => false,
                'lessonFree' => false,
            ],],
        ];
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
