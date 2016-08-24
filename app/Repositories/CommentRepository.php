<?php

namespace App\Repositories;

use App\Comment;
use App\Post;

class CommentRepository extends Repository implements CommentRepositoryInterface
{
    /**
     * Model class name
     *
     * @var string
     */
    protected $modelClassName = 'App\Comment';

    public function findCommentByPost($post)
    {
        if ($post === null) {
            return null;
        }

        return call_user_func_array("{$this->modelClassName}::where", array('post_id', $post->id))->get();
    }
}