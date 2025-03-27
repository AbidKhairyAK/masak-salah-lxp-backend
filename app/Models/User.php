<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements CanResetPassword, MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, SoftDeletes, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Default password is used when resetting and
     * creating new user via admin panel
     */
    public static $default_password = '123456';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Make sure password is hashed before stored to db
     */
    protected function password() {
        return Attribute::make(
            set: fn (string $value) => Hash::make($value)
        );
    }

    /**
     * User relation on Instructor model.
     */
    public function instructor(): HasOne
    {
        return $this->hasOne(Instructor::class);
    }

    /**
     * User relation on Student model.
     */
    public function student(): HasOne
    {
        return $this->hasOne(Student::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_enrollments', 'user_id', 'course_id')
                    ->withPivot('is_completed', 'completion_percentage')
                    ->with('certificates');
    }

    public function topic_user_history()
    {
        return $this->belongsToMany(\App\Models\Topic::class, 'topic_user_histories', 'user_id', 'topic_id');
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class, 'user_id');
    }
}
