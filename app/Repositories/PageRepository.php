<?php

namespace App\Repositories;

use App\Http\Controllers\PostController;
use App\Post;
use App\User;

class PageRepository extends PostRepository implements PageRepositoryInterface
{
    /**
     * Model class name
     *
     * @var string
     */
    protected $modelClassName = 'App\Post';

    /**
     * Find all pages.
     *
     * @param User $author
     * @param int $paginate
     * @return mixed
     */
    public function findPagesByAuthor(User $author, $paginate = Repository::PAGINATION_DEFAULT)
    {
        return $this->findPages($paginate, $author);
    }

    /**
     * Find a page by its slug.
     *
     * @param $slug
     * @param bool $isPreview
     * @return mixed
     */
    public function findPageBySlug($slug, $isPreview = false)
    {
        $query = call_user_func_array("{$this->modelClassName}::where", array('slug', $slug))
            ->where('type', Post::POST_PAGE);
        if (!$isPreview) {
            $query->where('status', Post::STATUS_PUBLISHED);
        }
        return $query->firstOrFail();
    }

    /**
     * Find pages owned by an author.
     *
     * @param User $author
     * @param int $paginate
     * @return mixed
     */
    public function findPages($paginate = Repository::PAGINATION_DEFAULT, User $author = null)
    {
        $columns = User::$mappings;
        array_push($columns, 'posts.*');
        $query = call_user_func_array("{$this->modelClassName}::join", array('users', 'users.id', '=', 'posts.user_id'))
            ->select($columns)
            ->orderBy('posts.created_at', 'DESC')
            ->where('posts.type', Post::POST_PAGE);
        if ($author !== null) {
            $query->where('users.username', $author->username);
        }
        return $query->paginate($paginate);
    }
}