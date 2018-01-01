<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Validators\UserMetaValidator;

class UserMeta extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'user_meta';

	/**
     * The primary key for the model.
     *
     * @var string
     */
	protected $primaryKey = 'user_id';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
	public $incrementing = false;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = array(
		'biography',
		'job',
		'twitter',
		'instagram',
		'facebook',
		'github',
		'youtube',
		'googleplus',
		'stackoverflow',
		'bitbucket',
		'linkedin',
		'tumblr',
		'twitch',
		'vimeo',
	);

	public static $socialNetworks = [
		'twitter',
		'instagram',
		'facebook',
		'github',
		'youtube',
		'googleplus',
		'stackoverflow',
		'bitbucket',
		'linkedin',
		'tumblr',
		'twitch',
		'vimeo',
	];

	/**
	 * Get the user that has uploaded the image.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user()
	{
		return $this->belongsTo('App\User');
	}
}
