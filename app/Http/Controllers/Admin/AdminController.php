<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Exam;
use App\Models\Question;
use App\Models\ExamAttempt;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_exams' => Exam::count(),
            'total_questions' => Question::count(),
            'total_attempts' => ExamAttempt::count(),
            'recent_attempts' => ExamAttempt::with(['user', 'exam'])
                ->latest()
                ->take(5)
                ->get()
        ];

        return view('admin.dashboard', compact('stats'));
    }
} 