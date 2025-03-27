<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Instructor
 *
 * @property $id
 * @property $user_id
 * @property $phonenumber
 * @property $occupation
 * @property $gender
 * @property $address
 * @property $created_at
 * @property $updated_at
 *
 * @property User $user
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Instructor extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['user_id', 'phonenumber', 'occupation', 'gender', 'address'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'instructor_id');
    }
    
}
