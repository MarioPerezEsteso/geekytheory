<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\Post;
use App\Article;

class ArticleControllerTest extends TestCase
{
    use WithoutMiddleware;

    /**
     * Test delete success.
     */
    public function testDeleteSuccess()
    {
		$id = 1;
		$this->call("GET", "home/posts/delete/$id");
		
		$this->seeInDatabase('posts', [
			'id' => $id,
			'status' => Post::STATUS_DELETED,
		]);
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
		$postId = 1;
		$data = [
			'postId' => $postId,
			'socialNetwork' => 'whatsapp',
		];
		$this->call('POST', 'share-article', $data);

		$this->assertResponseOk();

		$this->seeInDatabase('posts', [
			'id' => $postId,
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
