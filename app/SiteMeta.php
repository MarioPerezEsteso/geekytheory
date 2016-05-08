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
     * Do not save timestamps
     *
     * @var bool
     */
    public $timestamps = false;

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
        'logo',
        'favicon',
        'logo_57',
        'logo_72',
        'logo_114',
        'twitter',
        'instagram',
        'facebook',
        'github',
        'youtube',
        'dribbble',
        'google-plus',
        'stack-overflow',
        'flickr',
        'bitbucket',
        'linkedin');

}
