<?php

use App\Http\Controllers\CommentController;
use App\Repositories\CommentRepository;
use App\Repositories\PostRepository;

class CommentControllerTest extends TestCase
{
    /**
     * Test sortByParent. This test checks the number of children of each comment and
     * also if all of them are instances of the \App\Comment class.
     */
    public function testSortByParent()
    {
        $comments = $this->getCommentsByPost();
        $this->assertEquals(5, count($comments));

        $commentsOrdered = CommentController::sortByParent($comments);

        $this->assertEquals(2, count($commentsOrdered));

        $this->assertEquals(2, count($commentsOrdered['1']->children));
        $this->assertInstanceOf(\App\Comment::class, $commentsOrdered['1']);

        $this->assertEquals(1, count($commentsOrdered['1']->children['2']->children));
        $this->assertInstanceOf(\App\Comment::class, $commentsOrdered['1']->children['2']);

        $this->assertEquals(0, count($commentsOrdered['1']->children['2']->children['3']->children));
        $this->assertInstanceOf(\App\Comment::class, $commentsOrdered['1']->children['2']->children['3']);

        $this->assertEquals(0, count($commentsOrdered['1']->children['4']->children));
        $this->assertInstanceOf(\App\Comment::class, $commentsOrdered['1']->children['4']);

        $this->assertEquals(0, count($commentsOrdered['5']->children));
        $this->assertInstanceOf(\App\Comment::class, $commentsOrdered['5']);

    }

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