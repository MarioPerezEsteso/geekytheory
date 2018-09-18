<?php

namespace Tests\Functional;

use App\Chapter;
use App\Course;
use App\Lesson;
use App\User;
use Tests\Helpers\Response;
use Tests\Helpers\TestUtils;
use Tests\TestCase;

class LessonControllerTest extends TestCase
{
    /**
     * Start lesson POST URL.
     *
     * @var string
     */
    protected $startLessonPostUrl = '/lesson/start';
    
    /**
     * Complete lesson POST URL.
     *
     * @var string
     */
    protected $completeLessonPostUrl = '/lesson/complete';

    /**
     * Test start lesson.
     * @dataProvider providerTestStartLesson
     *
     * @param array $example
     */
    public function testStartLesson($example)
    {
        // Prepare
        $isFreeCourse = $example['premiumCourse'] === false;
        $isFreeLesson = $example['premiumLesson'] === false;
        $isPremiumUser = $example['premiumUser'] === true;
        $userCanMarkLessonAsStarted = $example['canMarkLessonAsStarted'] === true;

        $courses = TestUtils::createCoursesWithChaptersAndLessons(
            null,
            1,
            1,
            1,
            ['free' => $isFreeCourse,]
        );

        /** @var Course $course */
        $course = $courses->first();

        /** @var Chapter $chapter */
        $chapter = $course->chapters->first();

        /** @var Lesson $lesson */
        $lesson = TestUtils::addLessonToCourseChapter($chapter, ['free' => $isFreeLesson,]);

        /** @var User $pupil */
        if ($isPremiumUser) {
            list($pupil, $subscription) = TestUtils::createUserAndSubscription();
        } else {
            $pupil = factory(User::class)->create([]);
        }

        // Request
        /** @var Response $response */
        $response = $this->actingAs($pupil)->call(
            'POST',
            $this->startLessonPostUrl,
            [
                'lesson_id' => $lesson->id,
            ]
        );

        // Asserts
        if ($userCanMarkLessonAsStarted) {
            $response->assertStatus(200);

            $response->assertExactJson([
                'message' => 'Lesson started',
            ]);

            $this->assertDatabaseMissing('users_lessons', [
                'user_id' => $pupil->id,
                'lesson_id' => $lesson->id,
                'started_at' => null,
            ]);

            $this->assertDatabaseHas('users_lessons', [
                'user_id' => $pupil->id,
                'lesson_id' => $lesson->id,
                'completed_at' => null,
            ]);
        } else {
            $response->assertStatus(403);

            $response->assertExactJson([
                'message' => 'Could not mark lesson as started',
            ]);

            $this->assertDatabaseMissing('users_lessons', [
                'user_id' => $pupil->id,
                'lesson_id' => $lesson->id,
            ]);
        }
    }

    /**
     * Data provider for testStartLesson.
     *
     * @return array
     */
    public function providerTestStartLesson(): array
    {
        return [
            [
                [
                    'premiumCourse' => false,
                    'premiumLesson' => false,
                    'premiumUser' => false,
                    'canMarkLessonAsStarted' => true,
                ]
            ], [
                [
                    'premiumCourse' => false,
                    'premiumLesson' => false,
                    'premiumUser' => true,
                    'canMarkLessonAsStarted' => true,
                ]
            ], [
                [
                    'premiumCourse' => false,
                    'premiumLesson' => true,
                    'premiumUser' => false,
                    'canMarkLessonAsStarted' => false,
                ]
            ], [
                [
                    'premiumCourse' => false,
                    'premiumLesson' => true,
                    'premiumUser' => true,
                    'canMarkLessonAsStarted' => true,
                ]
            ], [
                [
                    'premiumCourse' => true,
                    'premiumLesson' => false,
                    'premiumUser' => false,
                    'canMarkLessonAsStarted' => true,
                ]
            ], [
                [
                    'premiumCourse' => true,
                    'premiumLesson' => false,
                    'premiumUser' => true,
                    'canMarkLessonAsStarted' => true,
                ]
            ], [
                [
                    'premiumCourse' => true,
                    'premiumLesson' => true,
                    'premiumUser' => false,
                    'canMarkLessonAsStarted' => false,
                ]
            ], [
                [
                    'premiumCourse' => true,
                    'premiumLesson' => true,
                    'premiumUser' => true,
                    'canMarkLessonAsStarted' => true,
                ]
            ],
        ];
    }

