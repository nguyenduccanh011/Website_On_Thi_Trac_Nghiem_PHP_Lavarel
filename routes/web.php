<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ExamAttemptController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminExamController;
use App\Http\Controllers\Admin\AdminQuestionController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminExamBankController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');

// Đăng nhập
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Đăng ký
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Các route yêu cầu đăng nhập
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Quản lý câu hỏi
    Route::resource('questions', QuestionController::class);

    // Quản lý bài thi
    Route::resource('exams', ExamController::class);

    // Làm bài thi
    Route::get('/exam-attempts/create/{exam}', [ExamAttemptController::class, 'create'])->name('exam-attempts.create');
    Route::get('/exam-attempts/{attempt}', [ExamAttemptController::class, 'show'])->name('exam-attempts.show');
    Route::post('/exam-attempts/{attempt}/submit', [ExamAttemptController::class, 'submit'])->name('exam-attempts.submit');
    Route::get('/exam-attempts', [ExamAttemptController::class, 'index'])->name('exam-attempts.index');

    // Routes cho Leaderboard
    Route::resource('leaderboard', LeaderboardController::class)->only(['index', 'show']);
});

// Routes cho Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [AdminProfileController::class, 'updatePassword'])->name('profile.password');
    
    // Quản lý người dùng
    Route::resource('users', AdminUserController::class);
    
    // Quản lý danh mục
    Route::resource('categories', AdminCategoryController::class);
    
    // Quản lý ngân hàng câu hỏi
    Route::resource('exam-banks', AdminExamBankController::class);
    
    // Quản lý câu hỏi
    Route::resource('questions', AdminQuestionController::class);
    
    // Quản lý đề thi
    Route::resource('exams', AdminExamController::class);
    
    // Quản lý báo cáo
    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
});
