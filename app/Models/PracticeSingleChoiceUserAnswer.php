<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PracticeSingleChoiceUserAnswer extends Model
{
    use CreatedUpdatedBy;
    use SoftDeletes;

    protected $table = 'practice_single_choice_user_answers';

    // The attributes that are mass assignable
    protected $fillable = [
        'user_id',
        'question_id',
        'selected_option_id',
        'is_correct',
        'created_by',
        'updated_by',
    ];

    // The attributes that should be cast to native types
    protected $casts = [
        'is_correct' => 'boolean',
    ];

    // Relationships

    /**
     * Get the user that owns the answer.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the question that this answer belongs to.
     */
    public function question()
    {
        return $this->belongsTo(PracticeSingleChoiceQuestion::class);
    }

    /**
     * Get the selected option for this answer.
     */
    public function selected_option()
    {
        return $this->belongsTo(PracticeSingleChoiceOption::class, 'selected_option_id');
    }
}
