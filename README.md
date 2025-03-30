# Website Ôn Thi Trắc Nghiệm Tiếng Anh Bằng PHP Laravel

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

## Giới thiệu
Dự án này là một ứng dụng web được xây dựng bằng PHP và framework Laravel, cung cấp nền tảng cho người dùng ôn luyện tiếng Anh thông qua các bài thi trắc nghiệm trực tuyến. Dự án bao gồm các chức năng cho cả người dùng thông thường và quản trị viên (Admin).

## Các chức năng chính

**Người dùng:**

* Đăng ký và đăng nhập tài khoản.
* Tham gia các bài thi trắc nghiệm tiếng Anh.
* Xem kết quả thi chi tiết sau mỗi lần thi.
* Theo dõi lịch sử các lần thi đã thực hiện.
* Xem bảng xếp hạng người dùng dựa trên điểm số.
* Tham gia trao đổi, thảo luận câu hỏi trên diễn đàn.

**Admin:**

* Quản lý phân quyền người dùng (gán vai trò admin).
* Thêm, chỉnh sửa và xóa câu hỏi trắc nghiệm cùng các đáp án.
* Xem báo cáo thống kê về hoạt động của người dùng và hệ thống.
* Thêm các danh mục đề thi (ví dụ: Ngữ pháp, Từ vựng, Đọc hiểu).
* Tạo và quản lý các đề thi, bao gồm việc định cấu trúc số lượng câu hỏi theo độ khó (dễ, trung bình, khó).
* Tự động hóa việc chọn ngẫu nhiên câu hỏi từ ngân hàng câu hỏi theo cấu trúc đề thi đã định.

## Công nghệ sử dụng
* PHP >= 8.1
* Laravel Framework (Phiên bản mới nhất hoặc phiên bản dự án đang dùng)
* MySQL / MariaDB Database
* Blade (Template Engine)
* HTML5, CSS3, JavaScript (ES6+)
* Bootstrap (Frontend Framework - hoặc framework khác nếu sử dụng)
* Composer (Quản lý dependency PHP)
* Node.js & NPM (Quản lý dependency Frontend & Build tools)
* Vite / Laravel Mix (Build frontend assets)

## Yêu cầu hệ thống
* PHP >= 8.1
* Composer
* MySQL >= 5.7 hoặc MariaDB >= 10.3
* Node.js & NPM

## Cài đặt dự án
1.  **Clone repository:**
    ```bash
    git clone [https://github.com/nguyenduccanh011/Website_On_Thi_Trac_Nghiem_PHP_Lavarel.git](https://github.com/nguyenduccanh011/Website_On_Thi_Trac_Nghiem_PHP_Lavarel.git)
    ```

2.  **Di chuyển vào thư mục dự án:**
    ```bash
    cd Website_On_Thi_Trac_Nghiem_PHP_Lavarel
    ```

3.  **Cài đặt PHP dependencies:**
    ```bash
    composer install
    ```

4.  **Cài đặt Node.js dependencies:**
    ```bash
    npm install
    ```

5.  **Tạo file môi trường .env:**
    Sao chép file `.env.example` thành `.env`.
    ```bash
    cp .env.example .env
    ```

6.  **Tạo key cho ứng dụng:**
    ```bash
    php artisan key:generate
    ```

7.  **Cấu hình database trong file .env:**
    Mở file `.env` và cập nhật thông tin kết nối cơ sở dữ liệu của bạn.
    ```dotenv
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=exam_online  # Thay bằng tên database của bạn
    DB_USERNAME=root         # Thay bằng username database của bạn
    DB_PASSWORD=             # Thay bằng password database của bạn
    ```

8.  **Chạy migrations để tạo cấu trúc bảng:**
    (Đảm bảo bạn đã tạo database `exam_online` trong MySQL/MariaDB trước đó)
    ```bash
    php artisan migrate
    ```

9.  **(Tùy chọn) Chạy seeders để thêm dữ liệu mẫu (nếu có):**
    ```bash
    php artisan db:seed
    ```

10. **Biên dịch assets frontend:**
    ```bash
    npm run dev
    ```
    (Hoặc `npm run build` cho môi trường production)

