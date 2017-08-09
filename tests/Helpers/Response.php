<?php

namespace Tests\Helpers;

use Illuminate\Foundation\Testing\TestResponse;
use PHPUnit\Framework\Assert as PHPUnit;

class Response extends TestResponse
{
    /**
     * The response to delegate to.
     *
     * @var \Illuminate\Http\Response
     */
    public $baseResponse;

    /**
     * Create a new TestResponse from another response.
     *
     * @param TestResponse $response
     * @return static
     */
    public static function fromTestResponse(TestResponse $response)
    {
        return new static($response->baseResponse);
    }

    /**
     * Assert that the response has the given number of resources.
     *
     * @param $count
     */
    public function assertApiResponseResourceCountIs($count)
    {
        $arrayData = $this->json();
        $actual = count($arrayData['data']);
        PHPUnit::assertTrue(
            $actual === $count,
            "Expected resource count {$count} but received {$actual}."
        );
    }
}