    /**
     * Test complete a lesson that has already been completed.
     */
    public function testStartLessonThatHasBeenAlreadyStartedOk()
    {
        // Prepare
        $courses = TestUtils::createCoursesWithChaptersAndLessons(
            null,
            1,
            1,
            1,
            ['free' => true,]
        );

        /** @var Course $course */
        $course = $courses->first();

        /** @var Chapter $chapter */
        $chapter = $course->chapters->first();

        /** @var Lesson $lesson */
        $lesson = TestUtils::addLessonToCourseChapter($chapter, ['free' => true,]);

        /** @var User $pupil */
        $pupil = factory(User::class)->create([]);

        TestUtils::markLessonAsStartedForUser($pupil, $lesson);

        // Request
        /** @var Response $response */
        $response = $this->actingAs($pupil)->call(
            'POST',
            $this->startLessonPostUrl,
            [
                'lesson_id' => $lesson->id,
            ]
        );

        // Asserts
        $response->assertStatus(200);

        $response->assertExactJson([
            'message' => 'Lesson already started',
        ]);

        $this->assertDatabaseMissing('users_lessons', [
            'user_id' => $pupil->id,
            'lesson_id' => $lesson->id,
            'started_at' => null,
        ]);

        $this->assertDatabaseHas('users_lessons', [
            'user_id' => $pupil->id,
            'lesson_id' => $lesson->id,
            'completed_at' => null,
        ]);
    }

    /**
     * Test complete a lesson of a course that has not been published throws a 404 error.
     */
    public function testStartLessonOfCourseNotPublishedThrowsError()
    {
        // Prepare
        $courses = TestUtils::createCoursesWithChaptersAndLessons(
            null,
            1,
            1,
            1,
            [
                'free' => true,
                'status' => 'draft',
            ]
        );

        /** @var Course $course */
        $course = $courses->first();

        /** @var Chapter $chapter */
        $chapter = $course->chapters->first();

        /** @var Lesson $lesson */
        $lesson = TestUtils::addLessonToCourseChapter($chapter, ['free' => true,]);

        /** @var User $pupil */
        $pupil = factory(User::class)->create([]);

        // Request
        /** @var Response $response */
        $response = $this->actingAs($pupil)->call(
            'POST',
            $this->startLessonPostUrl,
            [
                'lesson_id' => $lesson->id,
            ]
        );

        // Asserts
        $response->assertStatus(404);

        $this->assertDatabaseMissing('users_lessons', [
            'user_id' => $pupil->id,
            'lesson_id' => $lesson->id,
        ]);
    }

    /**
     * Test complete a lesson that does not exist throws a 404 error.
     */
    public function testStartLessonThatDoesNotExistThrowsError()
    {
        // Prepare
        $courses = TestUtils::createCoursesWithChaptersAndLessons(
            null,
            1,
            1,
            1,
            [
                'free' => true,
            ]
        );

        /** @var Course $course */
        $course = $courses->first();

        /** @var Chapter $chapter */
        $chapter = $course->chapters->first();

        /** @var Lesson $lesson */
        $lesson = TestUtils::addLessonToCourseChapter($chapter, ['free' => true,]);

        /** @var User $pupil */
        $pupil = factory(User::class)->create([]);

        // Request
        /** @var Response $response */
        $response = $this->actingAs($pupil)->call(
            'POST',
            $this->startLessonPostUrl,
            [
                'lesson_id' => 99999,
            ]
        );

        // Asserts
        $response->assertStatus(404);

        $this->assertDatabaseMissing('users_lessons', [
            'user_id' => $pupil->id,
            'lesson_id' => $lesson->id,
        ]);
    }

    /**
     * Test complete a lesson with validation errors.
     * @dataProvider providerTestStartLessonWithValidationErrors
     *
     * @param $requestData
     * @param $validationErrorKeys
     */
    public function testStartLessonWithValidationErrors($requestData, $validationErrorKeys)
    {
        /** @var User $user */
        $user = factory(User::class)->create();

        // Request
        $response = $this->actingAs($user)->call(
            'POST',
            $this->startLessonPostUrl,
            $requestData
        );

        // Asserts
        $response->assertStatus(422);

        $this->assertDatabaseMissing('users_lessons', [
            'user_id' => $user->id,
        ]);
    }

