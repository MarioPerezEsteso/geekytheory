<?php

namespace App\Repositories;

use App\Tag;

class TagRepository extends Repository implements TagRepositoryInterface
{
    /**
     * Model class name
     *
     * @var string
     */
    protected $modelClassName = 'App\Tag';

    /**
     * Find tag by its slug
     *
     * @param $slug
     * @return Tag
     */
    public function findTagBySlug($slug)
    {
        return call_user_func_array("{$this->modelClassName}::where", array('slug', $slug))->firstOrFail();;
    }
}