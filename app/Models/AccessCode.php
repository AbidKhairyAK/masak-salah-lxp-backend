<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class AccessCode extends Model
{
    use CreatedUpdatedBy;
    use SoftDeletes;

    protected $table = 'access_codes';

    protected $fillable = [
        'course_id',
        'title',
        'code',
        'quota_used',
        'quota_total',
        'expiry_date',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'expiry_date' => 'date:Y-m-d',
        ];
    }

    public function course()
    {
        return $this->belongsTo(Course::class)->withTrashed();
    }
}
