<?php

namespace App\Http\Controllers;

use App\Course;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;

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
            abort(404);
        }

        if (!policy($course)->join($user, $course)) {
            return redirect()->route('pricing')->withErrors(
                new MessageBag(['subscription' => trans('public.you_must_be_premium_subscriber')])
            );
        }

        $user->courses()->attach($course->id);

        return redirect()->route('course', ['slug' => $course->slug])->withSuccess(trans('public.joined_course_ok'));
    }
}
