<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use App\Traits\ImageCollectionMedia;

class PracticeSingleChoiceQuestion extends Model implements HasMedia
{
    use CreatedUpdatedBy;
    use SoftDeletes;
    use ImageCollectionMedia;

    protected $table = 'practice_single_choice_questions';

    protected $fillable = [
        'practice_id',
        'question',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'practice_id' => 'integer',
    ];

    // Relationships

    public function practice()
    {
        return $this->belongsTo(Practice::class);
    }

    public function options()
    {
        return $this->hasMany(PracticeSingleChoiceOption::class, 'question_id');
    }

    public function userAnswer()
    {
        return $this->hasOne(PracticeSingleChoiceUserAnswer::class, 'question_id', 'id');
    }
}
