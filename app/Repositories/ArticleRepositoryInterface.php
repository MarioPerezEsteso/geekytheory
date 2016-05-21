<?php

namespace App\Repositories;

use App\User;

interface ArticleRepositoryInterface extends PostRepositoryInterface
{
    public function findArticleBySlug($slug);

    public function findArticlesByAuthor(User $author, $paginate = Repository::PAGINATION_DEFAULT);

}