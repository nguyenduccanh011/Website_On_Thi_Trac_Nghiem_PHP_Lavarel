<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $primaryKey = 'exam_id';

    protected $fillable = [
        'title',
        'description',
        'category_id',
        'duration',
        'total_marks',
        'passing_marks',
        'is_active'
    ];

    // Quan hệ với ExamCategory
    public function category()
    {
        return $this->belongsTo(ExamCategory::class, 'category_id');
    }

    // Quan hệ với ExamQuestion
    public function examQuestions()
    {
        return $this->hasMany(ExamQuestion::class, 'exam_id');
    }

    // Quan hệ với Question thông qua ExamQuestion
    public function questions()
    {
        return $this->belongsToMany(Question::class, 'exam_questions', 'exam_id', 'question_id')
                    ->withPivot('question_order')
                    ->withTimestamps();
    }

    // Quan hệ với ExamAttempt
    public function attempts()
    {
        return $this->hasMany(ExamAttempt::class, 'exam_id');
    }
}
