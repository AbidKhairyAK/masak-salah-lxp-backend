<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Practice
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
class Practice extends Model
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

    public function single_choice_question()
    {
        return $this->hasMany(PracticeSingleChoiceQuestion::class, 'practice_id');
    }

    public function children_model()
    {
        switch ($this->type) {
            case 'single_choice_question'  : return $this->single_choice_question();
        }
    }

}
