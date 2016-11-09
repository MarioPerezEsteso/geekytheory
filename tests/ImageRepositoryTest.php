<?php

use App\Image;
use App\Repositories\ImageRepository;

class ImageRepositoryTest extends TestCase
{
    /**
     * @var ImageRepository
     */
    protected $imageRepository;

    public function setUp()
    {
        parent::setUp();
        $this->imageRepository = new ImageRepository();
    }

    /**
     * Test findImageAllSizes
     */
    public function testFindImageAllSizes()
    {
        $images = $this->imageRepository->findImageAllSizes(1);
        $this->assertEquals(count(Image::SIZES_GALLERY), count($images));
        $this->assertEquals($images[0]->id, $images[1]->parent);
    }
}