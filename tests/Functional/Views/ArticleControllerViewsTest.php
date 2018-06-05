<?php

namespace Tests\Functional\Views;

use App\Article;
use App\Post;
use App\User;
use Tests\Helpers\TestUtils;
use Tests\TestCase;

class ArticleControllerViewsTest extends TestCase
{
    /**
     * @var string
     */
    protected $blogPageUrl = 'blog';

    /**
     * @var string
     */
    protected $articlesByUserPageUrl = 'user/{username}';

    /**
     * Test that any user can visit the blog page.
     */
    public function testVisitBlogPageOk()
    {
        // Request
        $response = $this->call('GET', $this->blogPageUrl);

        // Asserts
        $response->assertStatus(200);
        $response->assertViewIs('web.blog.postlist.index');

        $response->assertResponseHasData('articles');
        $response->assertResponseDataCollectionHasNumberOfItems('articles', 10);
        $response->assertResponseDataHasRelationLoaded('articles', 'user', 1);
        $response->assertResponseDataHasRelationLoaded('articles', 'categories', 0);
    }

    /**
     * Test show list of articles by user ok.
     */
    public function testVisitShowArticlesByUserPageOk()
    {
        // Prepare
        $userOne = factory(User::class)->create();

        $userTwo = factory(User::class)->create();

        $articleOne = factory(Article::class)->create([
            'user_id' => $userOne->id,
            'status' => 'published',
        ]);

        $articleTwo = factory(Article::class)->create([
            'user_id' => $userOne->id,
            'status' => 'published',
        ]);

        factory(Article::class)->create([
            'user_id' => $userOne->id,
            'status' => 'draft',
        ]);

        factory(Article::class)->create([
            'user_id' => $userTwo->id,
            'status' => 'published',
        ]);

        // Request
        $response = $this->call('GET', TestUtils::createEndpoint($this->articlesByUserPageUrl, ['username' => $userOne->username]));

        $response->assertStatus(200);
        $response->assertViewIs('web.blog.postlist.index');

        $response->assertResponseHasData('articles');
        $response->assertResponseDataCollectionHasNumberOfItems('articles', 2);
        $response->assertResponseDataCollectionItemHasValues('articles', 0, $articleOne->attributesToArray());
        $response->assertResponseDataCollectionItemHasValues('articles', 1, $articleTwo->attributesToArray());
        $response->assertResponseDataHasRelationLoaded('articles', 'user', 1);
        $response->assertResponseDataHasRelationLoaded('articles', 'categories', 0);
    }

    /**
     * Test show list of articles by non-existent username throws 404 error.
     */
    public function testVisitShowArticlesByUsernamePageNotFound()
    {
        // Request
        $response = $this->call('GET', TestUtils::createEndpoint($this->articlesByUserPageUrl, ['username' => 'doesnotexist']));

        $response->assertStatus(404);
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
