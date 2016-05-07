<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Available social networks
     *
     * @var array
     */
    public static $socialNetworks = array(
        'twitter',
        'instagram',
        'facebook',
        'linkedin',
        'github',
        'youtube',
        'dribbble',
        'google-plus',
        'stack-overflow',
        'flickr',
        'bitbucket'
    );

}
