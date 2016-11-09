<?php

namespace App\Http\Controllers;

use App\Gallery;
use App\Image;
use App\Repositories\ImageRepository;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\Facades\File;

class ImageController extends Controller
{
    /**
     * Path for the uploaded images
     */
    const PATH_UPLOADS = 'uploads';
    const PATH_IMAGE_NOT_FOUND = '/assets/img/imagenotfound.jpg';

    /**
     * @var ImageRepository
     */
    private $imageRepository;

    /**
     * ImageController constructor.
     *
     * @param ImageRepository $imageRepository
     */
    public function __construct(ImageRepository $imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }

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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return array
     * @internal param int $id
     */
    public function deleteImageFromGallery(Request $request)
    {
        $imageId = $request->imageId;
        /**
         * I use orderBy 'desc' because I have to delete the parent image in the last position in order to avoid
         */
        $images = $this->imageRepository->findImageAllSizes($imageId, 'desc');
        foreach ($images as $image) {
            /** @var Image $image */
            $image->delete();
        }

        return ['error' => 0];
    }

    /**
     * @param $gallery Gallery
     * @param $user User
     * @param array $images
     */
    public function storeGalleryImages($gallery, $user, $images = array())
    {
        $data = [
            'user_id' => $user->id,
            'gallery_id' => $gallery->id,
        ];

        $imageOriginalFilename = '';
        foreach ($images as $galleryImage) {
            foreach (Image::SIZES_GALLERY as $size) {
                $data['image'] = self::getUploadFilename($galleryImage, null, $size);
                $data['size'] = $size;
                if ($size == Image::SIZE_ORIGINAL) {
                    /**
                     * Store the original filename in this variable in order to resize the original file and
                     * find it by its name in the server.
                     */
                    $imageOriginalFilename = $data['image'];
                    $galleryImage->move(ImageManagerController::getPathYearMonth(), $data['image']);
                    $originalImage = $this->imageRepository->create($data);
                } else if ($size == Image::SIZE_THUMBNAIL) {
                    self::resizeImage(
                        self::getPathYearMonth($imageOriginalFilename),
                        Image::SIZE_GALLERY_THUMBNAIL_WIDTH,
                        0,
                        self::getPathYearMonth($data['image']),
                        100);

                    if ($originalImage !== null) {
                        $data['parent'] = $originalImage->id;
                    }

                    $this->imageRepository->create($data);
                }

            }
        }
    }

    /**
     * Returns the filename of a new uploaded file. It could be and image, document, etc.
     *
     * @param UploadedFile $image
     * @param string $path
     * @param string $size
     * @return string
     */
    public static function getUploadFilename($image, $path = null, $size = '')
    {
        if ($path === null) {
            $path = self::getPathYearMonth();
        }

        if ($size == Image::SIZE_ORIGINAL || $size == Image::SIZE_FEATURED) {
            $size = '';
        } else if ($size == Image::SIZE_FEATURED_THUMBNAIL || $size == Image::SIZE_THUMBNAIL) {
            $size = '-thumb';
        }

        $fileExtension = '.' . $image->getClientOriginalExtension();
        $fileName = substr($image->getClientOriginalName(), 0, -1 * strlen($fileExtension));
        $completeFileName = $fileName . $size . $fileExtension;
        $i = 1;

        while (File::exists($path . $completeFileName)) {
            $completeFileName = $fileName . ' (' . $i++ . ')' . $fileExtension;
        }

        return $completeFileName;
    }

    /**
     * Get upload path with the year and the month.
     *
     * @param string $file
     * @return string
     */
    public static function getPathYearMonth($file = '')
    {
        $path = self::PATH_UPLOADS . '/' . date('Y') . '/' . date('m') . '/';
        return (empty($file)) ? $path : $path . $file;
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
        if (filter_var($imageName, FILTER_VALIDATE_URL)) {
            return $imageName;
        }

        $publicImageUrl = $imageName;
        if ($checkIfExists) {
            if (File::exists($publicImageUrl)) {
                return '/' . $publicImageUrl;
            } else if (File::exists(self::getPathYearMonth($publicImageUrl))) {
                return '/' . self::getPathYearMonth($publicImageUrl);
            } else {
                return self::PATH_IMAGE_NOT_FOUND;
            }
        }

        return '/' . $publicImageUrl;
    }

