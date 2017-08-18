<?php

namespace Tests\Helpers;

class TestUtils
{
    /**
     * Create endpoint with parameters.
     *
     * @param string $endpoint
     * @param array $params
     * @param array $includes
     * @return string
     */
    public static function createEndpoint($endpoint, $params = [], $includes = []): string
    {
        foreach ($params as $param => $value) {
            $endpoint = str_replace('{' . $param . '}', $value, $endpoint);
        }

        if (count($includes) > 0) {
            $endpoint .= '?include=' . implode(',', $includes);
        }

        return $endpoint;
    }
}
