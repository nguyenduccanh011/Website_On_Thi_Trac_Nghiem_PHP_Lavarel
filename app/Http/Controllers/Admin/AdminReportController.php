<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminReportController extends Controller
{
    public function index()
    {
        // Thống kê tổng quan
        $totalUsers = User::count();
        $totalExams = Exam::count();
        $totalAttempts = ExamAttempt::count();
        
        // Thống kê bài thi
        $examStats = Exam::select([
            'exams.id',
            'exams.title',
            'exams.description',
            'exams.duration',
            'exams.total_marks',
            'exams.passing_marks',
            'exams.is_active',
            DB::raw('COUNT(exam_attempts.id) as total_attempts'),
            DB::raw('AVG(exam_attempts.score) as average_score')
        ])
        ->leftJoin('exam_attempts', 'exams.id', '=', 'exam_attempts.exam_id')
        ->groupBy(
            'exams.id',
            'exams.title',
            'exams.description',
            'exams.duration',
            'exams.total_marks',
            'exams.passing_marks',
            'exams.is_active'
        )
        ->get();

        // Thống kê người dùng
        $userStats = User::select([
            'users.id',
            'users.name',
            'users.email',
            DB::raw('COUNT(exam_attempts.id) as total_attempts'),
            DB::raw('AVG(exam_attempts.score) as average_score')
        ])
        ->leftJoin('exam_attempts', 'users.id', '=', 'exam_attempts.user_id')
        ->groupBy('users.id', 'users.name', 'users.email')
        ->get();

        // Thống kê theo thời gian
        $attemptsByDate = ExamAttempt::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as total_attempts'),
            DB::raw('AVG(score) as average_score')
        )
        ->groupBy('date')
        ->orderBy('date', 'desc')
        ->limit(30)
        ->get();

        return view('admin.reports.index', compact(
            'totalUsers',
            'totalExams',
            'totalAttempts',
            'examStats',
            'userStats',
            'attemptsByDate'
        ));
    }

    public function examReport($id)
    {
        $exam = Exam::findOrFail($id);
        
        $attempts = ExamAttempt::where('exam_id', $id)
            ->with('user')
            ->orderBy('score', 'desc')
            ->get();

        $stats = [
            'total_attempts' => $attempts->count(),
            'average_score' => $attempts->avg('score'),
            'highest_score' => $attempts->max('score'),
            'lowest_score' => $attempts->min('score'),
            'pass_rate' => $attempts->where('score', '>=', $exam->passing_marks)->count() / max(1, $attempts->count()) * 100
        ];

        return view('admin.reports.exam', compact('exam', 'attempts', 'stats'));
    }

    public function userReport($id)
    {
        $user = User::findOrFail($id);
        
        $attempts = ExamAttempt::where('user_id', $id)
            ->with('exam')
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'total_attempts' => $attempts->count(),
            'average_score' => $attempts->avg('score'),
            'highest_score' => $attempts->max('score'),
            'lowest_score' => $attempts->min('score'),
            'pass_rate' => $attempts->where('score', '>=', function($query) {
                return $query->select('passing_marks')
                    ->from('exams')
                    ->whereColumn('exams.id', 'exam_attempts.exam_id');
            })->count() / max(1, $attempts->count()) * 100
        ];

        return view('admin.reports.user', compact('user', 'attempts', 'stats'));
    }
} 