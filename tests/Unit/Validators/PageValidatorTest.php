<?php

namespace Tests\Unit\Validators;

use \App\Validators\PageValidator;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class PageValidatorTest extends TestCase
{
    /**
     * Test valid data.
     */
    public function testCreateSuccess()
    {
        $validator = new PageValidator(App::make('validator'));
        $this->assertTrue($validator->with($this->getValidCreateData())->passes());
    }

    /**
     * Test invalid data.
     */
    public function testCreateFailure()
    {
        $validator = new PageValidator(App::make('validator'));
        $this->assertFalse($validator->with($this->getInvalidCreateData())->passes());
        $this->assertEquals(2, count($validator->errors()));
        $this->assertInstanceOf('Illuminate\Support\MessageBag', $validator->errors());
    }

    /**
     * Returns an array with an example of valid data.
     */
    private function getValidCreateData()
    {
        return array(
            'title' => 'Just a title',
            'body' => 'This is the body',
            'status' => 'draft',
            'description' => 'This could be the description of the page',
            'slug' => 'just-a-title',
            'type' => 'page',
        );
    }

    /**
     * Returns an array with an example of invalid data.
     * Description is missing and type is not 'page'.
     */
    private function getInvalidCreateData()
    {
        return array(
            'title' => 'Just a title',
            'body' => 'This is the body',
            'status' => 'draft',
            'slug' => 'just-a-title',
            'type' => 'article',
        );
    }
}