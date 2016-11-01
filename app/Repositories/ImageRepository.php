<?php

namespace App\Repositories;

use App\Gallery;

class ImageRepository extends Repository implements ImageRepositoryInterface
{
    /**
     * Model class name
     *
     * @var string
     */
    protected $modelClassName = 'App\Image';

    /**
     * Find the images of a gallery.
     *
     * @param Gallery $gallery
     * @param string $size
     * @return mixed
     */
    public function findImagesByGallery($gallery, $size = '')
    {
        $query = $gallery->images();

        if (!empty($size)) {
            $query->where('size', '=', $size);
        }

        return $query->get();
    }
}