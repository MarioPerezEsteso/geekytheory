<?php

namespace Tests\Helpers;

class TestUtils
{
    /**
     * Create endpoint with parameters.
     *
     * @param string $endpoint
     * @param array $params
     *
     * @return string
     */
    public static function createEndpoint($endpoint, $params = []): string
    {
        foreach ($params as $param => $value) {
            $endpoint = str_replace('{' . $param . '}', $value, $endpoint);
        }

        return $endpoint;
    }
}
