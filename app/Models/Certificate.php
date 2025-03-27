<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Certificate extends Model
{
    use CreatedUpdatedBy;
    use SoftDeletes;

    protected $table = 'certificates';

    protected $fillable = [
        'user_id',
        'course_id',
        'certificate_number',
        'issued_date',
        'download_url',
        'created_by',
        'updated_by',
        'is_approved'
    ];

    protected function casts(): array
{
    return [
        'issued_date' => 'datetime:Y-m-d',
    ];
}
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public static function generateCertificateNumber($userId, $courseId)
    {
        return now()->format('Ymd')."-$userId-$courseId-".strtoupper(Str::random(5));
    }
}
