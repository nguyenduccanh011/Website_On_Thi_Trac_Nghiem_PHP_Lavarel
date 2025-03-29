# Website Ôn Thi Trắc Nghiệm PHP Laravel

## Giới thiệu
Dự án website ôn thi trắc nghiệm được xây dựng bằng PHP Laravel, giúp người dùng có thể ôn tập và kiểm tra kiến thức thông qua các bài thi trắc nghiệm trực tuyến.

## Công nghệ sử dụng
- PHP 8.x
- Laravel Framework
- MySQL Database
- HTML, CSS, JavaScript
- Bootstrap (Frontend Framework)

## Yêu cầu hệ thống
- PHP >= 8.1
- Composer
- MySQL >= 5.7
- Node.js & NPM

## Cài đặt dự án
1. Clone repository
```bash
git clone https://github.com/nguyenduccanh011/Website_On_Thi_Trac_Nghiem_PHP_Lavarel.git
```

2. Cài đặt dependencies
```bash
composer install
npm install
```

3. Tạo file .env
```bash
cp .env.example .env
```

4. Tạo key cho ứng dụng
```bash
php artisan key:generate
```

5. Cấu hình database trong file .env
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

6. Chạy migration
```bash
php artisan migrate
```

7. Chạy dự án
```bash
php artisan serve
npm run dev
```

## Quy tắc lập trình

### 1. Cấu trúc thư mục
- `app/Http/Controllers`: Chứa các controller
- `app/Models`: Chứa các model
- `resources/views`: Chứa các file blade template
- `database/migrations`: Chứa các file migration
- `routes`: Chứa các file định tuyến
- `public`: Chứa các file tĩnh

### 2. Quy ước đặt tên
- Controller: PascalCase, kết thúc bằng Controller (ví dụ: UserController)
- Model: Số ít, PascalCase (ví dụ: User)
- Migration: snake_case, bắt đầu bằng timestamp (ví dụ: create_users_table)
- View: snake_case.blade.php (ví dụ: user_profile.blade.php)
- Route: snake_case (ví dụ: user-profile)

### 3. Code Style
- Sử dụng PSR-12 cho PHP
- Sử dụng 4 spaces cho indentation
- Đặt tên biến và hàm theo camelCase
- Đặt tên class theo PascalCase
- Comment code rõ ràng, sử dụng tiếng Việt khi cần thiết

### 4. Git Workflow
- Branch chính: master
- Branch phát triển: develop
- Tạo branch mới cho mỗi tính năng: feature/tên-tính-năng
- Tạo branch mới cho mỗi bugfix: bugfix/tên-bug
- Commit message rõ ràng, viết bằng tiếng Việt
- Pull request phải được review trước khi merge

### 5. Bảo mật
- Không commit file .env
- Mã hóa password trước khi lưu vào database
- Sử dụng CSRF token cho form
- Validate dữ liệu đầu vào
- Escape dữ liệu đầu ra

## Đóng góp
Mọi đóng góp đều được chào đón. Vui lòng:
1. Fork dự án
2. Tạo branch mới cho tính năng của bạn
3. Commit các thay đổi
4. Push lên branch
5. Tạo Pull Request

## Tác giả
- Nguyễn Đức Cảnh

## License
Dự án được phân phối dưới giấy phép MIT.
