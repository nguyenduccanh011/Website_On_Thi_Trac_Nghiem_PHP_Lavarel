-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 14, 2025 lúc 04:54 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `exam_online_php`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`category_id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'TOEIC', 'toeic', 'Đề thi TOEIC', '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(2, 'IELTS', 'ielts', 'Đề thi IELTS', '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(3, 'TOEFL', 'toefl', 'Đề thi TOEFL', '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(4, 'Business English', 'business-english', 'Tiếng Anh thương mại', '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(5, 'General English', 'general-english', 'Tiếng Anh tổng quát', '2025-04-13 19:35:39', '2025-04-13 19:35:39');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `exams`
--

CREATE TABLE `exams` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `duration` int(11) NOT NULL DEFAULT 60,
  `total_marks` int(11) NOT NULL,
  `passing_marks` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `exams`
--

INSERT INTO `exams` (`id`, `title`, `description`, `category_id`, `duration`, `total_marks`, `passing_marks`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'TOEIC Full Practice Test 1', 'Bài thi TOEIC đầy đủ với 200 câu hỏi theo format chuẩn (100 Listening, 100 Reading)', 1, 120, 990, 450, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(2, 'TOEIC Reading Practice Test 1', 'Bài thi TOEIC Reading với 100 câu hỏi (Part 5, 6, 7)', 1, 75, 495, 225, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(3, 'TOEIC Listening Practice Test 1', 'Bài thi TOEIC Listening với 100 câu hỏi (Part 1, 2, 3, 4)', 1, 45, 495, 225, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(4, 'IELTS Academic Reading Test 1', 'Bài thi IELTS Academic Reading với 3 passages và 40 câu hỏi', 2, 60, 40, 20, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(5, 'IELTS General Reading Test 1', 'Bài thi IELTS General Reading với 3 sections và 40 câu hỏi', 2, 60, 40, 20, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(6, 'IELTS Writing Practice Task 1', 'Bài tập IELTS Writing Task 1 với các dạng biểu đồ và bảng', 2, 20, 9, 5, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(7, 'IELTS Writing Practice Task 2', 'Bài tập IELTS Writing Task 2 với các chủ đề essay', 2, 40, 9, 5, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(8, 'TOEFL Reading Practice Test 1', 'Bài thi TOEFL Reading với 3-4 passages và 30-40 câu hỏi', 3, 54, 30, 15, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(9, 'TOEFL Listening Practice Test 1', 'Bài thi TOEFL Listening với 28-39 câu hỏi (Lectures & Conversations)', 3, 41, 30, 15, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(10, 'Business Communication Test 1', 'Kiểm tra kỹ năng giao tiếp trong môi trường kinh doanh', 4, 45, 50, 30, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(11, 'Business Writing Test 1', 'Kiểm tra kỹ năng viết thư tín thương mại', 4, 45, 50, 30, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(12, 'Grammar Test - Intermediate', 'Bài kiểm tra ngữ pháp tiếng Anh trình độ trung cấp', 5, 30, 40, 24, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(13, 'Vocabulary Test - Advanced', 'Bài kiểm tra từ vựng tiếng Anh trình độ nâng cao', 5, 30, 40, 24, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `exam_attempts`
--

CREATE TABLE `exam_attempts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `exam_id` bigint(20) UNSIGNED NOT NULL,
  `start_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `end_time` timestamp NULL DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `total_questions` int(11) NOT NULL DEFAULT 0,
  `correct_answers` int(11) NOT NULL DEFAULT 0,
  `incorrect_answers` int(11) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'in_progress',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `exam_attempts`
--

INSERT INTO `exam_attempts` (`id`, `user_id`, `exam_id`, `start_time`, `end_time`, `score`, `total_questions`, `correct_answers`, `incorrect_answers`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2025-04-14 02:36:31', '2025-04-13 19:36:31', 330, 6, 2, 4, 'in_progress', '2025-04-13 19:36:17', '2025-04-13 19:36:31');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `exam_banks`
--

CREATE TABLE `exam_banks` (
  `bank_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `total_questions` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `exam_banks`
--

