<?php

namespace App\Http\Controllers;

use App\Course;
use App\Lesson;
use App\User;
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

        return view('courses.lesson', compact('course', 'lesson', 'user', 'showHeaderTemplate'));
    }

    /**
     * Mark lesson as completed for a certain user.
     *
     * @param Request $request
     */
    public function complete(Request $request)
    {
        // @TODO: validate request input

        /** @var Lesson $lesson */
        $lesson = Lesson::with('chapter.course')->findOrFail($request->lessonId);

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

        $user->lessons()->attach($lesson->id);

        return response()->json(
            [
                'message' => 'Lesson completed',
            ]
        );
    }
}
































