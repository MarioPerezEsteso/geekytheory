<?php

use App\Validators\GalleryValidator;
use Illuminate\Support\Facades\App;

class GalleryValidatorTest extends TestCase
{
    /**
     * Test valid data.
     */
    public function testValidatorPasses()
    {
        $validator = new \App\Validators\GalleryValidator(App::make('validator'));
        $this->assertTrue($validator->with($this->getValidCreateData())->passes());
    }

    /**
     * Test invalid data.
     */
    public function testValidatorDoesNotPass()
    {
        $validator = new \App\Validators\GalleryValidator(App::make('validator'));
        $this->assertFalse($validator->with($this->getInvalidCreateData())->passes());
    }

    /**
     * Returns an array with an example of valid data.
     *
     * @return array
     */
    private function getValidCreateData()
    {
        return ['title' => 'Gallery title'];
    }

    /**
     * Returns an array with an example of invalid data.
     *
     * @return array
     */
    private function getInvalidCreateData()
    {
        return ['title' => ''];
    }
}