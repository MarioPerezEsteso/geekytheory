<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * Statuses of a post
     */
    const STATUS_PUBLISHED = 'published';
    const STATUS_DRAFT = 'draft';
    const STATUS_PENDING = 'pending';
    const STATUS_SCHEDULED = 'scheduled';
    const STATUS_DELETED = 'deleted';
    
    /**
     * Possible types of a post
     */
    const POST_ARTICLE = 'article';
    const POST_PAGE = 'page';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'posts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'slug',
        'title',
        'body',
        'description',
        'status',
        'image',
        'type',
        'allow_comments',
        'show_title',
        'show_description',
		'shares_whatsapp',
		'shares_twitter',
		'shares_facebook',
		'shares_google-plus',
		'shares_telegram',
		'shares_mail',
    ];

    /**
     * Get the user that owns the post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get post tags.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'posts_tags', 'post_id', 'tag_id');
    }

    /**
     * Get post categories.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categories()
    {
        return $this->belongsToMany('App\Category', 'posts_categories', 'post_id', 'category_id');
    }
}
