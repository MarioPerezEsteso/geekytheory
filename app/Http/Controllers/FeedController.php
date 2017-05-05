<?php

namespace App\Http\Controllers;

use App\Article;
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
        $siteMeta = $this->siteMetaRepository->getSiteMeta();
        $articles = Article::findArticles(null, true, self::MAX_ITEMS);
        return response(view('home.feed.feed', compact('siteMeta', 'articles')), 200)->header('Content-Type', 'text/xml');
    }
}
