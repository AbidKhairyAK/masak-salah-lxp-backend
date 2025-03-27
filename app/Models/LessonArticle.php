<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LessonArticle
 *
 * @property $id
 * @property $lesson_id
 * @property $content
 * @property $created_at
 * @property $updated_at
 *
 * @property Lesson $lesson
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class LessonArticle extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['lesson_id', 'content'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lesson()
    {
        return $this->belongsTo(\App\Models\Lesson::class, 'lesson_id', 'id');
    }
    
}
