<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tag;
use Validator;
use Illuminate\Support\Facades\Redirect;

class TagController extends Controller
{

    /**
     * Number of tags to show with pagination
     */
    const TAGS_PAGINATION_NUMBER = 10;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::paginate(self::TAGS_PAGINATION_NUMBER);
        return view('home.posts.tags', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::paginate(self::TAGS_PAGINATION_NUMBER);
        return view('home.posts.tags', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (empty($request->slug)) {
            if (!empty($request->tag)) {
                $slug = $this->getAvailableSlug($request->tag);
            }
        } else {
            $slug = $this->getAvailableSlug($request->slug);
        }

        $rules = array(
            'tag' => 'required|unique:tags',
            'slug' => 'required|unique:tags',
        );

        $validator = Validator::make(array('tag' => $request->tag, 'slug' => $slug), $rules);

        if ($validator->fails()) {
            return Redirect::to('home/tags')->withErrors($validator->messages());
        } else {
            $tag = new Tag;
            $tag->tag = $request->tag;
            $tag->slug = $slug;
            $tag->save();
        }

        return Redirect::to('home/tags')->withSuccess(trans('home.tag_create_success'));
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
        $tag = Tag::findOrFail($id);
        $tags = Tag::paginate(self::TAGS_PAGINATION_NUMBER);
        return view('home.posts.tags', compact('tag', 'tags'));
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

    public function getAvailableSlug($text)
    {
        $slugAvailable = false;
        $slugSuffix = "";
        $counter = 1;
        while (!$slugAvailable) {
            $slug = slugify($text . $slugSuffix);
            if (Tag::where('slug', $slug)->first() == null) {
                $slugAvailable = true;
            }
            $slugSuffix = "-" . $counter++;
        }
        return $slug;
    }

}
