<?php

namespace Tests\Helpers;

use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\View\View;
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
     * @var View
     */
    private $view;
    /**
     * Array of data passed to view.
     *
     * @var array
     */
    private $arrayData = [];

    public function __construct(\Illuminate\Http\Response $response)
    {
        parent::__construct($response);
        $this->view = $response->getOriginalContent();
        $this->arrayData = $this->view->getData();
    }

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
    public function assertResponseResourceCountIs($count)
    {
        $actual = count($this->arrayData['data']);
        PHPUnit::assertTrue(
            $actual === $count,
            "Expected resource count {$count} but received {$actual}."
        );
    }

    /**
     * Assert that the response data has the given attribute.
     *
     * @param $data
     */
    public function assertResponseHasData($data)
    {
        PHPUnit::assertArrayHasKey($data, $this->arrayData, "Response data has not any attribute $data");
    }

    /**
     * Assert that the response has the given view.
     *
     * @param $view
     */
    public function assertResponseIsView($view)
    {
        $actual = $this->view->getName();
        PHPUnit::assertTrue(
            $actual === $view,
            "Expected view {$view} but received {$actual}."
        );
    }
}