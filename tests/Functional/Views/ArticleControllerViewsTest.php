<?php

namespace Tests\Functional\Views;

use App\Post;
use App\User;
use Tests\Helpers\TestUtils;
use Tests\TestCase;

class ArticleControllerViewsTest extends TestCase
{
    /**
     * Test that any user can visit the blog page.
     */
    public function testVisitBlogPageOk()
    {
        $response = $this->call('GET', 'blog');

        $response->assertStatus(200);

        $response->assertStatus(200);
        $response->assertViewIs('web.blog.postlist.index');

        $response->assertResponseHasData('articles');
        $response->assertResponseDataCollectionHasNumberOfItems('articles', 10);
        $response->assertResponseDataHasRelationLoaded('articles', 'user', 1);
        $response->assertResponseDataHasRelationLoaded('articles', 'categories', 0);
    }

    /**
     * Test administrator user can visit some article pages.
     *
     * @dataProvider providerArticleGETPages
     * @param string $page
     */
    public function testUserAdministratorCanVisitPages(string $page)
    {
        // Prepare
        /** @var User $user */
        $user = factory(User::class)->create(['is_admin' => true]);
        $article = factory(Post::class)->create([
            'status' => 'draft',
        ]);

        $page = TestUtils::createEndpoint($page, ['id' => $article->id, 'slug' => $article->slug,]);

        // Request
        $response = $this->actingAs($user)->call('GET', $page);

        // Asserts
        $response->assertStatus(200);
    }

    /**
     * Test non administrator user can't visit some article pages.
     *
     * @dataProvider providerArticleGETPages
     * @param string $page
     */
    public function testUserNonAdministratorCannotVisitPages(string $page)
    {
        // Prepare
        /** @var User $user */
        $user = factory(User::class)->create(['is_admin' => false,]);
        $article = factory(Post::class)->create([
            'status' => 'draft',
        ]);

        $page = TestUtils::createEndpoint($page, ['id' => $article->id, 'slug' => $article->slug,]);

        // Request
        $response = $this->actingAs($user)->call('GET', $page);

        // Asserts
        $response->assertStatus(404);
    }

    /**
     * Test non administrator user can't visit some article pages.
     *
     * @dataProvider providerArticleGETPages
     * @param string $page
     */
    public function testNonLoggedUserCannotVisitArticleCreatePage(string $page)
    {
        // Prepare
        $article = factory(Post::class)->create([
            'status' => 'draft',
        ]);

        $page = TestUtils::createEndpoint($page, ['id' => $article->id, 'slug' => $article->slug,]);

        // Request
        $response = $this->call('GET', $page);

        // Asserts
        $response->assertRedirect($this->loginUrl);
    }

    public function providerArticleGETPages(): array
    {
        return [
            [
                'home/articles'
            ], [
                'home/articles/create',
            ], [
                'home/articles/edit/{id}'
            ], [
                'home/articles/preview/{slug}'
            ], [
                'home/posts/delete/{id}',
            ], [
                'home/posts/restore/{id}',
            ], [
                'home/articles/imagemanager/upload',
            ], [
                'home/articles/edit/imagemanager/upload'
            ],
        ];
    }
}