11. **Khởi chạy server phát triển:**
    ```bash
    php artisan serve
    ```
    Ứng dụng sẽ chạy tại địa chỉ `http://127.0.0.1:8000` (hoặc cổng khác nếu 8000 đã được sử dụng).

## Cơ sở dữ liệu

* **Hệ quản trị cơ sở dữ liệu:** MySQL / MariaDB
* **Tên Database (mặc định):** `exam_online`

* **Cấu trúc các bảng:** (Dựa trên SQL dump cung cấp)

    * **`users`:** Lưu thông tin người dùng
        * `user_id` (`INT`, PRIMARY KEY, AUTO_INCREMENT)
        * `username` (`VARCHAR(50)`, UNIQUE, NOT NULL)
        * `password` (`VARCHAR(255)`, NOT NULL) - *Đã được hash*
        * `email` (`VARCHAR(100)`, UNIQUE, NOT NULL)
        * `full_name` (`VARCHAR(100)`)
        * `registration_date` (`DATETIME`, DEFAULT NULL)
        * `last_login` (`DATETIME`, DEFAULT NULL)
        * `role` (`ENUM('user', 'admin')`, DEFAULT 'user')
        * `profile_picture` (`VARCHAR(255)`, DEFAULT NULL)
        * `resetToken` (`VARCHAR(255)`, DEFAULT NULL)
        * `resetTokenExpires` (`DATETIME`, DEFAULT NULL)
        * `createdAt` (`DATETIME`, NOT NULL) - *Lưu ý: Laravel mặc định dùng `created_at`*
        * `updatedAt` (`DATETIME`, NOT NULL) - *Lưu ý: Laravel mặc định dùng `updated_at`*

    * **`exam_categories`:** Lưu trữ thông tin về các danh mục đề thi
        * `category_id` (`INT`, PRIMARY KEY, AUTO_INCREMENT)
        * `category_name` (`VARCHAR(100)`, UNIQUE, NOT NULL)
        * `description` (`TEXT`, DEFAULT NULL)
        * `created_at` (`DATETIME`, DEFAULT NULL)
        * `updated_at` (`DATETIME`, DEFAULT NULL)

    * **`questions`:** Lưu trữ các câu hỏi trắc nghiệm
        * `question_id` (`INT`, PRIMARY KEY, AUTO_INCREMENT)
        * `question_text` (`TEXT`, NOT NULL)
        * `correct_answer` (`VARCHAR(255)`, NOT NULL) - *Lưu ý: Có thể lưu text đáp án đúng để hiển thị nhanh, việc check đúng/sai nên dựa vào bảng `answers`*
        * `category_id` (`INT`, NOT NULL, FOREIGN KEY `exam_categories`)
        * `difficulty` (`ENUM('easy', 'medium', 'hard')`, DEFAULT NULL)
        * `explanation` (`TEXT`, DEFAULT NULL)
        * `created_at` (`DATETIME`, DEFAULT NULL)
        * `updated_at` (`DATETIME`, DEFAULT NULL)

    * **`answers`:** Lưu trữ các đáp án của câu hỏi
        * `answer_id` (`INT`, PRIMARY KEY, AUTO_INCREMENT)
        * `answer_text` (`VARCHAR(255)`, NOT NULL)
        * `question_id` (`INT`, NOT NULL, FOREIGN KEY `questions`)
        * `is_correct` (`TINYINT(1)`, NOT NULL, DEFAULT 0) - *1 là đúng, 0 là sai*
        * `created_at` (`DATETIME`, DEFAULT NULL)
        * `updated_at` (`DATETIME`, DEFAULT NULL)

    * **`exams`:** Lưu trữ thông tin về các đề thi
        * `exam_id` (`INT`, PRIMARY KEY, AUTO_INCREMENT)
        * `exam_name` (`VARCHAR(100)`, NOT NULL)
        * `easy_question_count` (`INT`, DEFAULT 0) - *Số câu dễ trong đề*
        * `medium_question_count` (`INT`, DEFAULT 0) - *Số câu trung bình trong đề*
        * `hard_question_count` (`INT`, DEFAULT 0) - *Số câu khó trong đề*
        * `description` (`TEXT`, DEFAULT NULL)
        * `category_id` (`INT`, NOT NULL, FOREIGN KEY `exam_categories`)
        * `created_at` (`DATETIME`, DEFAULT NULL)
        * `updated_at` (`DATETIME`, DEFAULT NULL)

    * **`exam_questions`:** Quan hệ nhiều-nhiều giữa `exams` và `questions` (Lưu các câu hỏi *cụ thể* được chọn cho một lần làm bài thi, có thể được tạo động khi bắt đầu thi)
        * `exam_question_id` (`INT`, PRIMARY KEY, AUTO_INCREMENT)
        * `exam_id` (`INT`, NOT NULL, FOREIGN KEY `exams`) - *Tham chiếu đến đề thi gốc*
        * `question_id` (`INT`, NOT NULL, FOREIGN KEY `questions`)
        * `question_order` (`INT`, DEFAULT NULL) - *Thứ tự câu hỏi trong lần thi cụ thể đó*
        * `createdAt` (`DATETIME`, NOT NULL)
        * `updatedAt` (`DATETIME`, NOT NULL)
        * *Lưu ý: Bảng này có thể cần được xem xét lại logic. Nếu `exams` đã định nghĩa cấu trúc (số câu dễ/TB/khó), thì bảng này có thể dùng để lưu tập câu hỏi *ngẫu nhiên* được tạo ra cho *một lần làm bài cụ thể* (`exam_attempts`) thay vì liên kết trực tiếp với `exams`.*

    * **`exam_attempts`:** Lưu trữ thông tin về các lần thi của người dùng
        * `attempt_id` (`INT`, PRIMARY KEY, AUTO_INCREMENT)
        * `user_id` (`INT`, NOT NULL, FOREIGN KEY `users`)
        * `exam_id` (`INT`, NOT NULL, FOREIGN KEY `exams`) - *Tham chiếu đến đề thi gốc*
        * `start_time` (`DATETIME`, DEFAULT NULL)
        * `end_time` (`DATETIME`, DEFAULT NULL)
        * `score` (`DECIMAL(5, 2)`, DEFAULT NULL)
        * `total_questions` (`INT`, DEFAULT NULL) - *Tổng số câu trong lần thi đó*
        * `correct_answers` (`INT`, DEFAULT NULL) - *Số câu trả lời đúng*
        * `incorrect_answers` (`INT`, DEFAULT NULL) - *Số câu trả lời sai*
        * `createdAt` (`DATETIME`, NOT NULL)
        * `updatedAt` (`DATETIME`, NOT NULL)

    * **`user_answers`:** Lưu trữ chi tiết câu trả lời của người dùng trong mỗi lần thi
        * `user_answer_id` (`INT`, PRIMARY KEY, AUTO_INCREMENT)
        * `attempt_id` (`INT`, NOT NULL, FOREIGN KEY `exam_attempts`)
        * `question_id` (`INT`, NOT NULL, FOREIGN KEY `questions`)
        * `selected_answer` (`VARCHAR(255)`, DEFAULT NULL) - *Lưu ID hoặc text của đáp án người dùng chọn*
        * `is_correct` (`TINYINT(1)`, DEFAULT NULL) - *Lưu kết quả đúng/sai của câu trả lời này*
        * `createdAt` (`DATETIME`, NOT NULL)
        * `updatedAt` (`DATETIME`, NOT NULL)

    * **`leaderboard`:** Lưu trữ thông tin bảng xếp hạng người dùng
        * `leaderboard_id` (`INT`, PRIMARY KEY, AUTO_INCREMENT)
        * `user_id` (`INT`, NOT NULL, FOREIGN KEY `users`)
        * `score` (`DECIMAL(10, 2)`, DEFAULT NULL) - *Có thể là điểm trung bình hoặc cao nhất*
        * `rank` (`INT`, DEFAULT NULL)
        * `last_attempt_date` (`DATETIME`, DEFAULT NULL)
        * `createdAt` (`DATETIME`, NOT NULL)
        * `updatedAt` (`DATETIME`, NOT NULL)

    * **`forum_topics`:** Lưu trữ các chủ đề thảo luận trên diễn đàn
        * `topic_id` (`INT`, PRIMARY KEY, AUTO_INCREMENT)
        * `user_id` (`INT`, NOT NULL, FOREIGN KEY `users`)
        * `title` (`VARCHAR(255)`, NOT NULL)
        * `created_at` (`DATETIME`, DEFAULT NULL)
        * `updated_at` (`DATETIME`, DEFAULT NULL)

    * **`forum_posts`:** Lưu trữ các bài viết trong từng chủ đề thảo luận
        * `post_id` (`INT`, PRIMARY KEY, AUTO_INCREMENT)
        * `topic_id` (`INT`, NOT NULL, FOREIGN KEY `forum_topics`)
        * `user_id` (`INT`, NOT NULL, FOREIGN KEY `users`)
        * `content` (`TEXT`, NOT NULL)
        * `created_at` (`DATETIME`, DEFAULT NULL)
        * `updated_at` (`DATETIME`, DEFAULT NULL)

