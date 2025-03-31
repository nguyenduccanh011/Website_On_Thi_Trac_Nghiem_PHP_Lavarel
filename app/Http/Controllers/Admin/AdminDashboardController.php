<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\User;
use App\Models\ExamAttempt;
use App\Models\Question;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Lấy thống kê tổng quan
        $totalUsers = User::where('role', 'user')->count();
        $totalExams = Exam::count();
        $totalQuestions = Question::count();
        $totalAttempts = ExamAttempt::count();

        // Lấy 5 bài thi gần đây
        $recentExams = Exam::latest()->take(5)->get();

        // Lấy 5 người dùng mới nhất
        $recentUsers = User::where('role', 'user')
            ->latest()
            ->take(5)
            ->get();

        // Lấy 5 lần thi gần đây
        $recentAttempts = ExamAttempt::with(['user', 'exam'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalExams',
            'totalQuestions',
            'totalAttempts',
            'recentExams',
            'recentUsers',
            'recentAttempts'
        ));
    }
}
