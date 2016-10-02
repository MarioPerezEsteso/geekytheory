<?php

use App\Http\Controllers\CommentController;
use App\Repositories\CommentRepository;
use App\Repositories\PostRepository;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class CommentControllerTest extends TestCase
{
    use WithoutMiddleware;

    public function testStoreComment()
    {
        $commentRepository = new CommentRepository();

        $data = array(
            'postId' => 1,
            'authorName' => 'Mario',
            'authorEmail' => 'mario@domain.com',
            'authorUrl' => 'http://geekytheory.com',
            'body' => 'This is the content of the comment',
        );

        $commentsBefore = count($commentRepository->all());

        $this->call('POST', 'comment/store', $data);

        $this->assertResponseOk();

        $comments = $commentRepository->all();
        $this->assertEquals($commentsBefore + 1, count($comments));

        /** @var \App\Comment $comment */
        $comment = $comments[count($comments) - 1];
        $this->assertEquals($data['postId'], $comment->post_id);
        $this->assertEquals($data['authorName'], $comment->author_name);
        $this->assertEquals($data['authorEmail'], $comment->author_email);
        $this->assertEquals($data['authorUrl'], $comment->author_url);
        $this->assertEquals($data['body'], $comment->body);
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