    /**
     * Function to resize JPG, PNG or GIF images.
     * It has been adapted from: https://github.com/Nimrod007/PHP_image_resize
     *
     * @param  $file - file name to resize
     * @param  $width - new image width
     * @param  $height - new image height
     * @param  $output - name of the new file (include path if needed)
     * @param  $quality - enter 1-100 (100 is best quality) default is 100
     * @return boolean|resource
     */
    public static function resizeImage($file, $width = 0, $height = 0, $output = 'file', $quality = 100)
    {
        if ($height <= 0 && $width <= 0 || $file === null) {
            return false;
        }

        # Setting defaults and meta
        $info = getimagesize($file);
        list($widthOriginal, $heightOriginal) = $info;

        # Calculate proportionality
        if ($width == 0) {
            $factor = $height / $heightOriginal;
        } elseif ($height == 0) {
            $factor = $width / $widthOriginal;
        } else {
            $factor = min($width / $widthOriginal, $height / $heightOriginal);
        }

        $finalWidth = round($widthOriginal * $factor);
        $finalHeight = round($heightOriginal * $factor);

        # Loading image to memory according to type
        switch ($info[2]) {
            case IMAGETYPE_JPEG:
                $image = imagecreatefromjpeg($file);
                break;
            case IMAGETYPE_GIF:
                $image = imagecreatefromgif($file);
                break;
            case IMAGETYPE_PNG:
                $image = imagecreatefrompng($file);
                break;
            default:
                return false;
        }

        # This is the resizing/resampling/transparency-preserving magic
        $imageResized = imagecreatetruecolor($finalWidth, $finalHeight);
        if (($info[2] == IMAGETYPE_GIF) || ($info[2] == IMAGETYPE_PNG)) {
            $transparency = imagecolortransparent($image);
            $palletsize = imagecolorstotal($image);

            if ($transparency >= 0 && $transparency < $palletsize) {
                $transparentColor = imagecolorsforindex($image, $transparency);
                $transparency = imagecolorallocate($imageResized, $transparentColor['red'], $transparentColor['green'], $transparentColor['blue']);
                imagefill($imageResized, 0, 0, $transparency);
                imagecolortransparent($imageResized, $transparency);
            } elseif ($info[2] == IMAGETYPE_PNG) {
                imagealphablending($imageResized, false);
                $color = imagecolorallocatealpha($imageResized, 0, 0, 0, 127);
                imagefill($imageResized, 0, 0, $color);
                imagesavealpha($imageResized, true);
            }
        }
        imagecopyresampled($imageResized, $image, 0, 0, 0, 0, $finalWidth, $finalHeight, $widthOriginal, $heightOriginal);

        # Preparing a method of providing result
        switch (strtolower($output)) {
            case 'browser':
                $mime = image_type_to_mime_type($info[2]);
                header("Content-type: $mime");
                $output = NULL;
                break;
            case 'file':
                $output = $file;
                break;
            case 'return':
                return $imageResized;
                break;
            default:
                break;
        }

        # Writing image according to type to the output destination and image quality
        switch ($info[2]) {
            case IMAGETYPE_GIF:
                imagegif($imageResized, $output);
                break;
            case IMAGETYPE_JPEG:
                imagejpeg($imageResized, $output, $quality);
                break;
            case IMAGETYPE_PNG:
                /**
                 * In some images quality of 100 causes that the size of the resized image is
                 * bigger than the original, so it is better to decrease the quality.
                 */
                $quality = $quality / 2;
                $quality = 9 - (int)((0.9 * $quality) / 10.0);
                imagepng($imageResized, $output, $quality);
                break;
            default:
                return false;
        }

        return true;
    }
}
