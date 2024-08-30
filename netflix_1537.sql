-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3306
-- Thời gian đã tạo: Th7 13, 2024 lúc 11:49 AM
-- Phiên bản máy phục vụ: 8.2.0
-- Phiên bản PHP: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `netflix_1537`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Netflix', '2024-07-12 11:36:03', '2024-07-12 11:36:03');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `log_users`
--

DROP TABLE IF EXISTS `log_users`;
CREATE TABLE IF NOT EXISTS `log_users` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `content` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `ip_address` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `browser` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `parent_id` bigint NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `log_users`
--

INSERT INTO `log_users` (`id`, `content`, `ip_address`, `browser`, `parent_id`, `created_at`, `updated_at`) VALUES
(88, 'Đăng ký tài khoản thành công', '127.0.0.1', 'Chrome - 120.0.0.0 - Windows', 13, '2024-07-13 10:12:51', '2024-07-13 10:12:51'),
(89, 'Đăng nhập thành công', '127.0.0.1', 'Chrome - 120.0.0.0 - Windows', 13, '2024-07-13 10:13:19', '2024-07-13 10:13:19');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `missions`
--

DROP TABLE IF EXISTS `missions`;
CREATE TABLE IF NOT EXISTS `missions` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `title` longblob NOT NULL,
  `reward` int NOT NULL,
  `type_reward` enum('Xu','đ') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'Xu',
  `type` enum('Vượt link','Tương tác') COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'Vượt link',
  `link` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `view` int NOT NULL DEFAULT '0',
  `parent_id` bigint NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `mission_users`
--

DROP TABLE IF EXISTS `mission_users`;
CREATE TABLE IF NOT EXISTS `mission_users` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `parent_id` bigint NOT NULL,
  `user_id` bigint NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `price` double(10,2) NOT NULL,
  `coin` int NOT NULL DEFAULT '0',
  `parent_id` bigint NOT NULL,
  `information` longblob NOT NULL,
  `payment_method` enum('price','coin') COLLATE utf8mb3_unicode_ci NOT NULL,
  `product_id` bigint NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `orders_ibfk_1` (`parent_id`),
  KEY `orders_ibfk_2` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `title` longblob NOT NULL,
  `price` int NOT NULL,
  `coin` int NOT NULL DEFAULT '0',
  `sold` int NOT NULL DEFAULT '0',
  `country` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'Việt nam',
  `description` longblob NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `parent_id` bigint NOT NULL,
  `user_id` bigint NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `products_ibfk_2` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `role_users`
--

DROP TABLE IF EXISTS `role_users`;
CREATE TABLE IF NOT EXISTS `role_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `role_display` longblob NOT NULL,
  `role_main` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `role_users`
--

INSERT INTO `role_users` (`id`, `role_display`, `role_main`, `created_at`, `updated_at`) VALUES
(1, 0x5175e1baa36e207472e1bb8b207669c3aa6e20f09fab85f09f8fbd, 'admin', '2024-07-10 19:42:14', '2024-07-10 19:42:14'),
(2, 0x43e1bb996e672074c3a163207669c3aa6e20f09fa5b7f09f8fbb, 'collaborators', '2024-07-10 19:43:25', '2024-07-10 19:43:25'),
(3, 0x4b68c3a163682068c3a06e67, 'client', '2024-07-10 19:44:04', '2024-07-10 19:44:04');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `stock_products`
--

DROP TABLE IF EXISTS `stock_products`;
CREATE TABLE IF NOT EXISTS `stock_products` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `info` longblob NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `status` tinyint NOT NULL DEFAULT '1',
  `parent_id` bigint NOT NULL,
  `user_id` bigint NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sub_categories`
--

DROP TABLE IF EXISTS `sub_categories`;
CREATE TABLE IF NOT EXISTS `sub_categories` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `image` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `parent_id` bigint NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `name`, `image`, `parent_id`, `created_at`, `updated_at`) VALUES
(1, 'Tài khoản netflix', 'netflix.png', 1, '2024-07-12 11:37:46', '2024-07-12 11:37:46'),
(2, 'Cookie netflix', 'netflix.png', 1, '2024-07-12 11:37:46', '2024-07-12 11:37:46'),
(3, 'Quét mã Netflix', 'netflix.png', 1, '2024-07-12 13:36:56', '2024-07-12 13:36:56');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `fullName` longblob NOT NULL,
  `username` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `password` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `email_verified` tinyint NOT NULL DEFAULT '0',
  `email_code` text COLLATE utf8mb3_unicode_ci,
  `phone` varchar(11) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `role_id` int NOT NULL DEFAULT '3',
  `last_login` timestamp NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `fullName`, `username`, `password`, `email`, `email_verified`, `email_code`, `phone`, `status`, `role_id`, `last_login`, `created_at`, `updated_at`) VALUES
(13, 0x4e677579e1bb856e2054e1baa56e20c39d, 'nguyentany', '$2y$10$eJoYRMdNdXcRR51tI9jyYOLkfaWv1xwTAd9KdBTBACANk7WkEc.H2', 'nguyentany.tricker@gmail.com', 0, NULL, NULL, 1, 3, '2024-07-13 10:13:19', '2024-07-13 10:12:51', '2024-07-13 10:13:19');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `wallet_users`
--

DROP TABLE IF EXISTS `wallet_users`;
CREATE TABLE IF NOT EXISTS `wallet_users` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `coin` int NOT NULL DEFAULT '0',
  `money` double(10,2) NOT NULL DEFAULT '0.00',
  `total` double(10,2) NOT NULL DEFAULT '0.00',
  `parent_id` bigint NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `wallet_users`
--

INSERT INTO `wallet_users` (`id`, `coin`, `money`, `total`, `parent_id`, `created_at`, `updated_at`) VALUES
(4, 0, 0.00, 0.00, 13, '2024-07-13 10:12:51', '2024-07-13 10:12:51');

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `log_users`
--
ALTER TABLE `log_users`
  ADD CONSTRAINT `log_users_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `missions`
--
ALTER TABLE `missions`
  ADD CONSTRAINT `missions_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `mission_users`
--
ALTER TABLE `mission_users`
  ADD CONSTRAINT `mission_users_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `missions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mission_users_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`parent_id`) REFERENCES `sub_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `stock_products`
--
ALTER TABLE `stock_products`
  ADD CONSTRAINT `stock_products_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `stock_products_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD CONSTRAINT `sub_categories_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `wallet_users`
--
ALTER TABLE `wallet_users`
  ADD CONSTRAINT `wallet_users_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
