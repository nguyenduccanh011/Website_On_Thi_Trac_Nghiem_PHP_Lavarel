<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'exam_id',
        'start_time',
        'end_time',
        'score',
        'total_questions',
        'correct_answers',
        'incorrect_answers'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'score' => 'decimal:2'
    ];

    // Quan hệ với User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Quan hệ với Exam
    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    // Quan hệ với UserAnswer
    public function userAnswers()
    {
        return $this->hasMany(UserAnswer::class, 'attempt_id');
    }
}
