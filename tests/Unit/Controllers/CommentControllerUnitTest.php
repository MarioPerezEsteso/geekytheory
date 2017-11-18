<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\CommentController;
use Carbon\Carbon;
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

}