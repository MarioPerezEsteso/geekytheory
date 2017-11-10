<?php

namespace Tests\Helpers;

use App\Chapter;
use App\Course;
use App\Lesson;
use App\Subscription;
use App\User;
use Faker\Factory;
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
     * Populate the database with courses, chapters and lessons. By default, the course has beginner difficulty,
     * it is published and it is not free.
     *
     * @param User $teacher
     * @param integer $numberOfCourses
     * @param integer $numberOfChapters
     * @param integer $numberOfLessons
     * @param array $courseAttributes
     *
     * @return Collection
     */
    public static function createCoursesWithChaptersAndLessons(User $teacher = null, $numberOfCourses = 1, $numberOfChapters = 1, $numberOfLessons = 1, $courseAttributes = [])
    {
        $courseAttributes = array_merge(['difficulty' => 'beginner', 'status' => 'published', 'free' => false,], $courseAttributes);
        $faker = \Faker\Factory::create();

        if (!$teacher) {
            $teacher = factory(User::class)->create();
        }

        $courses = new Collection();
        for ($i = 1; $i <= $numberOfCourses; $i++) {
            $course = factory(Course::class)->create([
                'teacher_id' => $teacher->id,
                'slug' => $faker->slug,
                'title' => $faker->text,
                'description' => $faker->text,
                'image' => $faker->url,
                'image_thumbnail' => $faker->url,
                'difficulty' => $courseAttributes['difficulty'],
                'duration' => 100,
                'students' => 50,
                'free' => $courseAttributes['free'],
                'status' => $courseAttributes['status'],
            ]);
            for ($numChapters = 1; $numChapters <= $numberOfChapters; $numChapters++) {
                $chapter = factory(Chapter::class)->create([
                    'course_id' => $course->id,
                    'order' => $numChapters,
                    'title' => $faker->text,
                ]);
                for ($numLessons = 1; $numLessons <= $numberOfLessons; $numLessons++) {
                    $lesson = factory(Lesson::class)->create([
                        'chapter_id' => $chapter->id,
                        'slug' => 'course-' . $i . '-chapter-' . $numChapters . '-lesson-' . $numLessons,
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

    /**
     * Add lesson to course chapter.
     *
     * @param Chapter $chapter
     * @param array $lessonAttributes
     * @return Lesson
     */
    public static function addLessonToCourseChapter(Chapter $chapter, $lessonAttributes)
    {
        $faker = Factory::create();
        $attributes = array_merge([
            'chapter_id' => $chapter->id,
            'slug' => $faker->slug,
            'title' => $faker->title,
            'content' => $faker->text,
            'video' => 'https://youtube.com/whatever',
            'order' => $faker->numberBetween(20, 50),
            'duration' => $faker->numberBetween(100, 500),
            'free' => false,
        ], $lessonAttributes);

        return factory(Lesson::class)->create($attributes);
    }

    /**
     * Create a user and a subscription.
     *
     * @param array $userAndCardAttributes
     * @param array $subscriptionAttributes
     * @param bool $createSubscriptionInStripe
     * @return void
     */
    public static function createUserAndSubscription($userAndCardAttributes = [], $subscriptionAttributes = [], $createSubscriptionInStripe = false)
    {
        if (!$createSubscriptionInStripe) {
            $userAttributes = array_merge([
                'stripe_id' => 'fake_stripe_id_123',
                'card_brand' => 'Visa',
                'card_last_four' => '4242',
                'trial_ends_at' => null,
            ], $userAndCardAttributes);

            /** @var User $user */
            $user = factory(User::class)->create($userAttributes);

            $subscriptionAttributes = array_merge([
                'user_id' => $user->id,
                'stripe_id' => 'another_fake_stripe_id_456',
                'name' => TestConstants::MODEL_SUBSCRIPTION_PLAN_NAME,
                'stripe_plan' => TestConstants::MODEL_SUBSCRIPTION_PLAN_MONTHLY,
                'quantity' => 1,
                'trial_ends_at' => null,
                'ends_at' => null,
            ], $subscriptionAttributes);

            /** @var \Laravel\Cashier\Subscription $subscription */
            $subscription = factory(\Laravel\Cashier\Subscription::class)->create($subscriptionAttributes);
        } else {
            /** @var User $user */
            $user = factory(User::class)->create();

            $stripePlan = $subscriptionAttributes['stripe_plan'] ?? TestConstants::MODEL_SUBSCRIPTION_PLAN_MONTHLY;

            /** @var \Stripe\Subscription $subscription */
            $subscription = $user->newSubscription(TestConstants::MODEL_SUBSCRIPTION_PLAN_NAME, $stripePlan)
                ->skipTrial()
                ->create('tok_visa', [
                    'email' => $user->email,
                    'metadata' => [
                        'ip' => getClientIPAddress(),
                    ]
                ]);
        }

        return [$user, $subscription];
    }
}
