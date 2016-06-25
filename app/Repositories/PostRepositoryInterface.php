<?php

namespace App\Repositories;

interface PostRepositoryInterface
{
    public function findPostBySlug($slug);

    public function findPostsByAuthor($author, $paginate = Repository::PAGINATION_DEFAULT);

    public function findPostsByCategory($category, $paginate = self::PAGINATION_DEFAULT);
}