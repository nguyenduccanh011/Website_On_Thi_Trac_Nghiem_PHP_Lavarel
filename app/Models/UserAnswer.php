<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_answer_id';

    protected $fillable = [
        'attempt_id',
        'question_id',
        'selected_answer',
        'is_correct'
    ];

    protected $casts = [
        'is_correct' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($userAnswer) {
            $userAnswer->user_id = $userAnswer->attempt->user_id;
        });
    }

    // Quan hệ với ExamAttempt
    public function attempt()
    {
        return $this->belongsTo(ExamAttempt::class, 'attempt_id');
    }

    // Quan hệ với Question
    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
