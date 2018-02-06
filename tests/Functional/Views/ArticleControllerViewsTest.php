<?php

namespace Tests\Functional\Views;

use App\User;
use Tests\TestCase;

class ArticleControllerViewsTest extends TestCase
{
    /**
     * URL of the page to create articles.
     *
     * @var string
     */
    private $articleCreatePageUrl = 'home/articles/create';

    /**
     * Test administrator user can visit the article create page.
     */
    public function testUserAdministratorCanVisitArticleCreatePage()
    {
        // Prepare
        /** @var User $user */
        $user = factory(User::class)->create();

        // Request
        $response = $this->actingAs($user)->call('GET', $this->articleCreatePageUrl);

        // Asserts
        $response->assertStatus(200);
        $response->assertResponseIsView('home.posts.article');
    }

    /**
     * Test non administrator user can't visit the article create page.
     */
    public function testUserNonAdministratorCannotVisitArticleCreatePage()
    {
        // Prepare
        /** @var User $user */
        $user = factory(User::class)->create(['is_admin' => false,]);

        // Request
        $response = $this->actingAs($user)->call('GET', $this->articleCreatePageUrl);

        // Asserts
        $response->assertStatus(404);
    }

    /**
     * Test non administrator user can't visit the article create page.
     */
    public function testNonLoggedUserCannotVisitArticleCreatePage()
    {
        // Request
        $response = $this->call('GET', $this->articleCreatePageUrl);

        // Asserts
        $response->assertStatus(404);
    }
}
