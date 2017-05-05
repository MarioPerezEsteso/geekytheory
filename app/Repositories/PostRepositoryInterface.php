<?php

namespace App\Repositories;

interface PostRepositoryInterface
{
    public function findPostBySlug($slug);

    public function findPostsByAuthor($author, $paginate = Repository::PAGINATION_DEFAULT);

    public function findPostsByCategory($category, $paginate = Repository::PAGINATION_DEFAULT);

    public function findPostsByTag($tag, $paginate = Repository::PAGINATION_DEFAULT);

}