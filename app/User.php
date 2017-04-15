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
    );    

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
            'avatar' => getGravatar($this->email, '100', 'mm', 'g'));
    }

}
