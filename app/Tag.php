<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tags';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array(
        'tag',
        'description',
        'slug',
    );

    /**
     * Get posts by Tag.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts()
    {
        return $this->belongsToMany('App\Post', 'posts_tags');
    }

    /**
     * Find tag by slug or fail.
     *
     * @param string $slug
     * @return Tag
     */
    public static function findBySlugOrFail(string $slug)
    {
        return self::where('slug', $slug)->firstOrFail();
    }
}
