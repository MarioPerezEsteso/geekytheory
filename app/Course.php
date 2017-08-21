<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class Course extends Model
{
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
     * Get the teacher of a course.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function teacher()
    {
        return $this->belongsTo('App\User', 'teacher_id', 'id');
    }

    /**
     * Get the chapters of a course.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function chapters()
    {
        return $this->hasMany('App\Chapter');
    }

    /**
     * Get published courses.
     *
     * @param array $andWhere
     * @return Builder
     */
    public static function getPublished($andWhere = [])
    {
        $query = Course::where('status', self::STATUS_PUBLISHED);
        foreach ($andWhere as $key => $value) {
            $query = $query->where($key, '=', $value);
        }

        return $query;
    }
}
