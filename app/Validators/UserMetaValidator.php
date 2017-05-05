<?php

namespace App\Validators;

use App\Validators\Base\LaravelValidator;
use App\Validators\Base\ValidableInterface;

class UserMetaValidator extends LaravelValidator implements ValidableInterface
{
    /**
     * Validation rules for creating the metadata of a User.
     */
    protected $rules = [
        'biography' => 'max:255',
		'job' => 'max:255',
		'twitter' => 'url|max:255',
		'instagram' => 'url|max:255',
		'facebook' => 'url|max:255',
		'github' => 'url|max:255',
		'youtube' => 'url|max:255',
		'googleplus' => 'url|max:255',
		'stackoverflow' => 'url|max:255',
		'bitbucket' => 'url|max:255',
		'linkedin' => 'url|max:255',
		'tumblr' => 'url|max:255',
		'twitch' => 'url|max:255',
		'vimeo' => 'url|max:255',
	];

    /**
     * Modify the rules for updating the metadata of a User.
     *
     * @param null $id
     * @return $this|ValidableInterface
     */
    public function update($id = null)
    {
        return $this;
    }
}