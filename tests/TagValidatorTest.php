<?php

class TagValidatorTest extends TestCase
{
    /**
     * Test valid data creation.
     */
    public function testCreateSuccess()
    {
        $validator = new \App\Validators\TagValidator(App::make('validator'));
        $this->assertTrue($validator->with($this->getValidCreateData())->passes());
    }

    /**
     * Test invalid data creation.
     */
    public function testCreateFailure()
    {
        $validator = new \App\Validators\TagValidator(App::make('validator'));
        $this->assertFalse($validator->with($this->getInvalidCreateData())->passes());
        $this->assertEquals(1, count($validator->errors()));
        $this->assertInstanceOf('Illuminate\Support\MessageBag', $validator->errors());
    }

    /**
     * Test valid data update.
     */
    public function testUpdateSuccess()
    {
        $validator = new \App\Validators\TagValidator(App::make('validator'));
        $this->assertTrue($validator->update(1)->with($this->getValidCreateData())->passes());
    }

    public function testUpdateFailure()
    {
        $validator = new \App\Validators\TagValidator(App::make('validator'));
        $this->assertFalse($validator->update(2)->with($this->getExistentData())->passes());
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

    /**
     * Returns an array with data that already
     * exists in the database.
     *
     * @return array
     */
    private function getExistentData()
    {
        return array(
            'tag'   => 'This is a tag',
            'slug'  => 'this-is-a-tag',
        );
    }
}