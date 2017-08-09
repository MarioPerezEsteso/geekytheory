<?php

namespace App\Http\Controllers\Api;

use App\Course;
use App\Transformers\CourseTransformer;

class CourseController extends BaseApiController
{
    /**
     * Show courses.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index()
    {
        return Course::getPublished()->get();
    }
}
