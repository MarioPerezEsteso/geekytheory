<?php

namespace App\Repositories;

interface TagRepositoryInterface
{
    public function findTagBySlug($slug);

}