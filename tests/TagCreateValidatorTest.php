<?php

class TagCreateValidatorTest extends TestCase
{
    /**
     * Test valid data.
     */
    public function testCreateSuccess()
    {
        $validator = new \App\Validators\TagCreateValidator(App::make('validator'));
        $this->assertTrue($validator->with($this->getValidCreateData())->passes());
    }

    /**
     * Test invalid data.
     */
    public function testCreateFailure()
    {
        $validator = new \App\Validators\TagCreateValidator(App::make('validator'));
        $this->assertFalse($validator->with($this->getInvalidCreateData())->passes());
        $this->assertEquals(1, count($validator->errors()));
        $this->assertInstanceOf('Illuminate\Support\MessageBag', $validator->errors());
    }

    /**
     * Returns an array with an example of valid data.
     *
     * @return array
     */
    private function getValidCreateData()
    {
        return array(
            'tag'   => 'This is a random tag',
            'slug'  => 'this-is-a-random-slug',
        );
    }

    /**
     * Returns an array with an example of invalid data.
     *
     * @return array
     */
    private function getInvalidCreateData()
    {
        return array(
            'tag'   => 'This is a tag without slug',
        );
    }
}