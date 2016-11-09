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

    /**
     * Find an image in all of the available sizes by searching by its identifier and the parent of the other images.
     *
     * @param $id
     * @return null
     */
    public function findImageAllSizes($id = null);
}