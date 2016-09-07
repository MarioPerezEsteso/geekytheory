<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'comments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array(
        'post_id',
        'user_id',
        'parent',
        'author_name',
        'author_email',
        'author_url',
        'content',
        'approved',
        'spam',
        'ip',
    );

    /**
     * Check if the comments has children comments.
     *
     * @return bool
     */
    public function hasChildren()
    {
        return ($this->children !== null) && (count($this->children) > 0);
    }

    /**
     * Get the user that owns the comment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the post that owns the comment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo('App\Post');
    }

}
