<?php

use App\Http\Controllers\CommentController;
use App\Repositories\CommentRepository;
use App\Repositories\PostRepository;
use Carbon\Carbon;
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

        $response = $this->call('POST', 'comment/store', $data);

        $response->assertStatus(200);

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
     * Test date string formatted for humans.
     */
    public function testGetDateFormatted()
    {
        // Format: 2016-10-02 13:07:54
        $dates = [
            'now' => Carbon::now()->toDateTimeString(),
            '1SecondAgo' => Carbon::now()->subSecond(1)->toDateTimeString(),
            '50SecondsAgo' => Carbon::now()->subSecond(50)->toDateTimeString(),
            '1MinAgo' => Carbon::now()->subMinute(1)->toDateTimeString(),
            '5MinAgo' => Carbon::now()->subMinute(5)->toDateTimeString(),
            '10MinAgo' => Carbon::now()->subMinute(10)->toDateTimeString(),
            '1HourAgo' => Carbon::now()->subHour(1)->toDateTimeString(),
            '5HourAgo' => Carbon::now()->subHour(5)->toDateTimeString(),
            '1DayAgo' => Carbon::now()->subDay(1)->toDateTimeString(),
            '10DaysAgo' => Carbon::now()->subDay(10)->toDateTimeString(),
            '1MonthAgo' => Carbon::now()->subMonth(1)->toDateTimeString(),
            '10MonthsAgo' => Carbon::now()->subMonth(10)->toDateTimeString(),
            '1YearAgo' => Carbon::now()->subYear(1)->toDateTimeString(),
            '2YearsAgo' => Carbon::now()->subYear(2)->toDateTimeString(),
        ];
        $this->assertEquals(trans('public.now'), CommentController::getDateFormatted($dates['now']));
        $this->assertEquals(trans('public.second_ago'), CommentController::getDateFormatted($dates['1SecondAgo']));
        $this->assertEquals(trans('public.seconds_ago', ['number' => 50]), CommentController::getDateFormatted($dates['50SecondsAgo']));
        $this->assertEquals(trans('public.minute_ago'), CommentController::getDateFormatted($dates['1MinAgo']));
        $this->assertEquals(trans('public.minutes_ago', ['number' => 5]), CommentController::getDateFormatted($dates['5MinAgo']));
        $this->assertEquals(trans('public.minutes_ago', ['number' => 10]), CommentController::getDateFormatted($dates['10MinAgo']));
        $this->assertEquals(trans('public.hour_ago'), CommentController::getDateFormatted($dates['1HourAgo']));
        $this->assertEquals(trans('public.hours_ago', ['number' => 5]), CommentController::getDateFormatted($dates['5HourAgo']));
        $this->assertEquals(trans('public.day_ago'), CommentController::getDateFormatted($dates['1DayAgo']));
        $this->assertEquals(trans('public.days_ago', ['number' => 10]), CommentController::getDateFormatted($dates['10DaysAgo']));
        $this->assertEquals(trans('public.month_ago', ['number' => 1]), CommentController::getDateFormatted($dates['1MonthAgo']));
        $this->assertEquals(trans('public.months_ago', ['number' => 10]), CommentController::getDateFormatted($dates['10MonthsAgo']));
        $this->assertEquals(trans('public.year_ago'), CommentController::getDateFormatted($dates['1YearAgo']));
        $this->assertEquals(trans('public.years_ago', ['number' => 2]), CommentController::getDateFormatted($dates['2YearsAgo']));
        $this->assertEquals('', CommentController::getDateFormatted(null));
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