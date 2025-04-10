<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ExamBank extends Model
{
    use HasFactory;

    protected $table = 'exam_banks';
    protected $primaryKey = 'bank_id';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'total_questions',
        'difficulty_level',
        'time_limit',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'total_questions' => 'integer',
        'time_limit' => 'integer'
    ];

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class, 'exam_bank_id', 'bank_id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(ExamCategory::class, 'exam_bank_categories', 'bank_id', 'category_id')
                    ->withTimestamps();
    }

    public function getQuestionsByDifficulty($difficulty)
    {
        return $this->questions()->where('difficulty_level', $difficulty)->get();
    }

    public function updateTotalQuestions()
    {
        $this->total_questions = $this->questions()->count();
        $this->save();
    }

    public function getRandomQuestions($count)
    {
        return $this->questions()->inRandomOrder()->limit($count)->get();
    }
} 