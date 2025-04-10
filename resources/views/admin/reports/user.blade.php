@extends('layouts.admin')

@section('title', 'Báo Cáo Chi Tiết Người Dùng')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Báo Cáo Chi Tiết Người Dùng: {{ $user->name }}</h1>
        <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay Lại
        </a>
    </div>

    <!-- Thống kê tổng quan -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Tổng Số Lần Làm</h5>
                    <h2 class="card-text">{{ $stats['total_attempts'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Điểm Trung Bình</h5>
                    <h2 class="card-text">{{ number_format($stats['average_score'], 2) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Điểm Cao Nhất</h5>
                    <h2 class="card-text">{{ number_format($stats['highest_score'], 2) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">Tỷ Lệ Đạt</h5>
                    <h2 class="card-text">{{ number_format($stats['pass_rate'], 1) }}%</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Chi tiết các lần làm bài -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Chi Tiết Các Lần Làm Bài</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên Đề Thi</th>
                            <th>Điểm</th>
                            <th>Thời Gian Làm</th>
                            <th>Trạng Thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attempts as $attempt)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $attempt->exam->exam_name }}</td>
                                <td>{{ number_format($attempt->score, 2) }}</td>
                                <td>{{ $attempt->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    @if($attempt->score >= $attempt->exam->passing_marks)
                                        <span class="badge bg-success">Đạt</span>
                                    @else
                                        <span class="badge bg-danger">Không Đạt</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Người dùng này chưa làm bài thi nào</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 