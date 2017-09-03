<?php

namespace Tests\Functional;

use App\Chapter;
use App\Course;
use App\Lesson;
use App\User;
use Illuminate\Database\Eloquent\Collection;
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
    protected $singleCourseEndpoint = 'curso/{slug}';

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
        $response = $this->call('GET', TestUtils::createEndpoint($this->singleCourseEndpoint, ['slug' => $course->slug]));

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
        $response = $this->call('GET', TestUtils::createEndpoint($this->singleCourseEndpoint, ['slug' => 'course-that-does-not-exist']));

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
        $response = $this->call('GET', TestUtils::createEndpoint($this->singleCourseEndpoint, ['slug' => $course->slug]));

        $response->assertStatus(404);
    }

    /**
     * Get an array of course statuses.
     *
     * @return array
     */
    public static function getCourseStatuses()
    {
        return [['draft'], ['pending'], ['scheduled'], ['deleted']];
    }
}
