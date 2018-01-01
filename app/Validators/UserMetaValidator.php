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
		'twitter' => 'nullable|url|max:255',
		'instagram' => 'nullable|url|max:255',
		'facebook' => 'nullable|url|max:255',
		'github' => 'nullable|url|max:255',
		'youtube' => 'nullable|url|max:255',
		'googleplus' => 'nullable|url|max:255',
		'stackoverflow' => 'nullable|url|max:255',
		'bitbucket' => 'nullable|url|max:255',
		'linkedin' => 'nullable|url|max:255',
		'tumblr' => 'nullable|url|max:255',
		'twitch' => 'nullable|url|max:255',
		'vimeo' => 'nullable|url|max:255',
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