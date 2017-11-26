<?php

namespace App\Policies;

use App\Course;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy
{
    use HandlesAuthorization;

    /**
     * Policy to check if a user can join a course.
     *
     * @param User $user
     * @param Course $course
     * @return bool
     */
    public function join(User $user, Course $course)
    {
        return $course->free || $user->hasSubscriptionActive();
    }
}
