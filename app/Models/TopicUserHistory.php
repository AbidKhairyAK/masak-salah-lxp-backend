<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * Class CourseEnrollment
 *
 * @property $id
 * @property $user_id
 * @property $topic_id
 * @property $created_at
 * @property $updated_at
 *
 * @property Topic $topic
 * @property User $user
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class TopicUserHistory extends Model
{
        /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['user_id', 'topic_id'];

        /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function topic()
    {
        return $this->belongsTo(\App\Models\Topic::class, 'topic_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }
}
