-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 29, 2026 at 01:48 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ukk_2026`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2026_01_17_015424_create_permission_tables', 1),
(6, '2026_02_02_011244_tb_area_parkir', 2);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 3),
(3, 'App\\Models\\User', 4),
(1, 'App\\Models\\User', 5),
(1, 'App\\Models\\User', 7),
(1, 'App\\Models\\User', 8);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2026-02-01 08:11:04', '2026-02-01 08:11:04'),
(2, 'Petugas Parkir', 'web', '2026-02-01 08:11:04', '2026-02-01 08:11:04'),
(3, 'Owner/Manajemen', 'web', '2026-02-01 08:11:04', '2026-02-01 08:11:04');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_area_parkir`
--

CREATE TABLE `tb_area_parkir` (
  `id` int NOT NULL,
  `kode_area` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `nama_area` varchar(50) DEFAULT NULL,
  `lokasi` varchar(50) DEFAULT NULL,
  `kapasitas` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(20) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_area_parkir`
--

INSERT INTO `tb_area_parkir` (`id`, `kode_area`, `nama_area`, `lokasi`, `kapasitas`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(1, 'AREA-1', 'A', 'Basement', 100, NULL, NULL, '2026-02-02 19:46:33', '1', NULL, NULL),
(2, 'AREA-2', 'B', 'Basement', 200, '2026-02-01 18:32:38', '1', '2026-02-02 19:46:19', '1', NULL, NULL),
(3, 'AREA-3', 'C', 'Basement', 300, '2026-02-01 19:06:34', '1', '2026-02-02 20:08:38', '1', NULL, NULL),
(4, 'AREA-4', 'D', 'Basement', 300, '2026-02-01 19:06:34', '1', '2026-02-02 20:08:38', '1', NULL, NULL),
(5, 'AREA-5', 'E', 'Basement', NULL, '2026-02-04 03:41:14', '1', '2026-02-04 03:42:42', '1', NULL, NULL),
(6, 'AREA-6', 'F', 'Basement', NULL, '2026-02-04 03:55:17', '1', '2026-02-04 03:55:17', NULL, NULL, NULL),
(7, 'AREA-7', 'Rooftop', 'SMKN 1 Boyolangu', NULL, '2026-02-08 18:51:00', '5', '2026-02-09 21:25:12', '1', NULL, '1'),
(8, 'AREA-8', 'F', 'SMKN 1 Boyolangu', NULL, '2026-02-08 23:46:48', '1', '2026-02-08 23:46:48', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_area_parkir_detail`
--

CREATE TABLE `tb_area_parkir_detail` (
  `id` int NOT NULL,
  `area_parkir_id` int DEFAULT NULL,
  `id_tipe_kendaraan` int DEFAULT NULL,
  `kapasitas` int DEFAULT NULL,
  `terisi` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_area_parkir_detail`
--

INSERT INTO `tb_area_parkir_detail` (`id`, `area_parkir_id`, `id_tipe_kendaraan`, `kapasitas`, `terisi`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(1, 2, 1, 200, 19, NULL, NULL, '2026-02-12 15:52:52', NULL, NULL, NULL),
(2, 2, 2, 300, 0, NULL, NULL, '2026-02-10 00:33:54', NULL, NULL, NULL),
(9, 2, 3, 100, 0, '2026-02-02 19:46:19', '1', '2026-02-10 02:06:26', NULL, NULL, NULL),
(14, 1, 4, 300, 0, '2026-02-02 19:48:53', '1', '2026-02-07 05:11:59', NULL, NULL, NULL),
(23, 5, 1, 200, 0, '2026-02-04 03:52:00', '1', '2026-02-07 20:29:51', NULL, NULL, NULL),
(25, 4, 4, 200, 0, '2026-02-04 03:53:48', '1', '2026-02-05 06:18:27', NULL, NULL, NULL),
(26, 6, 4, 200, 1, '2026-02-04 03:55:17', '1', '2026-02-10 00:29:28', NULL, NULL, NULL),
(27, 3, 4, 400, 0, '2026-02-04 03:55:27', '1', '2026-02-07 00:44:48', '1', NULL, NULL),
(29, 7, 2, 100, 0, '2026-02-08 18:51:00', '5', '2026-02-12 14:05:45', '1', NULL, NULL),
(30, 7, 1, 200, 0, '2026-02-08 18:51:00', '5', '2026-02-12 14:05:45', '1', NULL, NULL),
(31, 8, 1, 200, 0, '2026-02-08 23:46:48', '1', '2026-02-08 23:46:48', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_data_kendaraan`
--

CREATE TABLE `tb_data_kendaraan` (
  `id` int NOT NULL,
  `id_tipe_kendaraan` int DEFAULT NULL,
  `plat_nomor` varchar(15) NOT NULL,
  `warna` varchar(20) DEFAULT NULL,
  `pemilik` varchar(100) DEFAULT NULL,
  `aktif` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_data_kendaraan`
--

INSERT INTO `tb_data_kendaraan` (`id`, `id_tipe_kendaraan`, `plat_nomor`, `warna`, `pemilik`, `aktif`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(1, 1, 'ag 2020', 'merah', 'jokowi', 1, '2026-02-01 07:24:58', 'admin', '2026-02-01 07:27:01', 'admin', NULL, NULL),
(2, 2, 'b 5050', 'pink', 'jikiwi', 1, '2026-02-01 07:27:22', 'admin', '2026-02-01 07:33:23', 'admin', NULL, NULL),
(3, 2, 'c 1231', 'hitam', 'jakawa', 1, '2026-02-02 06:35:21', 'Admin', '2026-02-02 06:35:21', NULL, NULL, NULL),
(4, 1, 'jb 13131', 'hitam', 'jikiwi', 1, '2026-02-02 06:37:30', 'Admin', '2026-02-02 06:37:37', 'Admin', NULL, NULL),
(5, 3, 'al 3103', 'hitam', 'jokowi', 1, '2026-02-02 06:40:10', 'Admin', '2026-02-02 06:40:10', NULL, NULL, NULL),
(6, 1, 'B1234yx', 'merah', 'mukti', 1, '2026-02-02 20:55:24', '3', '2026-02-02 20:55:24', NULL, NULL, NULL),
(9, 4, 'b1231', 'pink', 'mukti', 1, '2026-02-03 19:30:31', '3', '2026-02-03 19:30:31', NULL, NULL, NULL),
(10, 3, 'ag505', 'merah', 'mukti', 1, '2026-02-04 04:01:47', '3', '2026-02-04 04:01:47', NULL, NULL, NULL),
(11, 1, 'n1234', 'merah', 'ALDO', 1, '2026-02-04 07:16:34', '3', '2026-02-04 07:16:34', NULL, NULL, NULL),
(12, 2, 'N3123', 'hitam', 'ALDO', 1, '2026-02-04 07:17:08', '3', '2026-02-04 07:17:08', NULL, NULL, NULL),
(13, 1, 'n1212', 'merah', 'ALDO', 1, '2026-02-04 07:30:33', '3', '2026-02-04 07:30:33', NULL, NULL, NULL),
(14, 4, 'nd31', 'merah', 'ALDO', 1, '2026-02-04 07:44:43', '3', '2026-02-04 07:44:43', NULL, NULL, NULL),
(15, 4, 'j1313', 'merah', 'ALDO', 1, '2026-02-04 07:52:00', '3', '2026-02-04 07:52:00', NULL, NULL, NULL),
(16, 4, 'b1223', 'merah', 'mukti', 1, '2026-02-04 08:16:14', '3', '2026-02-04 08:16:14', NULL, NULL, NULL),
(17, 4, 'ag40204', 'merah', 'jokowi', 1, '2026-02-04 19:08:33', '3', '2026-02-04 19:08:33', NULL, NULL, NULL),
(18, 2, 'AG123RS', 'merah', NULL, 1, '2026-02-08 19:21:39', '3', '2026-02-08 19:21:39', NULL, NULL, NULL),
(19, 2, 'AG1234RS', 'merah', 'mukti', 1, '2026-02-08 19:22:54', '3', '2026-02-08 19:22:54', NULL, NULL, NULL),
(20, 2, 'ag456rs', 'merah', 'mukti', 1, '2026-02-08 19:22:54', '3', '2026-02-08 19:22:54', NULL, NULL, NULL),
(21, 1, 'ag555', 'merah', NULL, 1, '2026-02-09 02:48:40', '3', '2026-02-09 02:48:40', NULL, NULL, NULL),
(22, 1, 'AG5000', 'merah', 'smea', 1, '2026-02-10 01:57:24', '3', '2026-02-10 01:57:24', NULL, NULL, NULL),
(23, 1, 'AG9000GF', 'pink', 'ALDO', 1, '2026-02-10 02:02:19', '3', '2026-02-10 02:02:19', NULL, NULL, NULL),
(24, 1, 'B 1234', 'merah', '1212', 1, '2026-02-10 09:46:43', '3', '2026-02-10 09:46:43', NULL, NULL, NULL),
(25, 1, 'AG 1322 GH', 'merah', 'mukti', 1, '2026-02-10 10:24:45', '3', '2026-02-10 10:24:45', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_diskon`
--

CREATE TABLE `tb_diskon` (
  `id` int NOT NULL,
  `nama_diskon` varchar(50) DEFAULT NULL,
  `diskon` int DEFAULT NULL,
  `waktu_mulai` datetime DEFAULT NULL,
  `waktu_selesai` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_diskon`
--

INSERT INTO `tb_diskon` (`id`, `nama_diskon`, `diskon`, `waktu_mulai`, `waktu_selesai`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(1, 'idul fitri', 10, '2026-02-01 00:00:00', '2026-02-12 00:00:00', '2026-02-07 03:29:00', '1', '2026-02-07 03:41:44', '1', NULL, NULL),
(2, 'idul adha', 20, '2026-02-01 00:00:00', '2026-02-12 00:00:00', '2026-02-07 03:29:00', '1', '2026-02-07 03:41:44', '1', NULL, NULL),
(3, 'tahun baru', 10, '2026-02-03 00:00:00', '2026-02-14 00:00:00', '2026-02-11 00:58:09', '1', '2026-02-11 01:03:13', '1', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_log_aktivitas`
--

CREATE TABLE `tb_log_aktivitas` (
  `id` int NOT NULL,
  `id_user` bigint UNSIGNED DEFAULT NULL,
  `ip` varchar(50) DEFAULT NULL,
  `user_agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `method` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `activity` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `before` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `after` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_log_aktivitas`
--

INSERT INTO `tb_log_aktivitas` (`id`, `id_user`, `ip`, `user_agent`, `method`, `activity`, `before`, `after`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1740, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'index', 'Akses menu / halaman: log-aktivitas.index (log-aktivitas)', NULL, NULL, '2026-02-12 14:05:14', 'Admin', '2026-02-12 14:05:14', NULL),
(1741, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'index', 'Akses menu / halaman: log-aktivitas.index (log-aktivitas)', NULL, NULL, '2026-02-12 14:05:15', 'Admin', '2026-02-12 14:05:15', NULL),
(1742, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'index', 'Akses menu / halaman: log-aktivitas.index (log-aktivitas)', NULL, NULL, '2026-02-12 14:05:19', 'Admin', '2026-02-12 14:05:19', NULL),
(1743, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'index', 'Akses menu / halaman: log-aktivitas.index (log-aktivitas)', NULL, NULL, '2026-02-12 14:05:19', 'Admin', '2026-02-12 14:05:19', NULL),
(1744, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'index', 'Akses menu / halaman: area-parkir.index (area-parkir)', NULL, NULL, '2026-02-12 14:05:30', 'Admin', '2026-02-12 14:05:30', NULL),
(1745, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'index', 'Akses menu / halaman: area-parkir.index (area-parkir)', NULL, NULL, '2026-02-12 14:05:30', 'Admin', '2026-02-12 14:05:30', NULL),
(1746, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'edit', 'Akses menu / halaman: area-parkir.edit (area-parkir/7/edit)', NULL, NULL, '2026-02-12 14:05:38', 'Admin', '2026-02-12 14:05:38', NULL),
(1747, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'update', 'Akses menu / halaman: area-parkir.update (area-parkir/7)', NULL, NULL, '2026-02-12 14:05:45', 'Admin', '2026-02-12 14:05:45', NULL),
(1748, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'index', 'Akses menu / halaman: area-parkir.index (area-parkir)', NULL, NULL, '2026-02-12 14:05:46', 'Admin', '2026-02-12 14:05:46', NULL),
(1749, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'index', 'Akses menu / halaman: area-parkir.index (area-parkir)', NULL, NULL, '2026-02-12 14:05:46', 'Admin', '2026-02-12 14:05:46', NULL),
(1750, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'index', 'Akses menu / halaman: log-aktivitas.index (log-aktivitas)', NULL, NULL, '2026-02-12 14:05:49', 'Admin', '2026-02-12 14:05:49', NULL),
(1751, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'index', 'Akses menu / halaman: log-aktivitas.index (log-aktivitas)', NULL, NULL, '2026-02-12 14:05:49', 'Admin', '2026-02-12 14:05:49', NULL),
(1752, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'index', 'Akses menu / halaman: log-aktivitas.index (log-aktivitas)', NULL, NULL, '2026-02-12 14:06:07', 'Admin', '2026-02-12 14:06:07', NULL),
(1753, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'index', 'Akses menu / halaman: log-aktivitas.index (log-aktivitas)', NULL, NULL, '2026-02-12 14:06:09', 'Admin', '2026-02-12 14:06:09', NULL),
(1754, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'index', 'Akses menu / halaman: log-aktivitas.index (log-aktivitas)', NULL, NULL, '2026-02-12 14:06:11', 'Admin', '2026-02-12 14:06:11', NULL),
(1755, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'index', 'Akses menu / halaman: log-aktivitas.index (log-aktivitas)', NULL, NULL, '2026-02-12 14:06:13', 'Admin', '2026-02-12 14:06:13', NULL),
(1756, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'index', 'Akses menu / halaman: tipe-kendaraan.index (tipe-kendaraan)', NULL, NULL, '2026-02-12 14:06:22', 'Admin', '2026-02-12 14:06:22', NULL),
(1757, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'index', 'Akses menu / halaman: tipe-kendaraan.index (tipe-kendaraan)', NULL, NULL, '2026-02-12 14:06:23', 'Admin', '2026-02-12 14:06:23', NULL),
(1758, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'index', 'Akses menu / halaman: tarif.index (tarif)', NULL, NULL, '2026-02-12 14:06:36', 'Admin', '2026-02-12 14:06:36', NULL),
(1759, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'index', 'Akses menu / halaman: tarif.index (tarif)', NULL, NULL, '2026-02-12 14:06:36', 'Admin', '2026-02-12 14:06:36', NULL),
(1760, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'edit', 'Akses menu / halaman: tarif.edit (tarif/50/edit)', NULL, NULL, '2026-02-12 14:06:38', 'Admin', '2026-02-12 14:06:38', NULL),
(1761, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'update', 'Akses menu / halaman: tarif.update (tarif/50)', NULL, NULL, '2026-02-12 14:06:44', 'Admin', '2026-02-12 14:06:44', NULL),
(1762, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'index', 'Akses menu / halaman: tarif.index (tarif)', NULL, NULL, '2026-02-12 14:06:44', 'Admin', '2026-02-12 14:06:44', NULL),
(1763, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'index', 'Akses menu / halaman: tarif.index (tarif)', NULL, NULL, '2026-02-12 14:06:45', 'Admin', '2026-02-12 14:06:45', NULL),
(1764, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'index', 'Akses menu / halaman: log-aktivitas.index (log-aktivitas)', NULL, NULL, '2026-02-12 14:06:47', 'Admin', '2026-02-12 14:06:47', NULL),
(1765, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'index', 'Akses menu / halaman: log-aktivitas.index (log-aktivitas)', NULL, NULL, '2026-02-12 14:06:48', 'Admin', '2026-02-12 14:06:48', NULL),
(1766, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'update', 'Akses menu / halaman: tarif.update (tarif/9)', NULL, NULL, '2026-02-12 14:44:41', 'Admin', '2026-02-12 14:44:41', NULL),
(1767, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'update', 'Akses menu / halaman: tarif.update (tarif/9)', NULL, NULL, '2026-02-12 14:46:06', 'Admin', '2026-02-12 14:46:06', NULL),
(1768, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'update', 'Akses menu / halaman: tarif.update (tarif/9)', NULL, NULL, '2026-02-12 14:47:23', 'Admin', '2026-02-12 14:47:23', NULL),
(1769, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'update', 'Akses menu / halaman: tarif.update (tarif/9)', NULL, NULL, '2026-02-12 14:51:09', 'Admin', '2026-02-12 14:51:09', NULL),
(1770, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'update', 'Update Tarif ID: 9', '{\"tarif_per_jam\":\"15000\"}', '{\"tarif_per_jam\":\"10000\"}', '2026-02-12 14:51:10', 'Admin', '2026-02-12 14:51:10', NULL),
(1771, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'destroy', 'Akses menu / halaman: logout (logout)', NULL, NULL, '2026-02-12 14:58:30', 'Admin', '2026-02-12 14:58:30', NULL),
(1772, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'destroy', '[LOGOUT] User logout | Nama: Admin | Email: alok@gmail.com', NULL, NULL, '2026-02-12 14:58:30', 'Admin', '2026-02-12 14:58:30', NULL),
(1773, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'destroy', 'Update User ID: 1', '{\"remember_token\":\"1TccdQeOLok1n1FGny2fgJGcWYEJ1P0pT3Vbe6SOUuQXfVOe7sgNnBPsTg7x\"}', '{\"remember_token\":\"ysR8gP9i9Zb1TCVLATbGtQReEjB2qwjt3BBCY5aYKv2rsObmJBIM0YmrgRXi\"}', '2026-02-12 14:58:30', 'Admin', '2026-02-12 14:58:30', NULL),
(1774, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'store', 'Akses menu / halaman: unknown (login)', NULL, NULL, '2026-02-12 14:58:37', 'SYSTEM', '2026-02-12 14:58:37', NULL),
(1775, 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'store', '[LOGIN] User login | Nama: Petugas Parkir | Email: Aden@gmail.com', NULL, NULL, '2026-02-12 14:58:37', 'Petugas Parkir', '2026-02-12 14:58:37', NULL),
(1776, 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'masuk', 'Akses menu / halaman: transaksi.masuk (transaksi/masuk)', NULL, NULL, '2026-02-12 15:42:47', 'Petugas Parkir', '2026-02-12 15:42:47', NULL),
(1777, 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'masuk', 'Akses menu / halaman: transaksi.masuk (transaksi/masuk)', NULL, NULL, '2026-02-12 15:43:46', 'Petugas Parkir', '2026-02-12 15:43:46', NULL),
(1778, 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'masuk', 'Akses menu / halaman: transaksi.masuk (transaksi/masuk)', NULL, NULL, '2026-02-12 15:45:46', 'Petugas Parkir', '2026-02-12 15:45:46', NULL),
(1779, 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'masuk', 'Akses menu / halaman: transaksi.masuk (transaksi/masuk)', NULL, NULL, '2026-02-12 15:48:05', 'Petugas Parkir', '2026-02-12 15:48:05', NULL),
(1780, 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'masuk', 'Create data Transaksi ID: 65', NULL, '{\"kode_tiket\":\"INV\\/25\\/20260212224805\",\"id_data_kendaraan\":25,\"waktu_masuk\":\"2026-02-12 22:48:05\",\"status\":\"masuk\",\"id_area\":\"2\",\"created_by\":3,\"updated_at\":\"2026-02-12 22:48:05\",\"created_at\":\"2026-02-12 22:48:05\",\"id\":65}', '2026-02-12 15:48:05', 'Petugas Parkir', '2026-02-12 15:48:05', NULL),
(1781, 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'masuk', 'Update AreaParkirDetail ID: 1', '{\"terisi\":18}', '{\"terisi\":19}', '2026-02-12 15:48:05', 'Petugas Parkir', '2026-02-12 15:48:05', NULL),
(1782, 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'masuk', '[TRANSAKSI MASUK] Kode: INV/25/20260212224805 | Plat: AG 1322 GH | Tipe: motor | ', NULL, NULL, '2026-02-12 15:48:05', 'Petugas Parkir', '2026-02-12 15:48:05', NULL),
(1783, 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'keluar', 'Akses menu / halaman: transaksi.keluar (transaksi/keluar)', NULL, NULL, '2026-02-12 15:50:06', 'Petugas Parkir', '2026-02-12 15:50:06', NULL),
(1784, 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'keluar', 'Update Membership ID: 3', '{\"free_entry_quota\":8}', '{\"free_entry_quota\":7}', '2026-02-12 15:50:06', 'Petugas Parkir', '2026-02-12 15:50:06', NULL),
(1785, 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'keluar', '[FREE ENTRY] Plat: AG 1322 GH | Sisa Kuota: 7', NULL, NULL, '2026-02-12 15:50:06', 'Petugas Parkir', '2026-02-12 15:50:06', NULL),
(1786, 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'keluar', 'Update Transaksi ID: 65', '{\"waktu_keluar\":null,\"id_tarif\":null,\"durasi_jam\":null,\"biaya\":null,\"diskon_member\":null,\"diskon_manual\":null,\"biaya_total\":null,\"id_user\":null,\"id_metode_pembayaran\":null,\"status\":\"masuk\"}', '{\"waktu_keluar\":\"2026-02-12 22:50:06\",\"id_tarif\":1,\"durasi_jam\":1,\"biaya\":2000,\"diskon_member\":0,\"diskon_manual\":10,\"biaya_total\":0,\"id_user\":3,\"id_metode_pembayaran\":\"2\",\"status\":\"keluar\"}', '2026-02-12 15:50:06', 'Petugas Parkir', '2026-02-12 15:50:06', NULL),
(1787, 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'keluar', 'Update AreaParkirDetail ID: 1', '{\"terisi\":19}', '{\"terisi\":18}', '2026-02-12 15:50:06', 'Petugas Parkir', '2026-02-12 15:50:06', NULL),
(1788, 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'keluar', '[TRANSAKSI KELUAR] Kode: INV/25/20260212224805 | Plat: AG 1322 GH | Durasi: 1 jam | Total: Rp 0', NULL, NULL, '2026-02-12 15:50:06', 'Petugas Parkir', '2026-02-12 15:50:06', NULL),
(1789, 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'masuk', 'Akses menu / halaman: transaksi.masuk (transaksi/masuk)', NULL, NULL, '2026-02-12 15:50:33', 'Petugas Parkir', '2026-02-12 15:50:33', NULL),
(1790, 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'masuk', 'Create data Transaksi ID: 66', NULL, '{\"kode_tiket\":\"INV\\/25\\/20260212225033\",\"id_data_kendaraan\":25,\"waktu_masuk\":\"2026-02-12 22:50:33\",\"status\":\"masuk\",\"id_area\":\"2\",\"created_by\":3,\"updated_at\":\"2026-02-12 22:50:33\",\"created_at\":\"2026-02-12 22:50:33\",\"id\":66}', '2026-02-12 15:50:33', 'Petugas Parkir', '2026-02-12 15:50:33', NULL),
(1791, 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'masuk', 'Update AreaParkirDetail ID: 1', '{\"terisi\":18}', '{\"terisi\":19}', '2026-02-12 15:50:33', 'Petugas Parkir', '2026-02-12 15:50:33', NULL),
(1792, 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'masuk', '[TRANSAKSI MASUK] Kode: INV/25/20260212225033 | Plat: AG 1322 GH | Tipe: motor | ', NULL, NULL, '2026-02-12 15:50:33', 'Petugas Parkir', '2026-02-12 15:50:33', NULL),
(1793, 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'keluar', 'Akses menu / halaman: transaksi.keluar (transaksi/keluar)', NULL, NULL, '2026-02-12 15:52:42', 'Petugas Parkir', '2026-02-12 15:52:42', NULL),
(1794, 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'keluar', 'Update Membership ID: 3', '{\"free_entry_quota\":7}', '{\"free_entry_quota\":6}', '2026-02-12 15:52:42', 'Petugas Parkir', '2026-02-12 15:52:42', NULL),
(1795, 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'keluar', '[FREE ENTRY] Plat: AG 1322 GH | Sisa Kuota: 6', NULL, NULL, '2026-02-12 15:52:42', 'Petugas Parkir', '2026-02-12 15:52:42', NULL),
(1796, 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'keluar', 'Update Transaksi ID: 66', '{\"waktu_keluar\":null,\"id_tarif\":null,\"durasi_jam\":null,\"biaya\":null,\"diskon_member\":null,\"diskon_manual\":null,\"biaya_total\":null,\"id_user\":null,\"id_metode_pembayaran\":null,\"status\":\"masuk\"}', '{\"waktu_keluar\":\"2026-02-12 22:52:42\",\"id_tarif\":1,\"durasi_jam\":1,\"biaya\":2000,\"diskon_member\":0,\"diskon_manual\":10,\"biaya_total\":0,\"id_user\":3,\"id_metode_pembayaran\":\"2\",\"status\":\"keluar\"}', '2026-02-12 15:52:42', 'Petugas Parkir', '2026-02-12 15:52:42', NULL),
(1797, 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'keluar', 'Update AreaParkirDetail ID: 1', '{\"terisi\":19}', '{\"terisi\":18}', '2026-02-12 15:52:42', 'Petugas Parkir', '2026-02-12 15:52:42', NULL),
(1798, 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'keluar', '[TRANSAKSI KELUAR] Kode: INV/25/20260212225033 | Plat: AG 1322 GH | Durasi: 1 jam | Total: Rp 0', NULL, NULL, '2026-02-12 15:52:42', 'Petugas Parkir', '2026-02-12 15:52:42', NULL),
(1799, 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'masuk', 'Akses menu / halaman: transaksi.masuk (transaksi/masuk)', NULL, NULL, '2026-02-12 15:52:52', 'Petugas Parkir', '2026-02-12 15:52:52', NULL),
(1800, 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'masuk', 'Create data Transaksi ID: 67', NULL, '{\"kode_tiket\":\"INV\\/25\\/20260212225252\",\"id_data_kendaraan\":25,\"waktu_masuk\":\"2026-02-12 22:52:52\",\"status\":\"masuk\",\"id_area\":\"2\",\"created_by\":3,\"updated_at\":\"2026-02-12 22:52:52\",\"created_at\":\"2026-02-12 22:52:52\",\"id\":67}', '2026-02-12 15:52:52', 'Petugas Parkir', '2026-02-12 15:52:52', NULL),
(1801, 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'masuk', 'Update AreaParkirDetail ID: 1', '{\"terisi\":18}', '{\"terisi\":19}', '2026-02-12 15:52:52', 'Petugas Parkir', '2026-02-12 15:52:52', NULL),
(1802, 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'masuk', '[TRANSAKSI MASUK] Kode: INV/25/20260212225252 | Plat: AG 1322 GH | Tipe: motor | ', NULL, NULL, '2026-02-12 15:52:52', 'Petugas Parkir', '2026-02-12 15:52:52', NULL),
(1803, 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'destroy', 'Akses menu / halaman: logout (logout)', NULL, NULL, '2026-02-13 00:47:13', 'Petugas Parkir', '2026-02-13 00:47:13', NULL),
(1804, 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'destroy', '[LOGOUT] User logout | Nama: Petugas Parkir | Email: Aden@gmail.com', NULL, NULL, '2026-02-13 00:47:13', 'Petugas Parkir', '2026-02-13 00:47:13', NULL),
(1805, 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'destroy', 'Update User ID: 3', '{\"remember_token\":\"a2wTdcOI2OqEUpZxLNhHeITK0ZLJcHzDlsBu0sHHR4AIVVeUbGXtws4hmfke\"}', '{\"remember_token\":\"3zWfWeWRVgRn8YgulGfcTFalX9ykMYFLgItYpCZ4dKgjODkHWIyYWYaWK67h\"}', '2026-02-13 00:47:13', 'Petugas Parkir', '2026-02-13 00:47:13', NULL),
(1806, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'store', 'Akses menu / halaman: unknown (login)', NULL, NULL, '2026-02-13 00:47:22', 'SYSTEM', '2026-02-13 00:47:22', NULL),
(1807, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'store', '[LOGIN] User login | Nama: Admin | Email: alok@gmail.com', NULL, NULL, '2026-02-13 00:47:22', 'Admin', '2026-02-13 00:47:22', NULL),
(1808, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'destroy', 'Akses menu / halaman: logout (logout)', NULL, NULL, '2026-02-13 01:36:42', 'Admin', '2026-02-13 01:36:42', NULL),
(1809, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'destroy', '[LOGOUT] User logout | Nama: Admin | Email: alok@gmail.com', NULL, NULL, '2026-02-13 01:36:42', 'Admin', '2026-02-13 01:36:42', NULL),
(1810, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'destroy', 'Update User ID: 1', '{\"remember_token\":\"ysR8gP9i9Zb1TCVLATbGtQReEjB2qwjt3BBCY5aYKv2rsObmJBIM0YmrgRXi\"}', '{\"remember_token\":\"YDBnDmfdNmPxV4OY7byXWashm6t1Bf80CmS5G2I1yzVIcWNh9xvKlUDu2i8a\"}', '2026-02-13 01:36:42', 'Admin', '2026-02-13 01:36:42', NULL),
(1811, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'store', 'Akses menu / halaman: unknown (login)', NULL, NULL, '2026-02-13 01:36:52', 'SYSTEM', '2026-02-13 01:36:52', NULL),
(1812, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'store', '[LOGIN FAILED] Gagal login | Email: owner@gmail.com', NULL, NULL, '2026-02-13 01:36:52', 'SYSTEM', '2026-02-13 01:36:52', NULL),
(1813, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'store', 'Akses menu / halaman: unknown (login)', NULL, NULL, '2026-02-13 01:36:58', 'SYSTEM', '2026-02-13 01:36:58', NULL),
(1814, 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'store', '[LOGIN] User login | Nama: owner | Email: owner@gmail.com', NULL, NULL, '2026-02-13 01:36:59', 'owner', '2026-02-13 01:36:59', NULL),
(1815, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'store', 'Akses menu / halaman: unknown (login)', NULL, NULL, '2026-04-28 01:15:58', 'SYSTEM', '2026-04-28 01:15:58', NULL),
(1816, 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'store', '[LOGIN] User login | Nama: Petugas Parkir | Email: Aden@gmail.com', NULL, NULL, '2026-04-28 01:15:58', 'Petugas Parkir', '2026-04-28 01:15:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_membership`
--

CREATE TABLE `tb_membership` (
  `id` int NOT NULL,
  `nama_lengkap` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `membership_tier_id` int DEFAULT NULL,
  `loyalty_point` int DEFAULT NULL,
  `free_entry_quota` int DEFAULT NULL,
  `last_renewal` datetime DEFAULT NULL,
  `expired` datetime DEFAULT NULL,
  `aktif` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_membership`
--

INSERT INTO `tb_membership` (`id`, `nama_lengkap`, `membership_tier_id`, `loyalty_point`, `free_entry_quota`, `last_renewal`, `expired`, `aktif`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(2, 'Rafi sayyida', 1, 2, 10, '2026-02-02 13:22:59', '2026-02-26 00:00:00', 1, '2026-02-02 06:22:59', '1', '2026-02-04 17:19:32', '1', NULL, NULL),
(3, 'ronaldo siu', 1, 2, 6, '2026-02-02 13:32:33', '2026-02-13 00:00:00', 1, '2026-02-02 06:32:33', '1', '2026-02-12 15:52:42', '1', NULL, NULL),
(4, 'wa', 2, 2, 20, '2026-02-02 13:40:27', '2026-02-26 00:00:00', 0, '2026-02-02 06:40:27', '1', '2026-02-02 06:53:02', '1', NULL, NULL),
(5, 'Nashrul MBG', 1, 7, 0, '2026-02-05 01:36:15', '2026-02-27 00:00:00', 1, '2026-02-04 18:36:15', '1', '2026-02-10 02:06:26', '1', NULL, NULL),
(6, 'badrus', 1, 21, 3, '2026-02-09 06:34:34', '2026-02-18 00:00:00', 1, '2026-02-08 23:34:34', '1', '2026-02-11 00:24:40', '1', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_membership_kendaraan`
--

CREATE TABLE `tb_membership_kendaraan` (
  `id` int NOT NULL,
  `id_data_kendaraan` int DEFAULT NULL,
  `id_membership` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_membership_kendaraan`
--

INSERT INTO `tb_membership_kendaraan` (`id`, `id_data_kendaraan`, `id_membership`) VALUES
(2, 9, 5),
(3, 10, 5),
(4, 6, 5),
(5, 11, 5),
(6, 20, 6),
(7, 25, 3);

-- --------------------------------------------------------

--
-- Table structure for table `tb_membership_tier`
--

CREATE TABLE `tb_membership_tier` (
  `id` int NOT NULL,
  `tier` varchar(15) DEFAULT NULL,
  `harga` int DEFAULT NULL,
  `diskon` int DEFAULT NULL,
  `free_entry` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_membership_tier`
--

INSERT INTO `tb_membership_tier` (`id`, `tier`, `harga`, `diskon`, `free_entry`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(1, 'silver', 100000, 5, 10, '2026-02-02 05:39:42', '1', '2026-02-06 08:12:32', '1', NULL, NULL),
(2, 'gold', 200000, 10, 20, '2026-02-02 05:40:13', '1', '2026-02-02 05:40:13', NULL, NULL, NULL),
(3, 'platinum', 300000, 15, 50, '2026-02-06 08:12:20', '1', '2026-02-06 08:12:20', NULL, NULL, NULL),
(4, 'basic', 0, 0, 0, '2026-02-07 12:17:30', '1', '2026-02-07 12:17:30', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_metode_pembayaran`
--

CREATE TABLE `tb_metode_pembayaran` (
  `id` int NOT NULL,
  `metode_pembayaran` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_metode_pembayaran`
--

INSERT INTO `tb_metode_pembayaran` (`id`, `metode_pembayaran`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(1, 'tunai', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'qris', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_tarif`
--

CREATE TABLE `tb_tarif` (
  `id` int NOT NULL,
  `id_tipe_kendaraan` int DEFAULT NULL,
  `durasi_mulai` int DEFAULT NULL,
  `tarif_per_jam` decimal(10,0) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_tarif`
--

INSERT INTO `tb_tarif` (`id`, `id_tipe_kendaraan`, `durasi_mulai`, `tarif_per_jam`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(1, 1, 0, 2000, '2026-01-18 17:27:49', 'admin', '2026-01-18 17:27:49', NULL, NULL, NULL),
(5, 2, 0, 5000, '2026-01-19 00:50:46', 'admin', NULL, NULL, NULL, NULL),
(9, 3, 0, 10000, '2026-01-19 00:50:46', 'admin', '2026-02-12 14:51:10', 'Admin', NULL, NULL),
(12, 4, 0, 20000, '2026-01-19 00:50:46', 'admin', NULL, NULL, NULL, NULL),
(48, 5, 0, 5000, '2026-02-08 19:10:31', 'Kurnilla Putri', '2026-02-08 19:10:35', NULL, '2026-02-08 19:10:35', 'Kurnilla Putri'),
(50, 1, 2, 6000, '2026-02-10 15:15:38', 'Admin', '2026-02-12 14:06:44', 'Admin', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_tipe_kendaraan`
--

CREATE TABLE `tb_tipe_kendaraan` (
  `id` int NOT NULL,
  `tipe_kendaraan` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `kapasitas` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_tipe_kendaraan`
--

INSERT INTO `tb_tipe_kendaraan` (`id`, `tipe_kendaraan`, `kapasitas`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(1, 'motor', 1, '2026-02-01 07:15:28', 'admin', '2026-02-01 07:15:28', NULL, NULL, NULL),
(2, 'mobil', 1, '2026-02-01 07:15:36', 'admin', '2026-02-01 07:15:36', NULL, NULL, NULL),
(3, 'bus', 1, '2026-02-01 07:15:42', 'admin', '2026-02-01 07:15:42', NULL, NULL, NULL),
(4, 'pesawat', 1, '2026-02-02 20:24:50', 'Admin', '2026-02-04 21:14:10', 'Admin', NULL, ''),
(5, 'excavator', 1, '2026-02-08 18:55:02', 'Kurnilla Putri', '2026-02-08 18:58:50', NULL, NULL, ''),
(6, 'helicopter', 1, '2026-02-10 00:23:22', 'Admin', '2026-02-10 00:23:22', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_transaksi`
--

CREATE TABLE `tb_transaksi` (
  `id` int NOT NULL,
  `kode_tiket` varchar(50) DEFAULT NULL,
  `id_data_kendaraan` int DEFAULT NULL,
  `waktu_masuk` datetime DEFAULT NULL,
  `waktu_keluar` datetime DEFAULT NULL,
  `id_tarif` int DEFAULT NULL,
  `durasi_jam` int DEFAULT NULL,
  `biaya` decimal(10,0) DEFAULT NULL,
  `diskon_member` int DEFAULT NULL,
  `diskon_manual` int DEFAULT NULL,
  `biaya_total` decimal(10,0) DEFAULT NULL,
  `id_user` bigint UNSIGNED DEFAULT NULL,
  `id_area` int DEFAULT NULL,
  `id_metode_pembayaran` int DEFAULT NULL,
  `status` enum('masuk','keluar','') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_transaksi`
--

INSERT INTO `tb_transaksi` (`id`, `kode_tiket`, `id_data_kendaraan`, `waktu_masuk`, `waktu_keluar`, `id_tarif`, `durasi_jam`, `biaya`, `diskon_member`, `diskon_manual`, `biaya_total`, `id_user`, `id_area`, `id_metode_pembayaran`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(21, 'INV/9/20260204023031', 9, '2026-02-04 02:30:31', '2026-02-05 13:11:02', 12, 35, 700000, 0, 15, 595000, 3, 1, 1, 'keluar', '2026-02-03 19:30:31', '3', '2026-02-05 06:11:02', NULL, NULL, NULL),
(22, 'INV/10/20260204110147', 10, '2026-02-04 11:01:47', '2026-02-07 08:48:57', 9, 70, 700000, NULL, NULL, 665000, 3, 2, 2, 'keluar', '2026-02-04 04:01:47', '3', '2026-02-07 01:48:57', NULL, NULL, NULL),
(23, 'INV/11/20260204141634', 11, '2026-02-04 14:17:08', '2026-02-08 03:58:42', 1, 86, 172000, NULL, NULL, 0, 3, 1, 1, 'keluar', '2026-02-04 07:16:34', '3', '2026-02-07 20:58:42', NULL, NULL, NULL),
(24, 'INV/12/20260204141708', 12, '2026-02-04 14:17:08', '2026-02-05 13:20:05', 5, 24, 120000, NULL, NULL, 102000, 3, 2, 2, 'keluar', '2026-02-04 07:17:08', '3', '2026-02-05 06:20:05', NULL, NULL, NULL),
(25, 'INV/13/20260204143033', 13, '2026-02-04 14:30:33', '2026-02-05 11:53:28', 1, 22, 0, NULL, NULL, 0, 3, 5, 1, 'keluar', '2026-02-04 07:30:33', '3', '2026-02-05 04:53:28', NULL, NULL, NULL),
(26, 'INV/14/20260204144443', 14, '2026-02-04 14:44:43', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, 'masuk', '2026-02-04 07:44:43', '3', '2026-02-04 07:44:43', NULL, NULL, NULL),
(27, 'INV/15/20260204145200', 15, '2026-02-04 14:52:00', '2026-02-07 07:44:48', 12, 65, 1300000, NULL, NULL, 1105000, 3, 3, 1, 'keluar', '2026-02-04 07:52:00', '3', '2026-02-07 00:44:48', NULL, NULL, NULL),
(28, 'INV/16/20260204151614', 16, '2026-02-07 15:16:14', '2026-02-07 13:18:27', 12, 23, 460000, NULL, NULL, 391000, 3, 4, 2, 'keluar', '2026-02-04 08:16:14', '3', '2026-02-05 06:18:27', NULL, NULL, NULL),
(29, 'INV/17/20260205020833', 17, '2026-02-05 02:08:33', '2026-02-05 11:48:53', 12, 10, 0, NULL, NULL, 0, 3, 6, 2, 'keluar', '2026-02-04 19:08:33', '3', '2026-02-05 04:48:53', NULL, NULL, NULL),
(30, 'INV/17/20260207121159', 17, '2026-02-07 12:11:59', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 'masuk', '2026-02-07 05:11:59', '3', '2026-02-07 05:11:59', NULL, NULL, NULL),
(31, 'INV/1/20260207121409', 1, '2026-02-07 12:14:09', '2026-02-08 03:29:51', 1, 16, 32000, NULL, NULL, 32000, 3, 5, 2, 'keluar', '2026-02-07 05:14:09', '3', '2026-02-07 20:29:51', NULL, NULL, NULL),
(32, 'INV/13/20260207123745', 13, '2026-02-07 12:37:45', '2026-02-08 12:38:50', 1, 1, 2000, NULL, NULL, 2000, 3, 1, 2, 'keluar', '2026-02-08 05:37:45', '3', '2026-02-07 05:38:50', NULL, NULL, NULL),
(33, 'INV/13/20260207123906', 13, '2026-02-07 12:39:06', '2026-02-08 03:26:28', 1, 15, 30000, NULL, NULL, 30000, 3, 1, 1, 'keluar', '2026-02-07 05:39:06', '3', '2026-02-07 20:26:28', NULL, NULL, NULL),
(34, 'INV/18/20260209022139', 18, '2026-02-09 02:21:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 2, 'masuk', '2026-02-08 19:21:39', '3', '2026-02-08 19:21:39', NULL, NULL, NULL),
(35, 'INV/19/20260209022254', 19, '2026-02-09 02:22:54', '2026-02-08 18:26:39', 5, 8, 40000, NULL, NULL, 40000, 3, 2, 1, 'keluar', '2026-02-08 19:22:54', '3', '2026-02-08 11:26:39', NULL, NULL, NULL),
(36, 'INV/6/20260209062943', 6, '2026-02-09 06:29:43', '2026-02-09 06:30:30', 1, 1, 2000, NULL, NULL, 0, 3, 1, 2, 'keluar', '2026-02-08 23:29:43', '3', '2026-02-08 23:30:30', NULL, NULL, NULL),
(37, 'INV/20/20260209063708', 20, '2026-02-09 06:37:08', '2026-02-09 09:38:33', 5, 4, 20000, NULL, NULL, 19000, 3, 2, 1, 'keluar', '2026-02-08 23:37:08', '3', '2026-02-09 02:38:33', NULL, NULL, NULL),
(38, 'INV/20/20260209094226', 20, '2026-02-09 09:42:26', '2026-02-09 09:45:04', 5, 1, 5000, NULL, NULL, 4750, 3, 2, 2, 'keluar', '2026-02-09 02:42:26', '3', '2026-02-09 02:45:04', NULL, NULL, NULL),
(39, 'INV/11/20260209094426', 11, '2026-02-09 09:44:26', '2026-02-10 04:58:09', 1, 20, 40000, 0, 0, 0, 3, 1, 1, 'keluar', '2026-02-09 02:44:26', '3', '2026-02-09 21:58:09', NULL, NULL, NULL),
(40, 'INV/21/20260209094840', 21, '2026-02-09 09:48:40', '2026-02-09 09:59:26', 1, 1, 2000, NULL, NULL, 2000, 3, 7, 2, 'keluar', '2026-02-09 02:48:40', '3', '2026-02-09 02:59:26', NULL, NULL, NULL),
(41, 'INV/21/20260209170701', 21, '2026-02-09 17:07:01', '2026-02-09 21:38:56', 1, 5, 10000, 0, 10, 9000, 3, 7, 2, 'keluar', '2026-02-09 10:07:01', '3', '2026-02-09 14:38:56', NULL, NULL, NULL),
(42, 'INV/11/20260210045831', 11, '2026-02-10 04:58:31', '2026-02-10 04:58:47', 1, 1, 2000, 0, 0, 0, 3, 1, 1, 'keluar', '2026-02-09 21:58:31', '3', '2026-02-09 21:58:47', NULL, NULL, NULL),
(43, 'INV/11/20260210045906', 11, '2026-02-10 04:59:06', '2026-02-10 04:59:13', 1, 1, 2000, 5, 0, 1900, 3, 1, 1, 'keluar', '2026-02-09 21:59:06', '3', '2026-02-09 21:59:13', NULL, NULL, NULL),
(44, 'INV/11/20260210050749', 11, '2026-02-10 05:07:49', '2026-02-10 05:07:58', 1, 1, 2000, 5, 0, 1900, 3, 1, 2, 'keluar', '2026-02-09 22:07:49', '3', '2026-02-09 22:07:58', NULL, NULL, NULL),
(45, 'INV/11/20260210052109', 11, '2026-02-10 05:21:09', '2026-02-10 05:22:36', 1, 1, 2000, 5, 0, 1900, 3, 1, 1, 'keluar', '2026-02-09 22:21:09', '3', '2026-02-09 22:22:36', NULL, NULL, NULL),
(46, 'INV/11/20260210052937', 11, '2026-02-10 05:29:37', '2026-02-10 05:29:47', 1, 1, 2000, 5, 0, 1900, 3, 1, 2, 'keluar', '2026-02-09 22:29:37', '3', '2026-02-09 22:29:47', NULL, NULL, NULL),
(47, 'INV/11/20260210053100', 11, '2026-02-10 05:31:00', '2026-02-10 05:31:15', 1, 1, 2000, 5, 0, 1900, 3, 1, 1, 'keluar', '2026-02-09 22:31:00', '3', '2026-02-09 22:31:15', NULL, NULL, NULL),
(48, 'INV/11/20260210072928', 11, '2026-02-10 07:29:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, 2, 'masuk', '2026-02-10 00:29:28', '3', '2026-02-10 00:29:28', NULL, NULL, NULL),
(49, 'INV/19/20260210073331', 19, '2026-02-10 07:33:31', '2026-02-10 07:33:54', 5, 1, 5000, 0, 20, 4000, 3, 2, 1, 'keluar', '2026-02-10 00:33:31', '3', '2026-02-10 00:33:54', NULL, NULL, NULL),
(53, 'INV/21/20260210075124', 21, '2026-02-10 07:51:24', '2026-02-10 07:51:43', 1, 1, 2000, 0, 20, 1600, 3, 7, 1, 'keluar', '2026-02-10 00:51:24', '3', '2026-02-10 00:51:44', NULL, NULL, NULL),
(54, 'INV/22/20260210085724', 22, '2026-02-10 08:57:24', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 'masuk', '2026-02-10 01:57:24', '3', '2026-02-10 01:57:24', NULL, NULL, NULL),
(55, 'INV/23/20260210090219', 23, '2026-02-10 09:02:19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, 'masuk', '2026-02-10 02:02:19', '3', '2026-02-10 02:02:19', NULL, NULL, NULL),
(56, 'INV/10/20260210090425', 10, '2026-02-10 09:04:25', '2026-02-10 09:06:26', 9, 1, 10000, 5, 20, 7500, 3, 2, 2, 'keluar', '2026-02-10 02:04:25', '3', '2026-02-10 02:06:26', NULL, NULL, NULL),
(58, 'INV/25/20260210172445', 25, '2026-02-10 17:24:45', '2026-02-11 00:57:29', 50, 8, 23000, 0, 20, 18400, 3, 1, 2, 'keluar', '2026-02-10 10:24:45', '3', '2026-02-10 17:57:29', NULL, NULL, NULL),
(59, 'INV/25/20260211004427', 25, '2026-02-11 00:44:27', '2026-02-11 00:55:03', 50, 1, 8000, 0, 20, 6400, 3, 1, 1, 'keluar', '2026-02-10 17:44:27', '3', '2026-02-10 17:55:03', NULL, NULL, NULL),
(60, 'INV/25/20260211011859', 25, '2026-02-11 01:18:59', '2026-02-11 01:19:11', 1, 1, 2000, 0, 20, 1600, 3, 1, 2, 'keluar', '2026-02-10 18:18:59', '3', '2026-02-10 18:19:11', NULL, NULL, NULL),
(61, 'INV/25/20260211011950', 25, '2026-02-11 01:19:50', '2026-02-11 01:24:39', 1, 1, 2000, 0, 20, 0, 3, 1, 2, 'keluar', '2026-02-10 18:19:50', '3', '2026-02-10 18:24:39', NULL, NULL, NULL),
(65, 'INV/25/20260212224805', 25, '2026-02-12 22:48:05', '2026-02-12 22:50:06', 1, 1, 2000, 0, 10, 0, 3, 2, 2, 'keluar', '2026-02-12 15:48:05', '3', '2026-02-12 15:50:06', NULL, NULL, NULL),
(66, 'INV/25/20260212225033', 25, '2026-02-12 22:50:33', '2026-02-12 22:52:42', 1, 1, 2000, 0, 10, 0, 3, 2, 2, 'keluar', '2026-02-12 15:50:33', '3', '2026-02-12 15:52:42', NULL, NULL, NULL),
(67, 'INV/25/20260212225252', 25, '2026-02-12 22:52:52', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 1, 'masuk', '2026-02-12 15:52:52', '3', '2026-02-12 15:52:52', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(1, 'Admin', 'alok@gmail.com', NULL, '$2y$12$lqwLXjS1iJnEPeohT8VxoOhBqq5a.6AlQEyqnGz6jwHW0bA1drikO', 'YDBnDmfdNmPxV4OY7byXWashm6t1Bf80CmS5G2I1yzVIcWNh9xvKlUDu2i8a', NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Petugas Parkir', 'Aden@gmail.com', NULL, '$2y$12$aj5t1NkXzeRSp3ZpBRytJe.ZeQyl1GZi9.Hfhc2hWDcW2PrchuuCK', '3zWfWeWRVgRn8YgulGfcTFalX9ykMYFLgItYpCZ4dKgjODkHWIyYWYaWK67h', NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'owner', 'owner@gmail.com', NULL, '$2y$12$KaLbbVRxRJBE3WUCGjXK2eDDt7eAfIfZyV7NHRXcK1f7VPj0BMBE.', 'gI1nRly7SjQei82kfhtPYPeIR7iC1U16pElWDcF2uNw77eVfV1FrSVAPVIcp', NULL, NULL, '2026-02-11 02:43:28', NULL, NULL, NULL),
(5, 'Kurnilla Putri', 'Putri@gmail.com', NULL, '$2y$12$qRCvnYuOVxGFSasLEncrMugKXU1ihiVFLQmU8rpy.k.7OUbaEi9s2', NULL, NULL, NULL, '2026-02-09 15:57:06', NULL, '2026-02-09 15:57:06', NULL),
(7, 'test_useradmin', 'test_useradmin@email.com', NULL, '$2y$12$1VUyqoA.qpPlIxEap7KGO.n1/v4Ih.wauPBdBzXJDdk83hZs5qtLa', 'QTZMQLRbhMuTKzwJ9H9kXTWwNiG6ReRCcOEPX3UZOkyd3o7NGb43Q8Lv86w9', '2026-02-10 01:28:03', NULL, '2026-02-10 01:33:27', NULL, '2026-02-10 01:33:27', NULL),
(8, 'NASHRUL', 'NASHRUL@gmail.com', NULL, '$2y$12$BjqK/OpohGuI8DwD5ozVrezWnzPP5KPWLlddxAYTahpnas6.C997O', 'gpAZndfqqPzgt7sKxhYY3YjR71jC8TQDqJroohnEIsgAzckW6ZLpUaZtPXcN', '2026-02-10 08:46:57', NULL, '2026-02-10 08:46:57', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

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
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `tb_area_parkir`
--
ALTER TABLE `tb_area_parkir`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_area_parkir_detail`
--
ALTER TABLE `tb_area_parkir_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_area_parkir_detail_tb_area_parkir_FK` (`area_parkir_id`),
  ADD KEY `tb_area_parkir_detail_tb_tipe_kendaraan_FK` (`id_tipe_kendaraan`);

--
-- Indexes for table `tb_data_kendaraan`
--
ALTER TABLE `tb_data_kendaraan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `plat_nomor` (`plat_nomor`);

--
-- Indexes for table `tb_diskon`
--
ALTER TABLE `tb_diskon`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_log_aktivitas`
--
ALTER TABLE `tb_log_aktivitas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_log_aktivitas_users_FK` (`id_user`);

--
-- Indexes for table `tb_membership`
--
ALTER TABLE `tb_membership`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_membership_tb_membership_tier_FK` (`membership_tier_id`);

--
-- Indexes for table `tb_membership_kendaraan`
--
ALTER TABLE `tb_membership_kendaraan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_membership_kendaraan_tb_membership_FK` (`id_membership`),
  ADD KEY `tb_membership_kendaraan_tb_data_kendaraan_FK` (`id_data_kendaraan`);

--
-- Indexes for table `tb_membership_tier`
--
ALTER TABLE `tb_membership_tier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_metode_pembayaran`
--
ALTER TABLE `tb_metode_pembayaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_tarif`
--
ALTER TABLE `tb_tarif`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_tipe_kendaraan` (`id_tipe_kendaraan`);

--
-- Indexes for table `tb_tipe_kendaraan`
--
ALTER TABLE `tb_tipe_kendaraan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_transaksi_tb_tarif_fk` (`id_tarif`),
  ADD KEY `tb_transaksi_tb_metode_pembayaran_FK` (`id_metode_pembayaran`),
  ADD KEY `tb_transaksi_tb_kendaraan_fk` (`id_data_kendaraan`),
  ADD KEY `tb_transaksi_tb_area_parkir_fk` (`id_area`),
  ADD KEY `tb_transaksi_users_FK` (`id_user`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_area_parkir`
--
ALTER TABLE `tb_area_parkir`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tb_area_parkir_detail`
--
ALTER TABLE `tb_area_parkir_detail`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `tb_data_kendaraan`
--
ALTER TABLE `tb_data_kendaraan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tb_diskon`
--
ALTER TABLE `tb_diskon`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_log_aktivitas`
--
ALTER TABLE `tb_log_aktivitas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1817;

--
-- AUTO_INCREMENT for table `tb_membership`
--
ALTER TABLE `tb_membership`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_membership_kendaraan`
--
ALTER TABLE `tb_membership_kendaraan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_membership_tier`
--
ALTER TABLE `tb_membership_tier`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_metode_pembayaran`
--
ALTER TABLE `tb_metode_pembayaran`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_tarif`
--
ALTER TABLE `tb_tarif`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `tb_tipe_kendaraan`
--
ALTER TABLE `tb_tipe_kendaraan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tb_area_parkir_detail`
--
ALTER TABLE `tb_area_parkir_detail`
  ADD CONSTRAINT `tb_area_parkir_detail_tb_area_parkir_FK` FOREIGN KEY (`area_parkir_id`) REFERENCES `tb_area_parkir` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_area_parkir_detail_tb_tipe_kendaraan_FK` FOREIGN KEY (`id_tipe_kendaraan`) REFERENCES `tb_tipe_kendaraan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tb_log_aktivitas`
--
ALTER TABLE `tb_log_aktivitas`
  ADD CONSTRAINT `tb_log_aktivitas_users_FK` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tb_membership`
--
ALTER TABLE `tb_membership`
  ADD CONSTRAINT `tb_membership_tb_membership_tier_FK` FOREIGN KEY (`membership_tier_id`) REFERENCES `tb_membership_tier` (`id`);

--
-- Constraints for table `tb_membership_kendaraan`
--
ALTER TABLE `tb_membership_kendaraan`
  ADD CONSTRAINT `tb_membership_kendaraan_tb_data_kendaraan_FK` FOREIGN KEY (`id_data_kendaraan`) REFERENCES `tb_data_kendaraan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_membership_kendaraan_tb_membership_FK` FOREIGN KEY (`id_membership`) REFERENCES `tb_membership` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_tarif`
--
ALTER TABLE `tb_tarif`
  ADD CONSTRAINT `tb_tarif_tb_tipe_kendaraan_FK` FOREIGN KEY (`id_tipe_kendaraan`) REFERENCES `tb_tipe_kendaraan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  ADD CONSTRAINT `tb_transaksi_tb_area_parkir_fk` FOREIGN KEY (`id_area`) REFERENCES `tb_area_parkir` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_transaksi_tb_kendaraan_fk` FOREIGN KEY (`id_data_kendaraan`) REFERENCES `tb_data_kendaraan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_transaksi_tb_metode_pembayaran_FK` FOREIGN KEY (`id_metode_pembayaran`) REFERENCES `tb_metode_pembayaran` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_transaksi_tb_tarif_fk` FOREIGN KEY (`id_tarif`) REFERENCES `tb_tarif` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_transaksi_users_FK` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
