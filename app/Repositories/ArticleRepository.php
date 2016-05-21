<?php

namespace App\Repositories;

use App\Http\Controllers\PostController;
use App\User;

class ArticleRepository extends PostRepository implements ArticleRepositoryInterface
{
    /**
     * Model class name
     *
     * @var string
     */
    protected $modelClassName = 'App\Post';

    /**
     * Find all articles.
     *
     * @param int $paginate
     * @return mixed
     */
    public function findAllArticles($paginate = Repository::PAGINATION_DEFAULT)
    {
        return $this->findArticles(null, false, $paginate);
    }

    /**
     * Find an article by its slug.
     *
     * @param $slug
     * @return mixed
     */
    public function findArticleBySlug($slug)
    {
        return call_user_func_array("{$this->modelClassName}::where", array('slug', $slug))
            ->where('type', PostController::POST_ARTICLE)
            ->firstOrFail();
    }

    /**
     * Find the published articles owned by an author.
     *
     * @param User $author
     * @param int $paginate
     * @return mixed
     */
    public function findPublishedArticlesByAuthor(User $author, $paginate = Repository::PAGINATION_DEFAULT)
    {
        return $this->findArticles($author, true, $paginate);
    }

    /**
     * Find the articles owned by an author.
     *
     * @param User $author
     * @param bool $onlyPublishedArticles
     * @param int $paginate
     * @return mixed
     */
    public function findArticles(User $author = null, $onlyPublishedArticles = false, $paginate = Repository::PAGINATION_DEFAULT)
    {
        $columns = User::$mappings;
        array_push($columns, 'posts.*');
        $query = call_user_func_array("{$this->modelClassName}::join", array('users', 'users.id', '=', 'posts.user_id'))
            ->select($columns)
            ->orderBy('posts.created_at', 'DESC')
            ->where('posts.type', PostController::POST_ARTICLE);
        if ($author !== null) {
            $query->where('users.username', $author->username);
        }
        if ($onlyPublishedArticles) {
            $query->where('posts.status', PostController::POST_STATUS_PUBLISHED);
        }
        return $query->paginate($paginate);
    }
}