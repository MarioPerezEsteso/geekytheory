<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Foundation\Testing\WithoutMiddleware;

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

        $articleRepository = new \App\Repositories\ArticleRepository();
        $article = $articleRepository->find($id);
        $this->assertEquals(ArticleController::POST_STATUS_DELETED, $article->status);
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

}