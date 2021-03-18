-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 18, 2021 lúc 11:32 AM
-- Phiên bản máy phục vụ: 10.4.17-MariaDB
-- Phiên bản PHP: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `laravel`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `child_fields`
--

CREATE TABLE `child_fields` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_field` bigint(20) UNSIGNED NOT NULL,
  `name_field` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `child_fields`
--

INSERT INTO `child_fields` (`id`, `id_field`, `name_field`, `status`, `description`, `created_at`, `updated_at`, `type`) VALUES
(1, 1, 'A3', 1, 'San moi sua thang 3', NULL, NULL, 5),
(2, 1, 'A1', 1, 'San moi sua thang 3', NULL, NULL, 5),
(3, 1, 'A2', 1, 'San moi sua thang 3', NULL, NULL, 7),
(4, 1, 'A5', 1, 'San moi sua thang 3', NULL, NULL, 7),
(5, 2, 'A3', 1, 'San moi sua thang 7', NULL, NULL, 5),
(6, 2, 'A6', 1, 'San moi sua thang 12', '2021-03-16 04:48:52', '2021-03-16 04:50:00', 5);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comments_field`
--

CREATE TABLE `comments_field` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_field` bigint(20) UNSIGNED NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `comments_field`
--

INSERT INTO `comments_field` (`id`, `id_user`, `id_field`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'dep', '2021-03-17 02:29:44', '2021-03-17 02:29:44'),
(2, 2, 1, 'chat luong ok', '2021-03-17 02:30:09', '2021-03-17 02:30:09'),
(3, 2, 2, 'chat luong ok', '2021-03-17 02:30:13', '2021-03-17 02:30:13'),
(4, 3, 2, 'chat luong ok', '2021-03-17 02:30:17', '2021-03-17 02:30:17'),
(6, 1, 2, 'chat luong ok', '2021-03-17 02:30:35', '2021-03-17 02:30:35');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `detail_matches`
--

CREATE TABLE `detail_matches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_match` bigint(20) UNSIGNED NOT NULL,
  `status_team` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numbers_user_added` int(11) DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `detail_matches`
--

INSERT INTO `detail_matches` (`id`, `id_user`, `id_match`, `status_team`, `numbers_user_added`, `address`, `created_at`, `updated_at`) VALUES
(1, 1, 2, '1', 3, '101B Le Huu Trac Son Tra Da Nang', NULL, '2021-03-16 19:08:42'),
(2, 2, 1, '2', 6, '101B Le Huu Trac Son Tra Da Nang', NULL, NULL),
(3, 1, 2, '1', 6, '101B Le Huu Trac Son Tra Da Nang', '2021-03-16 19:07:11', '2021-03-16 19:07:11');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `detail_notifications`
--

CREATE TABLE `detail_notifications` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_notification` int(11) NOT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `detail_notifications`
--

INSERT INTO `detail_notifications` (`id`, `id_user`, `id_notification`, `status`) VALUES
(1, 1, 1, 1),
(2, 2, 1, 0),
(3, 1, 2, 0),
(4, 2, 3, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `fields`
--

CREATE TABLE `fields` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_owner` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` double(8,2) DEFAULT NULL,
  `list_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_field` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_numbers` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `quantities_field` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `fields`
--

INSERT INTO `fields` (`id`, `id_owner`, `name`, `rating`, `list_image`, `address`, `email_field`, `phone_numbers`, `status`, `quantities_field`, `created_at`, `updated_at`) VALUES
(1, 3, '123abc', 4.00, '[]', '101 B Le Huu Trac Son Tra Da Nang', 'phamtinh4321@gmail.com', '0987040197', 1, 10, NULL, NULL),
(2, 3, '121abc', 4.50, '[]', '102 B Le Huu Trac Son Tra Da Nang', 'hungaoo@gmail.com', '0987040191', 1, 8, NULL, NULL),
(4, 1, '129abc', 4.00, '[]', '102B Le Huu Trac Son Tra Da Nang', 'phamtinh9321@gmail.com', '0987140197', 1, 20, '2021-03-16 04:13:50', '2021-03-16 04:13:50'),
(7, 1, '129fbc', 2.00, '[]', '102Ba Le Huu Trac Son Tra Da Nang', 'phamtinh7321@gmail.com', '0917140197', 1, 20, '2021-03-16 04:26:09', '2021-03-16 04:28:28');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `matches`
--

CREATE TABLE `matches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_field_play` bigint(20) UNSIGNED NOT NULL,
  `name_room` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lock` tinyint(1) DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time_start_play` time DEFAULT NULL,
  `time_end_play` time DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `matches`
--

