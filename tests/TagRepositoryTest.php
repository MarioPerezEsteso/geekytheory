<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use \App\Repositories\TagRepository;

class TagRepositoryTest extends TestCase
{
    use WithoutMiddleware;

    /**
     * Test method findTagBySlug.
     */
    public function testFindTagBySlug()
    {
        $repository = new TagRepository();
        $tag = $repository->findTagBySlug('tag-1');
        $this->assertNotNull($tag);
        $this->assertInstanceOf(\App\Tag::class, $tag);
        $this->assertEquals('Tag 1', $tag->getAttribute('tag'));
        $this->assertEquals('tag-1', $tag->getAttribute('slug'));
    }

}
