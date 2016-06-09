<?php

namespace App\Validators\Base;

interface ValidableInterface
{
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