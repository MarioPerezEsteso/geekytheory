<?php

namespace App\Http\Controllers\Home;


use App\Http\Requests;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show home homepage
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('home.home.home');
    }

}
