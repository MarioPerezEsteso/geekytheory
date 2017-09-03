<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;

class LessonController extends Controller
{
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

        return view('courses.lesson', compact('course', 'lesson'));
    }
}
