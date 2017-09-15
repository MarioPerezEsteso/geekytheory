<?php

namespace Tests\Helpers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Support\Facades\Auth;
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
     *
     * @param $response
     */
    public function __construct($response)
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
     * @param string $objects
     * @param string $relation
     * @param int $relationsLoaded
     */
    public function assertResponseDataHasRelationLoaded($objects, $relation, $relationsLoaded = 1)
    {
        $objectsExploded = explode('.', $objects);
        /** @var Model $object */
        $object = $this->viewData[$objectsExploded[0]];
        for ($index = 1; $index < count($objectsExploded); $index++) {
            $object = $object->getRelationValue($objectsExploded[$index]);
        }

        if ($object instanceof Collection) {
            foreach ($object as $item) {
                $this->assertRelationsLoaded($item, $relation, $relationsLoaded);
            }
        } else {
            $this->assertRelationsLoaded($object, $relation, $relationsLoaded);
        }
    }

    /**
     * Assert relations of an item.
     *
     * @param Model $item
     * @param string $relation
     * @param integer $relationsLoaded
     */
    private function assertRelationsLoaded($item, $relation, $relationsLoaded)
    {
        PHPUnit::assertTrue(
            $item->relationLoaded($relation),
            "Relation {$relation} has not been loaded"
        );
        $actualCountRelationsLoaded = count($item->getRelationValue($relation));
        PHPUnit::assertEquals(
            $relationsLoaded,
            $actualCountRelationsLoaded,
            "Expected {$relationsLoaded} {$relation} but got {$actualCountRelationsLoaded}"
        );
    }

    /**
     * Assert that response data model values are the expected ones.
     *
     * @param string item
     * @param array $values
     */
    public function assertResponseDataModelHasValues($item, $values)
    {
        $itemsExploded = explode('.', $item);

        /** @var Model $item*/
        $item = $this->viewData[$itemsExploded[0]];

        for ($index = 1; $index < count($itemsExploded); $index++) {
            $item = $item->getRelationValue($itemsExploded[$index]);
        }

        $actual = $item->attributesToArray();

        PHPUnit::assertEquals($values, $actual);
    }

    /**
     * Assert that response data item has value.
     *
     * @param $item
     * @param $value
     */
    public function assertResponseDataItemHasValue($item, $value)
    {
        $actual = $this->viewData[$item];

        PHPUnit::assertEquals($value, $actual);
    }

    /**
     * Assert that logged user is the expected one.
     *
     * @param $user
     */
    public function assertLoggedUserIs($user)
    {
        $actual = Auth::user();

        if (!$user) {
            PHPUnit::assertEquals(null, $actual);
        } else {
            PHPUnit::assertEquals($user->id, $actual->id);
        }
    }
}