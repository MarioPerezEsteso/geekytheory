<?php

namespace Tests\Functional;

use App\Chapter;
use App\Course;
use App\Lesson;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Tests\Helpers\Functional;
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
    protected $singleCourseEndpoint = 'cursos/{slug}';

    /**
     * Test page single course ok.
     */
    public function testVisitPageGetSingleCourseOk()
    {
        // Prepare
        $teacher = factory(User::class)->create();
        $courses = $this->createCoursesWithChaptersAndLessons($teacher);
        $course = $courses->first();

        // Request
        $response = $this->call('GET', TestUtils::createEndpoint($this->singleCourseEndpoint, ['slug' => $course->slug]));

        // Asserts
        $response->assertStatus(200);
        $response->assertResponseIsView('courses.course');
        $response->assertResponseHasData('course');
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
        $courses = $this->createCoursesWithChaptersAndLessons($teacher, 1, 1, 1, ['status' => $status]);
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

    /**
     * Populate the database with courses, chapters and lessons.
     *
     * @param User $teacher
     * @param integer $numberOfCourses
     * @param integer $numberOfChapters
     * @param integer $numberOfLessons
     * @param array $courseAttributes
     *
     * @return Collection
     */
    private function createCoursesWithChaptersAndLessons(User $teacher, $numberOfCourses = 1, $numberOfChapters = 1, $numberOfLessons = 1, $courseAttributes = [])
    {
        $courseAttributes = array_merge(['difficulty' => 'beginner' , 'status' => 'published'], $courseAttributes);
        $faker = \Faker\Factory::create();
        $courses = new Collection();
        for ($i = 1; $i <= $numberOfCourses; $i++) {
            $course = factory(Course::class)->create([
                'teacher_id' => $teacher->id,
                'slug' => $faker->slug,
                'title' => $faker->text,
                'description' => $faker->text,
                'image' => $faker->url,
                'difficulty' => $courseAttributes['difficulty'],
                'duration' => 100,
                'students' => 50,
                'free' => false,
                'status' => $courseAttributes['status'],
            ]);
//            for ($numChapters = 1; $numChapters <= $numberOfChapters; $numChapters++) {
//                $chapter = factory(Chapter::class)->create(['course_id' => $course->id]);
                /*for ($numLessons = 1; $numLessons <= $numberOfLessons; $numLessons++) {
                    $lesson = factory(Lesson::class)->create([]);
                }*/
//            }
            $courses->add($course);
        }

        return $courses;
    }
}
