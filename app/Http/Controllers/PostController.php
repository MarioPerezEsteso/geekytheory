<?php

namespace App\Http\Controllers;

use App\Category;
use App\Repositories\CategoryRepository;
use App\Repositories\PostRepository;
use App\Repositories\SiteMetaRepository;
use App\Repositories\UserRepository;
use App\Validators\ArticleValidator;
use App\Validators\PageValidator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use App\Post;
use Illuminate\Support\Facades\Cache;
use Validator;
use Illuminate\Support\Facades\Redirect;

class PostController extends Controller
{
    /**
     * Set cache expiration time to 240 minutes.
     */
    const CACHE_EXPIRATION_TIME = 240;

    /**
     * Number of posts to show with pagination in admin panel
     */
    const POSTS_PAGINATION_NUMBER = 10;

    /**
     * Number of posts to show with pagination in public view
     */
    const POSTS_PUBLIC_PAGINATION_NUMBER = 6;

    /**
     * Actions when editing a post
     */
    const POST_ACTION_PUBLISH = 'publish';
    const POST_ACTION_UPDATE = 'update';

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
     * PostController constructor.
     *
     * @param CategoryRepository $categoryRepository
     * @param UserRepository $userRepository
     * @param PageValidator|ArticleValidator $validator
     */
    public function __construct(CategoryRepository $categoryRepository, UserRepository $userRepository, $validator = null)
    {
        $this->categoryRepository = $categoryRepository;
        $this->userRepository = $userRepository;
        $this->validator = $validator;
    }

    /**
     * Store a newly created post in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param string $type
     * @return array
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
            'allow_comments' => $request->allow_comments,
            'show_title' => $request->show_title && $request->show_title == 'on',
            'show_description' => $request->show_description && $request->show_description == 'on',
        );

        if (!$this->validator->with($data)->passes()) {

            return array(
                'error' => true,
                'messages' => $this->validator->errors(),
            );
        } else {
            $post = new Post();
            $post->title = $data['title'];
            $post->body = $data['body'];
            $post->description = $data['description'];
            $post->status = $data['status'];
            $post->type = $data['type'];
            $post->allow_comments = $data['allow_comments'] == 'on';
            $post->show_title = $data['show_title'];
            $post->show_description = $data['show_description'];
            $post->published_at = null;

            if ($request->action == self::POST_ACTION_PUBLISH) {
                $post->status = Post::STATUS_PUBLISHED;
                $post->published_at = Carbon::now();
            }

            $post->slug = $slug;
            $post->user_id = Auth::user()->id;

            if ($image) {
                $fileName = ImageManagerController::getUploadFilename($image);
                $post->image = ImageManagerController::getPathYearMonth() . $fileName;
                $image->move(ImageManagerController::getPathYearMonth(), $fileName);
            }

            $post->save();
            if (!empty($data['categories'])) {
                // TODO: validate categories
                $categories = Category::whereIn('id', $data['categories'])->get();
                $post->categories()->sync($categories);
            }
        }

        return array(
            'id' => $post->id,
            'error' => false,
            'messages' => trans('home.post_create_success'),
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return array
     */
    public function update(Request $request, $id, $type)
    {
        /** @var UploadedFile $image */
        $image = $request->file('image');

        $data = array(
            'title' => $request->title,
            'body' => $request->body,
            'description' => $request->description,
            'status' => $request->status,
            'image' => $image,
            'type' => $type,
            'tags' => $request->tags,
            'categories' => $request->categories,
            'show_title' => $request->show_title && $request->show_title == 'on',
            'show_description' => $request->show_description && $request->show_description == 'on',
            'allow_comments' => $request->allow_comments,
        );

        if (!$this->validator->update($id)->with($data)) {
            return array(
                'error' => true,
                'messages' => $this->validator->errors(),
            );
        } else {
            $post = Post::findOrFail($id);
            $post->title = $data['title'];
            $post->body = $data['body'];
            $post->description = $data['description'];
            $post->show_title = $data['show_title'];
            $post->show_description = $data['show_description'];

            $post->status = $data['status'];
            $post->allow_comments = $data['allow_comments'] == 'on';
            if ($request->action == self::POST_ACTION_PUBLISH) {
                $post->status = Post::STATUS_PUBLISHED;
                $post->published_at = Carbon::now();
            }

            if ($image) {
                $fileName = ImageManagerController::getUploadFilename($image);
                $post->image = ImageManagerController::getPathYearMonth() . $fileName;
                $image->move(ImageManagerController::getPathYearMonth(), $fileName);
            }

            /*
             * Remove post cache on update
             */
            if (Cache::has('post_' . $post->slug)) {
                Cache::forget('post_' . $post->slug);
            }

            $post->save();
            if (!empty($data['categories'])) {
                $categories = Category::whereIn('id', $data['categories'])->get();
                $post->categories()->sync($categories);
            }
        }

        return array(
            'id' => $post->id,
            'error' => false,
            'messages' => trans('home.post_update_success'),
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

        return redirect()->route('home.articles');
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
        $post->update(['status' => Post::STATUS_DELETED]);

        return redirect()->route('home.articles');
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
            case Post::POST_ARTICLE:
                $url = 'home/articles/';
                break;
            case Post::POST_PAGE:
                $url = 'home/pages/';
                break;
        }

        return $url;
    }

    /**
     * Gets the public URL of a post depending of its type
     *
     * @param Post $post
     * @param bool $relative
     * @return string
     */
    public static function getPostPublicUrlByType(Post $post, $relative = true)
    {
        $url = '/' . $post->slug;
        if ($post->type == Post::POST_PAGE) {
            $url = '/p' . $url;
        }

        if (!$relative) {
            $siteUrl = (new SiteMetaRepository())->getSiteMeta()['url'];
            $url = $siteUrl . $url;
        }

        return $url;
    }
}
