<?php

namespace Tests\Helpers;

use Illuminate\Database\Eloquent\Model;
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
    private $viewData = [];

    /**
     * Response constructor.
     * @param \Illuminate\Http\Response $response
     */
    public function __construct(\Illuminate\Http\Response $response)
    {
        parent::__construct($response);
        $this->view = $response->getOriginalContent();
        if ($this->view instanceof View) {
            $this->viewData = $this->view->getData();
        }
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
        $actual = count($this->viewData['data']);
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
        PHPUnit::assertArrayHasKey($data, $this->viewData, "Response data has not any attribute $data");
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

    /**
     * Assert that a response data object has a relation.
     *
     * @param string $object
     * @param string $relation
     * @param int $relationsLoaded
     */
    public function assertResponseDataHasRelationLoaded($object, $relation, $relationsLoaded = 1)
    {
        /** @var Model $object */
        $object = $this->viewData[$object];

        PHPUnit::assertTrue(
            $object->relationLoaded($relation),
            "Relation {$relation} has not been loaded in {$object}"
        );
        $actualCountRelationsLoaded = count($object->getRelationValue($relation));
        PHPUnit::assertEquals(
            $relationsLoaded,
            $actualCountRelationsLoaded,
            "Expected {$relationsLoaded} {$relation} in {$object} but got {$actualCountRelationsLoaded}"
        );
    }
}