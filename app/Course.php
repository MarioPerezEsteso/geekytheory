<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /**
     * Resource type for API responses.
     */
    const RESOURCE_TYPE = 'Course';

    /**
     * Course difficulties.
     */
    const DIFFICULTY_BEGGINER = 'beginner';
    const DIFFICULTY_INTERMEDIATE = 'intermediate';
    const DIFFICULTY_ADVANCED = 'advanced';

    /**
     * Course statuses.
     */
    const STATUS_PUBLISHED = 'published';
    const STATUS_DRAFT = 'draft';
    const STATUS_PENDING = 'pending';
    const STATUS_SCHEDULED = 'scheduled';
    const STATUS_DELETED = 'deleted';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'courses';

    /**
     * The attributes that should be visible in serialization.
     *
     * @var array
     */
    public $visible = [
        'id',
        'slug',
        'title',
        'description',
        'image',
        'difficulty',
        'duration',
        'students',
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
     * Get published courses.
     */
    public static function getPublished()
    {
        return Course::where('status', self::STATUS_PUBLISHED);
    }

    /**
     * Get published by id.
     *
     * @param integer $id
     * @return $this
     */
    public static function getPublishedById($id)
    {
        return self::getPublished()->where('id', $id);
    }
}
