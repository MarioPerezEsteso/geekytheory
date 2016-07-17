<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use \App\Repositories\CategoryRepository;

class CategoryRepositoryTest extends TestCase
{
    use WithoutMiddleware;

    /**
     * Test method findCategoryBySlug.
     */
    public function testFindCategoryBySlug()
    {
        $categoryRepository = new CategoryRepository();
        $category = $categoryRepository->findCategoryBySlug('category-1');
        $this->assertNotNull($category);
        $this->assertInstanceOf(\App\Category::class, $category);
        $this->assertEquals('Category 1', $category->getAttribute('category'));
        $this->assertEquals('category-1', $category->getAttribute('slug'));
    }

}
