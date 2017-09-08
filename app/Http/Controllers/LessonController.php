<?php

namespace App\Http\Controllers;

use App\Course;
use App\User;
use Auth;

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
}
