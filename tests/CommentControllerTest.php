<?php

use App\Http\Controllers\CommentController;
use App\Repositories\CommentRepository;
use App\Repositories\PostRepository;

class CommentControllerTest extends TestCase
{
    /**
     * Test sortByParent with $addChildToParent = false.
     */
    public function testNoSortByParent()
    {
        $comments = $this->getCommentsByPost();
        $this->assertEquals(5, count($comments));

        $commentsOrdered = CommentController::sortByParent($comments, false);
        $this->assertEquals($comments, $commentsOrdered);
    }

    /**
     * Get the comments of a post using CommentRepository.
     *
     * @return null|array
     */
    public function getCommentsByPost()
    {
        $postRepository = new PostRepository();
        /** @var \App\Post $post */
        $post = $postRepository->find(1);
        $commentRepository = new CommentRepository();
        return $commentRepository->findCommentByPost($post);
    }

}