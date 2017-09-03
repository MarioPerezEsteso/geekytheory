<?php

namespace Tests\Helpers;

use App\Chapter;
use App\Course;
use App\Lesson;
use App\User;
use Illuminate\Database\Eloquent\Collection;

class TestUtils
{
    /**
     * Create endpoint with parameters.
     *
     * @param string $endpoint
     * @param array $params
     * @return string
     */
    public static function createEndpoint($endpoint, $params = []): string
    {
        foreach ($params as $param => $value) {
            $endpoint = str_replace('{' . $param . '}', $value, $endpoint);
        }

        return $endpoint;
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
    public static function createCoursesWithChaptersAndLessons(User $teacher, $numberOfCourses = 1, $numberOfChapters = 1, $numberOfLessons = 1, $courseAttributes = [])
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
            for ($numChapters = 1; $numChapters <= $numberOfChapters; $numChapters++) {
                $chapter = factory(Chapter::class)->create([
                    'course_id' => $course->id,
                    'order' => $numChapters,
                ]);
                for ($numLessons = 1; $numLessons <= $numberOfLessons; $numLessons++) {
                    $lesson = factory(Lesson::class)->create([
                        'chapter_id' => $chapter->id,
                        'slug' => 'course-' . $i . '-chapter-' . $numChapters. '-lesson-' . $numLessons,
                        'title' => $faker->title,
                        'content' => $faker->text,
                        'video' => 'https://youtube.com/whatever',
                        'order' => $numLessons,
                        'duration' => $faker->numberBetween(10, 50),
                        'free' => false,
                    ]);
                }
            }
            $courses->add($course);
        }

        return $courses;
    }
}
