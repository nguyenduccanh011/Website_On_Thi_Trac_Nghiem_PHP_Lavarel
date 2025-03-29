<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Quan hệ với ExamAttempt
    public function examAttempts()
    {
        return $this->hasMany(ExamAttempt::class, 'user_id');
    }

    // Quan hệ với ForumTopic
    public function forumTopics()
    {
        return $this->hasMany(ForumTopic::class, 'user_id');
    }

    // Quan hệ với ForumPost
    public function forumPosts()
    {
        return $this->hasMany(ForumPost::class, 'user_id');
    }

    // Quan hệ với Leaderboard
    public function leaderboardEntry()
    {
        return $this->hasOne(Leaderboard::class, 'user_id');
    }

    // Kiểm tra xem user có phải là admin không
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