## Giao diện người dùng (dự kiến)

* **Công nghệ Frontend:** Blade Templates, Bootstrap, JavaScript.
* **Các trang giao diện chính:**
    * **Trang chủ:** Giới thiệu về website, có thể hiển thị các đề thi nổi bật, thông tin chung.
    * **Trang đăng ký/đăng nhập:** Form cho người dùng tạo tài khoản hoặc đăng nhập.
    * **Trang danh sách đề thi:** Hiển thị danh sách các đề thi có sẵn, có thể lọc theo danh mục (`exam_categories`).
    * **Trang làm bài thi:** Giao diện hiển thị câu hỏi, các lựa chọn, thời gian làm bài (nếu có).
    * **Trang kết quả thi:** Hiển thị điểm số, số câu đúng/sai, đáp án chi tiết sau khi hoàn thành (`exam_attempts`, `user_answers`).
    * **Trang lịch sử thi:** Cho phép người dùng xem lại các lần thi trước đó (`exam_attempts`).
    * **Trang bảng xếp hạng:** Hiển thị danh sách người dùng có điểm số cao nhất (`leaderboard`).
    * **Trang diễn đàn:** Nơi người dùng có thể xem, tạo chủ đề (`forum_topics`) và bình luận (`forum_posts`).
    * **Trang quản trị (Admin Dashboard):** Giao diện quản lý dành cho admin, bao gồm các chức năng quản lý người dùng, câu hỏi, đề thi, danh mục, xem báo cáo, v.v.

