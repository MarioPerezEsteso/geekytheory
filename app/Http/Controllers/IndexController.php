<?php

namespace App\Http\Controllers;

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::join('users', 'users.id', '=', 'posts.user_id')->orderBy('posts.created_at', 'DESC')->where('posts.status', PostController::POST_STATUS_PUBLISHED)->paginate(6);
        return view('themes.' . self::THEME . '.index', compact('posts'));
    }

}
