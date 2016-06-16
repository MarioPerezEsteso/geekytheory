<?php

namespace App\Repositories;

interface RepositoryInterface
{

    public function create(array $attributes);

    public function all($columns = array('*'));

    public function paginate($pagination = self::PAGINATION_DEFAULT, $columns = array('*'));

    public function find($id, $columns = array('*'));

    public function findOrFail($id, $columns = array('*'));

    public function destroy($ids);
}