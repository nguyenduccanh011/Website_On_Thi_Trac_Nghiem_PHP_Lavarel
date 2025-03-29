<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $primaryKey = 'subject_id';

    protected $fillable = [
        'subject_name',
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    // Quan hệ với Question
    public function questions()
    {
        return $this->hasMany(Question::class, 'subject_id', 'subject_id');
    }

    public function exams()
    {
        return $this->hasMany(Exam::class, 'subject_id', 'subject_id');
    }
}
