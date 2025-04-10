<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'question_id',
        'order_index'
    ];

    // Quan hệ với Exam
    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    // Quan hệ với Question
    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
