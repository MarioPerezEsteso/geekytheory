<?php

namespace App\Repositories;

interface CategoryRepositoryInterface
{

    public function findCategoryBySlug($slug);

}