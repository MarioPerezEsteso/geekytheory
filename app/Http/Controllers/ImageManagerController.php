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
    const PATH_IMAGE_UPLOADS = 'images';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
     *
     */
    public static function getPublicImageUrl($imageName)
    {
        return '/' . self::PATH_IMAGE_UPLOADS . '/' . $imageName;
    }
}
