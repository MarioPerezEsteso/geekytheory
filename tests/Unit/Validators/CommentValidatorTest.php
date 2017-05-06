<?php


use App\Validators\CommentValidator;

class CommentValidatorTest extends TestCase
{
    /**
     * Test create with valid data.
     *
     * @dataProvider getValidCreateData
     * @param array $data
     */
    public function testCreateSuccess($data)
    {
        $validator = new CommentValidator(App::make('validator'));
        $this->assertTrue($validator->with($data)->passes());
    }

    /**
     * Test invalid data.
     * @dataProvider getInvalidCreateData
     * @param array $data
     */
    public function testCreateFailure($data, $validationErrorKeys)
    {
        $validator = new CommentValidator(App::make('validator'));
        $this->assertFalse($validator->with($data)->passes());
        $this->assertEquals(count($validationErrorKeys), count($validator->errors()));
        $this->assertInstanceOf('Illuminate\Support\MessageBag', $validator->errors());
        foreach ($validationErrorKeys as $validationErrorKey) {
            $this->assertArrayHasKey($validationErrorKey, $validator->errors()->toArray());
        }
    }

    /**
     * Returns an array with an example of valid data.
     */
    public static function getValidCreateData()
    {
        return [
            [
                [
                    'post_id' => 1,
                    'author_name' => 'John Doe',
                    'author_email' => 'mario@domain.com',
                    'author_url' => 'http://geekytheory.com',
                    'body' => 'This is the comment body!',
                    'approved' => true,
                    'spam' => false,
                ]
            ],
            [
                [
                    'post_id' => 1,
                    'author_name' => 'Alice McDonalds',
                    'author_email' => 'alice@mc.com',
                    'body' => 'This is the comment body!',
                    'approved' => true,
                    'spam' => false,
                ],
            ],
            [
                [
                    'post_id' => 1,
                    'author_name' => 'Alice McDonalds',
                    'author_email' => 'alice@mc.com',
                    'author_url' => '',
                    'body' => 'This is the comment body!',
                    'approved' => true,
                    'spam' => false,
                ]
            ],
        ];
    }

    /**
     * Returns an array with an example of invalid data.
     */
    public static function getInvalidCreateData()
    {
        return [
            [
                [
                    'author_name' => 'John Doe',
                    'author_email' => 'mario@domain.com',
                    'author_url' => 'http://geekytheory.com',
                    'approved' => true,
                    'spam' => false,
                ],
                'validationErrorKeys' => ['post_id', 'body'],
            ],
            [
                [
                    'post_id' => 1,
                    'author_name' => 'Alice McDonalds',
                    'body' => 'This is the comment body!',
                    'approved' => true,
                    'spam' => false,
                ],
                'validationErrorKeys' => ['author_email'],
            ],
            [
                [
                    'post_id' => 1,
                    'author_name' => 'Alice McDonalds',
                    'author_email' => 'alice@mc.com',
                    'author_url' => 'invalid url',
                    'body' => 'This is the comment body!',
                    'approved' => true,
                    'spam' => false,
                ],
                'validationErrorKeys' => ['author_url'],
            ],
            [
                [
                    'post_id' => 1,
                    'author_name' => 'Alice McDonalds',
                    'author_email' => 'alice@mc.com',
                    'author_url' => 'http://geekytheory.com',
                    'body' => 'This is the comment body!',
                    'approved' => 'yes',
                    'spam' => 'no',
                ],
                'validationErrorKeys' => ['approved', 'spam'],
            ]
        ];
    }
}