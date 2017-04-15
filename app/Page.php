<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Post
{
    /**
     * Find all pages.
     *
     * @param User $author
     * @param int $paginate
     * @return mixed
     */
    public static function findPagesByAuthor(User $author, $paginate = Repository::PAGINATION_DEFAULT)
    {
        return self::findPages($paginate, $author);
    }

    /**
     * Find a page by its slug.
     *
     * @param $slug
     * @param bool $isPreview
     * @return mixed
     */
    public static function findPageBySlug($slug, $isPreview = false)
    {
        $query = self::where('slug', $slug)
            ->where('type', Post::POST_PAGE);
        if (!$isPreview) {
            $query->where('status', Post::STATUS_PUBLISHED);
        }

        return $query->firstOrFail();
    }

    /**
     * Find pages owned by an author.
     *
     * @param User $author
     * @param int $paginate
     * @return mixed
     */
    public static function findPages($paginate = Repository::PAGINATION_DEFAULT, User $author = null)
    {
        $columns = User::$mappings;
        array_push($columns, 'posts.*');
        $query = self::join('users', 'users.id', '=', 'posts.user_id')
            ->select($columns)
            ->orderBy('posts.created_at', 'DESC')
            ->where('posts.type', Post::POST_PAGE);
        if ($author !== null) {
            $query->where('users.username', $author->username);
        }

        return $query->paginate($paginate);
    }
}