    /**
     * Provider for testStartLessonWithValidationErrors.
     *
     * @return array
     */
    public function providerTestStartLessonWithValidationErrors(): array
    {
        return [
            [
                'requestData' => [
                    'lesson_id' => null,
                ],
                'validationErrorKeys' => ['lesson_id',],
            ], [
                'requestData' => [
                    'lesson_id' => 0,
                ],
                'validationErrorKeys' => ['lesson_id',],
            ], [
                'requestData' => [
                    'lesson_id' => 'lesson-1',
                ],
                'validationErrorKeys' => ['lesson_id',],
            ],
        ];
    }

    /**
     * Test complete lesson.
     * @dataProvider providerTestCompleteLesson
     *
     * @param array $example
     */
    public function testCompleteLesson($example)
    {
        // Prepare
        $isFreeCourse = $example['premiumCourse'] === false;
        $isFreeLesson = $example['premiumLesson'] === false;
        $isPremiumUser = $example['premiumUser'] === true;
        $userCanMarkLessonAsCompleted = $example['canMarkLessonAsCompleted'] === true;

        $courses = TestUtils::createCoursesWithChaptersAndLessons(
            null,
            1,
            1,
            1,
            ['free' => $isFreeCourse,]
        );

        /** @var Course $course */
        $course = $courses->first();

        /** @var Chapter $chapter */
        $chapter = $course->chapters->first();

        /** @var Lesson $lesson */
        $lesson = TestUtils::addLessonToCourseChapter($chapter, ['free' => $isFreeLesson,]);

        /** @var User $pupil */
        if ($isPremiumUser) {
            list($pupil, $subscription) = TestUtils::createUserAndSubscription();
        } else {
            $pupil = factory(User::class)->create([]);
        }

        // Request
        /** @var Response $response */
        $response = $this->actingAs($pupil)->call(
            'POST',
            $this->completeLessonPostUrl,
            [
                'lesson_id' => $lesson->id,
            ]
        );

        // Asserts
        if ($userCanMarkLessonAsCompleted) {
            $response->assertStatus(200);

            $response->assertExactJson([
                'message' => 'Lesson completed',
            ]);

            $this->assertDatabaseHas('users_lessons', [
                'user_id' => $pupil->id,
                'lesson_id' => $lesson->id,
            ]);
        } else {
            $response->assertStatus(403);

            $response->assertExactJson([
                'message' => 'Could not mark lesson as completed',
            ]);

            $this->assertDatabaseMissing('users_lessons', [
                'user_id' => $pupil->id,
                'lesson_id' => $lesson->id,
            ]);
        }
    }

    /**
     * Data provider for testCompleteLesson.
     *
     * @return array
     */
    public function providerTestCompleteLesson(): array
    {
        return [
            [
                [
                    'premiumCourse' => false,
                    'premiumLesson' => false,
                    'premiumUser' => false,
                    'canMarkLessonAsCompleted' => true,
                ]
            ], [
                [
                    'premiumCourse' => false,
                    'premiumLesson' => false,
                    'premiumUser' => true,
                    'canMarkLessonAsCompleted' => true,
                ]
            ], [
                [
                    'premiumCourse' => false,
                    'premiumLesson' => true,
                    'premiumUser' => false,
                    'canMarkLessonAsCompleted' => false,
                ]
            ], [
                [
                    'premiumCourse' => false,
                    'premiumLesson' => true,
                    'premiumUser' => true,
                    'canMarkLessonAsCompleted' => true,
                ]
            ], [
                [
                    'premiumCourse' => true,
                    'premiumLesson' => false,
                    'premiumUser' => false,
                    'canMarkLessonAsCompleted' => true,
                ]
            ], [
                [
                    'premiumCourse' => true,
                    'premiumLesson' => false,
                    'premiumUser' => true,
                    'canMarkLessonAsCompleted' => true,
                ]
            ], [
                [
                    'premiumCourse' => true,
                    'premiumLesson' => true,
                    'premiumUser' => false,
                    'canMarkLessonAsCompleted' => false,
                ]
            ], [
                [
                    'premiumCourse' => true,
                    'premiumLesson' => true,
                    'premiumUser' => true,
                    'canMarkLessonAsCompleted' => true,
                ]
            ],
        ];
    }

