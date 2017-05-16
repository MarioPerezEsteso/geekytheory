<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer id
 * @property boolean active
 * @property string token
 * @property Carbon activated_at
 * @property Carbon token_expires_at
 * @property Carbon unsubscribed_at
 */
class Subscriber extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'subscribers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'token',
        'active',
        'token_expires_at',
        'activated_at',
        'unsubscribed_at'
    ];

    /**
     * Find subscriber by email.
     *
     * @param string $email
     * @return Subscriber
     */
    public static function findByEmail($email)
    {
        return Subscriber::where('email', $email)->first();
    }

    /**
     * Find subscriber by token.
     *
     * @param $token
     * @return Subscriber
     */
    public static function findByToken($token)
    {
        return Subscriber::where('token', $token)->first();
    }

    /**
     * Check if a subscriber is pending confirmation.
     *
     * @return bool
     */
    public function isPendingConfirmation()
    {
        return !$this->active && !$this->tokenHasExpired();
    }

    /**
     * Check if the token of a user has expired.
     *
     * @return bool
     */
    public function tokenHasExpired()
    {
        $now = Carbon::now();
        return $now->greaterThanOrEqualTo(new Carbon($this->token_expires_at));
    }

    /**
     * Check if the user is unsubscribed.
     *
     * @return bool
     */
    public function isUnsubscribed()
    {
        $now = Carbon::now();
        return !$this->active && $now->gt(new Carbon($this->unsubscribed_at));
    }
}
