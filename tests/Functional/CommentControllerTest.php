<?php

namespace Tests\Functional;

use App\Http\Controllers\CommentController;
use App\Repositories\CommentRepository;
use App\Repositories\PostRepository;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    use WithoutMiddleware;

    /**
     * Test store comments
     *
     * @dataProvider getCommentsToStore
     * @param array $data
     */
    public function testStoreCommentOk($data)
    {
        $response = $this->call('POST', 'comment/store', $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('comments', [
            'post_id' => $data['postId'],
            'author_name' => $data['authorName'],
            'author_email' => $data['authorEmail'],
            'author_url' => $data['authorUrl'],
            'body' => $data['body'],
        ]);
    }

    /**
     * Get the valid comments to be stored
     *
     * @return array
     */
    public static function getCommentsToStore()
    {
        return [
            [
                [
                    'postId' => 1,
                    'authorName' => 'Mario',
                    'authorEmail' => 'mario@domain.com',
                    'authorUrl' => 'http://geekytheory.com',
                    'body' => 'This is the content of the comment',
                ],
            ],
            [
                [
                    'postId' => 1,
                    'authorName' => 'Mario',
                    'authorEmail' => 'mario@domain.com',
                    'authorUrl' => '',
                    'body' => 'This is the content of the second test',
                ],
            ],
            [
                [
                    'postId' => 1,
                    'authorName' => 'Alice',
                    'authorEmail' => 'alice.3@domain.com',
                    'authorUrl' => '',
                    'body' => 'This is the third test',
                ],
            ],
        ];
    }

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