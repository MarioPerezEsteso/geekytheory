<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    /**
     * Resource type for API responses.
     */
    const RESOURCE_TYPE = 'Lesson';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lessons';

    /**
     * The attributes that should be visible in serialization.
     *
     * @var array
     */
    public $visible = [
        'id',
        'slug',
        'title',
        'content',
        'video',
        'order',
        'duration',
        'free',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    public $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Get the chapter this lesson belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function chapter()
    {
        return $this->belongsTo('App\Chapter');
    }

    /**
     * Check if a lesson is free.
     *
     * @return bool
     */
    public function isFree(): bool
    {
        return $this->free;
    }

    /**
     * Check if a lesson is premium.
     *
     * @return bool
     */
    public function isPremium(): bool
    {
        return !$this->isFree();
    }

    /**
     * Get image attribute.
     *
     * @return string
     */
    public function getImageAttribute()
    {
        if (!empty($this->image)) {
            return $this->image;
        }

        return '/assets/images/lessons/code.png';
    }
}
