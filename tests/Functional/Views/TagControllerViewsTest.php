<?php

namespace Tests\Functional\Views;

use App\Article;
use App\Tag;
use Tests\Helpers\TestUtils;
use Tests\TestCase;

class TagControllerViewsTest extends TestCase
{
    /**
     * @var string
     */
    protected $articlesByTagPageUrl = 'tag/{slug}';

    /**
     * Test show list of articles by tag ok.
     */
    public function testVisitShowArticlesByTagPageOk()
    {
        // Prepare
        $tagOne = factory(Tag::class)->create([
            'slug' => 'whatever-slug',
        ]);

        $tagTwo = factory(Tag::class)->create([
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

        $articleOne->tags()->sync($tagOne);
        $articleTwo->tags()->sync($tagOne);
        $articleThree->tags()->sync($tagTwo);

        // Request
        $response = $this->call('GET', TestUtils::createEndpoint($this->articlesByTagPageUrl, ['slug' => $tagOne->slug]));

        $response->assertStatus(200);
        $response->assertViewIs('web.blog.postlist.index');

        $response->assertResponseHasData('articles');
        $response->assertResponseDataCollectionHasNumberOfItems('articles', 1);
        $response->assertResponseDataCollectionItemHasValues('articles', 0, $articleOne->attributesToArray());
        $response->assertResponseDataHasRelationLoaded('articles', 'user', 1);
        $response->assertResponseDataHasRelationLoaded('articles', 'categories', 0);
    }

    /**
     * Test show list of articles by non-existent tag throws 404 error.
     */
    public function testVisitShowArticlesByTagPageNotFound()
    {
        // Request
        $response = $this->call('GET', TestUtils::createEndpoint($this->articlesByTagPageUrl, ['slug' => 'invented-slug']));

        $response->assertStatus(404);
    }
}
