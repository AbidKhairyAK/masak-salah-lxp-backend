<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PracticeSingleChoiceUserResult extends Model
{
    use CreatedUpdatedBy;
    use SoftDeletes;

    protected $table = 'practice_single_choice_user_results';

    protected $fillable = [
        'user_id',
        'practice_id',
        'correct_questions',
        'total_questions',
        'created_by',
        'updated_by',
    ];


    protected $casts = [
        'user_id' => 'integer',
        'practice_id' => 'integer',
        'correct_questions' => 'integer',
        'total_questions' => 'integer',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function practice()
    {
        return $this->belongsTo(Practice::class);
    }
}
