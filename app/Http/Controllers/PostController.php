<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Post;
use App\User;

class PostController extends Controller
{

    /**
     * Number of posts to show with pagination
     */
    const POSTS_PAGINATION_NUMBER = 10;

    /**
     * Display a listing of posts.
     *
     * @param $username
     */
    public function index($username)
    {
        //
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
            /*  Get posts of a concrete user */
            $user = User::where('username', $username)->firstOrFail();
            $posts = $user->posts()->paginate(self::POSTS_PAGINATION_NUMBER);
        } else {
            /* Get all posts */
            $posts = Post::paginate(self::POSTS_PAGINATION_NUMBER);
        }
        return view('home.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
