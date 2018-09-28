<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use Billable, Notifiable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array(
        'name',
        'username',
        'email',
        'password',
        'receive_newsletter',
    );

    protected $casts = [
        'is_admin' => 'boolean',
        'receive_newsletter' => 'boolean',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token', 'can_login'];

    /**
     * This array is used when a query joins with this table
     * and the columns need to be aliased.
     *
     * @var array
     */
    public static $mappings = array(
        'users.id as user_id',
        'users.name as user_name',
        'users.username as user_username',
        'users.email as user_email',
        'users.password as user_password',
    );

    /**
     * Get the posts of the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    /**
     * Get the user meta.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function userMeta()
    {
        return $this->hasOne('App\UserMeta');
    }

    /**
     * Get user courses.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function courses()
    {
        return $this
            ->belongsToMany('App\Course', 'users_courses', 'user_id', 'course_id')
            ->withTimestamps();
    }

    /**
     * Get user lessons.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function lessons()
    {
        return $this
            ->belongsToMany('App\Lesson', 'users_lessons', 'user_id', 'lesson_id')
            ->withTimestamps();
    }

    /**
     * Set lesson as completed for a user.
     *
     * @param Lesson $lesson
     * @return boolean
     */
    public function completeLesson(Lesson $lesson)
    {
        return DB::update(
            "UPDATE users_lessons SET completed_at = ? WHERE user_id = ? AND lesson_id = ?;",
            [\Carbon\Carbon::now(), $this->id, $lesson->id]
        );
    }

    /**
     * Check if user has subscription active.
     *
     * @return bool
     */
    public function hasSubscriptionActive()
    {
        return $this->subscribed(Subscription::PLAN_NAME, Subscription::PLAN_MONTHLY);
    }

    /**
     * Check if a user has joined a course.
     *
     * @param Course $course
     * @return bool
     */
    public function hasJoinedCourse(Course $course): bool
    {
        return $this->courses->contains($course);
    }

    /**
     * Check if a user has started a lesson.
     *
     * @param Lesson $lesson
     * @return bool
     */
    public function hasStartedLesson(Lesson $lesson): bool
    {
        return $this->lessons->contains($lesson);
    }

    /**
     * Check if a user has completed a lesson.
     *
     * @param Lesson $lesson
     * @return bool
     */
    public function hasCompletedLesson(Lesson $lesson): bool
    {
        $userLesson = DB::select(
            "SELECT * FROM users_lessons WHERE user_id = ? AND lesson_id = ?",
            [$this->id, $lesson->id]
        );

        if (!empty($userLesson)) {
            return $userLesson[0]->completed_at !== null;
        }

        return false;
    }

    /**
     * Check if a user is administrator or not.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->is_admin ?? false;
    }

    /**
     * Find user by its username or fail.
     *
     * @param string $username
     * @return User
     */
    public static function findByUsernameOrFail(string $username)
    {
        return self::where('username', '=', $username)->firstOrFail();
    }

    /**
     * Returns the basic user data for the admin panel view.
     *
     * @return array
     */
    public function getBasicUserData()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'job' => $this->job,
            'email' => $this->email,
            'avatar' => getGravatar($this->email, '100', 'mm', 'g'),
            'premium' => $this->hasSubscriptionActive(),
        ];
    }
}
