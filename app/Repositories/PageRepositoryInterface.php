<?php

namespace App\Repositories;


interface PageRepositoryInterface extends PostRepositoryInterface
{

    public function findPageBySlug($slug);

}