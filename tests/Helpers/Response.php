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
     * JSON response as array.
     *
     * @var array
     */
    private $arrayData = [];

    public function __construct(\Illuminate\Http\Response $response)
    {
        parent::__construct($response);
        $this->arrayData = $this->json();
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
    public function assertApiResponseResourceCountIs($count)
    {
        $actual = count($this->arrayData['data']);
        PHPUnit::assertTrue(
            $actual === $count,
            "Expected resource count {$count} but received {$actual}."
        );
    }

    /**
     * Assert that the response has the given resource type and the given JSON structure. If the array data is a
     * collection, the keys 'id', 'key' and 'attributes' will be in different elements. On the other hand, if the
     * array data is a single item, the keys 'id', 'key' and 'attributes' will be directly under the key 'data'.
     *
     * @param string $resourceType
     * @param array $resourceStructure
     */
    public function assertApiResponseResourceStructureIs($resourceType, $resourceStructure)
    {
        $item = isset($this->arrayData['data']['attributes']) ? $this->arrayData['data'] : $this->getFirstDataElement();

        $actual = $item['type'];

        PHPUnit::assertArrayHasKey('id', $item, 'Item must have key id');

        PHPUnit::assertTrue(
            $actual === $resourceType,
            "Expected resource type {$resourceType} but received {$actual}."
        );

        $attributes = $item['attributes'];
        $this->assertJsonStructure($resourceStructure, $attributes);
    }

    /**
     * Assert that the API has thrown an error with a given status and a given code.
     *
     * @param integer $status
     * @param integer $code
     */
    public function assertResponseIsErrorApiResponse($status, $code)
    {
        $actualStatus = $this->arrayData['status_code'];
        $actualCode = $this->arrayData['code'];

        PHPUnit::assertTrue(
            $actualStatus === $status,
            "Expected status {$status} but received {$actualStatus}."
        );

        PHPUnit::assertTrue(
            $actualCode === $code,
            "Expected error code {$code} but received {$actualCode}."
        );
    }

    /**
     * Get the first data element of the response.
     *
     * @return array|null
     */
    private function getFirstDataElement()
    {
        return $this->arrayData['data'][0] ?? null;
    }
}