<?php

namespace App\Policies;

use App\Lesson;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LessonPolicy
{
    use HandlesAuthorization;

    /**
     * Policy to check if a user can mark a lesson as completed.
     *
     * @param User $user
     * @param Lesson $lesson
     * @return bool
     */
    public function complete(User $user, Lesson $lesson)
    {
        $userHasJoinedCourse = $user->hasJoinedCourse($lesson->chapter->course);
        $courseIsPremium = $lesson->chapter->course->isPremium();
        $lessonIsPremium = $lesson->isPremium();
        $userHasSubscriptionActive = $user->hasSubscriptionActive();

        return !$userHasJoinedCourse && $courseIsPremium && !$lessonIsPremium
            || !$userHasJoinedCourse && !$courseIsPremium && !$lessonIsPremium
            || $userHasJoinedCourse && !$courseIsPremium && !$lessonIsPremium
            || $userHasJoinedCourse && $courseIsPremium && $userHasSubscriptionActive;
    }
}
