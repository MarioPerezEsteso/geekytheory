<?php

namespace App\Repositories;

use App\Category;

class CategoryRepository extends Repository implements CategoryRepositoryInterface
{
    /**
     * Model class name
     *
     * @var string
     */
    protected $modelClassName = 'App\Category';

    /**
     * Find category by its slug
     *
     * @param $slug
     * @return Category
     */
    public function findCategoryBySlug($slug)
    {
        return call_user_func_array("{$this->modelClassName}::where", array('slug', $slug))->firstOrFail();;
    }
}