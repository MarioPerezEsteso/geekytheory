<?php

namespace App;

use Doctrine\DBAL\Query\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

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
    public static function findArticles(User $author = null, $onlyPublishedArticles = false, $paginate = self::PAGINATION_DEFAULT)
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

        return $query->paginate($paginate);
    }

    public static function getPublishedArticles()
    {
        return Article::where('status', self::STATUS_PUBLISHED)
            ->where('type', self::POST_ARTICLE)
            ->orderBy('created_at', 'DESC');
    }

    /**
     * Get articles by category.
     *
     * @param Category $category
     * @return Builder
     */
    public static function getByCategory(Category $category)
    {
        return self::select('posts.*')
            ->join('posts_categories', 'posts.id', '=', 'posts_categories.post_id')
            ->where('posts_categories.category_id', $category->id)
            ->where('posts.status', self::STATUS_PUBLISHED)
            ->where('posts.type', self::POST_ARTICLE)
            ->orderBy('created_at', 'DESC');
    }

    /**
     * Get articles by tag.
     *
     * @param Tag $tag
     * @return Builder
     */
    public static function getByTag(Tag $tag)
    {
        return self::select('posts.*')
            ->join('posts_tags', 'posts.id', '=', 'posts_tags.post_id')
            ->where('posts_tags.tag_id', $tag->id)
            ->where('posts.status', self::STATUS_PUBLISHED)
            ->where('posts.type', self::POST_ARTICLE)
            ->orderBy('created_at', 'DESC');
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
}
