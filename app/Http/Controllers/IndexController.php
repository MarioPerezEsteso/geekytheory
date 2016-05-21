<?php

namespace App\Http\Controllers;

use App\Repositories\ArticleRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Post;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = $this->articleRepository->findArticles(null, true, 6);
        return view('themes.' . self::THEME . '.index', compact('posts'));
    }

}
