<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumPost extends Model
{
    use HasFactory;

    protected $primaryKey = 'post_id';

    protected $fillable = [
        'topic_id',
        'user_id',
        'content'
    ];

    // Quan hệ với User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Quan hệ với ForumTopic
    public function topic()
    {
        return $this->belongsTo(ForumTopic::class, 'topic_id');
    }
}
