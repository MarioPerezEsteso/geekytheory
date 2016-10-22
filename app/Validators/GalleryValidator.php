<?php

namespace App\Validators;

use App\Http\Controllers\Controller;
use App\Validators\Base\LaravelValidator;
use App\Validators\Base\ValidableInterface;

class GalleryValidator extends LaravelValidator implements ValidableInterface
{
    /**
     * Validation rules for creating a new Gallery.
     */
    protected $rules = [
        'title' => 'required',
    ];

    /**
     * The rules for updating a Gallery are the same than for creating a new one.
     *
     * @param null $id
     * @return self
     */
    public function update($id = null)
    {
        return $this;
    }
}