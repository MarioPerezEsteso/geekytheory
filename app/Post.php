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
        'content',
        'description',
        'status',
        'image',
    );

    /**
     * Get the user that owns the post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     *
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getTags()
    {
        return $this->hasMany('App\Tag');
    }

    public function getCategories()
    {
        return $this->hasMany('App\Categories');
    }

}
