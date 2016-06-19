<?php

namespace App\Http\Controllers;

use App\Category;
use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\PostRepository;
use App\Repositories\UserRepository;
use App\Validators\ArticleValidator;
use App\Validators\PageValidator;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use App\Post;
use App\Repositories\PageRepository;
use Validator;
use Illuminate\Support\Facades\Redirect;

class PostController extends Controller
{
    /**
     * @var PageRepository|ArticleRepository
     */
    protected $repository;

    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @var PageValidator|ArticleValidator
     */
    protected $validator;

    /**
     * Number of posts to show with pagination in admin panel
     */
    const POSTS_PAGINATION_NUMBER = 10;

    /**
     * Number of posts to show with pagination in public view
     */
    const POSTS_PUBLIC_PAGINATION_NUMBER = 6;

    /**
     * Possible statuses of a post
     */
    const POST_STATUS_PENDING   = 'pending';
    const POST_STATUS_DRAFT     = 'draft';
    const POST_STATUS_DELETED   = 'deleted';
    const POST_STATUS_PUBLISHED = 'published';
    const POST_STATUS_SCHEDULED = 'scheduled';

    /**
     * Possible types of a post
     */
    const POST_ARTICLE      = 'article';
    const POST_PAGE         = 'page';

    /**
     * Actions when editing a post
     */
    const POST_ACTION_PUBLISH   = 'publish';
    const POST_ACTION_UPDATE    = 'update';

    /**
     * PostController constructor.
     *
     * @param PageRepository|ArticleRepository $repository
     * @param CategoryRepository $categoryRepository
     * @param UserRepository $userRepository
     */
    public function __construct($repository = null, CategoryRepository $categoryRepository, UserRepository $userRepository, $validator)
    {
        if ($repository !== null) {
            $this->repository = $repository;
        } else {
            $this->repository = new PostRepository();
        }
        $this->categoryRepository = $categoryRepository;
        $this->userRepository = $userRepository;
        $this->validator = $validator;
    }

    /**
     * Store a newly created post in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param string $type
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $type)
    {
        $slug = getAvailableSlug($request->title, (new Post())->getTable());

        /** @var UploadedFile $image */
        $image = $request->file('image');

        $data = array(
            'title' => $request->title,
            'body' => $request->body,
            'description' => $request->description,
            'status' => $request->status,
            'tags' => $request->tags,
            'slug' => $slug,
            'categories' => $request->categories,
            'image' => $image,
            'type' => $type,
        );

        if (!$this->validator->with($data)->passes()) {
            return array(
                'error'     => true,
                'messages'  => $validator->messages(),
            );
        } else {
            $post = new Post;
            $post->title = $data['title'];
            $post->body = $data['body'];
            $post->description = $data['description'];
            $post->status = $data['status'];
            $post->type = $data['type'];
            if ($request->action == self::POST_ACTION_PUBLISH) {
                $post->status = self::POST_STATUS_PUBLISHED;
            }
            $post->slug = $slug;
            $post->user_id = Auth::user()->id;
            if ($image) {
                $fileName = ImageManagerController::getImageName($image, ImageManagerController::PATH_IMAGE_UPLOADS);
                $post->image = $fileName;
                $image->move(ImageManagerController::PATH_IMAGE_UPLOADS, $fileName);
            }
            $post->save();
            $categories = Category::whereIn('id', $data['categories'])->get();
            $post->categories()->sync($categories);
        }

        return array(
            'id'        => $post->id,
            'error'     => false,
            'messages'  => trans('home.post_create_success'),
        );
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
        $rules = array(
            'title' => 'required|max:255unique:posts,id,' . $id,
            'body' => 'required',
            'status' => 'in:' . self::POST_STATUS_PENDING . ','
                . self::POST_STATUS_DRAFT . ','
                . self::POST_STATUS_PUBLISHED . ','
                . self::POST_STATUS_SCHEDULED,
            'description' => 'required|max:170',
            'image' => 'mimes:jpeg,gif,png',
        );

        /** @var UploadedFile $image */
        $image = $request->file('image');

        $requestParams = array(
            'title' => $request->title,
            'body' => $request->body,
            'description' => $request->description,
            'status' => $request->status,
            'tags' => $request->tags,
            'categories' => $request->categories,
        );

        $validator = Validator::make($requestParams, $rules);

        if ($validator->fails()) {
            return array(
                'error'     => true,
                'messages'  => $validator->messages(),
            );
        } else {
            $post = Post::findOrFail($id);
            $post->title = $requestParams['title'];
            $post->body = $requestParams['body'];
            $post->description = $requestParams['description'];
            $post->status = $requestParams['status'];
            if ($request->action == self::POST_ACTION_PUBLISH) {
                $post->status = self::POST_STATUS_PUBLISHED;
            }
            if ($image) {
                $fileName = ImageManagerController::getImageName($image, ImageManagerController::PATH_IMAGE_UPLOADS);
                $post->image = $fileName;
                $image->move(ImageManagerController::PATH_IMAGE_UPLOADS, $fileName);
            }
            $post->save();
            $categories = Category::whereIn('id', $requestParams['categories'])->get();
            $post->categories()->sync($categories);
        }

        return array(
            'id'        => $post->id,
            'error'     => false,
            'messages'  => trans('home.post_update_success'),
        );
    }

    /**
     * Set post status as draft after being deleted
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $post = Post::findOrFail($id);
        $post->status = Post::STATUS_DRAFT;
        $post->save();
        return Redirect::back();
    }

    /**
     * Set post status as deleted.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $post = Post::findOrFail($id);
        $post->status = Post::STATUS_DELETED;
        $post->save();
        return Redirect::back();
    }

    /**
     * Delete the image of a post.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function deletePostImage(Request $request)
    {
        if (!empty($request->id)) {
            $post = Post::findOrFail($request->id);
            $post->image = NULL;
            $post->save();
            return response()->json(['error' => 0]);
        } else {
            return response()->json(['error' => 1]);
        }
    }

    /**
     * Gets the base URL of a post depending of its type
     *
     * @param Post $post
     * @return string
     */
    public static function getPostDashboardUrlByType(Post $post)
    {
        $url = '';
        switch ($post->type) {
            case self::POST_ARTICLE:
                $url = 'home/articles/';
                break;
            case self::POST_PAGE:
                $url = 'home/pages/';
                break;
        }
        return $url;
    }

    /**
     * Gets the public URL of a post depending of its type
     *
     * @param Post $post
     * @return string
     */
    public static function getPostPublicUrlByType(Post $post)
    {
        $url = '/' . $post->slug;
        if ($post->type == self::POST_PAGE) {
            $url = '/p' . $url;
        }
        return $url;
    }

}
