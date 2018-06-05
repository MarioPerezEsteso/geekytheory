<?php

namespace Tests\Functional\Views;

use App\Article;
use App\Category;
use Tests\Helpers\TestUtils;
use Tests\TestCase;

class CategoryControllerViewsTest extends TestCase
{
    /**
     * @var string
     */
    protected $articlesByCategoryPageUrl = 'category/{slug}';

    /**
     * Test show list of articles by category ok.
     */
    public function testVisitShowArticlesByCategoryPageOk()
    {
        // Prepare
        $categoryOne = factory(Category::class)->create([
            'slug' => 'whatever-slug',
        ]);

        $categoryTwo = factory(Category::class)->create([
            'slug' => 'whatever-slug-different-to-the-first-one',
        ]);

        $articleOne = factory(Article::class)->create([
            'status' => 'published',
        ]);

        $articleTwo = factory(Article::class)->create([
            'status' => 'draft',
        ]);

        $articleThree = factory(Article::class)->create([
            'status' => 'published',
        ]);

        $articleOne->categories()->sync($categoryOne);
        $articleTwo->categories()->sync($categoryOne);
        $articleThree->categories()->sync($categoryTwo);

        // Request
        $response = $this->call('GET', TestUtils::createEndpoint($this->articlesByCategoryPageUrl, ['slug' => $categoryOne->slug]));

        $response->assertStatus(200);
        $response->assertViewIs('web.blog.postlist.index');

        $response->assertResponseHasData('articles');
        $response->assertResponseDataCollectionHasNumberOfItems('articles', 1);
        $response->assertResponseDataCollectionItemHasValues('articles', 0, $articleOne->attributesToArray());
        $response->assertResponseDataHasRelationLoaded('articles', 'user', 1);
        $response->assertResponseDataHasRelationLoaded('articles', 'categories', 1);
    }

    /**
     * Test show list of articles by non-existen category throws 404 error.
     */
    public function testVisitShowArticlesByCategoryPageNotFound()
    {
        // Request
        $response = $this->call('GET', TestUtils::createEndpoint($this->articlesByCategoryPageUrl, ['slug' => 'invented-slug']));

        $response->assertStatus(404);
    }
}
