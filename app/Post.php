<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    /**
     * Statuses of a post
     */
    const STATUS_PENDING    = 'pending';
    const STATUS_DRAFT      = 'draft';
    const STATUS_DELETED    = 'deleted';
    const STATUS_PUBLISHED  = 'published';
    const STATUS_SCHEDULED  = 'scheduled';

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
    protected $fillable = array(
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
    );

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
        return $this->belongsToMany('App\Tag', 'posts_tags');
    }

    /**
     * Get post categories.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categories()
    {
        return $this->belongsToMany('App\Category', 'posts_categories');
    }

    /**
     * Get the comments of the post.
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

}
