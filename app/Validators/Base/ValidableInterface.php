<?php

namespace App\Validators\Base;

use App\Http\Controllers\Controller;

interface ValidableInterface
{
    /**
     * Modify the rules for updating a Model
     *
     * @param int $id
     * @return self
     */
    public function update($id = null);

    /**
     * With
     *
     * @param array $input
     * @return self
     */
    public function with(array $input);

    /**
     * Passes
     *
     * @return boolean
     */
    public function passes();

    /**
     * Errors
     *
     * @return array
     */
    public function errors();
}