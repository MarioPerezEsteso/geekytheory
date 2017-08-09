<?php

namespace Tests;

use App\Image;
use App\Repositories\GalleryRepository;
use App\Repositories\ImageRepository;

class ImageRepositoryTest extends TestCase
{
    /**
     * @var ImageRepository
     */
    protected $imageRepository;

    /**
     * @var GalleryRepository
     */
    protected $galleryRepository;

    public function setUp()
    {
        parent::setUp();
        $this->imageRepository = new ImageRepository();
        $this->galleryRepository = new GalleryRepository();
    }

    /**
     * Test findImagesByGallery searching all of the images with different sizes.
     */
    public function testFindImagesByGalleryInAllSizes()
    {
        $gallery = $this->galleryRepository->find(1);
        $images = $this->imageRepository->findImagesByGallery($gallery);
        $this->assertEquals(10, count($images));
    }

    /**
     * Test findImagesByGallery searching all of the images with original size.
     */
    public function testFindImagesByGalleryWithOriginalSize()
    {
        $gallery = $this->galleryRepository->find(1);
        $images = $this->imageRepository->findImagesByGallery($gallery, Image::SIZE_ORIGINAL);
        $this->assertEquals(5, count($images));
    }

    /**
     * Test findImageAllSizes
     */
    public function testFindImageAllSizes()
    {
        $images = $this->imageRepository->findImageAllSizes(1);
        $this->assertEquals(count(Image::$SIZES_GALLERY), count($images));
        $this->assertEquals($images[0]->id, $images[1]->parent);
    }
}