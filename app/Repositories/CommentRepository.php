<?php

namespace App\Repositories;

use App\Comment;

class CommentRepository extends Repository implements CommentRepositoryInterface
{
    /**
     * Model class name
     *
     * @var string
     */
    protected $modelClassName = 'App\Comment';

}