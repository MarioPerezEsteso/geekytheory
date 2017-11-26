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
        /** @var User $user */
        $loggedUser = Auth::user();
        $course = Course::getPublished(['slug' => $slug])->with('teacher')->with('chapters.lessons')->firstOrFail();

        $userHasJoinedCourse = false;

        if (!is_null($loggedUser)) {
            $userHasJoinedCourse = $loggedUser->courses->contains($course);
        }

        return view('courses.single', compact('course', 'userHasJoinedCourse'));
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
            return redirect()->route('course', ['slug' => $course->slug])->withErrors(
                new MessageBag(['subscription_error' => trans('public.you_must_be_premium_subscriber')])
            );
        }

        $user->courses()->attach($course->id);

        return redirect()->route('course', ['slug' => $course->slug]);
    }
}
