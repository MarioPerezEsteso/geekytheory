<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Repositories\PageRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Redirect;

class PageController extends PostController
{
    /**
     * Type of the post
     */
    const TYPE = PostController::POST_PAGE;

    /**
     * PageController constructor.
     *
     * @param PageRepository $repository
     * @param CategoryRepository $categoryRepository
     * @param UserRepository $userRepository
     */
    public function __construct(PageRepository $repository, CategoryRepository $categoryRepository, UserRepository $userRepository)
    {
        parent::__construct($repository, $categoryRepository, $userRepository);
    }

    /**
     * Display a listing of the pages in admin panel.
     *
     * @param null $username
     * @return \Illuminate\Http\Response
     */
    public function indexHome($username = null)
    {
        if (!empty($username)) {
            /*  Get pages of a concrete user */
            $author = $this->userRepository->findUserByUsername($username);
            $posts = $this->repository->findPagesByAuthor($author, self::POSTS_PAGINATION_NUMBER);
        } else {
            /* Get all pages */
            $posts = $this->repository->findPages(self::POSTS_PAGINATION_NUMBER);
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
        $categories = $this->categoryRepository->all();
        $type = self::TYPE;
        return view('home.posts.page', compact('categories', 'type'));
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
            return Redirect::to('home/pages/edit/' . $result['id'])->withSuccess($result['messages']);
        } else {
            return Redirect::to('home/pages/create')->withErrors($result['messages']);
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
        $post = $this->repository->findPageBySlug($slug);
        return view('themes.' . IndexController::THEME . '.blog.singlepage', compact('post'));
    }

    /**
     * Preview a page while it is being edited.
     *
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function preview($slug)
    {
        $post = $this->repository->findPageBySlug($slug, true);
        return view('themes.' . IndexController::THEME . '.blog.singlepage', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = $this->repository->findOrFail($id);
        $categories = $this->categoryRepository->all();
        return view('home.posts.page', compact('categories', 'post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $result = parent::update($request, $id);
        if (!$result['error']) {
            return Redirect::to('home/pages/edit/' . $id)->withSuccess($result['messages']);
        } else {
            return Redirect::to('home/pages/edit/' . $id)->withErrors($result['messages']);
        }
    }

}
