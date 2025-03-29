<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamCategory extends Model
{
    use HasFactory;

    protected $primaryKey = 'category_id';

    protected $fillable = [
        'name',
        'description'
    ];

    // Quan hệ với Question
    public function questions()
    {
        return $this->hasMany(Question::class, 'category_id');
    }

    // Quan hệ với Exam
    public function exams()
    {
        return $this->hasMany(Exam::class, 'category_id');
    }
}
