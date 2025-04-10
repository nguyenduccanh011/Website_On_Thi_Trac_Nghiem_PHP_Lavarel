@extends('layouts.admin')

@section('title', 'Báo Cáo Thống Kê')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Báo Cáo Thống Kê</h1>

    <!-- Thống kê tổng quan -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Tổng Số Người Dùng</h5>
                    <h2 class="card-text">{{ $totalUsers }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Tổng Số Đề Thi</h5>
                    <h2 class="card-text">{{ $totalExams }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Tổng Số Lần Làm Bài</h5>
                    <h2 class="card-text">{{ $totalAttempts }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Thống kê bài thi -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Thống Kê Bài Thi</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tên Đề Thi</th>
                            <th>Số Lần Làm</th>
                            <th>Điểm Trung Bình</th>
                            <th>Chi Tiết</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($examStats as $exam)
                            <tr>
                                <td>{{ $exam->exam_name }}</td>
                                <td>{{ $exam->total_attempts }}</td>
                                <td>{{ number_format($exam->average_score, 2) }}</td>
                                <td>
                                    <a href="{{ route('admin.reports.exam', $exam->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-chart-bar"></i> Xem Chi Tiết
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Chưa có dữ liệu</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Thống kê người dùng -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Thống Kê Người Dùng</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tên Người Dùng</th>
                            <th>Số Lần Làm Bài</th>
                            <th>Điểm Trung Bình</th>
                            <th>Chi Tiết</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($userStats as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->total_attempts }}</td>
                                <td>{{ number_format($user->average_score, 2) }}</td>
                                <td>
                                    <a href="{{ route('admin.reports.user', $user->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-chart-bar"></i> Xem Chi Tiết
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Chưa có dữ liệu</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Thống kê theo thời gian -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Thống Kê Theo Thời Gian</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Ngày</th>
                            <th>Số Lần Làm Bài</th>
                            <th>Điểm Trung Bình</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attemptsByDate as $attempt)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($attempt->date)->format('d/m/Y') }}</td>
                                <td>{{ $attempt->total_attempts }}</td>
                                <td>{{ number_format($attempt->average_score, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">Chưa có dữ liệu</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 