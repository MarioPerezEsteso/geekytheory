<?php

namespace App\Repositories;

use App\User;

interface ArticleRepositoryInterface extends PostRepositoryInterface
{
    public function findArticleBySlug($slug, $isPreview = false);

    public function findAllArticles($paginate = Repository::PAGINATION_DEFAULT);

    public function findPublishedArticlesByAuthor(User $author, $paginate = Repository::PAGINATION_DEFAULT);

    public function findArticles(User $author, $onlyPublishedArticles = false, $paginate = Repository::PAGINATION_DEFAULT);

    public function findArticlesBySearch($onlyPublishedArticles = false, $paginate = Repository::PAGINATION_DEFAULT, $text = null);

}