<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $primaryKey = 'question_id';

    protected $fillable = [
        'question_text',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_answer',
        'explanation',
        'difficulty_level',
        'subject_id'
    ];

    // Quan hệ với Subject
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    // Quan hệ với ExamQuestion
    public function examQuestions()
    {
        return $this->hasMany(ExamQuestion::class, 'question_id');
    }

    // Quan hệ với Exam thông qua ExamQuestion
    public function exams()
    {
        return $this->belongsToMany(Exam::class, 'exam_questions', 'question_id', 'exam_id')
                    ->withPivot('question_order')
                    ->withTimestamps();
    }

    // Quan hệ với UserAnswer
    public function userAnswers()
    {
        return $this->hasMany(UserAnswer::class, 'question_id');
    }

    // Quan hệ với Answer
    public function answers()
    {
        return $this->hasMany(Answer::class, 'question_id');
    }
}
