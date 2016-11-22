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
        'url',
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
        'linkedin',
        'allow_register',
        'show_author_post_list',
        'show_author_post',
        'akismet_api_key',
        'analytics_script',
        'adsense_script',
        'adsense_enabled',
        'adsense_postlist_script',
        'adsense_postlist_enabled',
    );

}
