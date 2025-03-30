<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamBank extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_name',
        'category_id',
        'description',
        'difficulty_level',
        'total_questions'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
} 