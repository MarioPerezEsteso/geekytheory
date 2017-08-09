<?php

namespace App\Transformers;

use App\Course;

class CourseTransformer extends BaseTransformer
{
    public function transform(Course $course)
    {
        $data = $course->toArray();
        $data = self::arrayToCamelCase($data);

        return $data;
    }
}