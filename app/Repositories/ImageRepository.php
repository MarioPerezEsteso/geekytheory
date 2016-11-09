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

    /**
     * Find an image in all of the available sizes by searching by its identifier and the parent of the other images.
     *
     * @param $id
     * @param string $orderBy
     * @return null
     */
    public function findImageAllSizes($id = null, $orderBy = 'asc')
    {
        if ($id === null) {
            return null;
        }

        return call_user_func_array("{$this->modelClassName}::where", array('id', $id))
            ->orWhere('parent', $id)
            ->orderBy('parent', $orderBy)
            ->get();
    }
}