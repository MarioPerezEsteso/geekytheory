<?php

namespace App\Http\Controllers;

use App\Repositories\ArticleRepository;
use App\Repositories\SiteMetaRepository;

class FeedController extends Controller
{
    /**
     * Maximum number of items to show in the feed.
     * TODO: save value in database to be configurable.
     */
    const MAX_ITEMS = 10;

    private $siteMetaRepository;
    private $articleRepository;

    public function __construct(SiteMetaRepository $siteMetaRepository, ArticleRepository $articleRepository)
    {
        $this->siteMetaRepository = $siteMetaRepository;
        $this->articleRepository = $articleRepository;
    }

    /**
     * Show RSS feed.
     */
    public function feed()
    {
        $siteMeta = $this->siteMetaRepository->getSiteMeta();
        $articles = $this->articleRepository->findArticles(null, true, self::MAX_ITEMS);
        return response(view('home.feed.feed', compact('siteMeta', 'articles')), 200)->header('Content-Type', 'text/xml');
    }
}
