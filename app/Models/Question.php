<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_text',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_answer',
        'explanation',
        'difficulty_level',
        'subject_id',
        'exam_id',
        'exam_bank_id',
        'category_id'
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
                    ->withPivot('order_index')
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

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function examBank()
    {
        return $this->belongsTo(ExamBank::class, 'exam_bank_id', 'bank_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
