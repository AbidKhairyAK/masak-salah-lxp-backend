<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LessonPdf
 *
 * @property $id
 * @property $lesson_id
 * @property $pdf_url
 * @property $created_at
 * @property $updated_at
 *
 * @property Lesson $lesson
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class LessonPdf extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['lesson_id', 'pdf_url'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lesson()
    {
        return $this->belongsTo(\App\Models\Lesson::class, 'lesson_id', 'id');
    }
    
}
