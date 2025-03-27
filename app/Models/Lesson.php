<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Lesson
 *
 * @property $id
 * @property $topic_id
 * @property $title
 * @property $type
 * @property $created_at
 * @property $updated_at
 *
 * @property Topic $topic
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Lesson extends Model
{

    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['topic_id', 'type'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function topic()
    {
        return $this->belongsTo(\App\Models\Topic::class, 'topic_id', 'id');
    }

    public function video()
    {
        return $this->hasOne(LessonVideo::class, 'lesson_id');
    }

    public function pdf()
    {
        return $this->hasOne(LessonPdf::class, 'lesson_id');
    }

    public function article()
    {
        return $this->hasOne(LessonArticle::class, 'lesson_id');
    }

    public function children_model()
    {
        switch ($this->type) {
            case 'article'  : return $this->article();
            case 'video'    : return $this->video();
            case 'pdf'      : return $this->pdf();
        }
    }
}
