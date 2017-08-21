<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    /**
     * Resource type for API responses.
     */
    const RESOURCE_TYPE = 'Chapter';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'chapters';

    /**
     * The attributes that should be visible in serialization.
     *
     * @var array
     */
    public $visible = [
        'id',
        'title',
        'order',
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
     * Get the course this chapter belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course()
    {
        return $this->belongsTo('App\Course');
    }
}