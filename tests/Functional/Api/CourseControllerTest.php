<?php

namespace Tests\Functional\Api;

use App\Course;
use App\User;
use Tests\Helpers\Functional;
use Tests\TestCase;

class CourseControllerTest extends TestCase
{
    /**
     * Courses endpoint
     *
     * @var string
     */
    protected $coursesEndpoint = 'api/courses';

    /**
     * Test user login ok and redirect to /home
     */
    public function testGetCoursesOk()
    {
        // Config
        $numberOfCourses = 10;
        $numberOfChapters = 5;
        $numberOfLessons = 7;

        // Prepare
        $teacher = factory(User::class)->create();
        $this->createCoursesWithChaptersAndLessons($teacher, $numberOfCourses, $numberOfChapters, $numberOfLessons);

        // Request
        $response = $this->call('get', $this->coursesEndpoint);

        $response->assertStatus(200);
        $response->assertApiResponseResourceCountIs($numberOfCourses);
    }

    /**
     * Populate the database with courses, chapters and lessons.
     *
     * @param User $teacher
     * @param integer $numberOfCourses
     * @param integer $numberOfChapters
     * @param integer $numberOfLessons
     */
    private function createCoursesWithChaptersAndLessons(User $teacher, $numberOfCourses = 1, $numberOfChapters = 1, $numberOfLessons = 1)
    {
        $faker = \Faker\Factory::create();
        for ($i = 1; $i <= $numberOfCourses; $i++) {
            $course = factory(Course::class)->create([
                'teacher_id' => $teacher->id,
                'slug' => $faker->slug,
                'title' => $faker->text,
                'description' => $faker->text,
                'image' => $faker->url,
                'difficulty' => 'beginner',
                'duration' => 100,
                'students' => 50,
                'free' => false,
                'status' => 'published',
            ]);
            /*for ($numChapters = 1; $numChapters <= $numberOfChapters; $numChapters++) {
                $chapter = factory(Chapter::class)->create([]);
                for ($numLessons = 1; $numLessons <= $numberOfLessons; $numLessons++) {
                    $lesson = factory(Lesson::class)->create([]);
                }
            }*/
        }
    }
}
