<?php

namespace App\Repositories;

interface PostRepositoryInterface
{

    public function findPostBySlug($slug);

}