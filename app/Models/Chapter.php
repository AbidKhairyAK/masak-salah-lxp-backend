<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Chapter
 *
 * @property $id
 * @property $course_id
 * @property $title
 * @property $created_at
 * @property $updated_at
 *
 * @property Course $course
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Chapter extends Model
{

    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['course_id', 'title'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course()
    {
        return $this->belongsTo(\App\Models\Course::class, 'course_id', 'id');
    }

    public function topics()
    {
        return $this->hasMany(Topic::class, 'chapter_id')->orderBy('sort_order');
    }

}
