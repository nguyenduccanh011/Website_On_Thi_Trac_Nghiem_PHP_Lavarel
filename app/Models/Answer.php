<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $primaryKey = 'answer_id';

    protected $fillable = [
        'answer_text',
        'question_id',
        'is_correct'
    ];

    protected $casts = [
        'is_correct' => 'boolean'
    ];

    // Quan hệ với Question
    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
