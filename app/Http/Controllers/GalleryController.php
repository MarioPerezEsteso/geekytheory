<?php

namespace App\Http\Controllers;

use App\Gallery;
use App\Image;
use App\Repositories\GalleryRepository;
use App\Repositories\ImageRepository;
use App\Repositories\UserRepository;
use App\User;
use App\Validators\GalleryValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;

class GalleryController extends Controller
{
    /**
     * @var GalleryRepository
     */
    protected $galleryRepository;

    /**
     * @var GalleryValidator
     */
    protected $galleryValidator;

    /**
     * @var  ImageRepository
     */
    protected $imageRepository;

    /**
     * GalleryController constructor.
     *
     * @param GalleryRepository $galleryRepository
     * @param GalleryValidator $galleryValidator
     * @param ImageRepository $imageRepository
     */
    public function __construct(GalleryRepository $galleryRepository, GalleryValidator $galleryValidator, ImageRepository $imageRepository)
    {
        $this->galleryRepository = $galleryRepository;
        $this->galleryValidator = $galleryValidator;
        $this->imageRepository = $imageRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param null $username
     * @return \Illuminate\Http\Response
     */
    public function indexHome($username = null)
    {
        if (!empty($username)) {
            /*  Get galleries of a concrete user */
            $author = (new UserRepository())->findUserByUsername($username);
            $galleries = $this->galleryRepository->findGalleries($author);
        } else {
            /* Get all galleries */
            $galleries = $this->galleryRepository->findGalleries();
        }
        return view('home.galleries.all', compact('galleries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('home.galleries.gallery');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [
            'user_id' => null,
            'title' => $request->title,
            'images' => $request->file('images'),
        ];

        /** @var User $user */
        $user = Auth::user();
        if ($user !== null) {
            $data['user_id'] = $user->getAttribute('id');
        }

        if (!$this->galleryValidator->with($data)->passes()) {
            return Redirect::to('home/gallery/create')->withErrors($this->galleryValidator->errors());
        } else {
            /** @var Gallery $gallery */
            $gallery = $this->galleryRepository->create($data);

            if (!empty($data['images'])) {
                $imageController = new ImageController(new ImageRepository());
                $imageController->storeGalleryImages($gallery, $user, $data['images']);
            }

            return Redirect::to('home/gallery/edit/' . $gallery->id)->withSuccess(trans('home.gallery_create_success'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $gallery = $this->galleryRepository->findOrFail($id);
        $images = $this->imageRepository->findImagesByGallery($gallery, Image::SIZE_ORIGINAL);
        return view('home.galleries.gallery', compact('gallery', 'images'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = [
            'user_id' => null,
            'title' => $request->title,
            'images' => $request->file('images'),
        ];

        /** @var User $user */
        $user = Auth::user();
        if ($user !== null) {
            $data['user_id'] = $user->getAttribute('id');
        }

        if (!$this->galleryValidator->with($data)->passes()) {
            return Redirect::to('home/gallery/edit/' . $id)->withErrors($this->galleryValidator->errors());
        } else {
            $this->galleryRepository->update($id, $data);
            /** @var Gallery $gallery */
            $gallery = $this->galleryRepository->find($id);
            if (!empty($data['images'])) {
                $imageController = new ImageController(new ImageRepository());
                $imageController->storeGalleryImages($gallery, $user, $data['images']);
            }

            if (Cache::has('gallery_rendered_' . $gallery->id)) {
                Cache::forget('gallery_rendered_' . $id);
            }

            return Redirect::to('home/gallery/edit/' . $gallery->id)->withSuccess(trans('home.gallery_update_success'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Render a gallery.
     *
     * @param Gallery $gallery
     * @return string Gallery rendered.
     */
    public static function render(Gallery $gallery)
    {
        $images = (new ImageRepository)->findImagesByGallery($gallery, Image::SIZE_ORIGINAL);
        return view('themes.vortex.blog.partials.gallery', compact('gallery', 'images'))->render();
    }
}