INSERT INTO `matches` (`id`, `id_field_play`, `name_room`, `lock`, `password`, `time_start_play`, `time_end_play`, `description`, `created_at`, `updated_at`) VALUES
(1, 2, '1o2313', 1, NULL, '00:00:00', '00:00:00', 'Giao luu vui ve khong choi xau', NULL, NULL),
(2, 1, '1o2333', 1, NULL, '00:00:00', '00:00:00', 'Giao luu vui ve khong choi xau', NULL, NULL),
(3, 2, 'ads193', 1, 'hung', '10:00:00', '11:00:00', 'Giao luu giai tri nhe', NULL, '2021-03-16 03:17:06'),
(5, 2, 'ads123', 1, NULL, '10:00:00', '11:00:00', 'Giao luu giai tri', '2021-03-16 02:35:59', '2021-03-16 02:35:59');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `match_comments`
--

CREATE TABLE `match_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_match` bigint(20) UNSIGNED NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `match_comments`
--

INSERT INTO `match_comments` (`id`, `id_user`, `id_match`, `description`, `created_at`, `updated_at`) VALUES
(4, 2, 3, 'a', '2021-03-17 02:01:52', '2021-03-17 02:01:52'),
(5, 2, 3, 'ab', '2021-03-17 02:02:06', '2021-03-17 02:02:06'),
(6, 3, 3, 'ab', '2021-03-17 02:02:15', '2021-03-17 02:02:15');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2021_03_03_031239_create_roles_table', 1),
(2, '2021_03_03_033945_create_users_table', 1),
(3, '2021_03_03_084308_create_fields_table', 1),
(4, '2021_03_03_085524_create_comments_field_table', 1),
(5, '2021_03_03_085908_create_child_fields_table', 1),
(6, '2021_03_03_090602_create_matches_table', 1),
(7, '2021_03_03_092013_create_detail_matches_table', 1),
(8, '2021_03_03_092910_create_match_comments_table', 1),
(9, '2021_03_03_093022_create_price_fields_table', 1),
(10, '2021_03_03_095334_create_orders_table', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `id_match` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `notifications`
--

INSERT INTO `notifications` (`id`, `description`, `id_match`, `type`, `updated_at`, `created_at`) VALUES
(1, 'Vua co mot tran dau duoc tao gan khu vuc ban song', NULL, 1, NULL, NULL),
(2, 'Vua co mot tran dau duoc tao gan khu vuc ban song', NULL, 2, NULL, NULL),
(3, 'San n1 Thu do khuyen mai', NULL, 1, NULL, NULL),
(4, 'Vua co mot tran dau', 2, 2, '2021-03-18 09:23:05', '2021-03-18 09:23:05'),
(5, 'Vua co mot tran dau roi roi', 2, 2, '2021-03-18 09:23:29', '2021-03-18 09:23:29');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_match` bigint(20) UNSIGNED NOT NULL,
  `id_price_field` bigint(20) UNSIGNED NOT NULL,
  `time_start` time NOT NULL,
  `time_end` time NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `price_fields`
--

CREATE TABLE `price_fields` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_child_field` bigint(20) UNSIGNED NOT NULL,
  `time_start` time NOT NULL,
  `time_end` time NOT NULL,
  `price` double(8,2) NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `price_fields`
--

INSERT INTO `price_fields` (`id`, `id_child_field`, `time_start`, `time_end`, `price`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, '05:00:00', '17:00:00', 100000.00, 'Gio gia re hon', NULL, NULL),
(2, 1, '17:00:00', '22:00:00', 250000.00, 'Gio gia dat hon', NULL, NULL),
(3, 2, '05:00:00', '17:00:00', 120000.00, 'Gio gia re hon', NULL, NULL),
(4, 2, '17:00:00', '22:00:00', 270000.00, 'Gio gia re hon', NULL, NULL),
(5, 3, '17:00:00', '22:00:00', 130000.00, 'Gio gia re hon', NULL, NULL),
(6, 3, '17:00:00', '22:00:00', 300000.00, 'Gio gia re hon', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `roles`
--

INSERT INTO `roles` (`id`, `name_role`, `description`, `created_at`, `updated_at`) VALUES
(1, 'user', NULL, NULL, NULL),
(2, 'owner', NULL, NULL, NULL),
(3, 'admin', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_roles` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_numbers` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `matches_number` int(11) DEFAULT NULL,
  `skill_rating` double(8,2) DEFAULT NULL,
  `attitude_rating` double(8,2) DEFAULT NULL,
  `position_play` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `id_roles`, `full_name`, `email`, `password`, `phone_numbers`, `address`, `avatar`, `age`, `matches_number`, `skill_rating`, `attitude_rating`, `position_play`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 'Nguyen VAn Huy', 'phamtinh4321@gmail.com', 'hunghung', '0987040197', '101B Le Huu Trac- Son Tra Da Nang', '[]', 19, 0, 4.00, 8.00, 'Thu mon', 'Thich giao luu ket ban', NULL, NULL),
(2, 1, 'Nguyen Huy', 'phamtinh321@gmail.com', 'hunghung', '0967040197', '101B Le Huu Trac- Son Tra Da Nang', '[]', 19, 0, 4.00, 8.00, 'Thu mon', 'Thich giao luu ket ban', NULL, NULL),
(3, 2, 'Nguyen Hung', 'phamtinh432@gmail.com', 'hunghung', '0987040195', '101B Le Huu Trac- Son Tra Da Nang', '[]', 19, 0, 4.00, 8.00, 'Thu mon', 'Thich giao luu ket ban', NULL, NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `child_fields`
--
ALTER TABLE `child_fields`
  ADD PRIMARY KEY (`id`),
  ADD KEY `child_fields_id_field_foreign` (`id_field`);

--
-- Chỉ mục cho bảng `comments_field`
--
ALTER TABLE `comments_field`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_field_id_user_foreign` (`id_user`),
  ADD KEY `comments_field_id_field_foreign` (`id_field`);

--
-- Chỉ mục cho bảng `detail_matches`
--
ALTER TABLE `detail_matches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detail_matches_id_user_foreign` (`id_user`),
  ADD KEY `detail_matches_id_match_foreign` (`id_match`);

--
-- Chỉ mục cho bảng `detail_notifications`
--
ALTER TABLE `detail_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `fields`
--
ALTER TABLE `fields`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fields_name_unique` (`name`),
  ADD UNIQUE KEY `fields_address_unique` (`address`),
  ADD UNIQUE KEY `fields_email_field_unique` (`email_field`),
  ADD UNIQUE KEY `fields_phone_numbers_unique` (`phone_numbers`),
  ADD KEY `fields_id_owner_foreign` (`id_owner`);

--
-- Chỉ mục cho bảng `matches`
--
ALTER TABLE `matches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `matches_name_room_unique` (`name_room`),
  ADD KEY `matches_id_field_play_foreign` (`id_field_play`);

--
-- Chỉ mục cho bảng `match_comments`
--
ALTER TABLE `match_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `match_comments_id_user_foreign` (`id_user`),
  ADD KEY `match_comments_id_match_foreign` (`id_match`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_id_match_foreign` (`id_match`),
  ADD KEY `orders_id_price_field_foreign` (`id_price_field`);

--
-- Chỉ mục cho bảng `price_fields`
--
ALTER TABLE `price_fields`
  ADD PRIMARY KEY (`id`),
  ADD KEY `price_fields_id_child_field_foreign` (`id_child_field`);

--
-- Chỉ mục cho bảng `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_phone_numbers_unique` (`phone_numbers`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_id_roles_foreign` (`id_roles`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `child_fields`
--
ALTER TABLE `child_fields`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `comments_field`
--
ALTER TABLE `comments_field`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `detail_matches`
--
ALTER TABLE `detail_matches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `detail_notifications`
--
ALTER TABLE `detail_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `fields`
--
ALTER TABLE `fields`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `matches`
--
ALTER TABLE `matches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `match_comments`
--
ALTER TABLE `match_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `price_fields`
--
ALTER TABLE `price_fields`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `child_fields`
--
ALTER TABLE `child_fields`
  ADD CONSTRAINT `child_fields_id_field_foreign` FOREIGN KEY (`id_field`) REFERENCES `fields` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `comments_field`
--
ALTER TABLE `comments_field`
  ADD CONSTRAINT `comments_field_id_field_foreign` FOREIGN KEY (`id_field`) REFERENCES `fields` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_field_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `detail_matches`
--
ALTER TABLE `detail_matches`
  ADD CONSTRAINT `detail_matches_id_match_foreign` FOREIGN KEY (`id_match`) REFERENCES `matches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_matches_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `fields`
--
ALTER TABLE `fields`
  ADD CONSTRAINT `fields_id_owner_foreign` FOREIGN KEY (`id_owner`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `matches`
--
ALTER TABLE `matches`
  ADD CONSTRAINT `matches_id_field_play_foreign` FOREIGN KEY (`id_field_play`) REFERENCES `fields` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `match_comments`
--
ALTER TABLE `match_comments`
  ADD CONSTRAINT `match_comments_id_match_foreign` FOREIGN KEY (`id_match`) REFERENCES `matches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `match_comments_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_id_match_foreign` FOREIGN KEY (`id_match`) REFERENCES `matches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_id_price_field_foreign` FOREIGN KEY (`id_price_field`) REFERENCES `price_fields` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `price_fields`
--
ALTER TABLE `price_fields`
  ADD CONSTRAINT `price_fields_id_child_field_foreign` FOREIGN KEY (`id_child_field`) REFERENCES `child_fields` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_id_roles_foreign` FOREIGN KEY (`id_roles`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
