<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiteMeta extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'site_meta';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array(
        'title',
        'subtitle',
        'description',
        'image',
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

}
