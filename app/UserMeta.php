<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserMeta extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'user_meta';

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
