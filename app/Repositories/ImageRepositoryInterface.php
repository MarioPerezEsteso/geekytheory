<?php

namespace App\Repositories;

use App\Gallery;
use App\Image;

interface ImageRepositoryInterface
{
    /**
     * Find the images of a gallery.
     *
     * @param Gallery $gallery
     * @param string $size
     * @return mixed
     */
    public function findImagesByGallery($gallery, $size = '');
}