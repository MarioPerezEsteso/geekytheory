<?php

namespace App\Repositories;

use App\Http\Controllers\PostController;
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
     * @param int $paginate
     * @return mixed
     */
    public function findAllPages($paginate = Repository::PAGINATION_DEFAULT)
    {
        return call_user_func_array("{$this->modelClassName}::where", array('type', PostController::POST_PAGE))
            ->paginate($paginate);
    }

    /**
     * Find a page by its slug.
     *
     * @param $slug
     * @return mixed
     */
    public function findPageBySlug($slug)
    {
        return call_user_func_array("{$this->modelClassName}::where", array('slug', $slug))->where('type', PostController::POST_PAGE)->firstOrFail();
    }

    public function findPagesByAuthor(User $author, $paginate = Repository::PAGINATION_DEFAULT)
    {

    }
}