## Quy tắc lập trình

### 1. Cấu trúc thư mục (Laravel Standard)
* `app/Http/Controllers`: Chứa các controller xử lý request.
* `app/Models`: Chứa các Eloquent model tương tác với database.
* `resources/views`: Chứa các file Blade template cho giao diện.
* `database/migrations`: Chứa các file migration quản lý schema database.
* `database/seeders`: Chứa các file seeder để tạo dữ liệu mẫu.
* `routes`: Chứa các file định nghĩa route (web.php, api.php).
* `public`: Thư mục gốc web, chứa file index.php và các assets đã biên dịch.
* `resources/js`, `resources/css`: Chứa source code JavaScript và CSS/SCSS.

### 2. Quy ước đặt tên
* **Controller:** PascalCase, số ít, kết thúc bằng `Controller` (ví dụ: `ExamController`, `UserProfileController`).
* **Model:** PascalCase, số ít, trùng tên bảng (nếu tuân thủ convention) (ví dụ: `User`, `Exam`, `Question`).
* **Migration:** snake_case, mô tả hành động và bảng (ví dụ: `create_users_table`, `add_role_to_users_table`).
* **View:** snake_case.blade.php (ví dụ: `exams/index.blade.php`, `user/profile.blade.php`).
* **Route Name:** snake_case hoặc kebab-case (ví dụ: `users.profile`, `exam-attempts.show`).
* **Database Table:** snake_case, số nhiều (ví dụ: `users`, `exam_attempts`).
* **Database Column:** snake_case (ví dụ: `user_id`, `full_name`, `created_at`).
* **Biến PHP:** camelCase (ví dụ: `$userName`, `$examList`).
* **Hàm/Method PHP:** camelCase (ví dụ: `getUserExams()`, `calculateScore()`).

