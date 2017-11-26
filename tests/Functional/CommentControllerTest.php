<?php

namespace Tests\Functional;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    use WithoutMiddleware;

    /**
     * Test store comments
     *
     * @dataProvider getCommentsToStore
     * @param array $data
     */
    public function testStoreCommentOk($data)
    {
        $response = $this->call('POST', 'comment/store', $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('comments', [
            'post_id' => $data['postId'],
            'author_name' => $data['authorName'],
            'author_email' => $data['authorEmail'],
            'author_url' => $data['authorUrl'],
            'body' => $data['body'],
        ]);
    }

    /**
     * Get the valid comments to be stored
     *
     * @return array
     */
    public static function getCommentsToStore()
    {
        return [
            [
                [
                    'postId' => 1,
                    'authorName' => 'Mario',
                    'authorEmail' => 'mario@domain.com',
                    'authorUrl' => 'http://geekytheory.com',
                    'body' => 'This is the content of the comment',
                ],
            ],
            [
                [
                    'postId' => 1,
                    'authorName' => 'Mario',
                    'authorEmail' => 'mario@domain.com',
                    'authorUrl' => '',
                    'body' => 'This is the content of the second test',
                ],
            ],
            [
                [
                    'postId' => 1,
                    'authorName' => 'Alice',
                    'authorEmail' => 'alice.3@domain.com',
                    'authorUrl' => '',
                    'body' => 'This is the third test',
                ],
            ],
        ];
    }
}
