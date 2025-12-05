-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 06, 2025 at 05:23 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel-stylex`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_reports`
--

CREATE TABLE `admin_reports` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `report_date` date NOT NULL COMMENT 'Ngày báo cáo, thường là ngày cuối tháng',
  `total_salary_paid` decimal(10,2) NOT NULL,
  `total_commission` decimal(10,2) NOT NULL DEFAULT '0.00',
  `orders_processed_count` int NOT NULL DEFAULT '0',
  `inventory_transactions_count` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `app_data`
--

CREATE TABLE `app_data` (
  `id` bigint UNSIGNED NOT NULL,
  `logo_text` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `heading` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `facebook` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `order` int NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `title`, `redirect_url`, `image`, `content`, `order`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '123', '123', 'banners/1762403279_NGcwJDUxKv.jpg', '123', 0, 1, NULL, '2025-11-05 21:27:59', '2025-11-05 21:27:59');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `session_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_id` bigint UNSIGNED DEFAULT NULL,
  `variant_id` bigint UNSIGNED DEFAULT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `size` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `session_id`, `product_id`, `variant_id`, `quantity`, `size`, `color`, `created_at`, `updated_at`) VALUES
(1, NULL, 'puCIdxbl44OvV7bpgwAabHFhLEK0ukOc8IOuPNbv', 22, NULL, 1, NULL, NULL, '2025-10-29 00:00:28', '2025-10-29 00:00:28'),
(2, NULL, 'puCIdxbl44OvV7bpgwAabHFhLEK0ukOc8IOuPNbv', 20, NULL, 3, NULL, NULL, '2025-10-29 00:10:24', '2025-10-29 00:15:04'),
(54, NULL, '8HDwF0v2GZrurdUQcdNNvAKAF9xIEBa8ZwTLB8Yg', 23, 53, 2, NULL, NULL, '2025-11-05 02:09:58', '2025-11-05 02:09:58'),
(56, 57, NULL, 23, 53, 3, NULL, NULL, '2025-11-05 02:34:51', '2025-11-05 02:38:28'),
(57, 57, NULL, 22, 52, 1, NULL, NULL, '2025-11-05 03:11:33', '2025-11-05 03:11:33'),
(58, NULL, 'sdRnS2U7LUd67AaActDKQmhpW3G738V3pYeN11eu', 23, 53, 1, NULL, NULL, '2025-11-05 19:38:41', '2025-11-05 19:38:41');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `parent_id`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Nam', NULL, 1, '2025-10-13 20:21:24', '2025-10-21 10:38:10', NULL),
(2, 'Nữ', NULL, 1, '2025-10-13 20:21:24', '2025-10-21 10:38:30', NULL),
(3, 'Phụ Kiện', NULL, 1, '2025-10-13 20:21:24', '2025-10-21 10:39:25', NULL),
(4, 'Quần Nữ', NULL, 1, '2025-10-13 20:21:24', '2025-10-13 20:21:24', NULL),
(5, 'Giày Dép', NULL, 1, '2025-10-13 20:21:24', '2025-10-13 20:21:24', NULL),
(6, 'Phụ Kiện 1', NULL, 1, '2025-10-13 20:21:24', '2025-10-21 11:09:04', '2025-10-21 11:09:04'),
(7, 'Áo Sơ Mi', 1, 1, '2025-10-13 20:21:24', '2025-10-13 20:21:24', NULL),
(8, 'Áo Thun', 1, 1, '2025-10-13 20:21:24', '2025-10-13 20:21:24', NULL),
(9, 'Áo Khoác', 1, 1, '2025-10-13 20:21:24', '2025-10-13 20:21:24', NULL),
(10, 'Áo Vest', 1, 1, '2025-10-13 20:21:24', '2025-10-13 20:21:24', NULL),
(11, 'Áo Dài', 2, 1, '2025-10-13 20:21:24', '2025-10-13 20:21:24', NULL),
(12, 'Áo Blouse', 2, 1, '2025-10-13 20:21:24', '2025-10-13 20:21:24', NULL),
(13, 'Áo Thun Nữ', 2, 1, '2025-10-13 20:21:24', '2025-10-13 20:21:24', NULL),
(14, 'Áo Khoác Nữ', 2, 1, '2025-10-13 20:21:24', '2025-10-13 20:21:24', NULL),
(15, 'Quần Jean', 3, 1, '2025-10-13 20:21:24', '2025-10-13 20:21:24', NULL),
(16, 'Quần Kaki', 3, 1, '2025-10-13 20:21:24', '2025-10-13 20:21:24', NULL),
(17, 'Quần Short', 3, 1, '2025-10-13 20:21:24', '2025-10-13 20:21:24', NULL),
(18, 'Quần Âu', 3, 1, '2025-10-13 20:21:24', '2025-10-13 20:21:24', NULL),
(19, 'Quần Jean Nữ', 4, 1, '2025-10-13 20:21:24', '2025-10-13 20:21:24', NULL),
(20, 'Quần Short Nữ', 4, 1, '2025-10-13 20:21:24', '2025-10-13 20:21:24', NULL),
(21, 'Quần Legging', 4, 1, '2025-10-13 20:21:24', '2025-10-13 20:21:24', NULL),
(22, 'Chân Váy', 4, 1, '2025-10-13 20:21:24', '2025-10-13 20:21:24', NULL),
(23, 'Giày Thể Thao', 5, 1, '2025-10-13 20:21:24', '2025-10-13 20:21:24', NULL),
(24, 'Giày Tây', 5, 1, '2025-10-13 20:21:24', '2025-10-13 20:21:24', NULL),
(25, 'Giày Cao Gót', 5, 1, '2025-10-13 20:21:24', '2025-10-13 20:21:24', NULL),
(26, 'Dép', 5, 1, '2025-10-13 20:21:24', '2025-10-13 20:21:24', NULL),
(27, 'Túi Xách', 6, 1, '2025-10-13 20:21:24', '2025-10-21 11:09:04', '2025-10-21 11:09:04'),
(28, 'Ví', 6, 1, '2025-10-13 20:21:24', '2025-10-21 11:09:04', '2025-10-21 11:09:04'),
(29, 'Đồng Hồ', 6, 1, '2025-10-13 20:21:24', '2025-10-21 11:09:04', '2025-10-21 11:09:04'),
(30, 'Trang Sức', 6, 1, '2025-10-13 20:21:24', '2025-10-21 11:09:04', '2025-10-21 11:09:04'),
(31, 'Váy', NULL, 1, '2025-10-18 22:21:11', '2025-10-18 22:21:11', NULL),
(32, 'Đầm', NULL, 1, '2025-10-18 22:21:11', '2025-10-18 22:21:11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE `colors` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hex_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1: active, 0: inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`id`, `name`, `hex_code`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'Xanh', NULL, 1, '2025-10-11 22:08:07', '2025-10-11 22:08:07', NULL),
(3, 'Vàng', NULL, 1, '2025-10-11 22:08:18', '2025-10-11 22:08:18', NULL),
(4, 'Đỏ', NULL, 1, '2025-10-11 22:08:23', '2025-10-11 22:08:23', NULL),
(5, 'Bui Tuan Phong', NULL, 1, '2025-10-13 03:16:07', '2025-10-13 03:16:12', '2025-10-13 03:16:12'),
(6, 'Đỏ', NULL, 1, '2025-10-18 22:20:09', '2025-10-18 22:20:09', NULL),
(7, 'Xanh dương', NULL, 1, '2025-10-18 22:20:09', '2025-10-18 22:20:09', NULL),
(8, 'Xanh lá', NULL, 1, '2025-10-18 22:20:09', '2025-10-18 22:20:09', NULL),
(9, 'Vàng', NULL, 1, '2025-10-18 22:20:09', '2025-10-18 22:20:09', NULL),
(10, 'Đen', NULL, 1, '2025-10-18 22:20:09', '2025-10-18 22:20:09', NULL),
(11, 'Trắng', NULL, 1, '2025-10-18 22:20:09', '2025-10-18 22:20:09', NULL),
(12, 'Hồng', NULL, 1, '2025-10-18 22:20:09', '2025-10-18 22:20:09', NULL),
(13, 'Tím', NULL, 1, '2025-10-18 22:20:09', '2025-10-18 22:20:09', NULL),
(14, 'Cam', NULL, 1, '2025-10-18 22:20:09', '2025-10-18 22:20:09', NULL),
(15, 'Xám', NULL, 1, '2025-10-18 22:20:09', '2025-10-18 22:20:09', NULL),
(16, 'Đỏ', NULL, 1, '2025-10-18 22:20:30', '2025-10-18 22:20:30', NULL),
(17, 'Xanh dương', NULL, 1, '2025-10-18 22:20:30', '2025-10-18 22:20:30', NULL),
(18, 'Xanh lá', NULL, 1, '2025-10-18 22:20:30', '2025-10-18 22:20:30', NULL),
(19, 'Đỏ', NULL, 1, '2025-10-18 22:21:47', '2025-10-18 23:21:33', '2025-10-18 23:21:33'),
(20, 'Xanh dương', NULL, 1, '2025-10-18 22:21:47', '2025-10-18 22:21:47', NULL),
(21, 'Xanh lá', NULL, 1, '2025-10-18 22:21:47', '2025-10-18 22:21:47', NULL),
(22, 'Vàng', NULL, 1, '2025-10-18 22:21:47', '2025-10-18 22:21:47', NULL),
(23, 'Đen', NULL, 1, '2025-10-18 22:21:47', '2025-10-18 22:21:47', NULL),
(24, 'Trắng', NULL, 1, '2025-10-18 22:21:47', '2025-10-18 22:21:47', NULL),
(25, 'Hồng', NULL, 1, '2025-10-18 22:21:47', '2025-10-18 22:21:47', NULL),
(26, 'Tím', NULL, 1, '2025-10-18 22:21:47', '2025-10-18 22:21:47', NULL),
(27, 'Cam', NULL, 1, '2025-10-18 22:21:47', '2025-10-18 22:21:47', NULL),
(28, 'Xám', NULL, 1, '2025-10-18 22:21:47', '2025-10-18 22:21:47', NULL),
(29, 'Đỏ', NULL, 1, '2025-10-18 22:51:33', '2025-10-18 22:51:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_logs`
--

CREATE TABLE `inventory_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `variant_id` bigint UNSIGNED NOT NULL,
  `change` int NOT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(1, 'default', '{\"uuid\":\"b295b16d-5d2a-4466-867a-a7de6b9d077c\",\"displayName\":\"App\\\\Jobs\\\\SendAccountUnblockedMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendAccountUnblockedMail\",\"command\":\"O:33:\\\"App\\\\Jobs\\\\SendAccountUnblockedMail\\\":1:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:19;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}\"},\"createdAt\":1760888252,\"delay\":null}', 0, NULL, 1760888252, 1760888252);

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loyalty_tiers`
--

CREATE TABLE `loyalty_tiers` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `min_spend_required` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discount_rate` decimal(4,2) NOT NULL DEFAULT '0.00' COMMENT 'Ưu đãi theo %',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loyalty_tiers`
--

INSERT INTO `loyalty_tiers` (`id`, `name`, `min_spend_required`, `discount_rate`, `created_at`, `updated_at`) VALUES
(2, 'Bạc', 70000.00, 7.00, '2025-10-13 02:17:45', '2025-10-13 03:08:14'),
(3, 'Vàng', 100000.00, 10.00, '2025-10-13 02:18:49', '2025-10-13 03:07:57'),
(4, 'Đồng', 50000.00, 5.00, '2025-10-13 02:50:05', '2025-10-13 03:18:08');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_10_04_003345_create_app_data', 1),
(5, '2025_10_06_055501_create_categories_table', 1),
(6, '2025_10_08_133104_add_phone_number_to_users_table', 2),
(7, '2025_10_08_135108_add_is_admin_to_users_table', 3),
(8, '2025_10_09_000000_add_soft_deletes_to_users_table', 3),
(9, '2025_01_15_000000_add_soft_deletes_to_categories_table', 4),
(10, '2025_10_12_031110_create_colors_table', 5),
(11, '2025_10_12_031126_create_sizes_table', 5),
(12, '2025_10_12_031134_create_textures_table', 5),
(13, '2025_10_09_120724_create_loyalty_tables', 6),
(14, '2025_10_13_000001_create_tax_rates_table', 7),
(15, '2025_10_13_000002_create_shipping_carriers_table', 7),
(16, '2025_10_12_123752_create_brands_table', 8),
(17, '2025_10_12_123809_create_products_table', 8),
(18, '2025_10_12_123826_create_product_variants_table', 8),
(19, '2025_10_12_123843_create_product_images_table', 8),
(20, '2025_10_12_123913_create_inventory_logs_table', 8),
(21, '2025_10_19_050429_add_deleted_at_to_products_table', 9),
(22, '2025_10_11_144804_create_products_table', 8),
(23, '2025_10_16_020338_create_product_variants_table', 8),
(24, '2025_10_19_051219_add_is_featured_to_products_table', 10),
(25, '2025_10_19_060000_add_sample_data_to_tables', 11),
(26, '2025_10_19_052120_add_sample_data_to_tables', 12),
(27, '2025_10_19_071508_add_columns_to_product_images_table', 13),
(28, '2025_10_19_090000_add_role_to_users_table', 14),
(29, '2025_10_19_120000_create_roles_table', 15),
(30, '2025_10_19_120100_create_permissions_table', 15),
(31, '2025_10_19_120200_create_permission_role_table', 15),
(34, '2025_10_02_162443_2025_10_02_09_create_posts_and_admin_reports', 16),
(35, '2025_10_27_055410_create_carts_table', 17),
(36, '2025_10_27_055724_add_variant_id_to_carts_table', 18),
(37, '2025_10_29_000000_alter_carts_add_columns', 19),
(38, '2025_10_30_000001_alter_carts_add_columns', 20),
(39, '2025_10_30_000100_create_orders_tables', 21),
(40, '2025_11_05_000001_create_vouchers_table', 22),
(41, '2025_11_05_000002_add_max_discount_to_vouchers', 23),
(42, '2025_10_22_151025_create_banners_table', 24),
(43, '2025_10_29_153526_create_tags_table', 25),
(44, '2025_10_29_153538_create_taggables_table', 26),
(45, '2025_01_14_055501_create_categories_table', 27),
(46, '2025_10_20_164641_create_product_images_table', 27),
(48, '2025_10_29_153511_create_posts_table', 28),
(49, '2025_11_06_042154_add_columns_to_posts_table_for_blog', 29);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `session_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `subtotal` bigint UNSIGNED NOT NULL DEFAULT '0',
  `shipping_fee` bigint UNSIGNED NOT NULL DEFAULT '0',
  `discount` bigint UNSIGNED NOT NULL DEFAULT '0',
  `total` bigint UNSIGNED NOT NULL DEFAULT '0',
  `payment_method` enum('cod','online') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cod',
  `payment_status` enum('unpaid','paid','refunded') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpaid',
  `status` enum('pending','processing','completed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `session_id`, `code`, `full_name`, `phone`, `email`, `city`, `address`, `note`, `subtotal`, `shipping_fee`, `discount`, `total`, `payment_method`, `payment_status`, `status`, `created_at`, `updated_at`) VALUES
(1, 57, NULL, 'OD155A300616', 'Phongbt', '0936665970', 'admin@test.com', 'Thành phố Hà Nội', 'Phường Ngô Quyền, Thị xã Sơn Tây, Thành phố Hà Nội', '123', 10888, 0, 0, 10888, 'cod', 'unpaid', 'completed', '2025-10-29 23:19:34', '2025-11-05 05:39:48'),
(2, 57, NULL, 'OD74F1BD8FE0', 'Phongbt', '0936665970', 'admin@test.com', 'Thành phố Hà Nội', 'Xã Đông Quang, Huyện Ba Vì, Thành phố Hà Nội', '123', 222, 0, 0, 222, 'cod', 'unpaid', 'pending', '2025-10-29 23:34:19', '2025-10-29 23:34:19'),
(3, 57, NULL, 'ODD2708F05E8', 'Phongbt', '0936665970', 'admin@test.com', 'Thành phố Hà Nội', 'Phường Ngô Quyền, Thị xã Sơn Tây, Thành phố Hà Nội, Phường Phú Thịnh, Thị xã Sơn Tây, Thành phố Hà Nội', NULL, 1554, 0, 0, 1554, 'cod', 'unpaid', 'pending', '2025-10-30 00:59:12', '2025-10-30 00:59:12'),
(4, 57, NULL, 'OD8B667235F5', 'Phongbt', '0936665970', 'admin@test.com', 'Thành phố Hà Nội', 'Phường Ngô Quyền, Thị xã Sơn Tây, Thành phố Hà Nội, Phường Phú Thịnh, Thị xã Sơn Tây, Thành phố Hà Nội, Xã Đại Thịnh, Huyện Mê Linh, Thành phố Hà Nội', NULL, 666, 0, 0, 666, 'cod', 'unpaid', 'pending', '2025-10-30 05:46:32', '2025-10-30 05:46:32'),
(5, 57, NULL, 'OD9CAF3C1A87', 'Phongbt', '0936665970', 'admin@test.com', 'Hà Nội', 'Phường Ngô Quyền, Thị xã Sơn Tây, Thành phố Hà Nội, Phường Phú Thịnh, Thị xã Sơn Tây, Thành phố Hà Nội, Xã Đại Thịnh, Huyện Mê Linh, Thành phố Hà Nội', 's', 1110, 0, 0, 1110, 'cod', 'unpaid', 'pending', '2025-11-04 11:31:07', '2025-11-04 11:31:07'),
(6, 57, NULL, 'ODDED696795C', 'Phongbt', '0936665970', 'admin@test.com', 'Tỉnh Hà Giang', 'Phường Trần Phú, Thành phố Hà Giang, Tỉnh Hà Giang', '`123', 40666, 0, 0, 40666, 'cod', 'unpaid', 'pending', '2025-11-04 15:51:14', '2025-11-04 15:51:14');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `variant_id` bigint UNSIGNED DEFAULT NULL,
  `quantity` int UNSIGNED NOT NULL DEFAULT '1',
  `price` bigint UNSIGNED NOT NULL,
  `line_total` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `variant_id`, `quantity`, `price`, `line_total`, `created_at`, `updated_at`) VALUES
(1, 1, 20, 28, 1, 10000, 10000, '2025-10-29 23:19:35', '2025-10-29 23:19:35'),
(2, 1, 22, 52, 4, 222, 888, '2025-10-29 23:19:35', '2025-10-29 23:19:35'),
(3, 2, 22, 52, 1, 222, 222, '2025-10-29 23:34:19', '2025-10-29 23:34:19'),
(4, 3, 22, 52, 7, 222, 1554, '2025-10-30 00:59:12', '2025-10-30 00:59:12'),
(5, 4, 22, 52, 3, 222, 666, '2025-10-30 05:46:32', '2025-10-30 05:46:32'),
(6, 5, 22, 52, 5, 222, 1110, '2025-11-04 11:31:07', '2025-11-04 11:31:07'),
(7, 6, 20, 28, 1, 10000, 10000, '2025-11-04 15:51:14', '2025-11-04 15:51:14'),
(8, 6, 20, 30, 3, 10000, 30000, '2025-11-04 15:51:14', '2025-11-04 15:51:14'),
(9, 6, 22, 52, 3, 222, 666, '2025-11-04 15:51:14', '2025-11-04 15:51:14');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(2, 'Xem trang chủ', 'views.dashboard', '2025-10-19 07:08:59', '2025-10-19 23:20:41');

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `role_id` bigint UNSIGNED NOT NULL,
  `permission_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`role_id`, `permission_id`) VALUES
(2, 2),
(3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `content` text COLLATE utf8mb4_unicode_ci,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('draft','pending','published','private','scheduled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `views` int NOT NULL DEFAULT '0',
  `is_hot` tinyint(1) NOT NULL DEFAULT '0',
  `published_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `category_id`, `title`, `slug`, `description`, `content`, `thumbnail`, `status`, `views`, `is_hot`, `published_at`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 56, 21, 'Phong cách thời trang nam hiện đại – Tối giản nhưng tinh tế', 'phong-cach-thoi-trang-nam-hien-dai-toi-gian-nhung-tinh-te-82b517f7-5', '<p>Khám phá bí quyết phối đồ phong cách tối giản cho nam giới – xu hướng được yêu thích trong năm nay tại StyleX.</p>', '<p>Thời trang nam hiện đại đang hướng tới phong cách tối giản (minimalist) – nơi mọi chi tiết đều được chọn lọc kỹ càng để tạo nên tổng thể tinh tế, thanh lịch. </p><p>Một tủ đồ nam tối giản thường bao gồm những món cơ bản như áo sơ mi trắng, quần tây đen, áo thun trơn, blazer và giày da. Khi biết cách phối hợp, bạn có thể tạo ra nhiều phong cách khác nhau mà không cần quá nhiều món đồ.</p><p>Điều quan trọng trong phong cách này là **chất liệu và form dáng**. Một chiếc áo vừa vặn, vải cotton thoáng mát hay linen tự nhiên sẽ mang lại cảm giác thoải mái và sang trọng.</p><p>Tại StyleX, bạn có thể dễ dàng tìm thấy những thiết kế nam mang phong cách hiện đại, tinh giản nhưng không hề đơn điệu – phù hợp cho cả đi làm, đi chơi hay dự tiệc.</p>', 'blogs/1762403333_zicGQwFDVw.jpg', 'published', 4914, 1, '2025-11-05 21:28:56', NULL, '2025-11-05 21:24:47', '2025-11-05 21:28:56'),
