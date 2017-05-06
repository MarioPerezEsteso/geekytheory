<?php

use App\Gallery;
use App\Image;
use App\Repositories\ImageRepository;
use App\User;
use \App\Repositories\GalleryRepository;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ImageControllerTest extends TestCase
{
    use WithoutMiddleware;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var GalleryRepository
     */
    protected $galleryRepository;

    /**
     * @var ImageRepository
     */
    protected $imageRepository;

    public function setUp()
    {
        parent::setUp();
        $this->user = (new \App\Repositories\UserRepository())->find(1);
        $this->galleryRepository = new GalleryRepository();
        $this->imageRepository = new ImageRepository();
    }

    /**
     * Test delete image from a gallery.
     */
    public function testDeleteImageFromGallery()
    {
        $data = [
            'imageId' => 1,
        ];

        Auth::login($this->user, true);

        $gallery = $this->galleryRepository->find(1);
        $imagesBefore = count($this->imageRepository->findImagesByGallery($gallery));

        $response = $this->actingAs($this->user)->call('POST', 'home/gallery/image/delete', $data);

        $response->assertStatus(200);

        $this->assertEquals($response->decodeResponseJson()['error'], 0);

        $images = $this->imageRepository->findImagesByGallery($gallery);
        $this->assertEquals($imagesBefore - count(Image::$SIZES_GALLERY), count($images));
    }
}
