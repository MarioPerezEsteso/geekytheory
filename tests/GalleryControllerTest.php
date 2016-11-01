<?php

use App\Gallery;
use App\Image;
use App\Repositories\ImageRepository;
use App\User;
use \App\Repositories\GalleryRepository;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class GalleryControllerTest extends TestCase
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
     * Test the creation of a new gallery.
     */
    public function testStoreGallery()
    {
        $data = [
            'title' => 'New gallery title',
        ];

        $uploadedFiles = [
            $this->createNewTestImage('image1.png'),
            $this->createNewTestImage('image2.png'),
            $this->createNewTestImage('image3.png'),
        ];

        Auth::login($this->user, true);

        $galleriesBefore = count($this->galleryRepository->all());

        $this->actingAs($this->user)->call('POST', 'home/gallery/store', $data, [], ['images' => $uploadedFiles]);

        /*
         * There are five galleries in the database so this would be the sixth.
         */
        $this->assertRedirectedTo('home/gallery/edit/6');

        $galleries = $this->galleryRepository->all();
        $this->assertEquals($galleriesBefore + 1, count($galleries));

        /** @var Gallery $gallery */
        $gallery = $this->galleryRepository->find(6);
        $galleryImages = $this->imageRepository->findImagesByGallery($gallery);
        $this->assertEquals(6, count($galleryImages));
        $galleryImagesOriginal = $this->imageRepository->findImagesByGallery($gallery, Image::SIZE_ORIGINAL);
        $this->assertEquals(3, count($galleryImagesOriginal));
        $galleryImagesThumbnail = $this->imageRepository->findImagesByGallery($gallery, Image::SIZE_THUMBNAIL);
        $this->assertEquals(3, count($galleryImagesThumbnail));
    }

    /**
     * Create a test file in order to pass it as parameter to create a new gallery of images.
     *
     * @param string $name
     * @return \Symfony\Component\HttpFoundation\File\UploadedFile
     */
    public function createNewTestImage($name = 'image.png')
    {
        $file = tempnam(sys_get_temp_dir(), 'upl'); // create file
        imagepng(imagecreatetruecolor(500, 500), $file); // create and write image/png to it
        $image = new \Symfony\Component\HttpFoundation\File\UploadedFile(
            $file,
            $name,
            'image/png',
            null,
            null,
            true
        );

        return $image;
    }
}