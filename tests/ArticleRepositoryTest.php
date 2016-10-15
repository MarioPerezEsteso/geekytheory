<?php

use \App\Repositories\ArticleRepository;

class ArticleRepositoryTest extends TestCase
{
    /**
     * Test method findArticlesBySearch finding one post.
     */
    public function testFindArticlesBySearchFindOne()
    {
        $articleRepository = new ArticleRepository();
        $articles = $articleRepository->findArticlesBySearch(true, 10, 'arduino');
        $this->assertNotNull($articles);
        $this->assertEquals(1, count($articles));
        $articles = $articles->getCollection()->first();
        $this->assertEquals('Tutorial Arduino', $articles->title);
        $this->assertEquals('Arduino tutorial in this blog', $articles->body);
    }

    /**
     * Test method findArticlesBySearch finding two posts.
     */
    public function testFindArticlesBySearchFindTwo()
    {
        $articleRepository = new ArticleRepository();
        $articles = $articleRepository->findArticlesBySearch(true, 10, 'tutorial');
        $articles = $articles->getCollection()->all();
        $this->assertNotNull($articles);
        $this->assertEquals(2, count($articles));
        $this->assertEquals('Tutorial Arduino', $articles[0]->title);
        $this->assertEquals('Tutorial Android', $articles[1]->title);
        $this->assertEquals('Arduino tutorial in this blog', $articles[0]->body);
        $this->assertEquals('Android tutorial in this blog', $articles[1]->body);
    }

    /**
     * Test method findArticlesBySearch finding zero posts.
     */
    public function testFindArticlesBySearchFindNone()
    {
        $articleRepository = new ArticleRepository();
        $articles = $articleRepository->findArticlesBySearch(true, 10, 'asfgasfgasgasfgasfg');
        $articles = $articles->getCollection()->all();
        $this->assertNotNull($articles);
        $this->assertEquals(0, count($articles));
    }
}
