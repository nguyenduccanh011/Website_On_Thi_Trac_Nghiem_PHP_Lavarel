<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumTopic extends Model
{
    use HasFactory;

    protected $primaryKey = 'topic_id';

    protected $fillable = [
        'user_id',
        'title'
    ];

    // Quan hệ với User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Quan hệ với ForumPost
    public function posts()
    {
        return $this->hasMany(ForumPost::class, 'topic_id');
    }
}
