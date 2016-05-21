<?php

namespace App\Repositories;


use App\User;

interface PageRepositoryInterface extends PostRepositoryInterface
{

    public function findPageBySlug($slug);

    public function findAllPages($paginate = Repository::PAGINATION_DEFAULT);

    public function findPagesByAuthor(User $author, $paginate = Repository::PAGINATION_DEFAULT);

}