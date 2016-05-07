<?php

namespace App\Repositories;

use App\SiteMeta;

class SiteMetaRepository extends Repository implements SiteMetaRepositoryInterface
{
    /**
     * Model class name
     *
     * @var string
     */
    protected $modelClassName = 'App\SiteMeta';

    /**
     * Get SiteMeta
     *
     * @return SiteMeta
     */
    public function getSiteMeta()
    {
        return call_user_func_array("{$this->modelClassName}::first", array());
    }
}