    /**
     * Test complete a lesson that has already been completed.
     */
    public function testCompleteLessonThatHasBeenAlreadyCompletedOk()
    {
        // Prepare
        $courses = TestUtils::createCoursesWithChaptersAndLessons(
            null,
            1,
            1,
            1,
            ['free' => true,]
        );

        /** @var Course $course */
        $course = $courses->first();

        /** @var Chapter $chapter */
        $chapter = $course->chapters->first();

        /** @var Lesson $lesson */
        $lesson = TestUtils::addLessonToCourseChapter($chapter, ['free' => true,]);

        /** @var User $pupil */
        $pupil = factory(User::class)->create([]);

        TestUtils::enrollUserInCourse($pupil, $course);

        TestUtils::markLessonAsCompletedForUser($pupil, $lesson);

        // Request
        /** @var Response $response */
        $response = $this->actingAs($pupil)->call(
            'POST',
            $this->completeLessonPostUrl,
            [
                'lesson_id' => $lesson->id,
            ]
        );

        // Asserts
        $response->assertStatus(200);

        $response->assertExactJson([
            'message' => 'Lesson already completed',
        ]);

        $this->assertDatabaseHas('users_lessons', [
            'user_id' => $pupil->id,
            'lesson_id' => $lesson->id,
        ]);
    }

    /**
     * Test complete a lesson of a course that has not been published throws a 404 error.
     */
    public function testCompleteLessonOfCourseNotPublishedThrowsError()
    {
        // Prepare
        $courses = TestUtils::createCoursesWithChaptersAndLessons(
            null,
            1,
            1,
            1,
            [
                'free' => true,
                'status' => 'draft',
            ]
        );

        /** @var Course $course */
        $course = $courses->first();

        /** @var Chapter $chapter */
        $chapter = $course->chapters->first();

        /** @var Lesson $lesson */
        $lesson = TestUtils::addLessonToCourseChapter($chapter, ['free' => true,]);

        /** @var User $pupil */
        $pupil = factory(User::class)->create([]);

        // Request
        /** @var Response $response */
        $response = $this->actingAs($pupil)->call(
            'POST',
            $this->completeLessonPostUrl,
            [
                'lesson_id' => $lesson->id,
            ]
        );

        // Asserts
        $response->assertStatus(404);

        $this->assertDatabaseMissing('users_lessons', [
            'user_id' => $pupil->id,
            'lesson_id' => $lesson->id,
        ]);
    }

    /**
     * Test complete a lesson that does not exist throws a 404 error.
     */
    public function testCompleteLessonThatDoesNotExistThrowsError()
    {
        // Prepare
        $courses = TestUtils::createCoursesWithChaptersAndLessons(
            null,
            1,
            1,
            1,
            [
                'free' => true,
            ]
        );

        /** @var Course $course */
        $course = $courses->first();

        /** @var Chapter $chapter */
        $chapter = $course->chapters->first();

        /** @var Lesson $lesson */
        $lesson = TestUtils::addLessonToCourseChapter($chapter, ['free' => true,]);

        /** @var User $pupil */
        $pupil = factory(User::class)->create([]);

        // Request
        /** @var Response $response */
        $response = $this->actingAs($pupil)->call(
            'POST',
            $this->completeLessonPostUrl,
            [
                'lesson_id' => 99999,
            ]
        );

        // Asserts
        $response->assertStatus(404);

        $this->assertDatabaseMissing('users_lessons', [
            'user_id' => $pupil->id,
            'lesson_id' => $lesson->id,
        ]);
    }

    /**
     * Test complete a lesson with validation errors.
     * @dataProvider providerTestCompleteLessonWithValidationErrors
     *
     * @param $requestData
     * @param $validationErrorKeys
     */
    public function testCompleteLessonWithValidationErrors($requestData, $validationErrorKeys)
    {
        /** @var User $user */
        $user = factory(User::class)->create();

        // Request
        $response = $this->actingAs($user)->call(
            'POST',
            $this->completeLessonPostUrl,
            $requestData
        );

        // Asserts
        $response->assertStatus(422);

        $this->assertDatabaseMissing('users_lessons', [
            'user_id' => $user->id,
        ]);
    }

    /**
     * Provider for testCompleteLessonWithValidationErrors.
     *
     * @return array
     */
    public function providerTestCompleteLessonWithValidationErrors(): array
    {
        return [
            [
                'requestData' => [
                    'lesson_id' => null,
                ],
                'validationErrorKeys' => ['lesson_id',],
            ], [
                'requestData' => [
                    'lesson_id' => 0,
                ],
                'validationErrorKeys' => ['lesson_id',],
            ], [
                'requestData' => [
                    'lesson_id' => 'lesson-1',
                ],
                'validationErrorKeys' => ['lesson_id',],
            ],
        ];
    }
}
