<?php

namespace App\Repositories;


use App\User;

interface PageRepositoryInterface extends PostRepositoryInterface
{

    public function findPageBySlug($slug, $isPreview = false);

    public function findPages($paginate = Repository::PAGINATION_DEFAULT, User $author = null);

    public function findPagesByAuthor(User $author, $paginate = Repository::PAGINATION_DEFAULT);

}