### 3. Code Style
* Tuân thủ chuẩn **PSR-12** cho code PHP. Sử dụng công cụ như PHP CS Fixer hoặc Larastan để kiểm tra.
* Sử dụng 4 spaces cho indentation (thụt lề).
* Comment code rõ ràng, giải thích các logic phức tạp. Sử dụng tiếng Việt có dấu khi cần thiết trong comment hoặc tài liệu.
* Giữ cho các phương thức (methods) và hàm (functions) ngắn gọn, thực hiện một nhiệm vụ cụ thể (Single Responsibility Principle).

### 4. Git Workflow
* **Branch chính:** `main` (hoặc `master`) - Chứa code production ổn định.
* **Branch phát triển:** `develop` - Chứa code đang phát triển, tích hợp các tính năng.
* **Feature branches:** `feature/ten-tinh-nang` (ví dụ: `feature/exam-creation`, `feature/user-forum`) - Phát triển tính năng mới từ `develop`.
* **Bugfix branches:** `bugfix/ten-bug` (ví dụ: `bugfix/login-error`, `bugfix/score-calculation`) - Sửa lỗi từ `main` hoặc `develop`.
* **Commit message:** Rõ ràng, ngắn gọn, mô tả thay đổi. Nên viết bằng tiếng Anh theo convention (ví dụ: `feat: Add user registration functionality`, `fix: Correct score calculation logic`). Nếu team thống nhất có thể dùng tiếng Việt.
* **Pull Request (PR):** Tạo PR từ feature/bugfix branch vào `develop` (hoặc `main` cho hotfix). PR cần mô tả rõ ràng, được review bởi thành viên khác trước khi merge.

### 5. Bảo mật
* **KHÔNG BAO GIỜ** commit file `.env` lên repository.
* Sử dụng cơ chế hash của Laravel (Bcrypt) để **mã hóa mật khẩu** người dùng trước khi lưu (`Hash::make()`).
* Sử dụng **CSRF protection** cho tất cả các form POST, PUT, DELETE. Laravel bật mặc định cho web routes.
* **Validate** tất cả dữ liệu đầu vào từ người dùng (Request Validation).
* Sử dụng **Eloquent Mass Assignment Protection** (`$fillable` hoặc `$guarded` trong Model).
* **Escape** dữ liệu đầu ra khi hiển thị trên HTML để chống XSS (Blade tự động escape với `{{ }}`). Sử dụng `{!! !!}` cẩn thận.
* Sử dụng **Authorization** (Gates, Policies) để kiểm soát quyền truy cập của người dùng vào các tài nguyên và hành động.
* Cập nhật các thư viện (Composer, NPM) thường xuyên để vá lỗi bảo mật.

## Đóng góp
Mọi đóng góp để cải thiện dự án đều được chào đón. Vui lòng tuân thủ quy trình sau:
1.  Fork dự án về tài khoản GitHub của bạn.
2.  Tạo một branch mới từ `develop` cho tính năng hoặc sửa lỗi của bạn (`git checkout -b feature/your-feature-name` hoặc `bugfix/your-bug-name`).
3.  Thực hiện các thay đổi và commit code.
4.  Push branch của bạn lên repository đã fork (`git push origin your-branch-name`).
5.  Tạo một Pull Request từ branch của bạn vào branch `develop` của repository gốc. Mô tả rõ ràng những thay đổi bạn đã thực hiện.

## Tác giả
* **Nguyễn Đức Cảnh** - [nguyenduccanh011](https://github.com/nguyenduccanh011)
* **Lê Công Chức** - 
* **Trần LiêU Huy Khánh** -
* **Trần Lê Bảo Trung** - 
* **Phan Trọng Thuận** - 




## License
Dự án này được phân phối dưới giấy phép MIT. Xem file `LICENSE` để biết thêm chi tiết.

1. Tạo database mới:
php artisan db:create

2. Chạy lại tất cả các migration:
php artisan migrate:fresh

3. Chạy seeder để tạo dữ liệu mẫu:
php artisan db:seed

4. Xóa cache:
php artisan config:clear
php artisan cache:clear