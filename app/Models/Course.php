<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use App\Traits\ImageCollectionMedia;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Course
 *
 * @property $id
 * @property $instructor_id
 * @property $title
 * @property $caption
 * @property $description
 * @property $created_at
 * @property $updated_at
 * @property $image
 *
 * @property Instructor $instructor
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Course extends Model implements HasMedia
{
    use ImageCollectionMedia, SoftDeletes;

    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['instructor_id', 'title', 'caption', 'description'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function instructor()
    {
        return $this->belongsTo(\App\Models\Instructor::class, 'instructor_id', 'id');
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class, 'course_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'course_enrollments', 'course_id', 'user_id');
    }

    public function topics()
    {
        return $this->hasManyThrough(Topic::class, Chapter::class);
    }

    public function getTopicCountAttribute(): int
    {
        return $this->topics_count ?? $this->topics()->count();
    }

    public function courseEnrollment()
    {
        return $this->hasMany(CourseEnrollment::class);
    }

    public function scopeWithDetails($query)
    {
        return $query->withCount([
            'topics',
            'topics as lesson_count' => function($query) {
                $query->where('type', 'lesson');
            },
            'topics as practice_count' => function($query) {
                $query->where('type', 'practice');
            }
        ]);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }
}
