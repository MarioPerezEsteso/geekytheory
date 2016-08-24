<?php

use App\Repositories\CommentRepository;
use App\Repositories\PostRepository;

class CommentRepositoryTest extends TestCase
{
    /**
     * Test findCommentsByPost
     */
    public function testFindCommentsByPost()
    {
        $postRepository = new PostRepository();
        /** @var Post $post */
        $post = $postRepository->find(1);
        $repository = new CommentRepository();
        $comments = $repository->findCommentByPost($post);
        $this->assertNotNull($comments);
        $this->assertEquals(5, count($comments));
    }

    /**
     * Test findCommentsByPost when post is null.
     */
    public function testFindCommentsByPostReturnsNull()
    {
        $repository = new CommentRepository();
        $comments = $repository->findCommentByPost(null);
        $this->assertNull($comments);
    }
}