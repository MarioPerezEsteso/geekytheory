<?php

namespace App\Repositories;

interface ArticleRepositoryInterface extends PostRepositoryInterface
{
    public function findArticleBySlug($slug);

    public function findArticlesByAuthor($author, $paginate = Repository::PAGINATION_DEFAULT);

}