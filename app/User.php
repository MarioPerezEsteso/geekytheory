<?php

namespace App;

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
    protected $fillable = ['name', 'email', 'password', 'biography', 'job'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Social networks available
     *
     * @var array
     */
    protected $socialNetworks = ['twitter',
        'instagram',
        'facebook',
        'github',
        'youtube',
        'dribble',
        'googleplus',
        'stackoverflow',
        'flickr',
        'bitbucket'];

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
            'avatar' => $this->getGravatar($this->email, '100', 'mm', 'g'));
    }

    /**
     * Get a Gravatar URL or complete image tag for a specified email address.
     *
     * @param string $email The email address
     * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
     * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
     * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
     * @return String containing Gravatar URL
     * @source http://gravatar.com/site/implement/images/php/
     */
    public function getGravatar($email, $s = '100', $d = 'mm', $r = 'g')
    {
        $url = '//www.gravatar.com/avatar/';
        $url .= md5(strtolower(trim($email)));
        $url .= "?s=$s&d=$d&r=$r";
        return $url;
    }
}
