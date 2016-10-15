<?php

namespace App\Http\Controllers;

use App\Repositories\ArticleRepository;
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
     * @var ArticleRepository
     */
    protected $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!empty($request->search)) {
            $posts = $this->articleRepository->findArticlesBySearch(true, 6, $request->search);
            $posts->appends(Input::except('page'));
        } else {
            $posts = $this->articleRepository->findArticles(null, true, 6);
        }
        return view('themes.' . self::THEME . '.index', compact('posts'));
    }

}
