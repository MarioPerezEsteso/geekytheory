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
    const PATH_UPLOADS = 'uploads';
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
        $fileName = ImageManagerController::getUploadFilename($image);
        $image->move(self::getPathYearMonth(), $fileName);
        $imgSrc = self::getPublicImageUrl(self::getPathYearMonth() . $fileName);
        return view('home.imagemanager.imageupload', compact('imgSrc'));
    }

    /**
     * Returns the filename of a new uploaded file. It could be and image, document, etc.
     *
     * @param string $path
     * @param UploadedFile $image
     * @return string
     */
    public static function getUploadFilename($image, $path = null)
    {
        if ($path === null) {
            $path = self::getPathYearMonth();
        }

        $fileExtension = '.' . $image->getClientOriginalExtension();
        $fileName = substr($image->getClientOriginalName(), 0, -1 * strlen($fileExtension));
        $completeFileName =  $fileName . $fileExtension;
        $i = 1;

        while (File::exists($path . $completeFileName)) {
            $completeFileName = $fileName . '(' . $i++ . ')' . $fileExtension;
        }

        return $completeFileName;
    }

    /**
     * Get upload path with the year and the month.
     *
     * @return string
     */
    public static function getPathYearMonth()
    {
        return self::PATH_UPLOADS . '/' . date('Y') . '/' .date('m') . '/';
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
        $publicImageUrl = $imageName;
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
