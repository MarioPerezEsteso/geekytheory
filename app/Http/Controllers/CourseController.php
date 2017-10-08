<?php

namespace App\Http\Controllers;

use App\Course;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        return view('courses.single', compact('course'));
    }


    /**
     * Join a course.
     *
     * @param Request $request
     * @param $id
     * @return array
     */
    public function join(Request $request, $id)
    {
        /** @var Course $course */
        $course = Course::findOrFail($id);

        /** @var User $user */
        $user = Auth::user();

        // Check if the course is published
        if (!$course->isPublished()) {
            return [
                'joined' => 0,
                'error' => trans('public.course_does_not_exist'),
            ];
        }

        if (!policy($course)->join($user, $course)) {
            return [
                'joined' => 0,
                'error' => trans('public.you_must_be_premium_subscriber'),
            ];
        }

        $user->courses()->attach($course->id);

        return ['joined' => 1];
    }
}
