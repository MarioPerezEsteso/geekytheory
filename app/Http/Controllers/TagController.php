<?php

namespace App\Http\Controllers;

use App\Article;
use App\Repositories\PostRepository;
use App\Validators\TagCreateValidator;
use App\Validators\TagValidator;
use Illuminate\Http\Request;
use App\Http\Requests;
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
     * Validator for Tag creation
     *
     * @var TagValidator
     */
    protected $validator;

    /**
     * TagController constructor.
     *
     * @param TagValidator $tagValidator
     */
    public function __construct(TagValidator $tagValidator)
    {
        $this->validator = $tagValidator;
    }

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
        if (empty($request->get('slug')) && !empty($request->get('tag'))) {
            $slug = $this->getAvailableSlug($request->get('tag'));
        } else {
            $slug = $this->getAvailableSlug($request->get('slug'));
        }

        $data = array(
            'tag' => $request->get('tag'),
            'description' => $request->get('description'),
            'slug' => $slug
        );

        if (!$this->validator->with($data)->passes()) {
            return Redirect::to('home/tags')->withErrors($this->validator->errors());
        } else {
            Tag::create($data);
        }

        return Redirect::to('home/tags')->withSuccess(trans('home.tag_create_success'));
    }

    /**
     * Display list of posts by tag.
     *
     * @param string $tagSlug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showByTag($tagSlug)
    {
        $tag = Tag::findBySlugOrFail($tagSlug);
        $articles = Article::getByTag($tag)->with('user', 'categories')->paginate(self::TAGS_PAGINATION_NUMBER);

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
        $tag = Tag::findOrFail($id);

        $data = array(
            'tag' => $request->get('tag'),
            'description' => $request->get('description'),
            'slug' => $request->get('slug'),
        );

        if (!$this->validator->update($id)->with($data)->passes()) {

            return Redirect::to("home/tags/edit/$id")->withErrors($this->validator->errors());
        } else {
            $tag->update($id, $data);
        }

        return Redirect::to('home/tags')->withSuccess(trans('home.tag_create_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);
        $tag->destroy($id);

        return Redirect::to('home/tags')->withSuccess(trans('home.tag_delete_success'));
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