(2, 56, 20, 'Xu hướng thời trang nữ 2025 – Thanh lịch và năng động', 'xu-huong-thoi-trang-nu-2025-thanh-lich-va-nang-dong-27a9ebca-2699-4bd2-a568-9fc9d2bfe2a3', 'StyleX cập nhật những xu hướng thời trang nữ nổi bật năm 2025: từ phong cách thanh lịch công sở đến streetwear năng động.', 'Bước sang năm 2025, thời trang nữ chứng kiến sự hòa trộn giữa phong cách thanh lịch cổ điển và nét năng động hiện đại. \n\nÁo blazer oversize, chân váy midi, đầm hai dây chất liệu satin, hay quần jeans ống suông là những món được yêu thích nhất. Xu hướng phối đồ theo tone màu pastel nhẹ nhàng hoặc các gam trung tính như beige, kem, xám vẫn tiếp tục được ưa chuộng.\n\nBên cạnh đó, phong cách **mix & match linh hoạt** lên ngôi – phụ nữ hiện đại không ngại thử nghiệm, kết hợp các item để thể hiện cá tính riêng. \n\nStyleX mang đến bộ sưu tập thời trang nữ được thiết kế tinh tế, dễ phối và phù hợp cho mọi hoàn cảnh – giúp bạn tự tin tỏa sáng mỗi ngày.', NULL, 'published', 3120, 1, '2025-10-27 21:24:47', NULL, '2025-11-05 21:24:47', '2025-11-05 21:24:47'),
(3, 56, 27, 'Cách chọn size quần áo chuẩn – Bí quyết mua sắm online tại StyleX', 'cach-chon-size-quan-ao-chuan-bi-quyet-mua-sam-online-tai-stylex-dd2b216a-d952-4baa-83fe-ae229cab6312', 'Chia sẻ mẹo chọn size quần áo chính xác khi mua hàng online để luôn vừa vặn và thoải mái.', 'Một trong những nỗi lo lớn nhất khi mua quần áo online là chọn sai size. Để giúp bạn yên tâm mua sắm tại StyleX, chúng tôi chia sẻ một số bí quyết đơn giản mà hiệu quả.\n\nTrước hết, hãy **đo 3 vòng cơ bản**: ngực, eo và hông. So sánh số đo này với bảng size chuẩn mà StyleX cung cấp trong từng sản phẩm. Mỗi mẫu quần áo có thể có sự chênh lệch nhỏ tùy chất liệu và form dáng, nên bạn hãy đọc kỹ phần mô tả.\n\nNgoài ra, nếu bạn thích mặc thoải mái, nên chọn **size lớn hơn 1 số** so với form ôm sát. Ngược lại, nếu muốn phong cách trẻ trung, năng động thì **chọn form vừa vặn** là lựa chọn tốt nhất.\n\nVới chính sách đổi trả dễ dàng của StyleX, bạn hoàn toàn yên tâm khi mua sắm trực tuyến mà vẫn đảm bảo phong cách và sự vừa vặn.', NULL, 'published', 2003, 1, '2025-10-25 21:24:47', NULL, '2025-11-05 21:24:47', '2025-11-05 21:24:47'),
(4, 56, 21, 'Phối đồ đôi cho cặp đôi – Tình yêu trong từng chi tiết thời trang', 'phoi-do-doi-cho-cap-doi-tinh-yeu-trong-tung-chi-tiet-thoi-trang-a4492ce8-389c-4c52-923b-1ef01e09b091', 'Gợi ý những set đồ đôi đẹp và tinh tế giúp các cặp đôi thể hiện phong cách riêng cùng StyleX.', 'Thời trang đôi không chỉ là xu hướng, mà còn là cách các cặp đôi thể hiện sự đồng điệu và kết nối trong phong cách sống. \n\nBạn không nhất thiết phải mặc giống hệt nhau để tạo cảm giác “đồ đôi”. Thay vào đó, hãy chọn **màu sắc, họa tiết hoặc chất liệu tương đồng**. Ví dụ, anh mặc áo sơ mi xanh navy thì cô có thể chọn váy xanh nhạt hoặc áo blouse cùng tone.\n\nCác bộ sưu tập Couple Collection của StyleX hướng đến sự tinh tế, trẻ trung và dễ phối. Chúng tôi tin rằng mỗi cặp đôi đều có thể tìm thấy phong cách riêng của mình – dù là năng động, thanh lịch hay lãng mạn.\n\nCùng StyleX tạo nên những khoảnh khắc thời trang đáng nhớ bên người thương của bạn!', NULL, 'published', 386, 1, '2025-10-10 21:24:47', NULL, '2025-11-05 21:24:47', '2025-11-05 21:24:47'),
(5, 56, 26, 'Chăm sóc và bảo quản quần áo đúng cách – Giữ phong độ bền lâu', 'cham-soc-va-bao-quan-quan-ao-dung-cach-giu-phong-do-ben-lau-8190a1a6-059b-42bc-ac83-a885a30399d2', 'Hướng dẫn cách giặt, phơi và bảo quản quần áo giúp giữ form và màu sắc lâu dài, được StyleX khuyên dùng.', 'Đầu tư vào thời trang không chỉ dừng lại ở việc chọn đồ đẹp mà còn ở cách bạn **bảo quản quần áo** sau khi sử dụng. Một vài thói quen nhỏ có thể giúp trang phục luôn như mới và bền màu.\n\nHãy đọc kỹ nhãn hướng dẫn giặt trên từng sản phẩm – đặc biệt với các chất liệu như lụa, len hoặc cotton cao cấp. Giặt tay bằng nước lạnh sẽ giúp giữ form áo tốt hơn, trong khi phơi nơi thoáng mát tránh ánh nắng trực tiếp giúp vải không bị phai màu.\n\nQuần áo nên được **phân loại theo màu và chất liệu** trước khi giặt, đồng thời tránh dùng quá nhiều chất tẩy. Khi ủi, hãy chọn nhiệt độ phù hợp cho từng loại vải để tránh hư hỏng.\n\nTại StyleX, chúng tôi tin rằng phong cách bền vững bắt đầu từ việc chăm sóc trang phục đúng cách – để mỗi bộ đồ luôn thể hiện trọn vẹn đẳng cấp và cá tính của bạn.', NULL, 'published', 1521, 1, '2025-10-30 21:24:47', NULL, '2025-11-05 21:24:47', '2025-11-05 21:24:47');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_description` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(20,0) NOT NULL DEFAULT '0',
  `price_sale` decimal(20,0) NOT NULL DEFAULT '0',
  `brand_id` bigint UNSIGNED DEFAULT NULL,
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `default_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `base_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `cost_price` decimal(12,2) DEFAULT NULL,
  `total_stock` int NOT NULL DEFAULT '0',
  `weight` decimal(8,3) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `visibility` enum('hidden','catalog','search','both') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'both',
  `additional` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `sku`, `name`, `slug`, `thumbnail`, `short_description`, `description`, `meta_title`, `price`, `price_sale`, `brand_id`, `category_id`, `default_image`, `base_price`, `cost_price`, `total_stock`, `weight`, `is_active`, `is_featured`, `visibility`, `additional`, `created_at`, `updated_at`, `deleted_at`) VALUES
(20, NULL, 'Bui Tuan Phong12233', 'bui-tuan-phong12233', 'products/75fFp16VGpt0sTEava5gq1p9ZETCG53X3LqWpsJW.jpg', NULL, '13122222312321', NULL, 12000, 10000, NULL, 2, NULL, 0.00, NULL, 0, NULL, 1, 0, 'both', NULL, '2025-10-19 01:55:17', '2025-10-20 23:45:40', NULL),
(22, NULL, 'Esprit Ruffle Shirtdd', 'esprit-ruffle-shirtdd', 'products/XFh5mQUIHI4j6PHzFROoiPREufdrk6QtHa0oZYRe.jpg', NULL, NULL, NULL, 44444, 222, NULL, 4, NULL, 0.00, NULL, 0, NULL, 1, 0, 'both', NULL, '2025-10-21 11:02:01', '2025-10-25 05:12:08', NULL),
(23, NULL, 'Esprit Ruffle Shirtd', 'esprit-ruffle-shirtd', 'products/gVMgUNPVJ8uehyaCCvBGjlHCBaBXwSdUBmoozUhc.jpg', NULL, NULL, NULL, 100000, 70000, NULL, 1, NULL, 0.00, NULL, 0, NULL, 1, 0, 'both', NULL, '2025-10-21 11:04:20', '2025-10-25 05:07:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `variant_id` bigint UNSIGNED DEFAULT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `is_main` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_variants`
--

