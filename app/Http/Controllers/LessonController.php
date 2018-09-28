<?php

namespace App\Http\Controllers;

use App\Course;
use App\Lesson;
use App\User;
use App\Validators\LessonValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    /**
     * Template header name to show video in course lesson.
     */
    const TEMPLATE_HEADER_VIDEO = 'video';

    /**
     * Template header name to show register form.
     */
    const TEMPLATE_HEADER_REGISTER = 'headerRegister';

    /**
     * Template header name to show go pro message.
     */
    const TEMPLATE_HEADER_GOPREMIUM = 'headerGopremium';

    /**
     * @var LessonValidator
     */
    protected $lessonValidator;

    /**
     * LessonController constructor.
     * @param LessonValidator $lessonValidator
     */
    public function __construct(LessonValidator $lessonValidator)
    {
        $this->lessonValidator = $lessonValidator;
    }

    /**
     * Show a lesson of a course.
     *
     * @param $courseSlug
     * @param $lessonSlug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($courseSlug, $lessonSlug)
    {
        /** @var Course $course */
        $course = Course::getPublished(['slug' => $courseSlug])->with('chapters.lessons')->firstOrFail();

        $lesson = null;
        foreach ($course->chapters as $chapter) {
            foreach ($chapter->lessons as $chapterLesson) {
                if ($chapterLesson->slug == $lessonSlug) {
                    $lesson = $chapterLesson;
                }
            }
        }

        if (!$lesson) {
            abort(404);
        }

        /** @var User $user */
        $user = Auth::user();

        if ($user) {
            if ($course->free || $lesson->free) {
                $showHeaderTemplate = self::TEMPLATE_HEADER_VIDEO;
            } else {
                if ($user->hasSubscriptionActive()) {
                    $showHeaderTemplate = self::TEMPLATE_HEADER_VIDEO;
                } else {
                    $showHeaderTemplate = self::TEMPLATE_HEADER_GOPREMIUM;
                }
            }
        } else {
            $showHeaderTemplate = self::TEMPLATE_HEADER_REGISTER;
        }

        if ($user) {
            $completedLessons = $user->lessons;

            foreach ($course->chapters as $chapter) {
                foreach ($chapter->lessons as $chapterLesson) {
                    if ($completedLessons->contains($chapterLesson)) {
                        $chapterLesson->completed = true;
                    }
                }
            }
        }

        list($previousLesson, $nextLesson) = $this->getPreviousAndNextLessons($course, $lesson);

        return view('web.lessons.lesson.lesson', compact('course', 'lesson', 'user', 'showHeaderTemplate', 'previousLesson', 'nextLesson'));
    }

    /**
     * Get the previous and next lessons for navigation purposes.
     *
     * @param Course $course
     * @param Lesson $currentLesson
     * @return array
     */
    public function getPreviousAndNextLessons($course, $currentLesson): array
    {
        $previousLesson = null;
        $nextLesson = null;

        foreach ($course->chapters as $chapter) {
            foreach ($chapter->lessons as $lesson) {
                if ($lesson->order === $currentLesson->order + 1) {
                    $nextLesson = $lesson;
                }

                if ($lesson->order === $currentLesson->order - 1) {
                    $previousLesson = $lesson;
                }
            }
        }

        return [$previousLesson, $nextLesson];
    }

    /**
     * Mark lesson as started for a certain user.
     *
     * @param Request $request
     */
    public function start(Request $request)
    {
        if (!$this->lessonValidator->with($request->all())->start()->passes()) {

            return response()->json(
                [
                    'message' => $this->lessonValidator->errors(),
                ],
                422
            );
        }

        /** @var Lesson $lesson */
        $lesson = Lesson::with('chapter.course')->findOrFail($request->lesson_id);

        /** @var User $user */
        $user = Auth::user();

        // Check if the course is published
        if (!$lesson->chapter->course->isPublished()) {
            abort(404);
        }

        if ($user->hasStartedLesson($lesson)) {

            return response()->json(
                [
                    'message' => 'Lesson already started',
                ]
            );
        }

        if (!policy($lesson)->start($user, $lesson)) {

            return response()->json(
                [
                    'message' => 'Could not mark lesson as started',
                ],
                403
            );
        }

        $user->lessons()->attach($lesson->id, [
            'started_at' => \Carbon\Carbon::now(), 
            'completed_at' => null,
        ]);

        return response()->json(
            [
                'message' => 'Lesson started',
            ]
        );
    }

    /**
     * Mark lesson as completed for a certain user.
     *
     * @param Request $request
     */
    public function complete(Request $request)
    {
        if (!$this->lessonValidator->with($request->all())->complete()->passes()) {

            return response()->json(
                [
                    'message' => $this->lessonValidator->errors(),
                ],
                422
            );
        }

        /** @var Lesson $lesson */
        $lesson = Lesson::with('chapter.course')->findOrFail($request->lesson_id);

        /** @var User $user */
        $user = Auth::user();

        // Check if the course is published
        if (!$lesson->chapter->course->isPublished()) {
            abort(404);
        }

        if ($user->hasCompletedLesson($lesson)) {

            return response()->json(
                [
                    'message' => 'Lesson already completed',
                ]
            );
        }

        if (!policy($lesson)->complete($user, $lesson)) {

            return response()->json(
                [
                    'message' => 'Could not mark lesson as completed',
                ],
                403
            );
        }

        $user->completeLesson($lesson);

        return response()->json(
            [
                'message' => 'Lesson completed',
            ]
        );
    }
}
































