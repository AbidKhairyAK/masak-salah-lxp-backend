<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PracticeSingleChoiceOption extends Model
{
    use CreatedUpdatedBy;
    use SoftDeletes;
    protected $table = 'practice_single_choice_options';

    protected $fillable = [
        'question_id',
        'description',
        'is_correct',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    // Relationships

    public function question()
    {
        return $this->belongsTo(PracticeSingleChoiceQuestion::class, 'question_id', 'id');
    }
}