CREATE TABLE `product_variants` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color_id` bigint UNSIGNED DEFAULT NULL,
  `size_id` bigint UNSIGNED DEFAULT NULL,
  `price` decimal(12,2) DEFAULT NULL,
  `quantity` int NOT NULL DEFAULT '0',
  `stock_quantity` int NOT NULL DEFAULT '0',
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `attributes` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `texture_id` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_variants`
--

INSERT INTO `product_variants` (`id`, `product_id`, `sku`, `color_id`, `size_id`, `price`, `quantity`, `stock_quantity`, `is_default`, `image`, `status`, `attributes`, `created_at`, `updated_at`, `texture_id`, `deleted_at`) VALUES
(20, 20, 'XNWGEGBAKRBM', 2, 1, 0.00, 12, 0, 0, 'products/xmXtGpC6ZtAkLRxuhl85eqsAyUo2x6uhFsUqLNWA.jpg', 1, NULL, '2025-10-19 01:55:17', '2025-10-19 23:15:05', 1, NULL),
(21, 20, 'ZVRAZIV99OJD', 2, 1, 0.00, 1, 0, 0, 'products/KIRjMOcAhekXb0LIWagUphaIBZTrLST7oyIAxOct.jpg', 1, NULL, '2025-10-19 02:03:21', '2025-10-19 23:15:05', 2, NULL),
(22, 20, 'EVGCCPBBF0IN', 2, 2, 0.00, 1, 0, 0, 'products/IZPxHXwKQXvN7Rj8RRmJb3yT865UPI6pstpwo2zs.jpg', 1, NULL, '2025-10-19 02:03:21', '2025-10-19 02:42:57', 1, NULL),
(23, 20, 'KDKQJGQM5LAB', 2, 2, 0.00, 1, 0, 0, 'products/lJfyBT1X2mew7occj1kHFQHL8HSAB6CWfaoamZ1l.jpg', 1, NULL, '2025-10-19 02:03:21', '2025-10-19 02:42:57', 2, NULL),
(24, 20, 'I7BFNIYSJYHI', 3, 1, 0.00, 1, 0, 0, 'products/yCjCHa2S53WPBLkoPqoMTQt6UIRyHEOgYKszgLhz.jpg', 1, NULL, '2025-10-19 02:03:21', '2025-10-19 02:42:57', 1, NULL),
(25, 20, 'EHWJ948LFLLJ', 3, 1, 0.00, 1, 0, 0, 'products/OWwE8WNgx5zoUKQavxerHdmeOx5fN1UT9fy4bUVN.jpg', 1, NULL, '2025-10-19 02:03:21', '2025-10-19 02:42:57', 2, NULL),
(26, 20, 'RUUGSYZIDUK7', 3, 2, 0.00, 1, 0, 0, 'products/jtruR8XNnRR4LHStRoSLYHw7fl4WibkwpsxVDxwn.jpg', 1, NULL, '2025-10-19 02:03:21', '2025-10-19 02:42:57', 1, NULL),
(27, 20, 'MIBRHEPL21ZJ', 3, 2, 0.00, 1, 0, 0, 'products/huFF2cclZZ8M4xSbtlo3TvorRzQCfhxkWpXN52XO.jpg', 1, NULL, '2025-10-19 02:03:21', '2025-10-19 02:42:57', 2, NULL),
(28, 20, 'MUG08PUM4RUQ', 2, 10, 0.00, 1, 0, 0, NULL, 1, NULL, '2025-10-19 09:10:18', '2025-10-19 09:10:18', 1, NULL),
(29, 20, 'CMHGHPZ6JRU1', 2, 10, 0.00, 1, 0, 0, NULL, 1, NULL, '2025-10-19 09:10:18', '2025-10-19 09:10:18', 2, NULL),
(30, 20, 'KEK8LSFKRREW', 3, 10, 0.00, 1, 0, 0, NULL, 1, NULL, '2025-10-19 09:10:18', '2025-10-19 09:10:18', 1, NULL),
(31, 20, 'M4KGLBCEBD2F', 3, 10, 0.00, 1, 0, 0, NULL, 1, NULL, '2025-10-19 09:10:18', '2025-10-19 09:10:18', 2, NULL),
(32, 20, 'YEG4YWPJY252', 2, 11, 0.00, 1, 0, 0, NULL, 1, NULL, '2025-10-19 09:10:18', '2025-10-19 09:10:18', 1, NULL),
(33, 20, 'LWJQKGPB5C5N', 2, 11, 0.00, 1, 0, 0, NULL, 1, NULL, '2025-10-19 09:10:18', '2025-10-19 09:10:18', 2, NULL),
(34, 20, 'Z2HSXFCNLLOS', 3, 11, 0.00, 1, 0, 0, NULL, 1, NULL, '2025-10-19 09:10:18', '2025-10-19 09:10:18', 1, NULL),
(35, 20, '4ZI3XVWWQQPP', 3, 11, 0.00, 1, 0, 0, NULL, 1, NULL, '2025-10-19 09:10:18', '2025-10-19 09:10:18', 2, NULL),
(36, 20, 'NHJVNRNCHLAE', 2, 10, 0.00, 1, 0, 0, NULL, 1, NULL, '2025-10-19 09:10:18', '2025-10-19 09:10:18', 1, NULL),
(37, 20, 'IIC8GQHZO1HI', 2, 10, 0.00, 1, 0, 0, NULL, 1, NULL, '2025-10-19 09:10:18', '2025-10-19 09:10:18', 2, NULL),
(38, 20, 'EAG6H9AJYTO4', 3, 10, 0.00, 1, 0, 0, NULL, 1, NULL, '2025-10-19 09:10:18', '2025-10-19 09:10:18', 1, NULL),
(39, 20, 'PLQP8MU5QZIV', 3, 10, 0.00, 1, 0, 0, NULL, 1, NULL, '2025-10-19 09:10:18', '2025-10-19 09:10:18', 2, NULL),
(40, 20, 'YYI72T97L9TS', 2, 11, 0.00, 1, 0, 0, NULL, 1, NULL, '2025-10-19 09:10:18', '2025-10-19 09:10:18', 1, NULL),
(41, 20, 'FVWJAPQIVRYA', 2, 11, 0.00, 1, 0, 0, NULL, 1, NULL, '2025-10-19 09:10:18', '2025-10-19 09:10:18', 2, NULL),
(42, 20, 'FJMWILZF1HIB', 3, 11, 0.00, 1, 0, 0, NULL, 1, NULL, '2025-10-19 09:10:18', '2025-10-19 09:10:18', 1, NULL),
(43, 20, 'BL79U2PLSZGD', 3, 11, 0.00, 1, 0, 0, NULL, 1, NULL, '2025-10-19 09:10:18', '2025-10-19 09:10:18', 2, NULL),
(44, 20, 'VIRKZTE8IBPA', 2, 10, 0.00, 1, 0, 0, NULL, 1, NULL, '2025-10-19 09:10:19', '2025-10-19 09:10:19', 1, NULL),
(45, 20, '34I2KMFG8SB4', 2, 10, 0.00, 1, 0, 0, NULL, 1, NULL, '2025-10-19 09:10:19', '2025-10-19 09:10:19', 2, NULL),
(46, 20, 'QIIXBALEWMX2', 3, 10, 0.00, 1, 0, 0, NULL, 1, NULL, '2025-10-19 09:10:19', '2025-10-19 09:10:19', 1, NULL),
(47, 20, 'TSVC4U4VCQJE', 3, 10, 0.00, 1, 0, 0, NULL, 1, NULL, '2025-10-19 09:10:19', '2025-10-19 09:10:19', 2, NULL),
(48, 20, 'P7PTPM52EFVX', 2, 11, 0.00, 1, 0, 0, NULL, 1, NULL, '2025-10-19 09:10:19', '2025-10-19 09:10:19', 1, NULL),
(49, 20, 'PIWJOZMFNUGS', 2, 11, 0.00, 1, 0, 0, NULL, 1, NULL, '2025-10-19 09:10:19', '2025-10-19 09:10:19', 2, NULL),
(50, 20, 'L5ZN8GN2UZOC', 3, 11, 0.00, 1, 0, 0, NULL, 1, NULL, '2025-10-19 09:10:19', '2025-10-19 09:10:19', 1, NULL),
(51, 20, 'TOLVSCJSSLTQ', 3, 11, 0.00, 1, 0, 0, NULL, 1, NULL, '2025-10-19 09:10:19', '2025-10-19 09:10:19', 2, NULL),
(52, 22, 'TGL5JDG0J3LT', 8, 11, 0.00, 1, 0, 0, 'products/9eu961G3qQEVz4N3orHSFSkEoICig52w0J0FMONn.jpg', 1, NULL, '2025-10-21 11:02:01', '2025-10-21 11:02:01', 7, NULL),
(53, 23, 'AET7ZGAYF6NX', 7, 9, 0.00, 1, 0, 0, 'products/rsxEtt6KuiFSbwDGbgIBhHOrzc8nlHX2yOEfG7Vw.jpg', 1, NULL, '2025-10-21 11:04:20', '2025-10-25 05:00:54', 6, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(2, 'Admin', 'Quản Lý Toàn Bộ Website', '2025-10-19 07:12:44', '2025-10-19 23:19:24'),
(3, 'Staff', 'Quản trị viên hệ thống', '2025-10-19 23:25:04', '2025-10-19 23:25:04');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('m3tP9UOXrWuCfeTnvmfAJx9TGx4mVaL5IhKas4BH', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTFlyWHdUaGpPN2hZWGlDWHZYbFJ4VDE0V1ZNUm1CTXRSeHJMYVZuVyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fX0=', 1762404604),
('Vi39o9DGH7Pf8y2tPu38bPZhnovSI8km79lIHQts', 57, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSWw4M3lqd0dkaTVxd3U1QWlaeEF1RWlOMDl2M1Y5TmtGV0dGNExxdyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9iYW5uZXJzL2NyZWF0ZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjU3O30=', 1762354873);

-- --------------------------------------------------------

--
-- Table structure for table `shipping_carriers`
--

CREATE TABLE `shipping_carriers` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipping_carriers`
--

INSERT INTO `shipping_carriers` (`id`, `name`, `code`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Giao Hàng Nhanh (GHN)', 'GHN', 1, '2025-10-13 03:41:24', '2025-10-13 03:41:24'),
(2, 'Giao Hàng Tiết Kiệm (GHTK)', 'GHTK', 1, '2025-10-13 03:41:24', '2025-10-13 03:41:24'),
(3, 'Viettel Post', 'VIETTEL', 1, '2025-10-13 03:41:24', '2025-10-13 03:41:24'),
(4, 'VNPost', 'VNPOST', 1, '2025-10-13 03:41:24', '2025-10-13 03:41:24'),
(5, 'J&T Express', 'JT', 1, '2025-10-13 03:41:24', '2025-10-13 03:41:24'),
(6, 'Ninja Van', 'NINJA', 1, '2025-10-13 03:41:24', '2025-10-13 03:41:24'),
(7, 'Best Express', 'BEST', 1, '2025-10-13 03:41:24', '2025-10-13 03:41:24'),
(8, 'DHL', 'DHL', 1, '2025-10-13 03:41:24', '2025-10-13 03:41:24'),
(9, 'FedEx', 'FEDEX', 1, '2025-10-13 03:41:24', '2025-10-13 03:41:24'),
(10, 'UPS', 'UPS', 1, '2025-10-13 03:41:24', '2025-10-13 04:19:57');

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE `sizes` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1: active, 0: inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`id`, `name`, `description`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'S', NULL, 1, '2025-10-11 20:14:03', '2025-10-19 08:53:12', '2025-10-19 08:53:12'),
(2, 'L', NULL, 1, '2025-10-11 20:14:58', '2025-10-19 08:53:08', '2025-10-19 08:53:08'),
(3, 'M', NULL, 1, '2025-10-11 20:15:03', '2025-10-19 08:53:16', '2025-10-19 08:53:16'),
(4, 'XL', 'To', 1, '2025-10-11 22:07:46', '2025-10-19 08:52:58', '2025-10-19 08:52:58'),
(5, 'XS', NULL, 1, '2025-10-18 22:21:11', '2025-10-19 08:53:19', '2025-10-19 08:53:19'),
(6, 'XXL', NULL, 1, '2025-10-18 22:21:11', '2025-10-19 08:53:04', '2025-10-19 08:53:04'),
(7, 'XXXL', NULL, 1, '2025-10-18 22:21:11', '2025-10-19 08:52:52', '2025-10-19 08:52:52'),
(8, 'XS', NULL, 1, '2025-10-18 22:21:47', '2025-10-25 23:15:00', NULL),
(9, 'S', NULL, 1, '2025-10-18 22:21:47', '2025-10-18 22:21:47', NULL),
(10, 'M', NULL, 1, '2025-10-18 22:21:47', '2025-10-18 22:21:47', NULL),
(11, 'L', NULL, 1, '2025-10-18 22:21:47', '2025-10-18 22:21:47', NULL),
(12, 'XL', NULL, 1, '2025-10-18 22:21:47', '2025-10-18 22:21:47', NULL),
(13, 'XXL', NULL, 1, '2025-10-18 22:21:47', '2025-10-19 08:53:26', '2025-10-19 08:53:26'),
(14, 'XXXL', NULL, 1, '2025-10-18 22:21:47', '2025-10-19 08:53:23', '2025-10-19 08:53:23');

-- --------------------------------------------------------

--
-- Table structure for table `taggables`
--

CREATE TABLE `taggables` (
  `id` bigint UNSIGNED NOT NULL,
  `tag_id` bigint UNSIGNED NOT NULL,
  `taggable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taggable_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tax_rates`
--

CREATE TABLE `tax_rates` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate` decimal(5,4) NOT NULL DEFAULT '0.0000',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tax_rates`
--

INSERT INTO `tax_rates` (`id`, `name`, `rate`, `created_at`, `updated_at`) VALUES
(1, 'VAT 0%', 0.0000, '2025-10-13 03:40:15', '2025-10-13 03:40:15'),
(2, 'VAT 5%', 0.0500, '2025-10-13 03:40:15', '2025-10-13 03:40:15'),
(3, 'VAT 8%', 0.0800, '2025-10-13 03:40:15', '2025-10-13 03:40:15'),
(4, 'VAT 10%', 0.1000, '2025-10-13 03:40:15', '2025-10-13 03:40:15'),
(5, 'Luxury 35%', 0.3500, '2025-10-13 03:40:15', '2025-10-13 04:20:47');

-- --------------------------------------------------------

--
-- Table structure for table `textures`
--

CREATE TABLE `textures` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1: active, 0: inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `textures`
--

INSERT INTO `textures` (`id`, `name`, `description`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Vải', NULL, 1, '2025-10-11 20:14:19', '2025-10-12 00:19:46', NULL),
(2, 'Cotton', NULL, 1, '2025-10-12 00:19:20', '2025-10-12 00:19:20', NULL),
(3, 'Da', NULL, 1, '2025-10-12 00:19:32', '2025-10-12 00:19:32', NULL),
(4, 'Polyester', NULL, 1, '2025-10-18 22:21:11', '2025-10-18 22:21:11', NULL),
(5, 'Linen', NULL, 1, '2025-10-18 22:21:11', '2025-10-18 22:21:11', NULL),
(6, 'Silk', NULL, 1, '2025-10-18 22:21:11', '2025-10-18 22:21:11', NULL),
(7, 'Denim', NULL, 1, '2025-10-18 22:21:11', '2025-10-18 22:21:11', NULL),
(8, 'Wool', NULL, 1, '2025-10-18 22:21:11', '2025-10-18 22:21:11', NULL),
(9, 'Leather', NULL, 1, '2025-10-18 22:21:11', '2025-10-18 22:21:11', NULL),
(10, 'Synthetic', NULL, 1, '2025-10-18 22:21:11', '2025-10-18 22:21:11', NULL),
(11, 'Cotton', NULL, 1, '2025-10-18 22:21:47', '2025-10-18 22:21:47', NULL),
(12, 'Polyester', NULL, 1, '2025-10-18 22:21:47', '2025-10-18 22:21:47', NULL),
(13, 'Linen', NULL, 1, '2025-10-18 22:21:47', '2025-10-18 22:21:47', NULL),
(14, 'Silk', NULL, 1, '2025-10-18 22:21:47', '2025-10-18 22:21:47', NULL),
(15, 'Denim', NULL, 1, '2025-10-18 22:21:47', '2025-10-18 22:21:47', NULL),
(16, 'Wool', NULL, 1, '2025-10-18 22:21:47', '2025-10-18 22:21:47', NULL),
(17, 'Leather', NULL, 1, '2025-10-18 22:21:47', '2025-10-18 22:21:47', NULL),
(18, 'Synthetic', NULL, 1, '2025-10-18 22:21:47', '2025-10-18 22:21:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_admin` int NOT NULL DEFAULT '0' COMMENT '0 -> User, 1 -> Admin',
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_verified` int NOT NULL DEFAULT '0' COMMENT '0 -> Unverified, 1 -> Verified',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `verification_token` text COLLATE utf8mb4_unicode_ci,
  `token_expires_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive','blocked') COLLATE utf8mb4_unicode_ci NOT NULL,
  `salary` decimal(10,2) DEFAULT NULL,
  `hire_date` date DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `role` tinyint NOT NULL DEFAULT '0' COMMENT '0: user, 1: admin, 2: staff'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `is_admin`, `phone_number`, `is_verified`, `email_verified_at`, `password`, `verification_token`, `token_expires_at`, `remember_token`, `created_at`, `updated_at`, `avatar`, `status`, `salary`, `hire_date`, `deleted_at`, `role`) VALUES
(56, 'Phong', 'admin@example.com', 1, NULL, 0, '2025-10-19 22:30:00', '$2y$12$SsAwPgg4JUk3E2rAlBWkwOycrbHuIB5yqNRsNWhkBYtBwcKSLJiUi', NULL, NULL, NULL, '2025-10-19 22:30:00', '2025-10-19 22:30:00', NULL, 'active', NULL, NULL, NULL, 1),
(57, 'Phongbt', 'admin@test.com', 1, NULL, 0, '2025-10-19 22:30:00', '$2y$12$yng8wr/VR7agiyKH./HJLuyv0RRqMtXy0XLOcdnRWGpbcrwT4KLYC', NULL, NULL, NULL, '2025-10-19 22:30:00', '2025-10-25 21:47:35', 'users/1761454055_banner-07.jpg', 'active', NULL, NULL, NULL, 1),
(58, 'Phong', 'staff@test.com', 0, NULL, 0, '2025-10-19 22:30:01', '$2y$12$rRvrPByC6LTGyAMtlZEl5.gp2FUCLx/A8bmwUgYKqRtykPEoz3..m', NULL, NULL, NULL, '2025-10-19 22:30:01', '2025-10-19 22:30:01', NULL, 'active', NULL, NULL, NULL, 2),
(59, 'Normal User', 'user@test.com', 0, NULL, 0, '2025-10-19 22:30:01', '$2y$12$iZkw.TKMeiRFyHqsvwFT.Oj1ObrMHuCAflQctHb/hv1UJD9ADyqcO', NULL, NULL, NULL, '2025-10-19 22:30:01', '2025-10-19 22:30:01', NULL, 'active', NULL, NULL, NULL, 0),
(60, 'Test User 1', 'test1@test.com', 0, NULL, 0, '2025-10-19 22:30:01', '$2y$12$jEPIBmI9vRQLikbEXTSwNugVKs5w4SuCgYbtC/9plkDKIYPcJ/ecu', NULL, NULL, NULL, '2025-10-19 22:30:01', '2025-10-19 22:30:01', NULL, 'active', NULL, NULL, NULL, 0),
(61, 'Test User 2', 'test2@test.com', 0, NULL, 0, '2025-10-19 22:30:01', '$2y$12$c1glojiDnYN3rzef3xbNjeGUgX1V8bBGROxmA..pwPxdZIvdTAx0O', NULL, NULL, NULL, '2025-10-19 22:30:01', '2025-10-19 22:30:01', NULL, 'inactive', NULL, NULL, NULL, 0),
(62, 'Test User 3', 'test3@test.com', 0, NULL, 0, '2025-10-19 22:30:02', '$2y$12$a1WQeEauGhj8dZE8cBYMdus4X9lWhVQOkrnfH3cCp.o3Z/ZxrV1aG', NULL, NULL, NULL, '2025-10-19 22:30:02', '2025-10-19 22:30:02', NULL, 'blocked', NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_loyalty`
--

CREATE TABLE `user_loyalty` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `loyalty_tier_id` bigint UNSIGNED NOT NULL,
  `total_spent` decimal(12,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

CREATE TABLE `vouchers` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('percent','fixed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'percent',
  `value` decimal(10,2) NOT NULL,
  `max_discount_amount` decimal(12,2) DEFAULT NULL,
  `min_order_amount` decimal(12,2) DEFAULT NULL,
  `usage_limit` int UNSIGNED DEFAULT NULL,
  `used_count` int UNSIGNED NOT NULL DEFAULT '0',
  `starts_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vouchers`
--

INSERT INTO `vouchers` (`id`, `code`, `description`, `type`, `value`, `max_discount_amount`, `min_order_amount`, `usage_limit`, `used_count`, `starts_at`, `ends_at`, `is_active`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'HEHE123', NULL, 'percent', 10.00, 200000.00, 20.00, 5, 0, '2025-11-05 09:33:00', '2025-11-06 09:33:00', 1, NULL, '2025-11-05 02:33:16', '2025-11-05 03:17:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_reports`
--
ALTER TABLE `admin_reports`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_reports_user_id_report_date_unique` (`user_id`,`report_date`);

--
-- Indexes for table `app_data`
--
ALTER TABLE `app_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `brands_slug_unique` (`slug`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_owner_product_variant_index` (`user_id`,`session_id`,`product_id`,`variant_id`),
  ADD KEY `carts_session_id_index` (`session_id`),
  ADD KEY `carts_user_id_index` (`user_id`),
  ADD KEY `carts_product_id_index` (`product_id`),
  ADD KEY `carts_variant_id_index` (`variant_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `inventory_logs`
--
ALTER TABLE `inventory_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventory_logs_variant_id_foreign` (`variant_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loyalty_tiers`
--
ALTER TABLE `loyalty_tiers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `loyalty_tiers_name_unique` (`name`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_code_unique` (`code`),
  ADD KEY `orders_session_id_index` (`session_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_index` (`order_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`role_id`,`permission_id`),
  ADD KEY `permission_role_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `posts_slug_unique` (`slug`),
  ADD KEY `posts_user_id_foreign` (`user_id`),
  ADD KEY `posts_category_id_foreign` (`category_id`);
ALTER TABLE `posts` ADD FULLTEXT KEY `posts_title_description_content_fulltext` (`title`,`description`,`content`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_brand_id_foreign` (`brand_id`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_sku_index` (`sku`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_product_id_foreign` (`product_id`),
  ADD KEY `product_images_variant_id_foreign` (`variant_id`);

--
-- Indexes for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_variants_sku_unique` (`sku`),
  ADD KEY `product_variants_product_id_foreign` (`product_id`),
  ADD KEY `product_variants_color_id_foreign` (`color_id`),
  ADD KEY `product_variants_size_id_foreign` (`size_id`),
  ADD KEY `product_variants_texture_id_foreign` (`texture_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `shipping_carriers`
--
ALTER TABLE `shipping_carriers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `shipping_carriers_code_unique` (`code`);

--
-- Indexes for table `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `taggables`
--
ALTER TABLE `taggables`
  ADD PRIMARY KEY (`id`),
  ADD KEY `taggables_tag_id_foreign` (`tag_id`),
  ADD KEY `taggables_taggable_type_taggable_id_index` (`taggable_type`,`taggable_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tags_slug_unique` (`slug`);

--
-- Indexes for table `tax_rates`
--
ALTER TABLE `tax_rates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tax_rates_name_unique` (`name`);

--
-- Indexes for table `textures`
--
ALTER TABLE `textures`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_loyalty`
--
ALTER TABLE `user_loyalty`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_loyalty_user_id_foreign` (`user_id`),
  ADD KEY `user_loyalty_loyalty_tier_id_foreign` (`loyalty_tier_id`);

--
-- Indexes for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vouchers_code_unique` (`code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_reports`
--
ALTER TABLE `admin_reports`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_data`
--
ALTER TABLE `app_data`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `colors`
--
ALTER TABLE `colors`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_logs`
--
ALTER TABLE `inventory_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `loyalty_tiers`
--
ALTER TABLE `loyalty_tiers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `shipping_carriers`
--
ALTER TABLE `shipping_carriers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `taggables`
--
ALTER TABLE `taggables`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tax_rates`
--
ALTER TABLE `tax_rates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `textures`
--
ALTER TABLE `textures`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `user_loyalty`
--
ALTER TABLE `user_loyalty`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_variant_id_foreign` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inventory_logs`
--
ALTER TABLE `inventory_logs`
  ADD CONSTRAINT `inventory_logs_variant_id_foreign` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_images_variant_id_foreign` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD CONSTRAINT `product_variants_color_id_foreign` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `product_variants_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_variants_size_id_foreign` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `product_variants_texture_id_foreign` FOREIGN KEY (`texture_id`) REFERENCES `textures` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `taggables`
--
ALTER TABLE `taggables`
  ADD CONSTRAINT `taggables_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_loyalty`
--
ALTER TABLE `user_loyalty`
  ADD CONSTRAINT `user_loyalty_loyalty_tier_id_foreign` FOREIGN KEY (`loyalty_tier_id`) REFERENCES `loyalty_tiers` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `user_loyalty_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
