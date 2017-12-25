<?php

namespace App\Validators;

use App\Validators\Base\LaravelValidator;
use App\Validators\Base\ValidableInterface;

class LessonValidator extends LaravelValidator implements ValidableInterface
{
    /**
     * Validation rules for creating a Lesson.
     */
    protected $rules = [];

    /**
     * Modify the rules for updating a Lesson.
     *
     * @param null $id
     * @return $this|ValidableInterface
     */
    public function update($id = null)
    {
        return $this;
    }

    /**
     * Modify the rules for completing a Lesson.
     *
     * @param null $id
     * @return $this|ValidableInterface
     */
    public function complete($id = null)
    {
        $this->rules = [
            'lesson_id' => 'required|integer|min:1',
        ];

        return $this;
    }
}