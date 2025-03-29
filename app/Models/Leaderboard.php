<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leaderboard extends Model
{
    use HasFactory;

    protected $table = 'leaderboard';

    protected $fillable = [
        'user_id',
        'exam_id',
        'score',
        'rank',
        'last_attempt_date'
    ];

    protected $casts = [
        'score' => 'decimal:2',
        'last_attempt_date' => 'datetime'
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
}