INSERT INTO `exam_banks` (`bank_id`, `name`, `slug`, `description`, `total_questions`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'TOEIC Reading Part 5 & 6', 'toeic-reading-part-5-6', 'Ngân hàng câu hỏi TOEIC Reading Part 5 & 6 - Incomplete Sentences & Text Completion', 8, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(2, 'TOEIC Reading Part 7', 'toeic-reading-part-7', 'Ngân hàng câu hỏi TOEIC Reading Part 7 - Reading Comprehension', 10, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(3, 'TOEIC Listening Part 1 & 2', 'toeic-listening-part-1-2', 'Ngân hàng câu hỏi TOEIC Listening Part 1 & 2 - Photographs & Question-Response', 6, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(4, 'TOEIC Listening Part 3 & 4', 'toeic-listening-part-3-4', 'Ngân hàng câu hỏi TOEIC Listening Part 3 & 4 - Conversations & Talks', 6, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(5, 'IELTS Academic Reading', 'ielts-academic-reading', 'Ngân hàng câu hỏi IELTS Academic Reading - Academic Texts', 9, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(6, 'IELTS General Reading', 'ielts-general-reading', 'Ngân hàng câu hỏi IELTS General Reading - Everyday Texts', 10, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(7, 'IELTS Writing Task 1', 'ielts-writing-task-1', 'Ngân hàng đề bài IELTS Writing Task 1 - Data Description', 7, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(8, 'IELTS Writing Task 2', 'ielts-writing-task-2', 'Ngân hàng đề bài IELTS Writing Task 2 - Essay Writing', 10, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(9, 'TOEFL Reading', 'toefl-reading', 'Ngân hàng câu hỏi TOEFL Reading - Academic Passages', 6, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(10, 'TOEFL Listening', 'toefl-listening', 'Ngân hàng câu hỏi TOEFL Listening - Lectures & Conversations', 5, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(11, 'Business Communication', 'business-communication', 'Ngân hàng câu hỏi về giao tiếp trong kinh doanh', 8, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(12, 'Business Writing', 'business-writing', 'Ngân hàng câu hỏi về viết thư tín thương mại', 8, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(13, 'Grammar Practice', 'grammar-practice', 'Ngân hàng câu hỏi ngữ pháp tiếng Anh tổng quát', 6, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(14, 'Vocabulary Builder', 'vocabulary-builder', 'Ngân hàng câu hỏi từ vựng tiếng Anh', 9, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `exam_bank_categories`
--

CREATE TABLE `exam_bank_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bank_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `exam_bank_questions`
--

CREATE TABLE `exam_bank_questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bank_id` bigint(20) UNSIGNED NOT NULL,
  `question_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `exam_bank_questions`
--

INSERT INTO `exam_bank_questions` (`id`, `bank_id`, `question_id`, `created_at`, `updated_at`) VALUES
(1, 1, 2, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(2, 1, 3, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(3, 1, 4, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(4, 1, 8, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(5, 1, 9, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(6, 1, 10, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(7, 1, 12, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(8, 1, 13, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(9, 2, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(10, 2, 2, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(11, 2, 3, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(12, 2, 4, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(13, 2, 6, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(14, 2, 8, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(15, 2, 9, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(16, 2, 10, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(17, 2, 11, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(18, 2, 12, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(19, 3, 2, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(20, 3, 3, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(21, 3, 5, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(22, 3, 6, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(23, 3, 10, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(24, 3, 12, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(25, 4, 4, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(26, 4, 6, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(27, 4, 7, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(28, 4, 9, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(29, 4, 10, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(30, 4, 11, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(31, 5, 2, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(32, 5, 3, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(33, 5, 5, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(34, 5, 7, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(35, 5, 8, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(36, 5, 9, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(37, 5, 10, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(38, 5, 11, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(39, 5, 12, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(40, 6, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(41, 6, 3, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(42, 6, 5, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(43, 6, 7, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(44, 6, 8, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(45, 6, 9, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(46, 6, 10, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(47, 6, 11, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(48, 6, 12, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(49, 6, 13, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(50, 7, 3, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(51, 7, 6, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(52, 7, 7, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(53, 7, 8, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(54, 7, 9, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(55, 7, 10, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(56, 7, 12, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(57, 8, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(58, 8, 2, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(59, 8, 4, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(60, 8, 6, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(61, 8, 8, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(62, 8, 9, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(63, 8, 10, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(64, 8, 11, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(65, 8, 12, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(66, 8, 13, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(67, 9, 3, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(68, 9, 4, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(69, 9, 7, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(70, 9, 9, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(71, 9, 10, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(72, 9, 13, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(73, 10, 2, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(74, 10, 5, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(75, 10, 7, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(76, 10, 8, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(77, 10, 10, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(78, 11, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(79, 11, 2, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(80, 11, 3, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(81, 11, 5, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(82, 11, 6, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(83, 11, 7, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(84, 11, 8, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(85, 11, 12, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(86, 12, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(87, 12, 2, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(88, 12, 3, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(89, 12, 6, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(90, 12, 9, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(91, 12, 10, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(92, 12, 11, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(93, 12, 13, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(94, 13, 3, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(95, 13, 4, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(96, 13, 6, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(97, 13, 10, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(98, 13, 11, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(99, 13, 13, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(100, 14, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(101, 14, 2, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(102, 14, 3, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(103, 14, 5, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(104, 14, 6, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(105, 14, 8, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(106, 14, 9, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(107, 14, 12, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(108, 14, 13, '2025-04-13 19:35:39', '2025-04-13 19:35:39');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `exam_categories`
--

CREATE TABLE `exam_categories` (
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `level` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `exam_questions`
--

CREATE TABLE `exam_questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `exam_id` bigint(20) UNSIGNED NOT NULL,
  `question_id` bigint(20) UNSIGNED NOT NULL,
  `order_index` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `exam_questions`
--

INSERT INTO `exam_questions` (`id`, `exam_id`, `question_id`, `order_index`, `created_at`, `updated_at`) VALUES
(1, 1, 5, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(2, 1, 6, 2, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(3, 1, 7, 3, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(4, 1, 8, 4, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(5, 1, 9, 5, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(6, 1, 10, 6, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(7, 2, 4, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(8, 2, 5, 2, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(9, 2, 6, 3, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(10, 2, 7, 4, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(11, 2, 9, 5, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(12, 2, 10, 6, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(13, 2, 11, 7, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(14, 2, 13, 8, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(15, 3, 2, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(16, 3, 3, 2, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(17, 3, 4, 3, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(18, 3, 5, 4, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(19, 3, 8, 5, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(20, 4, 1, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(21, 4, 2, 2, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(22, 4, 3, 3, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(23, 4, 4, 4, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(24, 4, 9, 5, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(25, 5, 4, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(26, 5, 5, 2, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(27, 5, 8, 3, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(28, 5, 10, 4, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(29, 5, 12, 5, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(30, 5, 13, 6, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(31, 6, 2, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(32, 6, 5, 2, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(33, 6, 6, 3, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(34, 6, 7, 4, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(35, 6, 11, 5, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(36, 6, 12, 6, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(37, 6, 13, 7, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(38, 7, 2, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(39, 7, 3, 2, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(40, 7, 4, 3, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(41, 7, 6, 4, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(42, 7, 9, 5, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(43, 7, 10, 6, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(44, 7, 13, 7, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(45, 8, 1, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(46, 8, 2, 2, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(47, 8, 3, 3, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(48, 8, 4, 4, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(49, 8, 5, 5, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(50, 8, 7, 6, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(51, 8, 8, 7, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(52, 8, 11, 8, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(53, 9, 1, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(54, 9, 3, 2, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(55, 9, 4, 3, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(56, 9, 6, 4, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(57, 9, 9, 5, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(58, 9, 10, 6, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(59, 9, 12, 7, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(60, 9, 13, 8, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(61, 10, 1, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(62, 10, 5, 2, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(63, 10, 6, 3, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(64, 10, 7, 4, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(65, 10, 8, 5, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(66, 10, 9, 6, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(67, 11, 1, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(68, 11, 6, 2, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(69, 11, 7, 3, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(70, 11, 8, 4, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(71, 11, 11, 5, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(72, 12, 1, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(73, 12, 2, 2, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(74, 12, 4, 3, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(75, 12, 6, 4, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(76, 12, 7, 5, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(77, 12, 9, 6, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(78, 12, 10, 7, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(79, 12, 11, 8, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(80, 13, 2, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(81, 13, 5, 2, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(82, 13, 7, 3, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(83, 13, 8, 4, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(84, 13, 11, 5, '2025-04-13 19:35:39', '2025-04-13 19:35:39');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `forum_posts`
--

CREATE TABLE `forum_posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `topic_id` bigint(20) UNSIGNED NOT NULL,
  `is_solution` tinyint(1) NOT NULL DEFAULT 0,
  `likes` int(11) NOT NULL DEFAULT 0,
  `is_edited` tinyint(1) NOT NULL DEFAULT 0,
  `edited_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `forum_topics`
--

CREATE TABLE `forum_topics` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `views` int(11) NOT NULL DEFAULT 0,
  `replies` int(11) NOT NULL DEFAULT 0,
  `is_locked` tinyint(1) NOT NULL DEFAULT 0,
  `is_pinned` tinyint(1) NOT NULL DEFAULT 0,
  `last_reply_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `leaderboard`
--

CREATE TABLE `leaderboard` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `total_score` int(11) NOT NULL DEFAULT 0,
  `exams_taken` int(11) NOT NULL DEFAULT 0,
  `average_score` int(11) NOT NULL DEFAULT 0,
  `rank` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_03_21_000001_create_categories_table', 1),
(6, '2024_03_21_000001_create_subjects_table', 1),
(7, '2024_04_11_000000_create_exam_banks_table', 1),
(8, '2025_03_29_045740_create_exam_categories_table', 1),
(9, '2025_03_29_045946_create_exams_table', 1),
(10, '2025_03_29_050057_create_leaderboard_table', 1),
(11, '2025_03_29_050113_create_forum_topics_table', 1),
(12, '2025_03_29_050208_create_forum_posts_table', 1),
(13, '2025_03_29_071420_create_questions_table', 1),
(14, '2025_03_29_071525_create_exam_attempts_table', 1),
(15, '2025_03_29_071525_create_user_answers_table', 1),
(16, '2025_03_29_090100_create_exam_questions_table', 1),
(17, '2025_03_30_180200_create_exam_bank_categories_table', 1),
(18, '2025_03_30_180300_add_category_id_to_questions_table', 1),
(19, '2025_03_30_180300_add_new_columns_to_exam_categories_table', 1),
(20, '2025_03_31_160207_update_leaderboard_table_add_default_rank', 1),
(21, '2025_04_05_032036_update_exams_table_foreign_key', 1),
(22, '2025_04_11_054801_add_exam_bank_id_to_questions_table', 1),
(23, '2025_04_11_060000_create_exam_bank_questions_table', 1),
(24, '2025_04_11_060001_remove_exam_bank_id_from_questions_table', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `questions`
--

CREATE TABLE `questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `question_text` text NOT NULL,
  `option_a` varchar(255) NOT NULL,
  `option_b` varchar(255) NOT NULL,
  `option_c` varchar(255) NOT NULL,
  `option_d` varchar(255) NOT NULL,
  `correct_answer` enum('A','B','C','D') NOT NULL,
  `explanation` text DEFAULT NULL,
  `difficulty_level` enum('easy','medium','hard') NOT NULL DEFAULT 'medium',
  `exam_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `questions`
--

INSERT INTO `questions` (`id`, `category_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_answer`, `explanation`, `difficulty_level`, `exam_id`, `is_active`, `created_at`, `updated_at`) VALUES
(1, NULL, 'The marketing department _____ the new advertising campaign next week.', 'launch', 'launches', 'will launch', 'launching', 'C', 'Future tense is needed to describe a planned future action.', 'medium', NULL, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(2, NULL, 'Please submit your expense reports _____ the end of each month.', 'by', 'until', 'for', 'since', 'A', 'The preposition \"by\" is used to indicate a deadline.', 'easy', NULL, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(3, NULL, 'The company\'s profits have increased _____ 15% compared to last year.', 'in', 'by', 'at', 'for', 'B', 'The preposition \"by\" is used to indicate the amount of change.', 'medium', NULL, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(4, NULL, 'If the weather _____ better, we would have gone to the beach.', 'was', 'had been', 'would be', 'were', 'B', 'Third conditional requires \"had been\" for past unreal situations.', 'hard', NULL, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(5, NULL, 'According to the passage, what is the main cause of global warming?', 'Deforestation', 'Greenhouse gas emissions', 'Industrial pollution', 'Ocean acidification', 'B', 'The passage identifies greenhouse gas emissions as the primary contributor to global warming.', 'medium', NULL, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(6, NULL, 'The author suggests that renewable energy sources:', 'are not economically viable', 'require significant infrastructure investment', 'are the only solution to climate change', 'should be combined with other energy sources', 'D', 'The author advocates for a mixed approach to energy production.', 'hard', NULL, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(7, NULL, 'What does the term \"carbon footprint\" refer to?', 'The amount of carbon dioxide released by an individual or organization', 'The size of a carbon-based organism', 'The measurement of carbon in soil', 'The carbon content in fossil fuels', 'A', 'Carbon footprint measures the total greenhouse gas emissions caused by an individual or organization.', 'easy', NULL, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(8, NULL, 'What can be inferred from the passage about the author\'s view on renewable energy?', 'It is too expensive to implement', 'It is the only solution to climate change', 'It requires more research and development', 'It is not effective in reducing carbon emissions', 'C', 'The author suggests that while renewable energy is promising, more research and development is needed.', 'hard', NULL, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(9, NULL, 'The passage suggests that early human civilizations:', 'were primarily nomadic', 'developed agriculture independently', 'had advanced technology', 'lived in isolation', 'B', 'The passage indicates that agriculture developed independently in different regions.', 'medium', NULL, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(10, NULL, 'Which of the following is the most appropriate way to begin a formal business email?', 'Hey there,', 'Dear Sir/Madam,', 'Hi everyone,', 'What\'s up?', 'B', 'In formal business communication, \"Dear Sir/Madam,\" is the most appropriate salutation.', 'easy', NULL, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(11, NULL, 'In a business meeting, what does \"to table a motion\" mean?', 'To postpone discussion of a topic', 'To present a new idea', 'To reject a proposal', 'To approve a decision', 'A', 'To table a motion means to postpone or delay discussion of a topic.', 'medium', NULL, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(12, NULL, 'Choose the correct sentence:', 'She don\'t like coffee.', 'She doesn\'t likes coffee.', 'She doesn\'t like coffee.', 'She not like coffee.', 'C', 'The correct form uses \"doesn\'t\" (third person singular) and the base form of the verb.', 'easy', NULL, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(13, NULL, 'Which sentence uses the present perfect tense correctly?', 'I have seen that movie yesterday.', 'I saw that movie yesterday.', 'I have seen that movie before.', 'I see that movie yesterday.', 'C', 'Present perfect is used for actions that happened at an unspecified time before now.', 'medium', NULL, 1, '2025-04-13 19:35:39', '2025-04-13 19:35:39');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `subjects`
--

CREATE TABLE `subjects` (
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `subject_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@example.com', '2025-04-13 19:35:39', '$2y$10$7H7Wo883xJgV1QES5K/XBej.vZIksEyp.Quz4aZCOQMK0.FX6uUW6', 'admin', 'active', NULL, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(2, 'User', 'user@example.com', '2025-04-13 19:35:39', '$2y$10$AHc74jUwQuk2VfxNVTKQke9Uzpt6YWIo4AQ/tQo6uIqSX79hSnqoK', 'user', 'active', NULL, '2025-04-13 19:35:39', '2025-04-13 19:35:39'),
(3, 'Teacher', 'teacher@example.com', '2025-04-13 19:35:39', '$2y$10$.tE8VifKjebRtTG.Xq4rqOdmMh52jzxqAudhLQF87/q3fxPsy7j8e', 'teacher', 'active', NULL, '2025-04-13 19:35:39', '2025-04-13 19:35:39');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_answers`
--

CREATE TABLE `user_answers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `exam_attempt_id` bigint(20) UNSIGNED NOT NULL,
  `question_id` bigint(20) UNSIGNED NOT NULL,
  `selected_answer` enum('A','B','C','D','') NOT NULL DEFAULT '',
  `is_correct` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `user_answers`
--

INSERT INTO `user_answers` (`id`, `user_id`, `exam_attempt_id`, `question_id`, `selected_answer`, `is_correct`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 5, 'C', 0, '2025-04-13 19:36:31', '2025-04-13 19:36:31'),
(2, 1, 1, 6, 'D', 1, '2025-04-13 19:36:31', '2025-04-13 19:36:31'),
(3, 1, 1, 7, 'C', 0, '2025-04-13 19:36:31', '2025-04-13 19:36:31'),
(4, 1, 1, 8, 'C', 1, '2025-04-13 19:36:31', '2025-04-13 19:36:31'),
(5, 1, 1, 9, 'D', 0, '2025-04-13 19:36:31', '2025-04-13 19:36:31'),
(6, 1, 1, 10, 'A', 0, '2025-04-13 19:36:31', '2025-04-13 19:36:31');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Chỉ mục cho bảng `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exams_category_id_foreign` (`category_id`);

--
-- Chỉ mục cho bảng `exam_attempts`
--
ALTER TABLE `exam_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_attempts_user_id_foreign` (`user_id`),
  ADD KEY `exam_attempts_exam_id_foreign` (`exam_id`);

--
-- Chỉ mục cho bảng `exam_banks`
--
ALTER TABLE `exam_banks`
  ADD PRIMARY KEY (`bank_id`),
  ADD UNIQUE KEY `exam_banks_slug_unique` (`slug`);

--
-- Chỉ mục cho bảng `exam_bank_categories`
--
ALTER TABLE `exam_bank_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_bank_categories_bank_id_foreign` (`bank_id`),
  ADD KEY `exam_bank_categories_category_id_foreign` (`category_id`);

--
-- Chỉ mục cho bảng `exam_bank_questions`
--
ALTER TABLE `exam_bank_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_bank_questions_bank_id_foreign` (`bank_id`),
  ADD KEY `exam_bank_questions_question_id_foreign` (`question_id`);

--
-- Chỉ mục cho bảng `exam_categories`
--
ALTER TABLE `exam_categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `exam_categories_slug_unique` (`slug`),
  ADD KEY `exam_categories_parent_id_foreign` (`parent_id`);

--
-- Chỉ mục cho bảng `exam_questions`
--
ALTER TABLE `exam_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_questions_exam_id_foreign` (`exam_id`),
  ADD KEY `exam_questions_question_id_foreign` (`question_id`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `forum_posts`
--
ALTER TABLE `forum_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `forum_posts_user_id_foreign` (`user_id`),
  ADD KEY `forum_posts_topic_id_foreign` (`topic_id`);

--
-- Chỉ mục cho bảng `forum_topics`
--
ALTER TABLE `forum_topics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `forum_topics_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `leaderboard`
--
ALTER TABLE `leaderboard`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leaderboard_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

--
-- Chỉ mục cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Chỉ mục cho bảng `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questions_exam_id_foreign` (`exam_id`),
  ADD KEY `questions_category_id_foreign` (`category_id`);

--
-- Chỉ mục cho bảng `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subject_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Chỉ mục cho bảng `user_answers`
--
ALTER TABLE `user_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_answers_user_id_foreign` (`user_id`),
  ADD KEY `user_answers_exam_attempt_id_foreign` (`exam_attempt_id`),
  ADD KEY `user_answers_question_id_foreign` (`question_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `exams`
--
ALTER TABLE `exams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `exam_attempts`
--
ALTER TABLE `exam_attempts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `exam_banks`
--
ALTER TABLE `exam_banks`
  MODIFY `bank_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `exam_bank_categories`
--
ALTER TABLE `exam_bank_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `exam_bank_questions`
--
ALTER TABLE `exam_bank_questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT cho bảng `exam_categories`
--
ALTER TABLE `exam_categories`
  MODIFY `category_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `exam_questions`
--
ALTER TABLE `exam_questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `forum_posts`
--
ALTER TABLE `forum_posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `forum_topics`
--
ALTER TABLE `forum_topics`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `leaderboard`
--
ALTER TABLE `leaderboard`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `questions`
--
ALTER TABLE `questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `subjects`
--
ALTER TABLE `subjects`
  MODIFY `subject_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `user_answers`
--
ALTER TABLE `user_answers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `exams`
--
ALTER TABLE `exams`
  ADD CONSTRAINT `exams_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `exam_attempts`
--
ALTER TABLE `exam_attempts`
  ADD CONSTRAINT `exam_attempts_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exam_attempts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `exam_bank_categories`
--
ALTER TABLE `exam_bank_categories`
  ADD CONSTRAINT `exam_bank_categories_bank_id_foreign` FOREIGN KEY (`bank_id`) REFERENCES `exam_banks` (`bank_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exam_bank_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `exam_bank_questions`
--
ALTER TABLE `exam_bank_questions`
  ADD CONSTRAINT `exam_bank_questions_bank_id_foreign` FOREIGN KEY (`bank_id`) REFERENCES `exam_banks` (`bank_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exam_bank_questions_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `exam_categories`
--
ALTER TABLE `exam_categories`
  ADD CONSTRAINT `exam_categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `exam_categories` (`category_id`);

--
-- Các ràng buộc cho bảng `exam_questions`
--
ALTER TABLE `exam_questions`
  ADD CONSTRAINT `exam_questions_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exam_questions_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `forum_posts`
--
ALTER TABLE `forum_posts`
  ADD CONSTRAINT `forum_posts_topic_id_foreign` FOREIGN KEY (`topic_id`) REFERENCES `forum_topics` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `forum_posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `forum_topics`
--
ALTER TABLE `forum_topics`
  ADD CONSTRAINT `forum_topics_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `leaderboard`
--
ALTER TABLE `leaderboard`
  ADD CONSTRAINT `leaderboard_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `questions_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `user_answers`
--
ALTER TABLE `user_answers`
  ADD CONSTRAINT `user_answers_exam_attempt_id_foreign` FOREIGN KEY (`exam_attempt_id`) REFERENCES `exam_attempts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_answers_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_answers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
