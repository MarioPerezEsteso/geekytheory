<?php

namespace App\Repositories;

use App\Post;

interface CommentRepositoryInterface
{
    public function findCommentByPost($post);
}