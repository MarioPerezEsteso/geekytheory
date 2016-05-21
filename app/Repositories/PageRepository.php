<?php

namespace App\Repositories;

use App\Http\Controllers\PostController;

class PageRepository extends PostRepository implements PageRepositoryInterface
{
    /**
     * Model class name
     *
     * @var string
     */
    protected $modelClassName = 'App\Post';

    public function findPageBySlug($slug)
    {
        return call_user_func_array("{$this->modelClassName}::where", array('slug', $slug))->where('type', PostController::POST_PAGE)->firstOrFail();
    }
}