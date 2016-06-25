<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Http\Request;

use App\Http\Requests;

class ImageManagerController extends Controller
{
    /**
     * Path for the uploaded images
     */
    const PATH_IMAGE_UPLOADS   = 'images';
    const PATH_IMAGE_NOT_FOUND = '/assets/img/imagenotfound.jpg';

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('home.imagemanager.imagedialog');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /** @var UploadedFile $image */
        $image = $request->file('image');
        $fileName = ImageManagerController::getImageName($image, self::PATH_IMAGE_UPLOADS);
        $image->move(self::PATH_IMAGE_UPLOADS, $fileName);
        $imgSrc = '/' . self::PATH_IMAGE_UPLOADS . '/' . $fileName;
        return view('home.imagemanager.imageupload', compact('imgSrc'));
    }

    /**
     * Returns the filename of a new uploaded image
     *
     * @param string $path
     * @param UploadedFile $image
     * @return string
     */
    public static function getImageName($image, $path = self::PATH_IMAGE_UPLOADS)
    {
        $fileExtension = '.' . $image->getClientOriginalExtension();
        $fileName = substr($image->getClientOriginalName(), 0, -1 * strlen($fileExtension));
        $completeFileName = $fileName . $fileExtension;
        $i = 1;
        while (File::exists($path . '/' . $completeFileName)) {
            $completeFileName = $fileName . '(' . $i++ . ')' . $fileExtension;
        }
        return $completeFileName;
    }

    /**
     * Get the public URL of an image
     *
     * @param string $imageName
     * @param bool $checkIfExists
     * @return string
     */
    public static function getPublicImageUrl($imageName, $checkIfExists = false)
    {
        $publicImageUrl = self::PATH_IMAGE_UPLOADS . '/' . $imageName;
        if ($checkIfExists) {
            if (File::exists($publicImageUrl)) {
                return '/' . $publicImageUrl;
            } else {
                return self::PATH_IMAGE_NOT_FOUND;
            }
        }
        return '/' . $publicImageUrl;
    }
}
