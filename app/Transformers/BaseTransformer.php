<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class BaseTransformer extends TransformerAbstract
{
    /**
     * Transform array keys to camel case.
     *
     * @param $data
     * @return array
     */
    public static function arrayToCamelCase($data)
    {
        $dataCamelCase = [];
        foreach ($data as $key => $value)
        {
            $dataCamelCase[camel_case($key)] = $value;
        }

        return $dataCamelCase;
    }
}