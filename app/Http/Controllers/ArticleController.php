<?php

namespace App\Http\Controllers;

use App\Category;
use App\Course;
use App\Post;
use App\Article;
use App\Repositories\UserRepository;
use App\User;
use App\Validators\ArticleValidator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Cache;

class ArticleController extends PostController
{
    /**
     * Type of the post
     */
    const TYPE = Post::POST_ARTICLE;

    /**
     * Cache expires in 240 minutes.
     */
    const CACHE_EXPIRATION_TIME = 240;

    /**
     * @var ArticleValidator
     */
    protected $validator;

    /**
     * ArticleController constructor.
     *
     * @param UserRepository $userRepository
     * @param ArticleValidator $articleValidator
     */
    public function __construct(UserRepository $userRepository, ArticleValidator $articleValidator)
    {
        parent::__construct($userRepository, $articleValidator);
    }

    /**
     * Show a list of articles.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        /** @var Collection $articles */
        $articles = Article::getPublishedArticles()->with('user', 'categories')->paginate(self::POSTS_PUBLIC_PAGINATION_NUMBER);

        return view('web.blog.postlist.index', compact('articles'));
    }

    /**
     * Display a listing of the posts in admin panel.
     *
     * @param null $username
     * @return \Illuminate\Http\Response
     */
    public function indexHome($username = null)
    {
        if (!empty($username)) {
            /*  Get articles of a concrete user */
            $author = $this->userRepository->findUserByUsername($username);
            $posts = Article::findArticles($author);
        } else {
            /* Get all articles */
            $posts = Article::findAllArticles(self::POSTS_PAGINATION_NUMBER);
        }

        return view('home.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new post.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $type = self::TYPE;
        return view('home.posts.article', compact('categories', 'type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param string $type
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $type = self::TYPE)
    {
        $result = parent::store($request, $type);
        if (!$result['error']) {
            return Redirect::to('home/articles/edit/' . $result['id'])->withSuccess($result['messages']);
        } else {
            return Redirect::to('home/articles/create')->withErrors($result['messages']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param string $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $post = Cache::remember('post_' . $slug, self::CACHE_EXPIRATION_TIME, function () use ($slug) {
            return Article::findArticleBySlug($slug)->with('tags', 'categories')->firstOrFail();
        });

        $authorUser = $post->user()->with('userMeta')->first();

        $socialShareButtons = $this->getSocialShareButtonsData($post);

        $courses = Course::getPublished()->get();

        return view('web.blog.post.post', compact('post', 'authorUser', 'socialShareButtons', 'courses'));
    }

    /**
     * Preview an article while it is being edited.
     *
     * @param string $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function preview($slug)
    {
        $post = Article::findArticleBySlug($slug, true)->with('tags', 'categories')->firstOrFail();
        $authorUser = $post->user()->with('userMeta')->first();
        $comments = $post->hamComments()->get();
        $commentCount = count($comments);
        $socialShareButtons = $this->getSocialShareButtonsData($post);

        return view('web.blog.post.post', compact('post', 'authorUser', 'comments', 'commentCount', 'socialShareButtons'));
    }

    /**
     * Display list of posts by username.
     *
     * @param string $username
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showByUsername($username)
    {
        $author = User::findByUsernameOrFail($username);
        $articles = Article::getPublishedArticlesByAuthor($author)->with('user', 'categories')->paginate(self::POSTS_PUBLIC_PAGINATION_NUMBER);

        return view('web.blog.postlist.index', compact('articles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Article::findOrFail($id);
        $categories = Category::all();

        return view('home.posts.article', compact('categories', 'post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @param string $type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $type = self::TYPE)
    {
        $result = parent::update($request, $id, $type);
        if (!$result['error']) {
            return Redirect::to('home/articles/edit/' . $id)->withSuccess($result['messages']);
        } else {
            return Redirect::to('home/articles/edit/' . $id)->withErrors($result['messages']);
        }
    }

    /**
     * Updates the share counter of a post.
     *
     * @param Request $request
     * @return array
     */
    public function updateShares(Request $request)
    {
        $postId = $request->postId;
        $socialNetwork = $request->socialNetwork;

        if (!$this->validator->updateShares()->with(['socialNetwork' => $socialNetwork])->passes()) {
            return [
                'error' => 1,
                'message' => 'Undefined social network',
            ];
        }

        /** @var Post $post */
        $post = Article::findOrFail($postId);
        $key = 'shares_' . $socialNetwork;
        $data = [
            $key => $post->getAttribute($key) + 1,
        ];

        $article = Article::findOrFail($postId);
        $article->update($data);

        return [
            'error' => 0,
        ];
    }

    /**
     * @param $post
     * @return array
     */
    public function getSocialShareButtonsData($post)
    {
        if (Cache::has('social_share_buttons_post_' . $post->id)) {
            $socialNetworks = Cache::get('social_share_buttons_post_' . $post->id);
        } else {
            $postUrl = self::getPostPublicUrlByType($post, false);
            $linkContent = $post->title . ' ' . $postUrl;
            $socialNetworks = [
                [
                    'socialNetwork' => 'whatsapp',
                    'title' => trans('public.share_with_whatsapp'),
                    'url' => 'whatsapp://send?text=' . $linkContent,
                    'icon' => 'fa-whatsapp',
                    'visibleDesktop' => false,
                    'visibleMobile' => true,
                ],
                [
                    'socialNetwork' => 'twitter',
                    'title' => trans('public.share_with_twitter'),
                    'url' => 'https://twitter.com/intent/tweet?text=' . $linkContent,
                    'icon' => 'fa-twitter',
                    'visibleDesktop' => true,
                    'visibleMobile' => true,
                ],
                [
                    'socialNetwork' => 'facebook',
                    'title' => trans('public.share_with_facebook'),
                    'url' => 'https://www.facebook.com/sharer/sharer.php?u=' . $postUrl,
                    'icon' => 'fa-facebook',
                    'visibleDesktop' => true,
                    'visibleMobile' => true,
                ],
                [
                    'socialNetwork' => 'google-plus',
                    'title' => trans('public.share_with_google-plus'),
                    'url' => 'https://plus.google.com/share?url=' . $postUrl,
                    'icon' => 'fa-google-plus',
                    'visibleDesktop' => true,
                    'visibleMobile' => true,
                ],
                [
                    'socialNetwork' => 'telegram',
                    'title' => trans('public.share_with_telegram'),
                    'url' => 'https://telegram.me/share/url?url=' . $linkContent,
                    'icon' => 'fa-send',
                    'visibleDesktop' => true,
                    'visibleMobile' => true,
                ],
                [
                    'socialNetwork' => 'mail',
                    'title' => trans('public.share_with_mail'),
                    'url' => 'mailto:?subject=' . $post->title . '&body=' . $postUrl,
                    'icon' => 'fa-envelope',
                    'visibleDesktop' => true,
                    'visibleMobile' => true,
                ],
            ];

            Cache::put('social_share_buttons_post_' . $post->id, $socialNetworks, self::CACHE_EXPIRATION_TIME);
        }

        return $socialNetworks;
    }
}
