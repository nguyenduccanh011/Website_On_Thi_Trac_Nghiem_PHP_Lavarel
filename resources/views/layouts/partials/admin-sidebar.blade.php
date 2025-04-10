<!-- Sidebar -->
<div class="sidebar">
    <div class="p-3">
        <h4 class="text-center mb-4">Admin Panel</h4>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                    <i class="fas fa-users"></i> Quản lý người dùng
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.questions.*') ? 'active' : '' }}" href="{{ route('admin.questions.index') }}">
                    <i class="fas fa-question-circle"></i> Quản lý câu hỏi
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                    <i class="fas fa-folder"></i> Quản lý danh mục
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.exams.*') ? 'active' : '' }}" href="{{ route('admin.exams.index') }}">
                    <i class="fas fa-file-alt"></i> Quản lý đề thi
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.exam-banks.*') ? 'active' : '' }}" href="{{ route('admin.exam-banks.index') }}">
                    <i class="fas fa-database"></i> Ngân hàng đề thi
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}">
                    <i class="fas fa-chart-bar"></i> Báo cáo thống kê
                </a>
            </li>
        </ul>
    </div>
</div> 