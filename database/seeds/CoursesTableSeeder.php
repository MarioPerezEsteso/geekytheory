<?php

use App\Chapter;
use App\Course;
use App\Lesson;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $teacher = factory(\App\User::class)->create();
        $courses = new Collection();
        foreach ([Course::DIFFICULTY_BEGGINER, Course::DIFFICULTY_INTERMEDIATE, Course::DIFFICULTY_ADVANCED] as $difficulty) {
            foreach ([true, false] as $free) {
                $course = factory(Course::class)->create([
                    'teacher_id' => $teacher->id,
                    'slug' => $faker->slug,
                    'title' => $faker->text,
                    'description' => $faker->text,
                    'image' => $faker->url,
                    'difficulty' => $difficulty,
                    'duration' => 100,
                    'students' => 50,
                    'free' => $free,
                    'status' => Course::STATUS_PUBLISHED,
                ]);
                for ($numChapters = 1; $numChapters <= 3; $numChapters++) {
                    $chapter = factory(Chapter::class)->create([
                        'course_id' => $course->id,
                        'title' => $faker->title,
                        'order' => $numChapters,
                    ]);
                    // Create free lessons
                    if ($course->free) {
                        $free = [true, true, true, true, true];
                    } else {
                        $free = [false, false, true, false, true];
                    }
                    for ($numLessons = 0; $numLessons < count($free); $numLessons++) {
                        $lesson = factory(Lesson::class)->create([
                            'chapter_id' => $chapter->id,
                            'slug' => 'course-' . $course->id . '-chapter-' . $chapter->id . '-lesson-' . $numLessons,
                            'title' => $faker->title,
                            'content' => $faker->text,
                            'video' => 'https://youtube.com/whatever',
                            'order' => $numLessons,
                            'duration' => $faker->numberBetween(10, 50),
                            'free' => $free[$numLessons],
                        ]);
                    }
                }
                $courses->add($course);
            }
    }
}
}
