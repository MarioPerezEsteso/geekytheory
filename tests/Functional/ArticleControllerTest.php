<?php

namespace Tests\Functional;

use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\Post;
use Tests\Helpers\TestUtils;
use Tests\TestCase;

class ArticleControllerTest extends TestCase
{
    /**
     * Test non administrator user can't visit the article create page.
     *
     * @dataProvider providerArticlePOSTPages
     * @param string $page
     */
    public function testUserNonAdministratorCannotMakePostRequest(string $page)
    {
        // Prepare
        /** @var User $user */
        $user = factory(User::class)->create(['is_admin' => false,]);
        $article = factory(Post::class)->create([
            'status' => 'draft',
        ]);

        $page = TestUtils::createEndpoint($page, ['id' => $article->id, 'slug' => $article->slug,]);

        // Request
        $response = $this->actingAs($user)->call('POST', $page);

        // Asserts
        $response->assertStatus(404);
    }

    /**
     * Test non administrator user can't visit the article create page.
     *
     * @dataProvider providerArticlePOSTPages
     * @param string $page
     */
    public function testNonLoggedUserCannotMakePostRequest(string $page)
    {
        // Prepare
        $article = factory(Post::class)->create([
            'status' => 'draft',
        ]);

        $page = TestUtils::createEndpoint($page, ['id' => $article->id, 'slug' => $article->slug,]);

        // Request
        $response = $this->call('POST', $page);

        // Asserts
        $response->assertRedirect($this->loginUrl);
    }

    public function providerArticlePOSTPages(): array
    {
        return [
            [
                'home/articles/update/{id}'
            ], [
                'home/articles/store',
            ], [
                'home/posts/delete-image',
            ], [
                'home/imagemanager/upload',
            ]
        ];
    }

    /**
     * Test delete success.
     */
    public function testDeleteSuccess()
    {
		$id = 1;
		$user = factory(User::class)->create([
		    'is_admin' => true,
        ]);

		// Request
		$response = $this->actingAs($user)->call("GET", "home/posts/delete/$id");

        $response->assertRedirect('home/articles');
    }

    /**
     * Test delete post that does not exist.
     *
     * @expectedExceptionCode 404
     */
    public function testDeleteException()
    {
        $id = 123456;
        $this->call("GET", "home/posts/delete/$id");
    }

	/**
	 * Test update share count of article success.
	 */
	public function testUpdateSharesSuccess()
	{
	    $post = factory(Post::class)->create();

		$data = [
			'postId' => $post->id,
			'socialNetwork' => 'whatsapp',
		];
		$response = $this->call('POST', 'share-article', $data);

		$response->assertStatus(200);

		$this->assertDatabaseHas('posts', [
			'id' => $post->id,
			'shares_whatsapp' => 1,
		]);
	}

	/**
	 * Test update share count of an article that does not exist.
	 *
	 * @expectedExceptionCode 404
	 */
	public function testUpdateSharesOfUndefinedPost()
	{
		$postId = 1322112;
		$data = [
			'postId' => $postId,
			'socialNetwork' => 'whatsapp',
		];
		$this->call('POST', 'share-article', $data);
	}

	/**
	 * Test update share count of an article with a social network that does not exist.
	 */
	public function testUpdateSharesOfUndefinedSocialNetwork()
	{
		$postId = 1;
		$data = [
			'postId' => $postId,
			'socialNetwork' => 'invented_social_network',
		];
		$result = $this->call('POST', 'share-article', $data);

		$this->assertEquals('1', $result->original['error']);
	}
}
