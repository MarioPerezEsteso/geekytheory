<?php

namespace App\Http\Controllers;

use App\Repositories\ArticleRepository;
use App\Repositories\SiteMetaRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Post;
use Illuminate\Support\Facades\Input;

class IndexController extends Controller
{
    /**
     * Theme name that the user has selected for its site.
     * TODO: move parameter to database
     */
    const THEME = 'vortex';

    /**
     * Number of posts to show in the homepage.
     */
    const SHOW_NUMBER_POSTS = 9;

    /**
     * @var ArticleRepository
     */
    protected $articleRepository;

    /**
     * @var SiteMetaRepository
     */
    protected $siteMetaRepository;

    public function __construct(ArticleRepository $articleRepository, SiteMetaRepository $siteMetaRepository)
    {
        $this->articleRepository = $articleRepository;
        $this->siteMetaRepository = $siteMetaRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $adsensePostlistEnabled = $this->siteMetaRepository->getSiteMeta()->adsense_postlist_enabled;
        $postsToShow = $adsensePostlistEnabled ? self::SHOW_NUMBER_POSTS - 1 : self::SHOW_NUMBER_POSTS;

        if (!empty($request->search)) {
            $posts = $this->articleRepository->findArticlesBySearch(true, $postsToShow, $request->search);
            $posts->appends(Input::except('page'));
        } else {
            $posts = $this->articleRepository->findArticles(null, true, $postsToShow);
        }

        return view('themes.' . self::THEME . '.index', compact('posts'));
    }

}
