<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * Class Topic
 *
 * @property $id
 * @property $chapter_id
 * @property $title
 * @property $sort_order
 * @property $type
 * @property $created_at
 * @property $updated_at
 *
 * @property Chapter $chapter
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Topic extends Model
{

    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['chapter_id', 'title', 'sort_order', 'type'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function chapter()
    {
        return $this->belongsTo(\App\Models\Chapter::class, 'chapter_id', 'id');
    }

    public function lesson()
    {
        return $this->hasOne(Lesson::class, 'topic_id');
    }

    public function practice()
    {
        return $this->hasOne(Practice::class, 'topic_id');
    }

    public function topicUserHistories()
    {
        return $this->hasMany(TopicUserHistory::class);
    }

    public function topic_user_history()
    {
        return $this->belongsToMany(\App\Models\User::class, 'topic_user_histories', 'topic_id', 'user_id');
    }

    /**
     * custom relationship function to get related
     * children model based on topic's type value
     */
    public function children_model()
    {
        switch ($this->type) {
            case 'lesson'   : return $this->lesson();
            case 'practice' : return $this->practice();
        }
    }

    /**
     * function to clean all topic's children and grandchildren
     */
    public function delete_children()
    {
        $lesson_child     = $this->lesson()->first();
        $practice_child   = $this->practice()->first();

        if ($lesson_child) {
            $lesson_child->children_model()->delete();
            $lesson_child->delete();
        }

        if ($practice_child) {
            $practice_child->delete();
        }
    }
}
