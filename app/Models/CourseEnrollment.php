<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CourseEnrollment
 *
 * @property $id
 * @property $user_id
 * @property $course_id
 * @property $created_at
 * @property $updated_at
 *
 * @property Course $course
 * @property User $user
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class CourseEnrollment extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['user_id', 'course_id','is_completed','completion_percentage'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course()
    {
        return $this->belongsTo(\App\Models\Course::class, 'course_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }
    
}
