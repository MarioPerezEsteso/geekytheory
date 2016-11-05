<?php

namespace App\Repositories;

use App\User;

interface GalleryRepositoryInterface
{
    public function findGalleries(User $author = null, $paginate = Repository::PAGINATION_DEFAULT);
}