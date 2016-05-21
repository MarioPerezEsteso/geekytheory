<?php

namespace App\Repositories;

use App\Http\Controllers\PostController;

class ArticleRepository extends PostRepository implements ArticleRepositoryInterface
{
    /**
     * Model class name
     *
     * @var string
     */
    protected $modelClassName = 'App\Post';


    public function findArticleBySlug($slug)
    {
        return call_user_func_array("{$this->modelClassName}::where", array('slug', $slug))->where('type', PostController::POST_ARTICLE)->firstOrFail();
    }

    public function findArticlesByAuthor($author, $paginate = Repository::PAGINATION_DEFAULT)
    {
        return call_user_func_array("{$this->modelClassName}::join", array('users', 'users.id', '=', 'posts.user_id'))
            ->orderBy('posts.created_at', 'DESC')
            ->where('posts.status', PostController::POST_STATUS_PUBLISHED)
            ->where('post.type', PostController::POST_ARTICLE)
            ->where('users.username', $author->username)
            ->paginate($paginate);
    }
}