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
     * Assert that the response has the given resource type and the given JSON structure.
     *
     * @param string $resourceType
     * @param array $resourceStructure
     */
    public function assertApiResponseResourceStructureIs($resourceType, $resourceStructure)
    {
        $firstElement = $this->getFirstDataElement();
        $actual = $firstElement['type'];
        PHPUnit::assertTrue(
            $actual === $resourceType,
            "Expected resource type {$resourceType} but received {$actual}."
        );

        $attributes = $firstElement['attributes'];
        $this->assertJsonStructure($resourceStructure, $attributes);
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

    private function calculateFirstDataElementJsonPath()
    {
        $arrResponse = json_decode($this->api->grabResponse());
        $data = $arrResponse->data;
        if (is_array($data) && count($data) > 0) {
            // data is a array of elements
            $jsonPath = '$.data[0]';
        } else if (is_object($data)) {
            // data is an object
            $jsonPath = '$.data';
        }
        return $jsonPath;
    }

    private function assertEqualsDataFromResponseByJsonPath($expectedValue, $jsonPath)
    {
        $valueToMatch = $this->api->grabDataFromResponseByJsonPath($jsonPath)[0];
        $this->assertEquals($expectedValue, $valueToMatch, "Equal condition doesn't match (JSONPath: $jsonPath)");
    }


}