-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 11, 2025 at 04:23 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

-- SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
-- START TRANSACTION;
-- SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_website`
--

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
(4, '2025_06_01_174606_create_rooms_table', 1),
(6, '2025_06_02_080000_create_sessions_table', 2),
(7, '2025_06_02_011915_add_quantity_to_rooms_table', 3),
(10, '2025_06_01_174610_create_reservations_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `room_id` bigint UNSIGNED NOT NULL,
  `check_in_date` date NOT NULL,
  `check_out_date` date NOT NULL,
  `total_nights` int DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `user_id`, `room_id`, `check_in_date`, `check_out_date`, `total_nights`, `total_price`, `status`, `created_at`, `updated_at`) VALUES
(3, 14, 1, '2025-06-04', '2025-06-07', 3, 1050000.00, 'Confirmed', '2025-06-02 23:56:00', '2025-06-07 19:28:31'),
(4, 14, 3, '2025-06-07', '2025-06-14', 7, 8400000.00, 'Confirmed', '2025-06-02 23:56:12', '2025-06-03 00:00:58'),
(5, 14, 2, '2025-06-10', '2025-06-15', 5, 3250000.00, 'Confirmed', '2025-06-07 16:44:45', '2025-06-07 16:48:36'),
(6, 14, 1, '2025-06-08', '2025-06-09', 1, 350000.00, 'Confirmed', '2025-06-07 19:27:29', '2025-06-07 19:28:37'),
(7, 14, 2, '2025-06-11', '2025-06-18', 7, 4550000.00, 'Confirmed', '2025-06-07 19:27:44', '2025-06-07 19:28:41'),
(8, 14, 1, '2025-06-11', '2025-06-15', 4, 1400000.00, 'Cancelled', '2025-06-08 21:58:15', '2025-06-08 23:16:15'),
(9, 14, 1, '2025-06-11', '2025-06-15', 4, 1400000.00, 'Cancelled', '2025-06-08 21:58:25', '2025-06-08 23:16:20'),
(10, 14, 1, '2025-06-09', '2025-06-12', 3, 1050000.00, 'Confirmed', '2025-06-08 22:00:35', '2025-06-09 09:40:14'),
(11, 14, 1, '2025-06-10', '2025-06-12', 2, 700000.00, 'Cancelled', '2025-06-08 22:35:30', '2025-06-09 09:40:39'),
(12, 14, 2, '2025-06-09', '2025-06-11', 2, 1300000.00, 'Confirmed', '2025-06-08 22:41:38', '2025-06-09 09:40:35'),
(13, 14, 3, '2025-06-09', '2025-06-11', 2, 2400000.00, 'Confirmed', '2025-06-08 22:45:02', '2025-06-08 23:16:29'),
(14, 14, 1, '2025-06-11', '2025-06-12', 1, 350000.00, 'Confirmed', '2025-06-09 04:30:54', '2025-06-09 09:40:28'),
(15, 14, 8, '2025-06-15', '2025-06-16', 1, 6700000.00, 'Confirmed', '2025-06-09 09:38:50', '2025-06-10 06:45:20'),
(16, 14, 2, '2025-06-12', '2025-06-13', 1, 2780000.00, 'Pending', '2025-06-11 08:47:37', '2025-06-11 08:49:54');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int NOT NULL DEFAULT '5',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `type`, `price`, `description`, `image`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 'Kamar Single Standard', 350000.00, 'Kamar nyaman untuk satu orang dengan fasilitas standar. Cocok untuk pelancong solo.', 'room_images/4KANm3bKxhOB4hH7KCNW05LOLuDD4v7dFEfHhSid.jpg', 20, '2025-06-01 18:23:01', '2025-06-08 23:48:03'),
(2, 'Kamar Double Deluxe', 2780000.00, 'Kamar luas dengan tempat tidur double atau twin, pemandangan kota, dan fasilitas mewah.', 'room_images/7Z85OfcAIQsxveogCZZ86E8L4t0iufgWfLv0izQa.jpg', 10, '2025-06-01 18:23:01', '2025-06-11 08:52:47'),
(3, 'Suite Keluarga', 720000.00, 'Suite dengan dua kamar tidur, ruang tamu terpisah, cocok untuk keluarga yang berlibur.', 'room_images/6rYyW6nJNInQHudIlHhBmQpTzkjfq51xN3Kw4WAC.jpg', 20, '2025-06-01 18:23:01', '2025-06-08 23:47:54'),
(4, 'Kamar Ekonomi Twin', 1250000.00, 'Pilihan hemat dengan dua tempat tidur single, fasilitas dasar, bersih dan nyaman.', 'room_images/vATXBn1GbPGpeeh9PEq0tiDYtdVDzMpu4WbKSpl8.jpg', 15, '2025-06-01 18:23:01', '2025-06-08 23:47:10'),
(7, 'Deluxe Suite', 2400000.00, 'kamar lainnya yang bagus', 'room_images/C3dzLO2ZDnSdltFTi2RSZ2lyHqZAcY69VxeYMWxK.jpg', 10, '2025-06-03 04:40:31', '2025-06-08 23:47:46'),
(8, 'Premium Maximum Plus', 6700000.00, 'Kamar terbaik, memiliki semua nuansa dan fitur yang sempurna', 'room_images/ktTiEulgRwe1KHc1pm1ICfgbCdrn7As24wA16hOZ.jpg', 2, '2025-06-08 23:45:41', '2025-06-09 04:50:28');

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
('zyIhrSLPl5OtmPrR0p0xDFULdoZSw6io6bwpw0eb', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSjhGcGZtTFdlaXdTWjNjMk1VS2E3dmRRMmNjVmZDN2F0WUx5UnFhTyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fX0=', 1749658568);

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
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(11, 'Admin CallMeHotel', 'admin@example.test', '2025-06-01 23:46:45', '$2y$12$UVRzy61o0tBls6g65allkuHZkwLDsVwoUo.pweYUFaJkZn7.0LVve', 'admin', NULL, '2025-06-01 23:46:45', '2025-06-01 23:46:45'),
(12, 'Staff CallMeHotel', 'staff@example.test', '2025-06-01 23:46:45', '$2y$12$awlJ8JjbLXZpZrug97efeOgPngbWHA9uZuFbq5R0w.of79TUW.gsa', 'staff', NULL, '2025-06-01 23:46:45', '2025-06-01 23:46:45'),
(14, 'user', 'user@example.test', NULL, '$2y$12$H0PGAepdXBZ9.rZO2R6vLuNZWmZDNUyU98/VoblFOxbILG10dcj1S', 'user', NULL, '2025-06-02 23:55:43', '2025-06-11 08:53:44'),
(15, 'user2', 'user2@example.test', NULL, '$2y$12$sbp2fmi5hjSdr1GgivGNVurRzgqqBhjIbwVdRSPx3ucAw/FuJUy4y', 'user', NULL, '2025-06-08 23:23:44', '2025-06-08 23:23:44'),
(16, 'user3', 'user3@example.test', NULL, '$2y$12$PkZU9YqN01SdRS6J0c7jzO8zlWE3hX5R0.n45n4npboWhgh.IWwlC', 'user', NULL, '2025-06-08 23:32:21', '2025-06-08 23:32:21');

--
-- Indexes for dumped tables
--

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
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservations_user_id_foreign` (`user_id`),
  ADD KEY `reservations_room_id_foreign` (`room_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

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
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
