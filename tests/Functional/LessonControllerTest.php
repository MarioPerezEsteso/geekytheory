<?php

namespace Tests\Functional;

use App\User;
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

    /*
     * Test visit a lesson page ok returns the correct view and data.
     */
    public function testVisitPageLessonOk()
    {
        // Prepare
        $teacher = factory(User::class)->create();
        $courses = TestUtils::createCoursesWithChaptersAndLessons($teacher, 3, 3, 3);
        $course = $courses->first();
        $chapter = $course->chapters->first();
        $lesson = $chapter->lessons->first();

        // Request
        $response = $this->call('GET', TestUtils::createEndpoint($this->lessonEndpoint, [
            'courseSlug' => $course->slug,
            'lessonSlug' => $lesson->slug,
        ]));

        // Asserts
        $response->assertStatus(200);
        $response->assertResponseIsView('courses.lesson');
        $response->assertResponseHasData('course');
        $response->assertResponseDataHasValues('course', $course->attributesToArray());
        $response->assertResponseHasData('lesson');
        $response->assertResponseDataHasValues('lesson', $lesson->attributesToArray());
        $response->assertResponseDataHasRelationLoaded('course', 'chapters', 3);
        $response->assertResponseDataHasRelationLoaded('course.chapters', 'lessons', 3);
    }

}