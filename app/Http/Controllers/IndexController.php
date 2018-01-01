<?php

namespace App\Http\Controllers;

use App\Course;
use App\Repositories\SiteMetaRepository;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Article;
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
     * @var SiteMetaRepository
     */
    protected $siteMetaRepository;

    public function __construct(SiteMetaRepository $siteMetaRepository)
    {
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
            $posts = Article::findArticlesBySearch(true, $postsToShow, $request->search);
            $posts->appends(Input::except('page'));
        } else {
            $posts = Article::findArticles(null, true, $postsToShow);
        }

        $courses = Course::getPublished()->with('teacher')->get();

        return view('courses.index', compact('posts', 'courses'));
    }

    /**
     * Show pricing page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function pricing()
    {
        return view('courses.pricing');
    }

}
