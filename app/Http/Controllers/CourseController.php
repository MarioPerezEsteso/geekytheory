<?php

namespace App\Http\Controllers;

use App\Course;
use App\Exceptions\ExceptionFactory;

class CourseController extends Controller
{
    /**
     * Show single course.
     *
     * @param $slug
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function show($slug)
    {
        $course = Course::getPublished(['slug' => $slug])->with('teacher')->with('chapters.lessons')->firstOrFail();

        return view('courses.course', compact('course'));
    }
}
