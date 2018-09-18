<?php

namespace App\Policies;

use App\Lesson;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LessonPolicy
{
    use HandlesAuthorization;

    /**
     * Policy to check if a user can mark a lesson as started.
     *
     * @param User $user
     * @param Lesson $lesson
     * @return bool
     */
    public function start(User $user, Lesson $lesson)
    {
        if (!$lesson->isPremium()) {
            return true;
        }

        return $user->hasSubscriptionActive();
    }

    /**
     * Policy to check if a user can mark a lesson as completed.
     *
     * @param User $user
     * @param Lesson $lesson
     * @return bool
     */
    public function complete(User $user, Lesson $lesson)
    {
        if (!$lesson->isPremium()) {
            return true;
        }

        return $user->hasSubscriptionActive();
    }
}
