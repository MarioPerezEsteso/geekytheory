<?php

namespace App\Http\Controllers;

use App\Course;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;

class CourseController extends Controller
{
    /**
     * Show all courses.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        /** @var Collection $courses */
        $courses = Course::getPublishedAndScheduled()->with('chapters.lessons')->get();

        $loggedUser = Auth::user();
        if (!is_null($loggedUser)) {
            /** @var Collection $completedLessons */
            $completedLessons = $loggedUser->lessons;
            $courseCompletedLessons = 0;

            foreach ($courses as $course) {
                foreach ($course->chapters as $chapter) {
                    foreach ($chapter->lessons as $chapterLesson) {
                        if ($completedLessons->contains($chapterLesson)) {
                            $chapterLesson->completed = true;
                            $courseCompletedLessons++;
                        }
                    }
                }
                $course->lessons_completed = $courseCompletedLessons;
            }
        }


        $premiumCourses = $courses->filter(function ($course) {
            if ($course->isPremium() && $course->isPublished()) {
                return $course;
            }
        });

        $freeCourses = $courses->filter(function ($course) {
            if ($course->isFree() && $course->isPublished()) {
                return $course;
            }
        });

        $scheduledCourses = $courses->filter(function ($course) {
            if ($course->isScheduled()) {
                return $course;
            }
        });

        return view('web.courses.index', compact('premiumCourses', 'freeCourses', 'scheduledCourses'));
    }

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

        /** @var Course $course */
        $course = Course::getPublished(['slug' => $slug])->with('teacher')->with('chapters.lessons')->firstOrFail();

        $userHasJoinedCourse = false;
        $coursePercentageCompleted = 0;

        if (!is_null($loggedUser)) {
            $userHasJoinedCourse = $loggedUser->hasJoinedCourse($course);

            if ($userHasJoinedCourse) {
                /** @var Collection $completedLessons */
                $completedLessons = $loggedUser->lessons;
                $courseCompletedLessons = 0;

                foreach ($course->chapters as $chapter) {
                    foreach ($chapter->lessons as $chapterLesson) {
                        if ($completedLessons->contains($chapterLesson)) {
                            $chapterLesson->completed = true;
                            $courseCompletedLessons++;
                        }
                    }
                }

                $coursePercentageCompleted = round($courseCompletedLessons * 100 / $course->getTotalLessonsCount());
            }
        }

        return view('courses.single', compact('course', 'userHasJoinedCourse', 'coursePercentageCompleted'));
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
