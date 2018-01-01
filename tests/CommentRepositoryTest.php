<?php

namespace Tests;

use App\Post;
use App\Repositories\CommentRepository;
use Tests\Helpers\TestUtils;

class CommentRepositoryTest extends TestCase
{
    /**
     * Test findCommentsByPost
     */
    public function testFindCommentsByPost()
    {
        $article = factory(Post::class)->create();
        TestUtils::createComments($article->id);
        $repository = new CommentRepository();
        $comments = $repository->findCommentByPost($article);
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