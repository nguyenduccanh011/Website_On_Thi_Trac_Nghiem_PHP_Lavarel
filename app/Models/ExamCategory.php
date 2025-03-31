<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamCategory extends Model
{
    use HasFactory;

    protected $table = 'exam_categories';
    protected $primaryKey = 'category_id';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'level',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'level' => 'integer'
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

    // Relationship với danh mục cha
    public function parent(): BelongsTo
    {
        return $this->belongsTo(ExamCategory::class, 'parent_id', 'category_id');
    }

    // Relationship với danh mục con
    public function children(): HasMany
    {
        return $this->hasMany(ExamCategory::class, 'parent_id', 'category_id');
    }

    // Relationship với ngân hàng đề thi
    public function examBanks()
    {
        return $this->belongsToMany(ExamBank::class, 'exam_bank_categories', 'category_id', 'bank_id')
                    ->withTimestamps();
    }

    // Lấy tất cả danh mục con (đệ quy)
    public function getAllChildren()
    {
        return $this->children()->with('children');
    }

    // Lấy đường dẫn đầy đủ của danh mục
    public function getFullPath()
    {
        $path = [$this->name];
        $parent = $this->parent;
        
        while ($parent) {
            array_unshift($path, $parent->name);
            $parent = $parent->parent;
        }
        
        return implode(' > ', $path);
    }
}
