<?php

namespace App\Http\Controllers\Api;

use App\Course;
use App\Exceptions\ExceptionFactory;
use App\Transformers\CourseTransformer;

class CourseController extends BaseApiController
{
    /**
     * Show courses.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return Course::getPublished()->get();
    }

    /**
     * Show single course.
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function show($id)
    {
        $course = Course::getPublishedById($id)->first();

        if (!$course) {
            throw ExceptionFactory::createModelNotFoundException();
        }

        return $course;
    }
}
