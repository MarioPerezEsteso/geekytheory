<?php

namespace Tests\Unit\Validators;

use App\Validators\LessonValidator;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class LessonValidatorTest extends TestCase
{
    /**
     * Test create with valid data.
     */
    public function testCompleteSuccess()
    {
        $validator = new LessonValidator(App::make('validator'));
        $this->assertTrue($validator->with(['lesson_id' => 1,])->complete()->passes());
    }

    /**
     * Test invalid data.
     * @dataProvider getInvalidCompleteData
     * @param array $data
     */
    public function testCompleteFailure($data, $validationErrorKeys)
    {
        $validator = new LessonValidator(App::make('validator'));
        $this->assertFalse($validator->with($data)->complete()->passes());
        $this->assertEquals(count($validationErrorKeys), count($validator->errors()));
        $this->assertInstanceOf('Illuminate\Support\MessageBag', $validator->errors());
        foreach ($validationErrorKeys as $validationErrorKey) {
            $this->assertArrayHasKey($validationErrorKey, $validator->errors()->toArray());
        }
    }

    /**
     * Returns an array with an example of invalid data.
     */
    public static function getInvalidCompleteData()
    {
        return [
            [
                [
                    'lesson_id' => 'lesson-1',
                ],
                'validationErrorKeys' => ['lesson_id',],
            ], [
                [
                    'lesson_id' => 0,
                ],
                'validationErrorKeys' => ['lesson_id'],
            ], [
                [
                    'lesson_id' => -1,
                ],
                'validationErrorKeys' => ['lesson_id'],
            ], [
                [
                ],
                'validationErrorKeys' => ['lesson_id'],
            ],
        ];
    }
}