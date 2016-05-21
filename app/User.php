<?php

namespace App;

use App\Http\Controllers\UserController;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

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
        'biography',
        'job',
        'twitter',
        'instagram',
        'facebook',
        'github',
        'youtube',
        'dribbble',
        'google-plus',
        'stack-overflow',
        'flickr',
        'bitbucket');

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

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
        'users.biography as user_biography',
        'users.job as user_job',
        'users.twitter as user_twitter',
        'users.instagram as user_instagram',
        'users.facebook as user_facebook',
        'users.github as user_github',
        'users.youtube as user_youtube',
        'users.dribbble as user_dribbble',
        'users.google-plus as user_google-plus',
        'users.stack-overflow as user_stack-overflow',
        'users.flickr as user_flickr',
        'users.bitbucket as user_bitbucket',
    );

    /**
     * Get the posts of the user.
     */
    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    /**
     * Returns the basic user data for the admin panel view
     *
     * @return array
     */
    public function getBasicUserData()
    {
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'job' => $this->job,
            'email' => $this->email,
            'avatar' => UserController::getGravatar($this->email, '100', 'mm', 'g'));
    }

}
