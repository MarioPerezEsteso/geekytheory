<?php

namespace App\Repositories;

abstract class Repository implements RepositoryInterface
{

    /**
     * Default number of items to show with pagination
     */
    const PAGINATION_DEFAULT = 10;

    /**
     * Model class name
     *
     * @var string
     */
    protected $modelClassName;

    /**
     * Create a new entity of a model
     *
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        return call_user_func_array("{$this->modelClassName}::create", array($attributes));
    }

    /**
     * Get all entities of a model
     *
     * @param array $columns
     * @return mixed
     */
    public function all($columns = array('*'))
    {
        return call_user_func_array("{$this->modelClassName}::all", array($columns));
    }

    /**
     * Find one entity by its identifier
     *
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = array('*'))
    {
        return call_user_func_array("{$this->modelClassName}::find", array($id, $columns));
    }

    /**
     * Find one entity by its identifier or fail
     *
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function findOrFail($id, $columns = array('*'))
    {
        return call_user_func_array("{$this->modelClassName}::findOrFail", array($id, $columns));
    }

    /**
     * Paginate a list of entities
     *
     * @param int $pagination
     * @param array $columns
     * @return mixed
     */
    public function paginate($pagination = self::PAGINATION_DEFAULT, $columns = array('*'))
    {
        return call_user_func_array("{$this->modelClassName}::paginate", array($pagination, $columns));
    }

    /**
     * Destroy a list of entities by their identifiers
     *
     * @param $ids
     * @return mixed
     */
    public function destroy($ids)
    {
        return call_user_func_array("{$this->modelClassName}::destroy", array($ids));
    }

}