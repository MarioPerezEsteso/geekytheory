<?php


use App\Validators\CommentValidator;

class CommentValidatorTest extends TestCase
{
    /**
     * Test valid data.
     */
    public function testCreateSuccess()
    {
        $validator = new CommentValidator(App::make('validator'));
        $this->assertTrue($validator->with($this->getValidCreateData())->passes());
    }

    /**
     * Test invalid data.
     */
    public function testCreateFailure()
    {
        $validator = new CommentValidator(App::make('validator'));
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
            'post_id' => 1,
            'author_name' => 'John Doe',
            'author_email' => 'mario@domain.com',
            'author_url' => 'http://geekytheory.com',
            'body' => 'This is the comment body!',
            'approved' => true,
            'spam' => false,
        );
    }

    /**
     * Returns an array with an example of invalid data.
     * Author email ans comment body are missing.
     */
    private function getInvalidCreateData()
    {
        return array(
            'post_id' => 1,
            'author_name' => 'John Doe',
            'author_url' => 'http://geekytheory.com',
            'approved' => true,
            'spam' => false,
        );
    }
}