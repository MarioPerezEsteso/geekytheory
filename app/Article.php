<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;

class Article extends Post
{
    /**
     * Default number of items to paginate.
     */
    const PAGINATION_DEFAULT = 10;

    /**
     * Get the comments of the post.
     */
    public function comments()
    {
        return $this->hasMany('App\Comment', 'post_id');
    }

    /**
     * Get the ham comments of the post.
     */
    public function hamComments()
    {
        return $this->comments()->where(['spam' => 0, 'approved' => 1])->orderBy('created_at', 'DESC');
    }
    
    /**
     * Find the articles owned by an author.
     *
     * @param User $author
     * @param bool $onlyPublishedArticles
     * @param int $paginate
     * 
     * @return mixed
     */
    public static function findArticles(User $author = null, $onlyPublishedArticles = false, $paginate = self::PAGINATION_DEFAULT, $text = null)
    {
        $columns = User::$mappings;
        array_push($columns, 'posts.*');
        $query = Article::join('users', 'users.id', '=', 'posts.user_id')
            ->select($columns)
            ->orderBy('posts.created_at', 'DESC')
            ->where('posts.type', self::POST_ARTICLE);
        if ($author !== null) {
            $query->where('users.username', $author->username);
        }

        if ($onlyPublishedArticles) {
            $query->where('posts.status', self::STATUS_PUBLISHED);
        }

        if ($text !== null) {
            $query->where('posts.body', 'like', "%$text%")
                ->orWhere('posts.title', 'like', "%$text%");
        }

        return $query->paginate($paginate);
    }

    /**
     * Find all the articles published.
     *
     * @return Collection
     */
    public static function findAllPublished()
    {
        $query = Article::where('type', self::POST_ARTICLE)
            ->where('status', self::STATUS_PUBLISHED)
            ->orderBy('created_at', 'DESC');

        return $query->get();
    }

    /**
     * Find all articles.
     *
     * @param int $paginate
     * 
     * @return mixed
     */
    public static function findAllArticles($paginate = self::PAGINATION_DEFAULT)
    {
        return self::findArticles(null, false, $paginate);
    }

    /**
     * Find an article by its slug.
     *
     * @param $slug
     * @param bool $isPreview
     * 
     * @return Article
     */
    public static function findArticleBySlug($slug, $isPreview = false)
    {
        $query = Article::where('slug', $slug)
            ->where('type', self::POST_ARTICLE);

        if (!$isPreview) {
            $query->where('status', self::STATUS_PUBLISHED);
        }

        return $query;
    }

    /**
     * Find the published articles owned by an author.
     *
     * @param User $author
     * @param int $paginate
     * 
     * @return mixed
     */
    public static function findPublishedArticlesByAuthor(User $author, $paginate = self::PAGINATION_DEFAULT)
    {
        return self::findArticles($author, true, $paginate);
    }

    /**
     * Find articles by search.
     *
     * @param bool $onlyPublishedArticles
     * @param int $paginate
     * @param null $text
     * 
     * @return mixed
     */
    public static function findArticlesBySearch($onlyPublishedArticles = false, $paginate = self::PAGINATION_DEFAULT, $text = null)
    {
        return self::findArticles(null, $onlyPublishedArticles, $paginate, $text);
    }
}
