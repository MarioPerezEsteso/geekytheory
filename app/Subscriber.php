<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
     */
    public static function findByEmail($email)
    {
        return Subscriber::where('email', $email)->first();
    }
}
