<?php

namespace App\Repositories;

use App\Post;

class PostRepository extends Repository implements PostRepositoryInterface {

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
        $where = call_user_func_array("{$this->modelClassName}::where", array('slug', $slug));
        return $where->firstOrFail();
    }
}