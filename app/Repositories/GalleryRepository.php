<?php

namespace App\Repositories;

use App\User;

class GalleryRepository extends Repository implements GalleryRepositoryInterface
{
    /**
     * Model class name
     *
     * @var string
     */
    protected $modelClassName = 'App\Gallery';

    /**
     * Find galleries owned by an author or all galleries joined with their authors.
     *
     * @param User|null $author
     * @param int $paginate
     * @return mixed
     */
    public function findGalleries(User $author = null, $paginate = Repository::PAGINATION_DEFAULT)
    {
        $columns = User::$mappings;
        array_push($columns, 'galleries.*');
        $query = call_user_func_array("{$this->modelClassName}::join", array('users', 'users.id', '=', 'galleries.user_id'))
            ->select($columns)
            ->orderBy('galleries.created_at', 'DESC');

        if ($author !== null) {
            $query->where('users.username', $author->username);
        }

        return $query->paginate($paginate);
    }
}