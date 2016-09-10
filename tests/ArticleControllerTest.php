<?php

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
        $this->assertEquals(\App\Http\Controllers\ArticleController::POST_STATUS_DELETED, $article->status);
    }
}