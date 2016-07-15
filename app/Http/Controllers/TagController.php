<?php

namespace App\Http\Controllers;

use App\Repositories\TagRepository;
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
     * @var TagRepository
     */
    protected $repository;

    /**
     * Validator for Tag creation
     *
     * @var TagValidator
     */
    protected $validator;

    /**
     * TagController constructor.
     *
     * @param TagRepository $tagRepository
     * @param TagValidator $tagValidator
     */
    public function __construct(TagRepository $tagRepository, TagValidator $tagValidator)
    {
        $this->repository = $tagRepository;
        $this->validator = $tagValidator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = $this->repository->paginate(self::TAGS_PAGINATION_NUMBER);
        return view('home.posts.tags', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = $this->repository->paginate(self::TAGS_PAGINATION_NUMBER);
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
        if (empty($request->slug) && !empty($request->tag)) {
            $slug = $this->getAvailableSlug($request->tag);
        } else {
            $slug = $this->getAvailableSlug($request->slug);
        }

        $data = array(
            'tag'   => $request->tag,
            'slug'  => $slug
        );

        if (!$this->validator->with($data)->passes()) {
            return Redirect::to('home/tags')->withErrors($this->validator->errors());
        } else {
            $tag = new Tag;
            $tag->tag = $request->tag;
            $tag->slug = $slug;
            $tag->save();
        }

        return Redirect::to('home/tags')->withSuccess(trans('home.tag_create_success'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tag = $this->repository->findOrFail($id);
        $tags = $this->repository->paginate(self::TAGS_PAGINATION_NUMBER);
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
        $data = array(
            'tag'   => $request->tag,
            'slug'  => $request->slug,
        );

        if (!$this->validator->update($id)->with($data)->passes()) {
            return Redirect::to('home/tags')->withErrors($this->validator->errors());
        } else {
            $this->repository->update($id, $data);
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
        $this->repository->destroy($id);
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
