<?php

namespace App\Http\Controllers;

use App\Repositories\SiteMetaRepository;

class FeedController extends Controller
{
    /**
     * Maximum number of items to show in the feed.
     * TODO: save value in database to be configurable.
     */
    const MAX_ITEMS = 10;

    private $siteMetaRepository;

    public function __construct(SiteMetaRepository $siteMetaRepository)
    {
        $this->siteMetaRepository = $siteMetaRepository;
    }

    /**
     * Show RSS feed.
     */
    public function feed()
    {
        return response(view('home.feed.feed'), 200)->header('Content-Type', 'text/xml');
    }
}
