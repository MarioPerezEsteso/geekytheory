<?php

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

    public function setUp()
    {
        parent::setUp();
        $this->user = (new \App\Repositories\UserRepository())->find(1);
        $this->galleryRepository = new GalleryRepository();
    }

    /**
     * Test create a new gallery.
     */
    public function testStoreGallery()
    {
        $data = array(
            'title' => 'New gallery title',
        );

        Auth::login($this->user, true);

        $galleriesBefore = count($this->galleryRepository->all());

        $this->actingAs($this->user)->call('POST', 'home/gallery/store', $data);

        /*
         * There are five galleries in the database so this would be the sixth.
         */
        $this->assertRedirectedTo('home/gallery/edit/6');

        $galleries = $this->galleryRepository->all();
        $this->assertEquals($galleriesBefore + 1, count($galleries));
    }
}