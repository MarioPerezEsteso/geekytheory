<?php

namespace App\Repositories;

use App\Category;
use App\Http\Controllers\PostController;
use App\Post;
use App\User;
use phpDocumentor\Reflection\DocBlock\Tag;

class PostRepository extends Repository implements PostRepositoryInterface
{

    /**
     * Model class name
     *
     * @var string
     */
    protected $modelClassName = 'App\Post';

    /**
     * Find post by its slug
     *
     * @param $slug
     * @return Post
     */
    public function findPostBySlug($slug)
    {
        return call_user_func_array("{$this->modelClassName}::where", array('slug', $slug))->firstOrFail();
    }

    /**
     * Find posts by author
     *
     * @param User $author
     * @param int $paginate
     */
    public function findPostsByAuthor($author, $paginate = self::PAGINATION_DEFAULT)
    {
        return call_user_func_array("{$this->modelClassName}::join", array('users', 'users.id', '=', 'posts.user_id'))
            ->orderBy('posts.created_at', 'DESC')
            ->where('posts.status', PostController::POST_STATUS_PUBLISHED)
            ->where('users.username', $author->username)
            ->paginate($paginate);
    }

    /**
     * Find posts by category
     *
     * @param Category $category
     * @param int $paginate
     * @return array Post
     */
    public function findPostsByCategory($category, $paginate = self::PAGINATION_DEFAULT)
    {
        $columns = User::$mappings;
        array_push($columns, 'posts.*');
        $query = $category->posts()
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->orderBy('posts.created_at', 'DESC')
            ->where('posts.type', PostController::POST_ARTICLE)
            ->where('posts.status', PostController::POST_STATUS_PUBLISHED)
            ->select($columns);
        return $query->paginate($paginate);
    }

    /**
     * Find posts by tag
     *
     * @param Tag $tag
     * @param int $paginate
     */
    public function findPostsByTag($tag, $paginate = self::PAGINATION_DEFAULT)
    {
        $columns = User::$mappings;
        array_push($columns, 'posts.*');
        $query = $tag->posts()
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->orderBy('posts.created_at', 'DESC')
            ->where('posts.type', PostController::POST_ARTICLE)
            ->where('posts.status', PostController::POST_STATUS_PUBLISHED)
            ->select($columns);
        return $query->paginate($paginate);
    }
}