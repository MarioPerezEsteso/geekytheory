<?php

namespace App\Repositories;

use App\Http\Controllers\PostController;
use App\Http\Requests\Request;
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
     * @param bool $isPreview
     * @return mixed
     */
    public function findArticleBySlug($slug, $isPreview = false)
    {
        $query = call_user_func_array("{$this->modelClassName}::where", array('slug', $slug))
            ->where('type', PostController::POST_ARTICLE);
        if (!$isPreview) {
            $query->where('status', PostController::POST_STATUS_PUBLISHED);
        }
        return $query->firstOrFail();
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
    public function findArticles(User $author = null, $onlyPublishedArticles = false, $paginate = Repository::PAGINATION_DEFAULT, $text = null)
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

        if ($text !== null) {
            $query->where('posts.body', 'like', "%$text%");
        }

        return $query->paginate($paginate);
    }

    /**
     * Find articles by search.
     *
     * @param bool $onlyPublishedArticles
     * @param int $paginate
     * @param null $text
     * @return mixed
     */
    public function findArticlesBySearch($onlyPublishedArticles = false, $paginate = Repository::PAGINATION_DEFAULT, $text = null)
    {
        return self::findArticles(null, $onlyPublishedArticles, $paginate, $text);
    }
}