<?php

namespace Tests\Unit\Controllers;

use App\Comment;
use App\Http\Controllers\CommentController;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class CommentControllerUnitTest extends TestCase
{
    /**
     * Test date string formatted for humans.
     *
     * @TODO: user a data provider for this test.
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
     * Test sortByParent. This test checks the number of children of each comment and
     * also if all of them are instances of the \App\Comment class.
     */
    public function testSortByParent()
    {
        $comments = $this->getFactoryComments();

        $commentsOrdered = CommentController::sortByParent($comments);

        $this->assertEquals(2, count($commentsOrdered));

        $this->assertEquals(2, count($commentsOrdered[$comments[0]->id]->children));
        $this->assertInstanceOf(Comment::class, $commentsOrdered[$comments[0]->id]);

        $this->assertEquals(1, count($commentsOrdered[$comments[0]->id]->children[$comments[1]->id]->children));
        $this->assertInstanceOf(Comment::class, $commentsOrdered[$comments[0]->id]->children[$comments[1]->id]);

        $this->assertEquals(0, count($commentsOrdered[$comments[0]->id]->children[$comments[1]->id]->children[$comments[2]->id]->children));
        $this->assertInstanceOf(Comment::class, $commentsOrdered[$comments[0]->id]->children[$comments[1]->id]->children[$comments[2]->id]);

        $this->assertEquals(0, count($commentsOrdered[$comments[0]->id]->children[$comments[3]->id]->children));
        $this->assertInstanceOf(Comment::class, $commentsOrdered[$comments[0]->id]->children[$comments[3]->id]);

        $this->assertEquals(0, count($commentsOrdered[$comments[4]->id]->children));
        $this->assertInstanceOf(Comment::class, $commentsOrdered[$comments[4]->id]);
    }

    /**
     * Test sortByParent with $addChildToParent = false.
     */
    public function testNoSortByParent()
    {
        $comments = $this->getFactoryComments();
        $this->assertEquals(5, count($comments));

        $commentsOrdered = CommentController::sortByParent($comments, false);
        $this->assertEquals($comments, $commentsOrdered);
    }

    /**
     * Build comments.
     *
     * @return Collection
     */
    public function getFactoryComments(): Collection
    {
        $comment1 = factory(Comment::class)->create(['parent' => null,]);
        $comment2 = factory(Comment::class)->create(['parent' => $comment1->id,]);
        $comment3 = factory(Comment::class)->create(['parent' => $comment2->id,]);
        $comment4 = factory(Comment::class)->create(['parent' => $comment1->id,]);
        $comment5 = factory(Comment::class)->create(['parent' => null,]);

        return new Collection([
            $comment1,
            $comment2,
            $comment3,
            $comment4,
            $comment5,
        ]);
    }

}