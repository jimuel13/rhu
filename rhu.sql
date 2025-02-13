-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 13, 2025 at 03:34 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rhu`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
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
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `user_id` int(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `time_in` datetime DEFAULT NULL,
  `time_out` datetime DEFAULT NULL,
  `activity` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `user_id`, `name`, `department`, `position`, `time_in`, `time_out`, `activity`, `date`, `created_at`, `updated_at`) VALUES
(429, 200, 'Cleven Javier', 'BLOOD', 'Admin', '2025-01-27 08:45:42', '2025-01-27 08:52:30', 'Login', '2025-01-27 08:45:42', '2025-01-27 08:45:42', '2025-01-27 08:52:30'),
(430, 206, 'Maria Luisa Hepana', 'Client', 'Client', '2025-01-27 09:00:49', '2025-01-27 09:00:49', ' Maria Luisa Hepana successfully registered: ', '2025-01-27 09:00:49', '2025-01-27 09:00:49', '2025-01-27 09:00:49'),
(431, 206, 'Maria Luisa Hepana', 'Client', 'Client', '2025-01-27 09:00:59', '2025-01-27 10:57:08', 'Login', '2025-01-27 09:00:59', '2025-01-27 09:00:59', '2025-01-27 10:57:08'),
(432, 198, 'Ivy Pondivida', 'IT DEPARTMENT', 'Admin', '2025-01-27 09:02:56', '2025-01-27 09:10:24', 'Login', '2025-01-27 09:02:56', '2025-01-27 09:02:56', '2025-01-27 09:10:24'),
(433, 198, 'Ivy Pondivida', 'IT DEPARTMENT', 'Admin', '2025-01-27 09:03:18', '2025-01-27 09:10:24', 'Approved client account: Maria Luisa Hepana', '2025-01-27 09:03:18', '2025-01-27 09:03:18', '2025-01-27 09:10:24'),
(434, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-01-27 09:10:34', '2025-01-27 10:08:09', 'Login', '2025-01-27 09:10:34', '2025-01-27 09:10:34', '2025-01-27 10:08:09'),
(435, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-01-27 09:10:59', '2025-01-27 10:08:09', 'Added lab test Urinalysis.', '2025-01-27 09:10:59', '2025-01-27 09:10:59', '2025-01-27 10:08:09'),
(436, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-01-27 09:11:17', '2025-01-27 10:08:09', 'Added lab test Rapid Antigen Test.', '2025-01-27 09:11:17', '2025-01-27 09:11:17', '2025-01-27 10:08:09'),
(437, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-01-27 09:14:50', '2025-01-27 10:08:09', 'Added lab test Blood Typing.', '2025-01-27 09:14:50', '2025-01-27 09:14:50', '2025-01-27 10:08:09'),
(438, 206, 'Maria Luisa Hepana', 'Client', 'Client', '2025-01-27 09:22:44', '2025-01-27 10:57:08', 'Maria Luisa Hepana Added new appointment to Department:  - Blood Typing.', '2025-01-27 09:22:44', '2025-01-27 09:22:44', '2025-01-27 10:57:08'),
(439, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-01-27 09:28:43', '2025-01-27 10:08:09', 'Approved Maria Luisa Hepana appointment to Department:  - Blood Typing.', '2025-01-27 09:28:43', '2025-01-27 09:28:43', '2025-01-27 10:08:09'),
(440, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-01-27 09:43:24', '2025-01-27 10:08:09', 'Added Maria Luisa Hepana to patient record .', '2025-01-27 09:43:24', '2025-01-27 09:43:24', '2025-01-27 10:08:09'),
(441, 206, 'Maria Luisa Hepana', 'Client', 'Client', '2025-01-27 09:45:39', '2025-01-27 10:57:08', 'Maria Luisa Hepana Added new appointment to Department:  - Urinalysis.', '2025-01-27 09:45:39', '2025-01-27 09:45:39', '2025-01-27 10:57:08'),
(442, 206, 'Maria Luisa Hepana', 'Client', 'Client', '2025-01-27 10:07:33', '2025-01-27 10:57:08', 'Maria Luisa Hepana Added new appointment to Department:  - physical.', '2025-01-27 10:07:33', '2025-01-27 10:07:33', '2025-01-27 10:57:08'),
(443, 202, 'Catherine Estrella', 'CONSULTATION', 'Admin', '2025-01-27 10:08:18', '2025-01-27 10:54:06', 'Login', '2025-01-27 10:08:18', '2025-01-27 10:08:18', '2025-01-27 10:54:06'),
(444, 202, 'Catherine Estrella', 'CONSULTATION', 'Admin', '2025-01-27 10:19:36', '2025-01-27 10:54:06', 'Deleted Maria Luisa Hepana appointment from Department:  - physical.', '2025-01-27 10:19:36', '2025-01-27 10:19:36', '2025-01-27 10:54:06'),
(445, 207, 'Steph Ariola', 'Client', 'Client', '2025-01-27 10:56:52', '2025-01-27 10:56:52', ' Steph Ariola successfully registered: ', '2025-01-27 10:56:52', '2025-01-27 10:56:52', '2025-01-27 10:56:52'),
(446, 207, 'Steph Ariola', 'Client', 'Client', '2025-01-27 10:56:59', '2025-01-27 12:19:14', 'Login', '2025-01-27 10:56:59', '2025-01-27 10:56:59', '2025-01-27 12:19:14'),
(447, 201, 'Mariel Palma', 'INVENTORY', 'Admin', '2025-01-27 10:57:16', '2025-01-27 10:57:22', 'Login', '2025-01-27 10:57:16', '2025-01-27 10:57:16', '2025-01-27 10:57:22'),
(448, 198, 'Ivy Pondivida', 'IT DEPARTMENT', 'Admin', '2025-01-27 10:57:34', '2025-01-27 10:57:46', 'Login', '2025-01-27 10:57:34', '2025-01-27 10:57:34', '2025-01-27 10:57:46'),
(449, 198, 'Ivy Pondivida', 'IT DEPARTMENT', 'Admin', '2025-01-27 10:58:12', '2025-01-27 11:00:42', 'Login', '2025-01-27 10:58:12', '2025-01-27 10:58:12', '2025-01-27 11:00:42'),
(450, 198, 'Ivy Pondivida', 'IT DEPARTMENT', 'Admin', '2025-01-27 10:58:30', '2025-01-27 11:00:42', 'Approved patient account: Steph Ariola', '2025-01-27 10:58:30', '2025-01-27 10:58:30', '2025-01-27 11:00:42'),
(451, 207, 'Steph Ariola', 'Client', 'Client', '2025-01-27 11:00:12', '2025-01-27 12:19:14', 'Steph Ariola Added new appointment to Department:  - Rapid Antigen Test.', '2025-01-27 11:00:12', '2025-01-27 11:00:12', '2025-01-27 12:19:14'),
(452, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-01-27 11:00:51', '2025-01-27 11:09:32', 'Login', '2025-01-27 11:00:51', '2025-01-27 11:00:51', '2025-01-27 11:09:32'),
(453, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-01-27 11:01:49', '2025-01-27 11:09:32', 'Approved Steph Ariola appointment to Department:  - Rapid Antigen Test.', '2025-01-27 11:01:49', '2025-01-27 11:01:49', '2025-01-27 11:09:32'),
(454, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-01-27 11:04:17', '2025-01-27 11:09:32', 'Added Steph Ariola to patient record .', '2025-01-27 11:04:17', '2025-01-27 11:04:17', '2025-01-27 11:09:32'),
(455, 207, 'Steph Ariola', 'Client', 'Client', '2025-01-27 11:09:22', '2025-01-27 12:19:14', 'Steph Ariola Added new appointment to Department:  - online.', '2025-01-27 11:09:22', '2025-01-27 11:09:22', '2025-01-27 12:19:14'),
(456, 202, 'Catherine Estrella', 'CONSULTATION', 'Admin', '2025-01-27 11:09:38', '2025-01-27 11:51:26', 'Login', '2025-01-27 11:09:38', '2025-01-27 11:09:38', '2025-01-27 11:51:26'),
(457, 202, 'Catherine Estrella', 'CONSULTATION', 'Admin', '2025-01-27 11:43:46', '2025-01-27 11:51:26', 'Deleted Steph Ariola appointment from Department:  - online.', '2025-01-27 11:43:46', '2025-01-27 11:43:46', '2025-01-27 11:51:26'),
(458, 201, 'Mariel Palma', 'INVENTORY', 'Admin', '2025-01-27 11:51:33', '2025-01-27 11:57:08', 'Login', '2025-01-27 11:51:33', '2025-01-27 11:51:33', '2025-01-27 11:57:08'),
(459, 201, 'Mariel Palma', 'INVENTORY', 'Admin', '2025-01-27 11:54:26', '2025-01-27 11:57:08', ' Added Anti-Rabies Vaccine, Vaccines ', '2025-01-27 11:54:26', '2025-01-27 11:54:26', '2025-01-27 11:57:08'),
(460, 207, 'Steph Ariola', 'Client', 'Client', '2025-01-27 11:56:47', '2025-01-27 12:19:14', 'Steph Ariola Added new appointment to Department: Client', '2025-01-27 11:56:47', '2025-01-27 11:56:47', '2025-01-27 12:19:14'),
(461, 204, 'Anne Nicole Diaz', 'VACCINATION', 'Admin', '2025-01-27 11:57:16', '2025-01-27 11:59:31', 'Login', '2025-01-27 11:57:16', '2025-01-27 11:57:16', '2025-01-27 11:59:31'),
(462, 204, 'Anne Nicole Diaz', 'VACCINATION', 'Admin', '2025-01-27 11:57:37', '2025-01-27 11:59:31', 'Updated staff account (no changes)', '2025-01-27 11:57:37', '2025-01-27 11:57:37', '2025-01-27 11:59:31'),
(463, 204, 'Anne Nicole Diaz', 'VACCINATION', 'Admin', '2025-01-27 11:57:49', '2025-01-27 11:59:31', 'Approved Steph Ariola appointment to Department:  - Anti-Rabies Vaccine.', '2025-01-27 11:57:49', '2025-01-27 11:57:49', '2025-01-27 11:59:31'),
(464, 204, 'Anne Nicole Diaz', 'VACCINATION', 'Admin', '2025-01-27 11:59:18', '2025-01-27 11:59:31', 'Steph Ariola Added to patient record. Department: VACCINATION - .', '2025-01-27 11:59:18', '2025-01-27 11:59:18', '2025-01-27 11:59:31'),
(465, 200, 'Cleven Javier', 'BLOOD', 'Admin', '2025-01-27 12:01:26', '2025-01-27 12:42:43', 'Login', '2025-01-27 12:01:26', '2025-01-27 12:01:26', '2025-01-27 12:42:43'),
(466, 208, 'Andrei Raneses', 'Client', 'Client', '2025-01-27 12:23:30', '2025-01-27 12:23:30', ' Andrei Raneses successfully registered: ', '2025-01-27 12:23:30', '2025-01-27 12:23:30', '2025-01-27 12:23:30'),
(467, 208, 'Andrei Raneses', 'Client', 'Client', '2025-01-27 12:23:41', '2025-01-27 12:29:42', 'Login', '2025-01-27 12:23:41', '2025-01-27 12:23:41', '2025-01-27 12:29:42'),
(468, 198, 'Ivy Pondivida', 'IT DEPARTMENT', 'Admin', '2025-01-27 12:24:05', '2025-01-27 12:25:42', 'Login', '2025-01-27 12:24:05', '2025-01-27 12:24:05', '2025-01-27 12:25:42'),
(469, 198, 'Ivy Pondivida', 'IT DEPARTMENT', 'Admin', '2025-01-27 12:24:47', '2025-01-27 12:25:42', 'Approved patient account: Andrei Raneses', '2025-01-27 12:24:47', '2025-01-27 12:24:47', '2025-01-27 12:25:42'),
(470, 208, 'Andrei Raneses', 'Client', 'Client', '2025-01-27 12:27:50', '2025-01-27 12:29:42', 'Andrei Raneses Added new appointment to Department:  - Rapid Antigen Test.', '2025-01-27 12:27:50', '2025-01-27 12:27:50', '2025-01-27 12:29:42'),
(471, 208, 'Andrei Raneses', 'Client', 'Client', '2025-01-27 12:29:37', '2025-01-27 12:29:42', 'Andrei Raneses Added new appointment to Department: Client', '2025-01-27 12:29:37', '2025-01-27 12:29:37', '2025-01-27 12:29:42'),
(472, 204, 'Anne Nicole Diaz', 'VACCINATION', 'Admin', '2025-01-27 12:29:52', '2025-01-27 12:33:00', 'Login', '2025-01-27 12:29:52', '2025-01-27 12:29:52', '2025-01-27 12:33:00'),
(473, 204, 'Anne Nicole Diaz', 'VACCINATION', 'Admin', '2025-01-27 12:30:09', '2025-01-27 12:33:00', 'Approved Andrei Raneses appointment to Department:  - Anti-Rabies Vaccine.', '2025-01-27 12:30:09', '2025-01-27 12:30:09', '2025-01-27 12:33:00'),
(474, 204, 'Anne Nicole Diaz', 'VACCINATION', 'Admin', '2025-01-27 12:32:53', '2025-01-27 12:33:00', 'Andrei Raneses Added to patient record. Department: VACCINATION - .', '2025-01-27 12:32:53', '2025-01-27 12:32:53', '2025-01-27 12:33:00'),
(475, 208, 'Andrei Raneses', 'Client', 'Client', '2025-01-27 12:33:16', '2025-01-27 12:33:41', 'Login', '2025-01-27 12:33:16', '2025-01-27 12:33:16', '2025-01-27 12:33:41'),
(476, 208, 'Andrei Raneses', 'Client', 'Client', '2025-01-27 12:34:51', '2025-01-27 12:48:53', 'Login', '2025-01-27 12:34:51', '2025-01-27 12:34:51', '2025-01-27 12:48:53'),
(477, 209, 'Saewqda Qweads', 'Client', 'Client', '2025-01-27 12:44:24', '2025-01-27 12:44:24', ' Saewqda Qweads successfully registered: ', '2025-01-27 12:44:24', '2025-01-27 12:44:24', '2025-01-27 12:44:24'),
(478, 198, 'Ivy Pondivida', 'IT DEPARTMENT', 'Admin', '2025-01-27 12:44:35', '2025-01-27 12:48:47', 'Login', '2025-01-27 12:44:35', '2025-01-27 12:44:35', '2025-01-27 12:48:47'),
(479, 198, 'Ivy Pondivida', 'IT DEPARTMENT', 'Admin', '2025-01-27 12:44:45', '2025-01-27 12:48:47', 'Approved patient account: Saewqda Qweads', '2025-01-27 12:44:45', '2025-01-27 12:44:45', '2025-01-27 12:48:47'),
(480, 210, 'Qew Qwewqeas', 'Client', 'Client', '2025-01-27 12:49:44', '2025-01-27 12:49:44', ' Qew Qwewqeas successfully registered: ', '2025-01-27 12:49:44', '2025-01-27 12:49:44', '2025-01-27 12:49:44'),
(481, 198, 'Ivy Pondivida', 'IT DEPARTMENT', 'Admin', '2025-01-27 12:50:03', '2025-01-27 12:54:58', 'Login', '2025-01-27 12:50:03', '2025-01-27 12:50:03', '2025-01-27 12:54:58'),
(482, 198, 'Ivy Pondivida', 'IT DEPARTMENT', 'Admin', '2025-01-27 12:50:12', '2025-01-27 12:54:58', 'Approved patient account: Qew Qwewqeas', '2025-01-27 12:50:12', '2025-01-27 12:50:12', '2025-01-27 12:54:58'),
(483, 211, 'Sadqwe Asewqdas', 'Client', 'Client', '2025-01-27 12:55:50', '2025-01-27 12:55:50', ' Sadqwe Asewqdas successfully registered: ', '2025-01-27 12:55:50', '2025-01-27 12:55:50', '2025-01-27 12:55:50'),
(484, 198, 'Ivy Pondivida', 'IT DEPARTMENT', 'Admin', '2025-01-27 12:55:59', '2025-01-27 13:00:45', 'Login', '2025-01-27 12:55:59', '2025-01-27 12:55:59', '2025-01-27 13:00:45'),
(485, 198, 'Ivy Pondivida', 'IT DEPARTMENT', 'Admin', '2025-01-27 12:56:06', '2025-01-27 13:00:45', 'Approved patient account: Sadqwe Asewqdas', '2025-01-27 12:56:06', '2025-01-27 12:56:06', '2025-01-27 13:00:45'),
(486, 212, 'Dqweas Asewqdsa', 'Client', 'Client', '2025-01-27 13:02:20', '2025-01-27 13:02:20', ' Dqweas Asewqdsa successfully registered: ', '2025-01-27 13:02:20', '2025-01-27 13:02:20', '2025-01-27 13:02:20'),
(487, 198, 'Ivy Pondivida', 'IT DEPARTMENT', 'Admin', '2025-01-27 13:02:28', '2025-01-27 13:07:45', 'Login', '2025-01-27 13:02:28', '2025-01-27 13:02:28', '2025-01-27 13:07:45'),
(488, 198, 'Ivy Pondivida', 'IT DEPARTMENT', 'Admin', '2025-01-27 13:02:46', '2025-01-27 13:07:45', 'Approved patient account: Dqweas Asewqdsa', '2025-01-27 13:02:46', '2025-01-27 13:02:46', '2025-01-27 13:07:45'),
(489, 213, 'Saeqwdas Qwdaseqw', 'Client', 'Client', '2025-01-27 13:09:51', '2025-01-27 13:09:51', ' Saeqwdas Qwdaseqw successfully registered: ', '2025-01-27 13:09:51', '2025-01-27 13:09:51', '2025-01-27 13:09:51'),
(490, 198, 'Ivy Pondivida', 'IT DEPARTMENT', 'Admin', '2025-01-27 13:09:57', '2025-01-27 13:16:29', 'Login', '2025-01-27 13:09:57', '2025-01-27 13:09:57', '2025-01-27 13:16:29'),
(491, 198, 'Ivy Pondivida', 'IT DEPARTMENT', 'Admin', '2025-01-27 13:10:05', '2025-01-27 13:16:29', 'Approved patient account: Saeqwdas Qwdaseqw', '2025-01-27 13:10:05', '2025-01-27 13:10:05', '2025-01-27 13:16:29'),
(492, 214, 'Dsqwdas Qwedsadsa', 'Client', 'Client', '2025-01-27 13:17:18', '2025-01-27 13:17:18', ' Dsqwdas Qwedsadsa successfully registered: ', '2025-01-27 13:17:18', '2025-01-27 13:17:18', '2025-01-27 13:17:18'),
(493, 198, 'Ivy Pondivida', 'IT DEPARTMENT', 'Admin', '2025-01-27 13:17:24', '2025-01-27 13:20:42', 'Login', '2025-01-27 13:17:24', '2025-01-27 13:17:24', '2025-01-27 13:20:42'),
(494, 198, 'Ivy Pondivida', 'IT DEPARTMENT', 'Admin', '2025-01-27 13:17:37', '2025-01-27 13:20:42', 'Approved patient account: Dsqwdas Qwedsadsa', '2025-01-27 13:17:37', '2025-01-27 13:17:37', '2025-01-27 13:20:42'),
(495, 215, 'Dasqweqw Asdqwe', 'Client', 'Client', '2025-01-27 13:21:55', '2025-01-27 13:21:55', ' Dasqweqw Asdqwe successfully registered: ', '2025-01-27 13:21:55', '2025-01-27 13:21:55', '2025-01-27 13:21:55'),
(496, 198, 'Ivy Pondivida', 'IT DEPARTMENT', 'Admin', '2025-01-27 13:22:04', '2025-01-27 14:02:48', 'Login', '2025-01-27 13:22:04', '2025-01-27 13:22:04', '2025-01-27 14:02:48'),
(497, 198, 'Ivy Pondivida', 'IT DEPARTMENT', 'Admin', '2025-01-27 13:22:11', '2025-01-27 14:02:48', 'Approved patient account: Dasqweqw Asdqwe', '2025-01-27 13:22:11', '2025-01-27 13:22:11', '2025-01-27 14:02:48'),
(498, 216, 'Jimuel Hipana', 'Client', 'Client', '2025-01-27 13:53:23', '2025-01-27 13:53:23', ' Jimuel Hipana successfully registered: ', '2025-01-27 13:53:23', '2025-01-27 13:53:23', '2025-01-27 13:53:23'),
(499, 216, 'Jimuel Hipana', 'Client', 'Client', '2025-01-27 13:53:45', '2025-01-27 14:03:25', 'Login', '2025-01-27 13:53:45', '2025-01-27 13:53:45', '2025-01-27 14:03:25'),
(500, 198, 'Ivy Pondivida', 'IT DEPARTMENT', 'Admin', '2025-01-27 13:54:46', '2025-01-27 14:02:48', 'Approved patient account: Jimuel Hipana', '2025-01-27 13:54:46', '2025-01-27 13:54:46', '2025-01-27 14:02:48'),
(501, 216, 'Jimuel Hipana', 'Client', 'Client', '2025-01-27 14:01:54', '2025-01-27 14:03:25', 'Jimuel Hipana Added new appointment to Department:  - Rapid Antigen Test.', '2025-01-27 14:01:54', '2025-01-27 14:01:54', '2025-01-27 14:03:25'),
(502, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-01-27 14:02:57', '2025-01-27 14:15:55', 'Login', '2025-01-27 14:02:57', '2025-01-27 14:02:57', '2025-01-27 14:15:55'),
(503, 214, 'Dsqwdas Qwedsadsa', 'Client', 'Client', '2025-01-27 14:03:32', '2025-01-27 14:18:46', 'Login', '2025-01-27 14:03:32', '2025-01-27 14:03:32', '2025-01-27 14:18:46'),
(504, 214, 'Dsqwdas Qwedsadsa', 'Client', 'Client', '2025-01-27 14:04:01', '2025-01-27 14:18:46', 'Dsqwdas Qwedsadsa Added new appointment to Department:  - Rapid Antigen Test.', '2025-01-27 14:04:01', '2025-01-27 14:04:01', '2025-01-27 14:18:46'),
(505, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-01-27 14:05:12', '2025-01-27 14:15:55', 'Approved Jimuel Hipana appointment to Department:  - Rapid Antigen Test.', '2025-01-27 14:05:12', '2025-01-27 14:05:12', '2025-01-27 14:15:55'),
(506, 200, 'Cleven Javier', 'BLOOD', 'Admin', '2025-01-27 14:16:23', '2025-01-27 14:17:26', 'Login', '2025-01-27 14:16:23', '2025-01-27 14:16:23', '2025-01-27 14:17:26'),
(507, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-01-27 14:17:33', '2025-01-27 14:22:35', 'Login', '2025-01-27 14:17:33', '2025-01-27 14:17:33', '2025-01-27 14:22:35'),
(508, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-01-27 14:18:21', '2025-01-27 14:22:35', 'Added Jimuel Hipana to patient record .', '2025-01-27 14:18:21', '2025-01-27 14:18:21', '2025-01-27 14:22:35'),
(509, 216, 'Jimuel Hipana', 'Client', 'Client', '2025-01-27 14:18:55', '2025-01-27 14:39:28', 'Login', '2025-01-27 14:18:55', '2025-01-27 14:18:55', '2025-01-27 14:39:28'),
(510, 198, 'Ivy Pondivida', 'IT DEPARTMENT', 'Admin', '2025-01-27 14:22:43', '2025-01-27 14:23:54', 'Login', '2025-01-27 14:22:43', '2025-01-27 14:22:43', '2025-01-27 14:23:54'),
(511, 198, 'Ivy Pondivida', 'IT DEPARTMENT', 'Admin', '2025-01-27 14:24:11', '2025-01-27 14:25:42', 'Login', '2025-01-27 14:24:11', '2025-01-27 14:24:11', '2025-01-27 14:25:42'),
(512, 201, 'Mariel Palma', 'INVENTORY', 'Admin', '2025-01-27 14:25:56', '2025-01-27 14:34:31', 'Login', '2025-01-27 14:25:56', '2025-01-27 14:25:56', '2025-01-27 14:34:31'),
(513, 201, 'Mariel Palma', 'INVENTORY', 'Admin', '2025-01-27 14:26:25', '2025-01-27 14:34:31', ' Added new medicine name:adsqew ', '2025-01-27 14:26:25', '2025-01-27 14:26:25', '2025-01-27 14:34:31'),
(514, 201, 'Mariel Palma', 'INVENTORY', 'Admin', '2025-01-27 14:26:54', '2025-01-27 14:34:31', ' Updated medicine', '2025-01-27 14:26:54', '2025-01-27 14:26:54', '2025-01-27 14:34:31'),
(515, 201, 'Mariel Palma', 'INVENTORY', 'Admin', '2025-01-27 14:27:04', '2025-01-27 14:34:31', ' Updated medicine', '2025-01-27 14:27:04', '2025-01-27 14:27:04', '2025-01-27 14:34:31'),
(516, 201, 'Mariel Palma', 'INVENTORY', 'Admin', '2025-01-27 14:28:52', '2025-01-27 14:34:31', ' Updated medicine', '2025-01-27 14:28:52', '2025-01-27 14:28:52', '2025-01-27 14:34:31'),
(517, 201, 'Mariel Palma', 'INVENTORY', 'Admin', '2025-01-27 14:30:27', '2025-01-27 14:34:31', ' Updated medicine', '2025-01-27 14:30:27', '2025-01-27 14:30:27', '2025-01-27 14:34:31'),
(518, 201, 'Mariel Palma', 'INVENTORY', 'Admin', '2025-01-27 14:31:01', '2025-01-27 14:34:31', ' Updated medicine', '2025-01-27 14:31:01', '2025-01-27 14:31:01', '2025-01-27 14:34:31'),
(519, 198, 'Ivy Pondivida', 'IT DEPARTMENT', 'Admin', '2025-01-27 14:34:42', '2025-01-27 14:36:10', 'Login', '2025-01-27 14:34:42', '2025-01-27 14:34:42', '2025-01-27 14:36:10'),
(520, 198, 'Ivy Pondivida', 'IT DEPARTMENT', 'Admin', '2025-01-27 14:44:01', '2025-01-27 14:44:56', 'Login', '2025-01-27 14:44:01', '2025-01-27 14:44:01', '2025-01-27 14:44:56'),
(521, 199, 'Luis Mallari', 'SUPER ADMIN', 'Admin', '2025-01-27 14:45:07', '2025-01-27 16:22:02', 'Login', '2025-01-27 14:45:07', '2025-01-27 14:45:07', '2025-01-27 16:22:02'),
(522, 217, 'Evelyn Veluz', 'Client', 'Client', '2025-01-27 16:28:45', '2025-01-27 16:28:45', ' Evelyn Veluz successfully registered: ', '2025-01-27 16:28:45', '2025-01-27 16:28:45', '2025-01-27 16:28:45'),
(523, 217, 'Evelyn Veluz', 'Client', 'Client', '2025-01-27 16:28:59', '2025-01-28 15:48:05', 'Login', '2025-01-27 16:28:59', '2025-01-27 16:28:59', '2025-01-28 15:48:05'),
(524, 198, 'Ivy Pondivida', 'IT DEPARTMENT', 'Admin', '2025-01-27 16:29:27', '2025-01-27 16:31:08', 'Login', '2025-01-27 16:29:27', '2025-01-27 16:29:27', '2025-01-27 16:31:08'),
(525, 198, 'Ivy Pondivida', 'IT DEPARTMENT', 'Admin', '2025-01-27 16:30:02', '2025-01-27 16:31:08', 'Approved patient account: Evelyn Veluz', '2025-01-27 16:30:02', '2025-01-27 16:30:02', '2025-01-27 16:31:08'),
(526, 217, 'Evelyn Veluz', 'Client', 'Client', '2025-01-27 16:32:07', '2025-01-28 15:48:05', 'Evelyn Veluz Added new appointment to Department:  - Rapid Antigen Test.', '2025-01-27 16:32:07', '2025-01-27 16:32:07', '2025-01-28 15:48:05'),
(527, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-01-27 16:32:43', '2025-01-27 16:41:17', 'Login', '2025-01-27 16:32:43', '2025-01-27 16:32:43', '2025-01-27 16:41:17'),
(528, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-01-27 16:33:11', '2025-01-27 16:41:17', 'Approved Evelyn Veluz appointment to Department:  - Rapid Antigen Test.', '2025-01-27 16:33:11', '2025-01-27 16:33:11', '2025-01-27 16:41:17'),
(529, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-01-27 16:34:14', '2025-01-27 16:41:17', 'Approved Evelyn Veluz appointment to Department:  - Rapid Antigen Test.', '2025-01-27 16:34:14', '2025-01-27 16:34:14', '2025-01-27 16:41:17'),
(530, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-01-27 16:36:07', '2025-01-27 16:41:17', 'Added lab test Sputum.', '2025-01-27 16:36:07', '2025-01-27 16:36:07', '2025-01-27 16:41:17'),
(531, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-01-27 16:36:19', '2025-01-27 16:41:17', 'Updated lab test Sputum.', '2025-01-27 16:36:19', '2025-01-27 16:36:19', '2025-01-27 16:41:17'),
(532, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-01-27 16:36:56', '2025-01-27 16:41:17', 'Updated lab test Blood Typing.', '2025-01-27 16:36:56', '2025-01-27 16:36:56', '2025-01-27 16:41:17'),
(533, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-01-27 16:37:38', '2025-01-27 16:41:17', 'Added Evelyn Veluz to patient record .', '2025-01-27 16:37:38', '2025-01-27 16:37:38', '2025-01-27 16:41:17'),
(534, 200, 'Cleven Javier', 'BLOOD', 'Admin', '2025-01-27 16:41:27', '2025-01-27 16:43:04', 'Login', '2025-01-27 16:41:27', '2025-01-27 16:41:27', '2025-01-27 16:43:04'),
(535, 200, 'Cleven Javier', 'BLOOD', 'Admin', '2025-01-27 16:42:00', '2025-01-27 16:43:04', 'Approved Evelyn Veluz appointment to Department:  - B+.', '2025-01-27 16:42:00', '2025-01-27 16:42:00', '2025-01-27 16:43:04'),
(536, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-01-27 16:48:09', '2025-01-27 16:54:18', 'Login', '2025-01-27 16:48:09', '2025-01-27 16:48:09', '2025-01-27 16:54:18'),
(537, 217, 'Evelyn Veluz', 'Client', 'Client', '2025-01-27 16:48:38', '2025-01-28 15:48:05', 'Evelyn Veluz Added new appointment to Department:  - Sputum.', '2025-01-27 16:48:38', '2025-01-27 16:48:38', '2025-01-28 15:48:05'),
(538, 217, 'Evelyn Veluz', 'Client', 'Client', '2025-01-27 16:49:53', '2025-01-28 15:48:05', 'Evelyn Veluz Added new appointment to Department:  - Rapid Antigen Test.', '2025-01-27 16:49:53', '2025-01-27 16:49:53', '2025-01-28 15:48:05'),
(539, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-01-27 16:50:17', '2025-01-27 16:54:18', 'Approved Evelyn Veluz appointment to Department:  - Rapid Antigen Test.', '2025-01-27 16:50:17', '2025-01-27 16:50:17', '2025-01-27 16:54:18'),
(540, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-01-27 16:51:46', '2025-01-27 16:54:18', 'Updated lab test Rapid Antigen Test.', '2025-01-27 16:51:46', '2025-01-27 16:51:46', '2025-01-27 16:54:18'),
(541, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-01-27 16:52:29', '2025-01-27 16:54:18', 'Added Evelyn Veluz to patient record .', '2025-01-27 16:52:29', '2025-01-27 16:52:29', '2025-01-27 16:54:18'),
(542, 204, 'Anne Nicole Diaz', 'VACCINATION', 'Admin', '2025-01-27 16:57:55', '2025-01-27 16:58:31', 'Login', '2025-01-27 16:57:55', '2025-01-27 16:57:55', '2025-01-27 16:58:31'),
(543, 217, 'Evelyn Veluz', 'Client', 'Client', '2025-01-27 16:59:34', '2025-01-28 15:48:05', 'Evelyn Veluz Added new appointment to Department: Client', '2025-01-27 16:59:34', '2025-01-27 16:59:34', '2025-01-28 15:48:05'),
(544, 204, 'Anne Nicole Diaz', 'VACCINATION', 'Admin', '2025-01-27 17:00:30', '2025-01-28 17:09:33', 'Login', '2025-01-27 17:00:30', '2025-01-27 17:00:30', '2025-01-28 17:09:33'),
(545, 204, 'Anne Nicole Diaz', 'VACCINATION', 'Admin', '2025-01-27 17:00:47', '2025-01-28 17:09:33', 'Approved Evelyn Veluz appointment to Department:  - Anti-Rabies Vaccine.', '2025-01-27 17:00:47', '2025-01-27 17:00:47', '2025-01-28 17:09:33'),
(546, 204, 'Anne Nicole Diaz', 'VACCINATION', 'Admin', '2025-01-27 17:01:36', '2025-01-28 17:09:33', 'Evelyn Veluz Added to patient record. Department: VACCINATION - .', '2025-01-27 17:01:36', '2025-01-27 17:01:36', '2025-01-28 17:09:33'),
(547, 214, 'Dsqwdas Qwedsadsa', 'Client', 'Client', '2025-01-28 02:01:53', '2025-01-28 03:08:38', 'Login', '2025-01-28 02:01:53', '2025-01-28 02:01:53', '2025-01-28 03:08:38'),
(548, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-01-28 02:35:18', '2025-01-28 05:18:02', 'Login', '2025-01-28 02:35:18', '2025-01-28 02:35:18', '2025-01-28 05:18:02'),
(549, 214, 'Veronica Sulit', 'Client', 'Client', '2025-01-28 03:00:04', '2025-01-28 03:08:38', 'Veronica Sulit Added new appointment to Department:  - Sputum 50.', '2025-01-28 03:00:04', '2025-01-28 03:00:04', '2025-01-28 03:08:38'),
(550, 214, 'Veronica Sulit', 'Client', 'Client', '2025-01-28 03:01:34', '2025-01-28 03:08:38', 'Veronica Sulit Added new appointment to Department:  - Urinalysis 50.', '2025-01-28 03:01:34', '2025-01-28 03:01:34', '2025-01-28 03:08:38'),
(551, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-01-28 03:05:54', '2025-01-28 05:18:02', 'Deleted Veronica Sulit appointment to Department:  - Sputum 50.', '2025-01-28 03:05:54', '2025-01-28 03:05:54', '2025-01-28 05:18:02'),
(552, 214, 'Veronica Sulit', 'Client', 'Client', '2025-01-28 03:06:35', '2025-01-28 03:08:38', 'Veronica Sulit Added new appointment to Department:  - Sputum 50.', '2025-01-28 03:06:35', '2025-01-28 03:06:35', '2025-01-28 03:08:38'),
(553, 214, 'Veronica Sulit', 'Client', 'Client', '2025-01-28 03:11:17', '2025-01-28 03:52:43', 'Login', '2025-01-28 03:11:17', '2025-01-28 03:11:17', '2025-01-28 03:52:43'),
(554, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-01-28 03:18:54', '2025-01-28 05:18:02', 'Deleted Veronica Sulit appointment to Department:  - Urinalysis 50.', '2025-01-28 03:18:54', '2025-01-28 03:18:54', '2025-01-28 05:18:02'),
(555, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-01-28 03:18:57', '2025-01-28 05:18:02', 'Deleted Veronica Sulit appointment to Department:  - Sputum 50.', '2025-01-28 03:18:57', '2025-01-28 03:18:57', '2025-01-28 05:18:02'),
(556, 214, 'Veronica Sulit', 'Client', 'Client', '2025-01-28 03:19:46', '2025-01-28 03:52:43', 'Veronica Sulit Added new appointment to Department:  - Sputum.', '2025-01-28 03:19:46', '2025-01-28 03:19:46', '2025-01-28 03:52:43'),
(557, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-01-28 03:20:31', '2025-01-28 05:18:02', 'Updated lab test Rapid Antigen Test.', '2025-01-28 03:20:31', '2025-01-28 03:20:31', '2025-01-28 05:18:02'),
(558, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-01-28 03:20:35', '2025-01-28 05:18:02', 'Updated lab test Blood Typing.', '2025-01-28 03:20:35', '2025-01-28 03:20:35', '2025-01-28 05:18:02'),
(559, 214, 'Veronica Sulit', 'Client', 'Client', '2025-01-28 03:25:18', '2025-01-28 03:52:43', 'Veronica Sulit Added new appointment to Department:  - Blood Typing.', '2025-01-28 03:25:18', '2025-01-28 03:25:18', '2025-01-28 03:52:43'),
(560, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-01-28 03:25:44', '2025-01-28 05:18:02', 'Approved Veronica Sulit appointment to Department:  - Blood Typing.', '2025-01-28 03:25:44', '2025-01-28 03:25:44', '2025-01-28 05:18:02'),
(561, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-01-28 03:26:19', '2025-01-28 05:18:02', 'Added Veronica Sulit to patient record .', '2025-01-28 03:26:19', '2025-01-28 03:26:19', '2025-01-28 05:18:02'),
(562, 214, 'Veronica Sulit', 'Client', 'Client', '2025-01-28 03:54:59', '2025-01-28 04:01:09', 'Login', '2025-01-28 03:54:59', '2025-01-28 03:54:59', '2025-01-28 04:01:09'),
(563, 214, 'Ericson Yu', 'Client', 'Client', '2025-01-28 04:07:30', '2025-01-28 05:51:05', 'Login', '2025-01-28 04:07:30', '2025-01-28 04:07:30', '2025-01-28 05:51:05'),
(564, 214, 'Veronica Sulit', 'Client', 'Client', '2025-01-28 05:11:10', '2025-01-28 05:51:05', 'Veronica Sulit Added new appointment to Department:  - online.', '2025-01-28 05:11:10', '2025-01-28 05:11:10', '2025-01-28 05:51:05'),
(565, 214, 'Veronica Sulit', 'Client', 'Client', '2025-01-28 05:12:32', '2025-01-28 05:51:05', 'Veronica Sulit Added new appointment to Department: Client', '2025-01-28 05:12:32', '2025-01-28 05:12:32', '2025-01-28 05:51:05'),
(566, 200, 'Cleven Javier', 'BLOOD', 'Admin', '2025-01-28 05:18:15', '2025-01-28 05:34:48', 'Login', '2025-01-28 05:18:15', '2025-01-28 05:18:15', '2025-01-28 05:34:48'),
(567, 214, 'Veronica Sulit', 'Client', 'Client', '2025-01-28 05:25:45', '2025-01-28 05:51:05', 'Veronica Sulit Added new appointment to Department:  - Sputum.', '2025-01-28 05:25:45', '2025-01-28 05:25:45', '2025-01-28 05:51:05'),
(568, 214, 'Veronica Sulit', 'Client', 'Client', '2025-01-28 05:29:09', '2025-01-28 05:51:05', 'Veronica Sulit Added new appointment to Department:  - Urinalysis.', '2025-01-28 05:29:09', '2025-01-28 05:29:09', '2025-01-28 05:51:05'),
(569, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-01-28 05:34:58', '2025-01-28 05:44:47', 'Login', '2025-01-28 05:34:58', '2025-01-28 05:34:58', '2025-01-28 05:44:47'),
(570, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-01-28 05:35:04', '2025-01-28 05:44:47', 'Deleted Veronica Sulit appointment to Department:  - Sputum.', '2025-01-28 05:35:04', '2025-01-28 05:35:04', '2025-01-28 05:44:47'),
(571, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-01-28 05:35:08', '2025-01-28 05:44:47', 'Deleted Veronica Sulit appointment to Department:  - Urinalysis.', '2025-01-28 05:35:08', '2025-01-28 05:35:08', '2025-01-28 05:44:47'),
(572, 214, 'Veronica Sulit', 'Client', 'Client', '2025-01-28 05:35:45', '2025-01-28 05:51:05', 'Veronica Sulit Added new appointment to Department:  - Urinalysis.', '2025-01-28 05:35:45', '2025-01-28 05:35:45', '2025-01-28 05:51:05'),
(573, 214, 'Veronica Sulit', 'Client', 'Client', '2025-01-28 05:41:52', '2025-01-28 05:51:05', 'Veronica Sulit Added new appointment to Department:  - Sputum.', '2025-01-28 05:41:52', '2025-01-28 05:41:52', '2025-01-28 05:51:05'),
(574, 200, 'Cleven Javier', 'BLOOD', 'Admin', '2025-01-28 05:44:55', '2025-01-28 05:47:49', 'Login', '2025-01-28 05:44:55', '2025-01-28 05:44:55', '2025-01-28 05:47:49'),
(575, 200, 'Cleven Javier', 'BLOOD', 'Admin', '2025-01-28 05:45:08', '2025-01-28 05:47:49', 'Deleted Steph Ariola appointment to Department:  - AB+.', '2025-01-28 05:45:08', '2025-01-28 05:45:08', '2025-01-28 05:47:49'),
(576, 200, 'Cleven Javier', 'BLOOD', 'Admin', '2025-01-28 05:45:11', '2025-01-28 05:47:49', 'Deleted Dsqwdas Qwedsadsa appointment to Department:  - A+.', '2025-01-28 05:45:11', '2025-01-28 05:45:11', '2025-01-28 05:47:49'),
(577, 200, 'Cleven Javier', 'BLOOD', 'Admin', '2025-01-28 05:45:14', '2025-01-28 05:47:49', 'Deleted Evelyn Veluz appointment to Department:  - B+.', '2025-01-28 05:45:14', '2025-01-28 05:45:14', '2025-01-28 05:47:49'),
(578, 200, 'Cleven Javier', 'BLOOD', 'Admin', '2025-01-28 05:45:17', '2025-01-28 05:47:49', 'Deleted Veronica Sulit appointment to Department:  - B+.', '2025-01-28 05:45:17', '2025-01-28 05:45:17', '2025-01-28 05:47:49'),
(579, 200, 'Cleven Javier', 'BLOOD', 'Admin', '2025-01-28 05:45:20', '2025-01-28 05:47:49', 'Deleted Veronica Sulit appointment to Department:  - AB+.', '2025-01-28 05:45:20', '2025-01-28 05:45:20', '2025-01-28 05:47:49'),
(580, 200, 'Cleven Javier', 'BLOOD', 'Admin', '2025-01-28 05:45:22', '2025-01-28 05:47:49', 'Deleted Veronica Sulit appointment to Department:  - AB-.', '2025-01-28 05:45:22', '2025-01-28 05:45:22', '2025-01-28 05:47:49'),
(581, 200, 'Cleven Javier', 'BLOOD', 'Admin', '2025-01-28 05:45:24', '2025-01-28 05:47:49', 'Deleted Veronica Sulit appointment to Department:  - O+.', '2025-01-28 05:45:24', '2025-01-28 05:45:24', '2025-01-28 05:47:49'),
(582, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-01-28 05:47:55', '2025-01-28 05:48:21', 'Login', '2025-01-28 05:47:55', '2025-01-28 05:47:55', '2025-01-28 05:48:21'),
(583, 201, 'Mariel Palma', 'INVENTORY', 'Admin', '2025-01-28 05:48:31', '2025-01-28 05:50:27', 'Login', '2025-01-28 05:48:31', '2025-01-28 05:48:31', '2025-01-28 05:50:27'),
(584, 201, 'Mariel Palma', 'INVENTORY', 'Admin', '2025-01-28 05:49:13', '2025-01-28 05:50:27', ' Added saewq, Medical Supplies ', '2025-01-28 05:49:13', '2025-01-28 05:49:13', '2025-01-28 05:50:27'),
(585, 201, 'Mariel Palma', 'INVENTORY', 'Admin', '2025-01-28 05:49:42', '2025-01-28 05:50:27', ' Added asdweq, Medical Equipments ', '2025-01-28 05:49:42', '2025-01-28 05:49:42', '2025-01-28 05:50:27'),
(586, 201, 'Mariel Palma', 'INVENTORY', 'Admin', '2025-01-28 05:49:58', '2025-01-28 05:50:27', ' Added new medicine name:sadwq ', '2025-01-28 05:49:58', '2025-01-28 05:49:58', '2025-01-28 05:50:27'),
(587, 198, 'Ivy Pondivida', 'IT DEPARTMENT', 'Admin', '2025-01-28 05:50:32', '2025-01-28 05:55:03', 'Login', '2025-01-28 05:50:32', '2025-01-28 05:50:32', '2025-01-28 05:55:03'),
(588, 218, 'Jims Hipana', 'Client', 'Client', '2025-01-28 05:53:38', '2025-01-28 05:53:38', ' Jims Hipana successfully registered: ', '2025-01-28 05:53:38', '2025-01-28 05:53:38', '2025-01-28 05:53:38'),
(589, 199, 'Luis Mallari', 'SUPER ADMIN', 'Admin', '2025-01-28 05:56:13', '2025-01-28 05:58:09', 'Login', '2025-01-28 05:56:13', '2025-01-28 05:56:13', '2025-01-28 05:58:09'),
(590, 214, 'Veronica Sulit', 'Client', 'Client', '2025-01-28 06:15:08', '2025-01-28 06:59:17', 'Login', '2025-01-28 06:15:08', '2025-01-28 06:15:08', '2025-01-28 06:59:17'),
(591, 200, 'Cleven Javier', 'BLOOD', 'Admin', '2025-01-28 06:36:33', '2025-01-28 06:57:38', 'Login', '2025-01-28 06:36:33', '2025-01-28 06:36:33', '2025-01-28 06:57:38'),
(592, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-01-28 06:57:46', '2025-01-28 12:18:27', 'Login', '2025-01-28 06:57:46', '2025-01-28 06:57:46', '2025-01-28 12:18:27'),
(593, 216, 'Jimuel Hipana', 'Client', 'Client', '2025-01-28 07:01:57', '2025-01-28 08:10:29', 'Login', '2025-01-28 07:01:57', '2025-01-28 07:01:57', '2025-01-28 08:10:29'),
(594, 216, 'Jimuel Hipana', 'Client', 'Client', '2025-01-28 07:02:29', '2025-01-28 08:10:29', 'Jimuel Hipana Added new appointment to Department:  - Blood Typing.', '2025-01-28 07:02:29', '2025-01-28 07:02:29', '2025-01-28 08:10:29'),
(595, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-01-28 07:02:57', '2025-01-28 12:18:27', 'Approved Jimuel Hipana appointment to Department:  - Blood Typing.', '2025-01-28 07:02:57', '2025-01-28 07:02:57', '2025-01-28 12:18:27'),
(596, 201, 'Mariel Palma', 'INVENTORY', 'Admin', '2025-01-28 08:11:23', '2025-01-28 09:00:00', 'Login', '2025-01-28 08:11:23', '2025-01-28 08:11:23', '2025-01-28 09:00:00'),
(597, 201, 'Mariel Palma', 'INVENTORY', 'Admin', '2025-01-28 08:12:17', '2025-01-28 09:00:00', ' Deleted sadwq medicine', '2025-01-28 08:12:17', '2025-01-28 08:12:17', '2025-01-28 09:00:00'),
(598, 201, 'Mariel Palma', 'INVENTORY', 'Admin', '2025-01-28 08:12:20', '2025-01-28 09:00:00', ' Deleted adsqew medicine', '2025-01-28 08:12:20', '2025-01-28 08:12:20', '2025-01-28 09:00:00'),
(599, 201, 'Mariel Palma', 'INVENTORY', 'Admin', '2025-01-28 08:16:27', '2025-01-28 09:00:00', ' Added new medicine name:Paracetamol ', '2025-01-28 08:16:27', '2025-01-28 08:16:27', '2025-01-28 09:00:00'),
(600, 201, 'Mariel Palma', 'INVENTORY', 'Admin', '2025-01-28 08:17:35', '2025-01-28 09:00:00', ' Added new medicine name:Amoxicillin Syrup ', '2025-01-28 08:17:35', '2025-01-28 08:17:35', '2025-01-28 09:00:00'),
(601, 201, 'Mariel Palma', 'INVENTORY', 'Admin', '2025-01-28 08:18:48', '2025-01-28 09:00:00', ' Added new medicine name:Ibuprofen ', '2025-01-28 08:18:48', '2025-01-28 08:18:48', '2025-01-28 09:00:00'),
(602, 201, 'Mariel Palma', 'INVENTORY', 'Admin', '2025-01-28 08:19:55', '2025-01-28 09:00:00', ' Added new medicine name:Aspirin ', '2025-01-28 08:19:55', '2025-01-28 08:19:55', '2025-01-28 09:00:00'),
(603, 201, 'Mariel Palma', 'INVENTORY', 'Admin', '2025-01-28 08:27:57', '2025-01-28 09:00:00', ' Added new medicine name:Omeprazole ', '2025-01-28 08:27:57', '2025-01-28 08:27:57', '2025-01-28 09:00:00'),
(604, 201, 'Mariel Palma', 'INVENTORY', 'Admin', '2025-01-28 08:28:47', '2025-01-28 09:00:00', ' Added new medicine name:Cetirizine Syrup ', '2025-01-28 08:28:47', '2025-01-28 08:28:47', '2025-01-28 09:00:00'),
(605, 201, 'Mariel Palma', 'INVENTORY', 'Admin', '2025-01-28 08:29:48', '2025-01-28 09:00:00', ' Added Surgical Gloves, Medical Supplies ', '2025-01-28 08:29:48', '2025-01-28 08:29:48', '2025-01-28 09:00:00'),
(606, 201, 'Mariel Palma', 'INVENTORY', 'Admin', '2025-01-28 08:30:04', '2025-01-28 09:00:00', ' Added Face Masks, Medical Supplies ', '2025-01-28 08:30:04', '2025-01-28 08:30:04', '2025-01-28 09:00:00'),
(607, 201, 'Mariel Palma', 'INVENTORY', 'Admin', '2025-01-28 08:30:28', '2025-01-28 09:00:00', ' Added Disposable Syringes, Medical Supplies ', '2025-01-28 08:30:28', '2025-01-28 08:30:28', '2025-01-28 09:00:00'),
(608, 201, 'Mariel Palma', 'INVENTORY', 'Admin', '2025-01-28 08:30:51', '2025-01-28 09:00:00', ' Added Sterile Gauze, Medical Supplies ', '2025-01-28 08:30:51', '2025-01-28 08:30:51', '2025-01-28 09:00:00'),
(609, 201, 'Mariel Palma', 'INVENTORY', 'Admin', '2025-01-28 08:31:17', '2025-01-28 09:00:00', ' Added Suction Catheters, Medical Supplies ', '2025-01-28 08:31:17', '2025-01-28 08:31:17', '2025-01-28 09:00:00'),
(610, 201, 'Mariel Palma', 'INVENTORY', 'Admin', '2025-01-28 08:32:12', '2025-01-28 09:00:00', ' Added Digital Blood Pressure Monitor, Medical Equipments ', '2025-01-28 08:32:12', '2025-01-28 08:32:12', '2025-01-28 09:00:00'),
(611, 201, 'Mariel Palma', 'INVENTORY', 'Admin', '2025-01-28 08:32:45', '2025-01-28 09:00:00', ' Added Defibrillator, Medical Equipments ', '2025-01-28 08:32:45', '2025-01-28 08:32:45', '2025-01-28 09:00:00'),
(612, 201, 'Mariel Palma', 'INVENTORY', 'Admin', '2025-01-28 08:33:20', '2025-01-28 09:00:00', ' Added Nebulizer, Medical Equipments ', '2025-01-28 08:33:20', '2025-01-28 08:33:20', '2025-01-28 09:00:00'),
(613, 201, 'Mariel Palma', 'INVENTORY', 'Admin', '2025-01-28 08:33:25', '2025-01-28 09:00:00', ' Deleted asdweq, Medical Equipments ', '2025-01-28 08:33:25', '2025-01-28 08:33:25', '2025-01-28 09:00:00'),
(614, 201, 'Mariel Palma', 'INVENTORY', 'Admin', '2025-01-28 08:35:04', '2025-01-28 09:00:00', ' Added COVID-19 Vaccine (Pfizer), Vaccines ', '2025-01-28 08:35:04', '2025-01-28 08:35:04', '2025-01-28 09:00:00'),
(615, 201, 'Mariel Palma', 'INVENTORY', 'Admin', '2025-01-28 08:35:44', '2025-01-28 09:00:00', ' Added MMR Vaccine, Vaccines ', '2025-01-28 08:35:44', '2025-01-28 08:35:44', '2025-01-28 09:00:00'),
(616, 202, 'Catherine Estrella', 'CONSULTATION', 'Admin', '2025-01-28 09:00:09', '2025-01-28 16:53:47', 'Login', '2025-01-28 09:00:09', '2025-01-28 09:00:09', '2025-01-28 16:53:47'),
(617, 202, 'Catherine Estrella', 'CONSULTATION', 'Admin', '2025-01-28 09:01:15', '2025-01-28 16:53:47', 'Deleted Steph Ariola appointment to Department:  - online.', '2025-01-28 09:01:15', '2025-01-28 09:01:15', '2025-01-28 16:53:47'),
(618, 202, 'Catherine Estrella', 'CONSULTATION', 'Admin', '2025-01-28 09:01:18', '2025-01-28 16:53:47', 'Deleted Maria Luisa Hepana appointment to Department:  - physical.', '2025-01-28 09:01:18', '2025-01-28 09:01:18', '2025-01-28 16:53:47'),
(619, 201, 'Mariel Palma', 'INVENTORY', 'Admin', '2025-01-28 11:51:38', '2025-01-28 11:52:21', 'Login', '2025-01-28 11:51:38', '2025-01-28 11:51:38', '2025-01-28 11:52:21'),
(620, 214, 'Veronica Sulit', 'Client', 'Client', '2025-01-28 12:08:42', '2025-01-28 12:13:38', 'Login', '2025-01-28 12:08:42', '2025-01-28 12:08:42', '2025-01-28 12:13:38'),
(621, 214, 'Veronica Sulit', 'Client', 'Client', '2025-01-28 12:12:26', '2025-01-28 12:13:38', 'Veronica Sulit Added new appointment to Department:  - Rapid Antigen Test.', '2025-01-28 12:12:26', '2025-01-28 12:12:26', '2025-01-28 12:13:38'),
(622, 214, 'Veronica Sulit', 'Client', 'Client', '2025-01-28 12:18:39', '2025-01-28 12:40:36', 'Login', '2025-01-28 12:18:39', '2025-01-28 12:18:39', '2025-01-28 12:40:36'),
(623, 200, 'Cleven Javier', 'BLOOD', 'Admin', '2025-01-28 12:27:40', '2025-01-28 12:27:49', 'Login', '2025-01-28 12:27:40', '2025-01-28 12:27:40', '2025-01-28 12:27:49'),
(624, 214, 'Veronica Sulit', 'Client', 'Client', '2025-01-28 12:41:06', '2025-01-28 12:42:53', 'Login', '2025-01-28 12:41:06', '2025-01-28 12:41:06', '2025-01-28 12:42:53'),
(625, 214, 'Veronica Sulit', 'Client', 'Client', '2025-01-28 12:45:13', NULL, 'Login', '2025-01-28 12:45:13', '2025-01-28 12:45:13', '2025-01-28 12:45:13'),
(626, 219, 'Ange Madrid', 'Client', 'Client', '2025-01-28 15:20:34', '2025-01-28 15:20:34', ' Ange Madrid successfully registered: ', '2025-01-28 15:20:34', '2025-01-28 15:20:34', '2025-01-28 15:20:34'),
(627, 219, 'Ange Madrid', 'Client', 'Client', '2025-01-28 15:25:02', NULL, 'Login', '2025-01-28 15:25:02', '2025-01-28 15:25:02', '2025-01-28 15:25:02'),
(628, 220, 'Clarise Pondivida', 'Client', 'Client', '2025-01-28 15:29:11', '2025-01-28 15:29:11', ' Clarise Pondivida successfully registered: ', '2025-01-28 15:29:11', '2025-01-28 15:29:11', '2025-01-28 15:29:11'),
(629, 198, 'Ivy Pondivida', 'IT DEPARTMENT', 'Admin', '2025-01-28 15:43:47', '2025-01-28 16:00:31', 'Login', '2025-01-28 15:43:47', '2025-01-28 15:43:47', '2025-01-28 16:00:31'),
(630, 217, 'Evelyn Veluz', 'Client', 'Client', '2025-01-28 15:50:15', NULL, 'Login', '2025-01-28 15:50:15', '2025-01-28 15:50:15', '2025-01-28 15:50:15'),
(631, 217, 'Angela Madrid', 'Client', 'Client', '2025-01-28 15:58:28', NULL, 'Angela Madrid Added new appointment to Department:  - physical.', '2025-01-28 15:58:28', '2025-01-28 15:58:28', '2025-01-28 15:58:28'),
(632, 198, 'Ivy Pondivida', 'IT DEPARTMENT', 'Admin', '2025-01-28 16:00:47', '2025-01-28 16:01:22', 'Login', '2025-01-28 16:00:47', '2025-01-28 16:00:47', '2025-01-28 16:01:22'),
(633, 221, 'Jimuel Hipana', 'Client', 'Client', '2025-01-28 16:39:13', '2025-01-28 16:39:13', ' Jimuel Hipana successfully registered: ', '2025-01-28 16:39:13', '2025-01-28 16:39:13', '2025-01-28 16:39:13'),
(634, 221, 'Jimuel Hipana', 'Client', 'Client', '2025-01-28 16:39:38', '2025-01-28 16:46:46', 'Login', '2025-01-28 16:39:38', '2025-01-28 16:39:38', '2025-01-28 16:46:46'),
(635, 198, 'Ivy Pondivida', 'IT DEPARTMENT', 'Admin', '2025-01-28 16:39:58', '2025-01-28 16:44:41', 'Login', '2025-01-28 16:39:58', '2025-01-28 16:39:58', '2025-01-28 16:44:41'),
(636, 198, 'Ivy Pondivida', 'IT DEPARTMENT', 'Admin', '2025-01-28 16:41:03', '2025-01-28 16:44:41', 'Approved patient account: Jimuel Hipana', '2025-01-28 16:41:03', '2025-01-28 16:41:03', '2025-01-28 16:44:41'),
(637, 221, 'Jimuel Hipana', 'Client', 'Client', '2025-01-28 16:44:32', '2025-01-28 16:46:46', 'Jimuel Hipana Added new appointment to Department:  - Blood Typing.', '2025-01-28 16:44:32', '2025-01-28 16:44:32', '2025-01-28 16:46:46'),
(638, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-01-28 16:45:13', '2025-01-28 16:50:56', 'Login', '2025-01-28 16:45:13', '2025-01-28 16:45:13', '2025-01-28 16:50:56'),
(639, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-01-28 16:45:54', '2025-01-28 16:50:56', 'Approved Jimuel Hipana appointment to Department:  - Blood Typing.', '2025-01-28 16:45:54', '2025-01-28 16:45:54', '2025-01-28 16:50:56'),
(640, 221, 'Jimuel Hipana', 'Client', 'Client', '2025-01-28 16:48:07', '2025-02-05 09:11:13', 'Login', '2025-01-28 16:48:07', '2025-01-28 16:48:07', '2025-02-05 09:11:13'),
(641, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-01-28 16:49:04', '2025-01-28 16:50:56', 'Added Jimuel Hipana to patient record .', '2025-01-28 16:49:04', '2025-01-28 16:49:04', '2025-01-28 16:50:56'),
(642, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-01-28 16:49:40', '2025-01-28 16:50:56', 'Approved Jimuel Hipana appointment to Department:  - Blood Typing.', '2025-01-28 16:49:40', '2025-01-28 16:49:40', '2025-01-28 16:50:56'),
(643, 221, 'Jimuel Hipana', 'Client', 'Client', '2025-01-28 16:50:49', '2025-02-05 09:11:13', 'Jimuel Hipana Added new appointment to Department:  - physical.', '2025-01-28 16:50:49', '2025-01-28 16:50:49', '2025-02-05 09:11:13'),
(644, 202, 'Catherine Estrella', 'CONSULTATION', 'Admin', '2025-01-28 16:52:05', '2025-01-28 16:53:47', 'Deleted Jimuel Hipana appointment from Department:  - physical.', '2025-01-28 16:52:05', '2025-01-28 16:52:05', '2025-01-28 16:53:47'),
(645, 198, 'Ivy Pondivida', 'IT DEPARTMENT', 'Admin', '2025-01-28 16:53:54', '2025-01-28 16:55:17', 'Login', '2025-01-28 16:53:54', '2025-01-28 16:53:54', '2025-01-28 16:55:17'),
(646, 199, 'Luis Mallari', 'SUPER ADMIN', 'Admin', '2025-01-28 16:55:27', '2025-01-28 16:56:46', 'Login', '2025-01-28 16:55:27', '2025-01-28 16:55:27', '2025-01-28 16:56:46'),
(647, 201, 'Mariel Palma', 'INVENTORY', 'Admin', '2025-01-28 16:56:58', '2025-01-28 16:58:29', 'Login', '2025-01-28 16:56:58', '2025-01-28 16:56:58', '2025-01-28 16:58:29'),
(648, 201, 'Mariel Palma', 'INVENTORY', 'Admin', '2025-01-28 16:57:26', '2025-01-28 16:58:29', ' Updated medicine', '2025-01-28 16:57:26', '2025-01-28 16:57:26', '2025-01-28 16:58:29'),
(649, 200, 'Cleven Javier', 'BLOOD', 'Admin', '2025-01-28 17:00:20', '2025-01-28 17:03:03', 'Login', '2025-01-28 17:00:20', '2025-01-28 17:00:20', '2025-01-28 17:03:03'),
(650, 200, 'Cleven Javier', 'BLOOD', 'Admin', '2025-01-28 17:01:15', '2025-01-28 17:03:03', 'Approved Veronica Sulit appointment to Department:  - O-.', '2025-01-28 17:01:15', '2025-01-28 17:01:15', '2025-01-28 17:03:03'),
(651, 200, 'Cleven Javier', 'BLOOD', 'Admin', '2025-01-28 17:01:20', '2025-01-28 17:03:03', 'Approved Jimuel Hipana appointment to Department:  - A+.', '2025-01-28 17:01:20', '2025-01-28 17:01:20', '2025-01-28 17:03:03'),
(652, 200, 'Cleven Javier', 'BLOOD', 'Admin', '2025-01-28 17:01:30', '2025-01-28 17:03:03', 'New patient record added', '2025-01-28 17:01:30', '2025-01-28 17:01:30', '2025-01-28 17:03:03'),
(653, 200, 'Cleven Javier', 'BLOOD', 'Admin', '2025-01-28 17:01:43', '2025-01-28 17:03:03', 'New patient record added', '2025-01-28 17:01:43', '2025-01-28 17:01:43', '2025-01-28 17:03:03'),
(654, 200, 'Cleven Javier', 'BLOOD', 'Admin', '2025-01-28 17:02:25', '2025-01-28 17:03:03', 'Turned over Red Cross A+ ', '2025-01-28 17:02:25', '2025-01-28 17:02:25', '2025-01-28 17:03:03'),
(655, 201, 'Mariel Palma', 'INVENTORY', 'Admin', '2025-01-28 17:09:39', '2025-01-28 17:11:19', 'Login', '2025-01-28 17:09:39', '2025-01-28 17:09:39', '2025-01-28 17:11:19'),
(656, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-01-28 17:11:29', '2025-02-05 08:30:27', 'Login', '2025-01-28 17:11:29', '2025-01-28 17:11:29', '2025-02-05 08:30:27'),
(657, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-01-28 17:12:07', '2025-02-05 08:30:27', 'Added lab test X-ray.', '2025-01-28 17:12:07', '2025-01-28 17:12:07', '2025-02-05 08:30:27'),
(658, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-01-28 17:12:37', '2025-02-05 08:30:27', 'Updated lab test Sputum.', '2025-01-28 17:12:37', '2025-01-28 17:12:37', '2025-02-05 08:30:27'),
(659, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-01-28 17:13:22', '2025-02-05 08:30:27', 'Added lab test CBC.', '2025-01-28 17:13:22', '2025-01-28 17:13:22', '2025-02-05 08:30:27'),
(660, 198, 'Ivy Pondivida', 'IT DEPARTMENT', 'Admin', '2025-02-05 06:11:07', '2025-02-05 06:13:51', 'Login', '2025-02-05 06:11:07', '2025-02-05 06:11:07', '2025-02-05 06:13:51'),
(661, 200, 'Cleven Javier', 'BLOOD', 'Admin', '2025-02-05 06:14:31', '2025-02-05 06:33:11', 'Login', '2025-02-05 06:14:31', '2025-02-05 06:14:31', '2025-02-05 06:33:11'),
(662, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-02-05 06:46:33', '2025-02-05 08:30:27', 'Deleted Jimuel Hipana appointment to Department:  - Blood Typing.', '2025-02-05 06:46:33', '2025-02-05 06:46:33', '2025-02-05 08:30:27'),
(663, 221, 'Jimuel Hipana', 'Client', 'Client', '2025-02-05 06:47:04', '2025-02-05 09:11:13', 'Jimuel Hipana added a new appointment to Department:  - CBC,Rapid Antigen Test.', '2025-02-05 06:47:04', '2025-02-05 06:47:04', '2025-02-05 09:11:13'),
(664, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-02-05 06:50:27', '2025-02-05 08:30:27', 'Added lab test Jimjim.', '2025-02-05 06:50:27', '2025-02-05 06:50:27', '2025-02-05 08:30:27'),
(665, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-02-05 06:51:53', '2025-02-05 08:30:27', 'Deleted Jimuel Hipana appointment to Department:  - CBC,Rapid Antigen Test.', '2025-02-05 06:51:53', '2025-02-05 06:51:53', '2025-02-05 08:30:27'),
(666, 221, 'Jimuel Hipana', 'Client', 'Client', '2025-02-05 06:52:09', '2025-02-05 09:11:13', 'Jimuel Hipana added a new appointment to Department:  - Blood Typing,CBC,Jimjim,Rapid Antigen Test,Urinalysis,X-ray.', '2025-02-05 06:52:09', '2025-02-05 06:52:09', '2025-02-05 09:11:13'),
(667, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-02-05 06:52:24', '2025-02-05 08:30:27', 'Approved Jimuel Hipana appointment to Department:  - Blood Typing,CBC,Jimjim,Rapid Antigen Test,Urinalysis,X-ray.', '2025-02-05 06:52:24', '2025-02-05 06:52:24', '2025-02-05 08:30:27'),
(668, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-02-05 06:52:49', '2025-02-05 08:30:27', 'Added Jimuel Hipana to patient record .', '2025-02-05 06:52:49', '2025-02-05 06:52:49', '2025-02-05 08:30:27'),
(669, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-02-05 08:30:53', '2025-02-05 08:43:14', 'Login', '2025-02-05 08:30:53', '2025-02-05 08:30:53', '2025-02-05 08:43:14'),
(670, 221, 'Jimuel Hipana', 'Client', 'Client', '2025-02-05 09:11:27', NULL, 'Login', '2025-02-05 09:11:27', '2025-02-05 09:11:27', '2025-02-05 09:11:27'),
(671, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-02-05 09:34:15', NULL, 'Login', '2025-02-05 09:34:15', '2025-02-05 09:34:15', '2025-02-05 09:34:15'),
(672, 221, 'Jimuel Hipana', 'Client', 'Client', '2025-02-05 09:35:02', NULL, 'Jimuel Hipana added a new appointment in Department:  - multiple tests.', '2025-02-05 09:35:02', '2025-02-05 09:35:02', '2025-02-05 09:35:02'),
(673, 221, 'Jimuel Hipana', 'Client', 'Client', '2025-02-05 09:37:24', NULL, 'Jimuel Hipana added a new appointment in Department:  - multiple tests.', '2025-02-05 09:37:24', '2025-02-05 09:37:24', '2025-02-05 09:37:24'),
(674, 221, 'Jimuel Hipana', 'Client', 'Client', '2025-02-05 09:41:41', NULL, 'Jimuel Hipana added a new appointment in Department:  - multiple tests.', '2025-02-05 09:41:41', '2025-02-05 09:41:41', '2025-02-05 09:41:41');
INSERT INTO `logs` (`id`, `user_id`, `name`, `department`, `position`, `time_in`, `time_out`, `activity`, `date`, `created_at`, `updated_at`) VALUES
(675, 221, 'Jimuel Hipana', 'Client', 'Client', '2025-02-05 09:45:17', NULL, 'Jimuel Hipana Added new appointment to Department:  - X-ray.', '2025-02-05 09:45:17', '2025-02-05 09:45:17', '2025-02-05 09:45:17'),
(676, 221, 'Jimuel Hipana', 'Client', 'Client', '2025-02-05 09:59:56', NULL, 'Jimuel Hipana added a new appointment in Department:  - multiple tests.', '2025-02-05 09:59:56', '2025-02-05 09:59:56', '2025-02-05 09:59:56'),
(677, 221, 'Jimuel Hipana', 'Client', 'Client', '2025-02-05 10:09:52', NULL, 'Jimuel Hipana added a new appointment in Department:  - multiple tests.', '2025-02-05 10:09:52', '2025-02-05 10:09:52', '2025-02-05 10:09:52'),
(678, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-02-05 10:10:25', NULL, 'Added lab test Siomai Test.', '2025-02-05 10:10:25', '2025-02-05 10:10:25', '2025-02-05 10:10:25'),
(679, 221, 'Jimuel Hipana', 'Client', 'Client', '2025-02-05 10:20:46', NULL, 'Jimuel Hipana added a new appointment in Department:  - multiple tests.', '2025-02-05 10:20:46', '2025-02-05 10:20:46', '2025-02-05 10:20:46'),
(680, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-02-05 10:31:43', NULL, 'Approved Jimuel Hipana appointment to Department:  - [\"Jimjim\",\"Siomai Test\"].', '2025-02-05 10:31:43', '2025-02-05 10:31:43', '2025-02-05 10:31:43'),
(681, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-02-05 10:37:07', NULL, 'Approved Jimuel Hipana appointment to Department:  - [\"Blood Typing\",\"Rapid Antigen Test\",\"X-ray\"].', '2025-02-05 10:37:07', '2025-02-05 10:37:07', '2025-02-05 10:37:07'),
(682, 221, 'Jimuel Hipana', 'Client', 'Client', '2025-02-05 10:41:30', NULL, 'Jimuel Hipana added a new appointment in Department:  - multiple tests.', '2025-02-05 10:41:30', '2025-02-05 10:41:30', '2025-02-05 10:41:30'),
(683, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-02-05 10:41:35', NULL, 'Approved Jimuel Hipana appointment to Department:  - [\"Jimjim\",\"Siomai Test\"].', '2025-02-05 10:41:35', '2025-02-05 10:41:35', '2025-02-05 10:41:35'),
(684, 203, 'Veronica Sulit', 'LABORATORY', 'Admin', '2025-02-05 10:55:29', NULL, 'Added Jimuel Hipana to patient record .', '2025-02-05 10:55:29', '2025-02-05 10:55:29', '2025-02-05 10:55:29');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `client_id` int(255) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `client_id`, `content`, `date`, `status`, `created_at`, `updated_at`) VALUES
(76, 203, 'New appointment for laboratory (Jimjim, Siomai Test) has been created.', '2025-02-05 10:41:30', 'unread', '2025-02-05 10:41:30', '2025-02-05 10:41:30'),
(77, 221, 'Your appointment for laboratory [\"Jimjim\",\"Siomai Test\"] services has been approved.', '2025-02-05 10:41:43', 'unread', '2025-02-05 10:41:43', '2025-02-05 10:41:43');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `receipt`
--

CREATE TABLE `receipt` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `receipt_no` varchar(255) DEFAULT NULL,
  `series` varchar(255) DEFAULT NULL,
  `agency` varchar(255) DEFAULT NULL,
  `payor` varchar(255) DEFAULT NULL,
  `nature` varchar(255) DEFAULT NULL,
  `account_code` varchar(255) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `teller` varchar(255) DEFAULT NULL,
  `collecting_officer` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rhu_announcement`
--

CREATE TABLE `rhu_announcement` (
  `id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `fullcontext` text DEFAULT NULL,
  `isShow` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rhu_announcement`
--

INSERT INTO `rhu_announcement` (`id`, `image`, `title`, `description`, `date`, `fullcontext`, `isShow`, `created_at`, `updated_at`) VALUES
(33, 'images/mig7PjEXEIqMwFVGzcFJNMVqZnE9qXZYiJuHHEgf.jpg', 'Project Iskol Blood Olympics 2025', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus lacinia odio vitae vestibulum vestibulum.\"', '2025-01-28 00:00:00', 'Curabitur pretium tincidunt lacus. Nulla gravida orci a odio. Nullam varius, turpis et commodo pharetra, est eros bibendum elit, nec luctus magna felis sollicitudin mauris. Integer in mauris eu nibh euismod gravida. Duis ac tellus et risus vulputate vehicula. Donec lobortis risus a elit. Etiam tempor. Ut ullamcorper, ligula eu tempor congue, eros est euismod turpis, id tincidunt sapien risus a quam.', 'Yes', '2025-01-27 02:01:01', '2025-01-27 03:16:02'),
(34, 'images/zcnYQo2ym4f9jPjYktdUXJkityR8RvRvCM4Opl0z.jpg', 'Health Education Promotion', '\"Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.\"', '2025-01-29 00:00:00', 'Suspendisse potenti. Fusce euismod convallis velit, eu auctor lacus vehicula sit amet. Nullam pharetra enim at magna cursus, vel dapibus risus vehicula. Phasellus a libero ut massa mollis feugiat vitae a arcu. Etiam auctor lacus sit amet elit gravida fringilla. Ut faucibus libero ut nulla vehicula, vitae dictum est mattis. Integer sed urna at dolor tincidunt aliquet nec quis massa.', 'Yes', '2025-01-27 02:03:20', '2025-01-27 03:12:45'),
(36, 'images/9uIJoycfMrfk5NErV3YbiQ4uUrFNLAsJx39OkhYh.jpg', 'National Children\'s Month 2025', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.\"', '2025-01-30 00:00:00', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.', 'Yes', '2025-01-27 03:04:06', '2025-01-27 03:11:18');

-- --------------------------------------------------------

--
-- Table structure for table `rhu_appointment`
--

CREATE TABLE `rhu_appointment` (
  `id` int(11) NOT NULL,
  `client_id` int(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `sub_type` varchar(255) DEFAULT NULL,
  `doctor` varchar(255) DEFAULT NULL,
  `dose_number` int(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `contactNo` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `refer` varchar(255) DEFAULT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `result` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rhu_appointment`
--

INSERT INTO `rhu_appointment` (`id`, `client_id`, `name`, `type`, `sub_type`, `doctor`, `dose_number`, `date`, `status`, `contactNo`, `email`, `refer`, `reason`, `price`, `result`, `created_at`, `updated_at`) VALUES
(103, 221, 'Jimuel Hipana', 'laboratory', '[\"Jimjim\",\"Siomai Test\"]', NULL, NULL, '2025-02-06 14:30:00', 'Completed', '09772916582', 'jhepana12@gmail.com', NULL, NULL, NULL, 'test_results/dlrkvnFJydM1Dgsk7wHAzIvHAxP1ftwdVvSZxjDE.pdf', '2025-02-05 10:41:30', '2025-02-05 10:55:29');

-- --------------------------------------------------------

--
-- Table structure for table `rhu_blood_type`
--

CREATE TABLE `rhu_blood_type` (
  `id` int(11) NOT NULL,
  `blood_type` varchar(255) DEFAULT NULL,
  `total` bigint(255) DEFAULT 0,
  `current` bigint(255) DEFAULT 0,
  `turned_over` bigint(20) NOT NULL DEFAULT 0,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rhu_blood_type`
--

INSERT INTO `rhu_blood_type` (`id`, `blood_type`, `total`, `current`, `turned_over`, `updated_at`, `created_at`) VALUES
(10, 'B-', 500, 500, 0, '2025-01-28 17:01:30', '2025-01-28 17:01:30'),
(11, 'A+', 500, 400, 100, '2025-01-28 17:02:25', '2025-01-28 17:01:43');

-- --------------------------------------------------------

--
-- Table structure for table `rhu_client`
--

CREATE TABLE `rhu_client` (
  `id` int(11) NOT NULL,
  `client_id` int(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `sub_type` varchar(255) DEFAULT NULL,
  `doctor` varchar(255) DEFAULT NULL,
  `dose_number` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `result` varchar(255) DEFAULT NULL,
  `volume` varchar(255) DEFAULT NULL,
  `analysis` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rhu_client`
--

INSERT INTO `rhu_client` (`id`, `client_id`, `name`, `type`, `sub_type`, `doctor`, `dose_number`, `date`, `result`, `volume`, `analysis`, `status`, `created_at`, `updated_at`) VALUES
(31, NULL, 'Jimuel Hipana', 'laboratory', '[\"Jimjim\",\"Siomai Test\"]', NULL, NULL, '2025-02-05 10:55:29', 'test_results/dlrkvnFJydM1Dgsk7wHAzIvHAxP1ftwdVvSZxjDE.pdf', NULL, NULL, 'Completed', '2025-02-05 10:55:29', '2025-02-05 10:55:29');

-- --------------------------------------------------------

--
-- Table structure for table `rhu_medical_history`
--

CREATE TABLE `rhu_medical_history` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `well_health` varchar(255) DEFAULT NULL,
  `antibiotics` varchar(255) DEFAULT NULL,
  `infection_medication` varchar(255) DEFAULT NULL,
  `medication_deferral` varchar(255) DEFAULT NULL,
  `aspirin` varchar(255) DEFAULT NULL,
  `vaccinations` varchar(255) DEFAULT NULL,
  `pregnant` varchar(255) DEFAULT NULL,
  `donated_recently` varchar(255) DEFAULT NULL,
  `apheresis` varchar(255) DEFAULT NULL,
  `blood_transfusion` varchar(255) DEFAULT NULL,
  `transplant` varchar(255) DEFAULT NULL,
  `graft` varchar(255) DEFAULT NULL,
  `contact_blood` varchar(255) DEFAULT NULL,
  `needlestick_injury` varchar(255) DEFAULT NULL,
  `sexual_contact_hiv` varchar(255) DEFAULT NULL,
  `prostitute_contact` varchar(255) DEFAULT NULL,
  `drug_use_contact` varchar(255) DEFAULT NULL,
  `hemophilia_contact` varchar(255) DEFAULT NULL,
  `male_contact_with_male` varchar(255) DEFAULT NULL,
  `saliva_contact_hepatitis` varchar(255) DEFAULT NULL,
  `contact_blood_hepatitis` varchar(255) DEFAULT NULL,
  `sexual_contact_hepatitis` varchar(255) DEFAULT NULL,
  `tattoo` varchar(255) DEFAULT NULL,
  `piercing` varchar(255) DEFAULT NULL,
  `acupuncture` varchar(255) DEFAULT NULL,
  `syphilis_gonorrhea` varchar(255) DEFAULT NULL,
  `juvenile_detention` varchar(255) DEFAULT NULL,
  `hiv_aids_positive` varchar(255) DEFAULT NULL,
  `used_needles` varchar(255) DEFAULT NULL,
  `clotting_factor` varchar(255) DEFAULT NULL,
  `hepatitis` varchar(255) DEFAULT NULL,
  `malaria` varchar(255) DEFAULT NULL,
  `chagas` varchar(255) DEFAULT NULL,
  `babesiosis` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rhu_medical_history`
--

INSERT INTO `rhu_medical_history` (`id`, `client_id`, `well_health`, `antibiotics`, `infection_medication`, `medication_deferral`, `aspirin`, `vaccinations`, `pregnant`, `donated_recently`, `apheresis`, `blood_transfusion`, `transplant`, `graft`, `contact_blood`, `needlestick_injury`, `sexual_contact_hiv`, `prostitute_contact`, `drug_use_contact`, `hemophilia_contact`, `male_contact_with_male`, `saliva_contact_hepatitis`, `contact_blood_hepatitis`, `sexual_contact_hepatitis`, `tattoo`, `piercing`, `acupuncture`, `syphilis_gonorrhea`, `juvenile_detention`, `hiv_aids_positive`, `used_needles`, `clotting_factor`, `hepatitis`, `malaria`, `chagas`, `babesiosis`, `created_at`, `updated_at`) VALUES
(4, 207, 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', '2025-01-27 12:01:13', '2025-01-27 12:01:13'),
(5, 214, 'yes', 'yes', 'no', 'no', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 'no', 'yes', 'no', 'yes', 'no', 'yes', 'no', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'no', 'no', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', '2025-01-27 14:15:44', '2025-01-28 06:24:23'),
(6, 217, 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', '2025-01-27 16:40:50', '2025-01-27 16:40:50');

-- --------------------------------------------------------

--
-- Table structure for table `rhu_medicine`
--

CREATE TABLE `rhu_medicine` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `total` int(255) DEFAULT NULL,
  `current` int(255) DEFAULT NULL,
  `turned_over` int(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rhu_medicine`
--

INSERT INTO `rhu_medicine` (`id`, `name`, `total`, `current`, `turned_over`, `created_at`, `updated_at`) VALUES
(16, 'Paracetamol', 1200, 1100, 100, '2025-01-28 08:16:27', '2025-01-28 16:57:26'),
(17, 'Amoxicillin Syrup', 450, 450, NULL, '2025-01-28 08:17:35', '2025-01-28 08:17:35'),
(18, 'Ibuprofen', 300, 300, NULL, '2025-01-28 08:18:48', '2025-01-28 08:18:48'),
(19, 'Aspirin', 500, 500, NULL, '2025-01-28 08:19:55', '2025-01-28 08:19:55'),
(20, 'Omeprazole', 600, 600, NULL, '2025-01-28 08:27:57', '2025-01-28 08:27:57'),
(21, 'Cetirizine Syrup', 400, 400, NULL, '2025-01-28 08:28:47', '2025-01-28 08:28:47');

-- --------------------------------------------------------

--
-- Table structure for table `rhu_supplies`
--

CREATE TABLE `rhu_supplies` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `batchNo` varchar(255) DEFAULT NULL,
  `dosage_f` varchar(255) DEFAULT NULL,
  `dosage_s` varchar(255) DEFAULT NULL,
  `expiration_date` datetime DEFAULT NULL,
  `location_code` varchar(255) DEFAULT NULL,
  `quantity` varchar(255) DEFAULT NULL,
  `expiration` datetime DEFAULT NULL,
  `end_user` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rhu_supplies`
--

INSERT INTO `rhu_supplies` (`id`, `name`, `type`, `batchNo`, `dosage_f`, `dosage_s`, `expiration_date`, `location_code`, `quantity`, `expiration`, `end_user`, `created_at`, `updated_at`) VALUES
(53, 'Anti-Rabies Vaccine', 'Vaccines', NULL, NULL, NULL, '2027-06-24 00:00:00', '32/3rd', '500', NULL, NULL, '2025-01-27 11:54:26', '2025-01-27 11:54:26'),
(55, 'saewq', 'Medical Supplies', 'dasqwe', NULL, NULL, NULL, 'qw312qw', '100', NULL, NULL, '2025-01-28 05:49:13', '2025-01-28 05:49:13'),
(58, 'Paracetamol', 'Medicines', NULL, 'Tablet', '500mg', '2026-07-15 00:00:00', 'A1-B3', '1100', NULL, 'General Use', '2025-01-28 08:16:27', '2025-01-28 16:57:26'),
(59, 'Amoxicillin Syrup', 'Medicines', NULL, 'Syrup', '5ml', '2025-12-20 00:00:00', 'B2-C5', '450', NULL, 'Pediatric', '2025-01-28 08:17:35', '2025-01-28 08:17:35'),
(60, 'Ibuprofen', 'Medicines', NULL, 'Capsule', '250mg', '2027-03-30 00:00:00', 'C3-D1', '300', NULL, 'Sports Use', '2025-01-28 08:18:48', '2025-01-28 08:18:48'),
(61, 'Aspirin', 'Medicines', NULL, 'Tablet', '100mg', '2026-01-04 00:00:00', 'A3-B1', '500', NULL, 'General Use', '2025-01-28 08:19:55', '2025-01-28 08:19:55'),
(62, 'Omeprazole', 'Medicines', NULL, 'Capsule', '100mg', '2027-10-05 00:00:00', 'A1-C1', '600', NULL, 'Gastroenterology', '2025-01-28 08:27:57', '2025-01-28 08:27:57'),
(63, 'Cetirizine Syrup', 'Medicines', NULL, 'Syrup', '5ml', '2026-09-25 00:00:00', 'B2-D4', '400', NULL, 'Pediatric/Allergy', '2025-01-28 08:28:47', '2025-01-28 08:28:47'),
(64, 'Surgical Gloves', 'Medical Supplies', 'BATCH202501A', NULL, NULL, NULL, 'A1-B3', '1200', NULL, NULL, '2025-01-28 08:29:48', '2025-01-28 08:29:48'),
(65, 'Face Masks', 'Medical Supplies', 'LOT20250112', NULL, NULL, NULL, 'C2-D4', '5000', NULL, NULL, '2025-01-28 08:30:04', '2025-01-28 08:30:04'),
(66, 'Disposable Syringes', 'Medical Supplies', 'LOTSYRINGE2301', NULL, NULL, NULL, 'A2-B4', '1500', NULL, NULL, '2025-01-28 08:30:28', '2025-01-28 08:30:28'),
(67, 'Sterile Gauze', 'Medical Supplies', 'GAUZE20250108', NULL, NULL, NULL, 'C4-E3', '1000', NULL, NULL, '2025-01-28 08:30:51', '2025-01-28 08:30:51'),
(68, 'Suction Catheters', 'Medical Supplies', 'SUCTION20240125', NULL, NULL, NULL, 'C1-D1', '500', NULL, NULL, '2025-01-28 08:31:17', '2025-01-28 08:31:17'),
(69, 'Digital Blood Pressure Monitor', 'Medical Equipments', 'BP202501A', NULL, NULL, NULL, 'A1-C3', '25', NULL, NULL, '2025-01-28 08:32:12', '2025-01-28 08:32:12'),
(70, 'Defibrillator', 'Medical Equipments', 'DEFIB2023-05', NULL, NULL, NULL, 'A4-B5', '5', NULL, NULL, '2025-01-28 08:32:45', '2025-01-28 08:32:45'),
(71, 'Nebulizer', 'Medical Equipments', 'NEBU20240125', NULL, NULL, NULL, 'A1-D4', '40', NULL, NULL, '2025-01-28 08:33:20', '2025-01-28 08:33:20'),
(72, 'COVID-19 Vaccine (Pfizer)', 'Vaccines', NULL, NULL, NULL, '2025-09-16 00:00:00', 'A1-B2', '1200', NULL, NULL, '2025-01-28 08:35:04', '2025-01-28 08:35:04'),
(73, 'MMR Vaccine', 'Vaccines', NULL, NULL, NULL, '2026-03-18 00:00:00', 'E3-F2', '700', NULL, NULL, '2025-01-28 08:35:44', '2025-01-28 08:35:44');

-- --------------------------------------------------------

--
-- Table structure for table `rhu_test`
--

CREATE TABLE `rhu_test` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `price` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rhu_test`
--

INSERT INTO `rhu_test` (`id`, `name`, `price`, `status`, `created_at`, `updated_at`) VALUES
(6, 'Urinalysis', '50', 'Available', '2025-01-27 09:10:59', '2025-01-27 09:10:59'),
(7, 'Rapid Antigen Test', '350', 'Available', '2025-01-27 09:11:17', '2025-01-28 03:20:31'),
(8, 'Blood Typing', '40', 'Available', '2025-01-27 09:14:50', '2025-01-28 03:20:35'),
(9, 'Sputum', '50', 'Unavailable', '2025-01-27 16:36:07', '2025-01-28 17:12:37'),
(10, 'X-ray', '180', 'Available', '2025-01-28 17:12:07', '2025-01-28 17:12:07'),
(11, 'CBC', '60', 'Available', '2025-01-28 17:13:22', '2025-01-28 17:13:22'),
(12, 'Jimjim', '500', 'Available', '2025-02-05 06:50:27', '2025-02-05 06:50:27'),
(13, 'Siomai Test', '100', 'Available', '2025-02-05 10:10:25', '2025-02-05 10:10:25');

-- --------------------------------------------------------

--
-- Table structure for table `rhu_turned_over`
--

CREATE TABLE `rhu_turned_over` (
  `id` int(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `blood_type` varchar(255) DEFAULT NULL,
  `volume` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rhu_turned_over`
--

INSERT INTO `rhu_turned_over` (`id`, `name`, `blood_type`, `volume`, `date`, `created_at`, `updated_at`) VALUES
(6, 'Red Cross', 'A+', '100', '2025-01-28 00:00:00', '2025-01-28 17:02:25', '2025-01-28 17:02:25');

-- --------------------------------------------------------

--
-- Table structure for table `rhu_user`
--

CREATE TABLE `rhu_user` (
  `id` int(255) NOT NULL,
  `f_name` varchar(255) DEFAULT NULL,
  `m_name` varchar(255) DEFAULT NULL,
  `l_name` varchar(255) DEFAULT NULL,
  `suffix` varchar(255) DEFAULT NULL,
  `bday` datetime DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `contactNo` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `brgy` varchar(255) DEFAULT NULL,
  `zip_code` varchar(255) DEFAULT NULL,
  `municipality` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `upload_id` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rhu_user`
--

INSERT INTO `rhu_user` (`id`, `f_name`, `m_name`, `l_name`, `suffix`, `bday`, `gender`, `contactNo`, `street`, `brgy`, `zip_code`, `municipality`, `province`, `address`, `upload_id`, `username`, `email`, `password`, `department`, `status`, `role`, `profile_picture`, `created_at`, `updated_at`) VALUES
(198, 'Ivy', 'S', 'Pondivida', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin_it', 'ivy123@gmail.com', '$2y$12$yltfalQ/OzD60gSQOM8yRe4.zoE5H..IeoxHQsfmeJHroxs0q.Hou', 'IT DEPARTMENT', 'Active', 'Admin', 'profile_pictures/3J4JXnRBUh3dt0fYBZV3Np84bttl4OS0qZk2yzYd.png', '2025-01-27 05:08:22', '2025-01-28 05:54:41'),
(199, 'Luis', 'S', 'Mallari', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin_super', 'rhu24@gmail.com', '$2y$12$tGqCf/hyIZFSEss7T3cIYuxpVDNGu5xGVviV1xVlWa.igYuIqtupm', 'SUPER ADMIN', 'Active', 'Admin', NULL, '2025-01-27 05:10:01', '2025-01-27 05:10:01'),
(200, 'Cleven', 'R', 'Javier', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin_blood', 'blood@gmail.com', '$2y$12$ODJWRpiZpqiPfX5CjwnO/.yV0BpuBbEkCESt.bDv6ZVubK3bbrZ6u', 'BLOOD', 'Active', 'Admin', NULL, '2025-01-27 05:13:17', '2025-01-27 05:13:17'),
(201, 'Mariel', 'M', 'Palma', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin_inventory', 'inventory@gmail.com', '$2y$12$gGSxf3Zk8Bq21xoZqxhA7OXbEYQMa.BiBq2bVZ75xk.CjVr2f7xBK', 'INVENTORY', 'Active', 'Admin', NULL, '2025-01-27 05:14:18', '2025-01-27 05:14:18'),
(202, 'Catherine', 'A', 'Estrella', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin_consultation', 'consultation@gmail.com', '$2y$12$MQVWqinVVTwxkTpMM3Wxw.gEUfifk/6AF16FZr6mMEm87abmkyTUi', 'CONSULTATION', 'Active', 'Admin', NULL, '2025-01-27 05:14:53', '2025-01-27 05:14:53'),
(203, 'Veronica', 'B', 'Sulit', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'LABORATORY', 'laboratory@gmail.com', '$2y$12$EAA1rHvLKM.309QM0EKhgOaX0JXr76bCr46wvpTlc/49AFQvTQlVy', 'LABORATORY', 'Active', 'Admin', 'profile_pictures/uMxRXB1Vky96hQgwMOvomS8LUSXoA0uWxTjgemIU.jpg', '2025-01-27 05:15:33', '2025-01-30 08:31:22'),
(204, 'Anne Nicole', 'C', 'Diaz', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin_vaccination', 'vaccination@gmail.com', '$2y$12$M8uy44J9FX4qJzTtv0Ysauwh/Lx/qHx/AoJC6RFA9tn3oTV9NnJF6', 'VACCINATION', 'Active', 'Admin', NULL, '2025-01-27 05:16:10', '2025-01-27 05:16:10'),
(207, 'Steph', 'P', 'Ariola', NULL, '2009-07-31 00:00:00', 'Male', '09272401139', '20 Marcos Tigla St.', 'Barangay 5', '4328', 'Lucban', 'Quezon', NULL, 'uploads/caCnqsnGersyFoPXmFDCTwZMikOw1ImWkY04fuXu.png', 'steph123', 'ivypondivida22@gmail.com', '$2y$12$TPWf.ftv/6TR/C4n8G4Im.3XtMpGYV3YyS66FkxYxdZV7iirfOuy2', 'Client', 'Approved', 'Client', 'profile_pictures/1llgdI1c9g4CQuxma4vkBUPljik9PqBEjjbXvRT1.jpg', '2025-01-27 10:56:52', '2025-01-27 11:05:36'),
(208, 'Andrei', 'R', 'Raneses', NULL, '2002-12-26 00:00:00', 'male', '09363423105', 'Claro cabungcal st.', 'Barangay 5', '4328', 'Lucban', 'Quezon', NULL, 'uploads/lQ62r6TGo1ai0zDKOyISws8xFC64iwBZiclLvIZt.png', 'andrei123', 'andreira882@gmail.com', '$2y$12$0T0bG9u21kAbKcQ.4btQw.CLJJA6ZXmp7q4YbS8dAqVtD8C1ERAwS', 'Client', 'Approved', 'Client', NULL, '2025-01-27 12:23:30', '2025-01-27 12:34:45'),
(214, 'Veronica', 'A', 'Sulit', NULL, '2002-01-10 00:00:00', 'Female', '09304844874', '120 Marcos Tigla St.', 'Barangay 3', '4328', 'Lucban', 'Quezon', NULL, 'uploads/9ov6PNe9HbVqeX0Um8WxKRT1GaBwQn1TwmGZIM9d.png', 'jhepana13', 'jhepana13@gmail.com', '$2y$12$4cETnqJLs6X2TYrD7eeogOJrABCTWiC6KZqcVmrLt8q8e39iSh4oq', 'Client', 'Approved', 'Client', 'profile_pictures/XV0veoGxlCNJ2Nj6ra8UKKAzHnshhbFFsxZiXFG1.png', '2025-01-27 13:17:18', '2025-01-28 04:09:03'),
(216, 'Jimuel', 'V', 'Hipana', NULL, '2003-04-13 00:00:00', 'male', '09772916582', '120 Don V Cadelina St.', 'Barangay 5', '4328', 'Lucban', 'Quezon', NULL, 'uploads/U4dyTiMNf5Lzo2AWVgGpfDKcJiALU7Wje7SFhbQS.png', 'jhepana10', 'jhepana10@gmail.com', '$2y$12$VZZ.AkifdX23LnOEAUJvl.JpYWcNXJ15UbAwMEe3wnpvfC8Fp6W9O', 'Client', 'Approved', 'Client', NULL, '2025-01-27 13:53:23', '2025-01-28 07:01:57'),
(217, 'Angela', 'P', 'Madrid', NULL, '2002-08-29 00:00:00', 'Female', '09272401139', '120 Don V Cadelina St.', 'Barangay 3', '4328', 'Lucban', 'Quezon', NULL, 'uploads/an71BOPOpZaPpA05vPtZQXxBh5FRX4wH8npcKTHG.jpg', 'angela29', 'angela29.madrid@gmail.com', '$2y$12$Z7M56jGranQwe1.bok6k6uqT3OyHlWELVbgSQjlvEhi.0CYDjeDXC', 'Client', 'Approved', 'Client', 'profile_pictures/zCRC921AyriLlVKYfQftDcgsLTaLEdaAtIF7TUIs.jpg', '2025-01-27 16:28:45', '2025-01-28 15:54:55'),
(219, 'Ange', 'P', 'Madrid', NULL, '2002-08-29 00:00:00', 'female', '09765921002', 'Sitio Burol', 'Barangay 5', '4328', 'Lucban', 'Quezon', NULL, 'uploads/w2FYIxgrPMcjw9ZEC4KwBYOaCy34Hr7WcKzpEEWB.png', 'angeee123', 'angelamadrid082902@gmail.com', '$2y$12$.uA3ANN3sjzFj1eBpLF3E.dkqseDVuNrysLD8J2kTV1n7stov15ba', 'Client', 'Pending', 'Client', NULL, '2025-01-28 15:20:34', '2025-01-28 15:24:31'),
(220, 'Clarise', 'A', 'Pondivida', NULL, '2002-11-11 00:00:00', 'female', '09272401139', '20 Marcos Tigla St.', 'Barangay 5', '4328', 'Lucban', 'Quezon', NULL, 'uploads/KG1undxceNBI1QuxxkJYtRPyTKpbDmBfp2SqgwKo.jpg', 'Clarise123', 'ipondivida2021@gmail.com', '$2y$12$mQHMvOcyMTh4tV/xuIIf5O0KmorxTmnnlArDRkktgzqU/gjUYQmzu', 'Client', 'Pending', 'Client', NULL, '2025-01-28 15:29:11', '2025-01-28 15:29:11'),
(221, 'Jimuel', 'V', 'Hipana', NULL, '2003-04-13 00:00:00', 'male', '09772916582', '120 Marcos Tigla St.', 'Barangay 5', '4328', 'Lucban', 'Quezon', NULL, 'uploads/ELt3APyBYZeu3VaY3VIYXcNRu4EJj8LLH3yFJm6Q.jpg', 'jhepana12', 'jhepana12@gmail.com', '$2y$12$ght3OOeVYYSPZx45y2rx6OqUUHOPIlbEpCDaCjP.LHQtR/kl.RcSK', 'Client', 'Approved', 'Client', NULL, '2025-01-28 16:39:13', '2025-02-05 06:12:48');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('e8ZDP7k9DveTaGG75GxMtDToDxagPWXgYXJxaCSH', 221, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiU3dMYnZhakNKVnc2ZDE2SktoSmNIY2xRUEVpMlpUNDc1aURHRnVGcyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTU6Imh0dHA6Ly9yaHUudGVzdCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjIyMTtzOjE3OiJjdXJyZW50RGVwYXJ0bWVudCI7czo2OiJDbGllbnQiO3M6MTE6ImN1cnJlbnRSb2xlIjtzOjY6IkNsaWVudCI7fQ==', 1738724147),
('vjHnZbkuUDNMOpB0iDGUimDn8GyoV7TLff25VjqT', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYXFkTTlQV1hnM0xmOWlmYktXcVFobXV1N0k3Z2tsNTk5b1ZwOVpNQSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTU6Imh0dHA6Ly9yaHUudGVzdCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1739419627),
('vxUfLk8LUuDo0o6AbdxaVXwWtxqf1lK74IWyM3r3', 203, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiNDVWUE1nQlJDQ2ZiTENYdjNWZTc5aEphY2ZmY3hya1JkV1lscGZ4VyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly9yaHUudGVzdC9kaXNwbGF5LWxhYl9hcHBvaW50bWVudHMiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyMDM7czoxNzoiY3VycmVudERlcGFydG1lbnQiO3M6MTA6IkxBQk9SQVRPUlkiO3M6MTE6ImN1cnJlbnRSb2xlIjtzOjU6IkFkbWluIjt9', 1738730255);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Jimuel Hipana', 'jhepana13@gmail.com', NULL, '$2y$12$zUW8AFrfpjHvh9ns12GEBef2fvsta74T3QnnrblZgfS3JL1zDZf2y', NULL, '2025-01-11 06:08:07', '2025-01-11 06:08:07');

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
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `receipt`
--
ALTER TABLE `receipt`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rhu_announcement`
--
ALTER TABLE `rhu_announcement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rhu_appointment`
--
ALTER TABLE `rhu_appointment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rhu_blood_type`
--
ALTER TABLE `rhu_blood_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rhu_client`
--
ALTER TABLE `rhu_client`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rhu_medical_history`
--
ALTER TABLE `rhu_medical_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rhu_medicine`
--
ALTER TABLE `rhu_medicine`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rhu_supplies`
--
ALTER TABLE `rhu_supplies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rhu_test`
--
ALTER TABLE `rhu_test`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rhu_turned_over`
--
ALTER TABLE `rhu_turned_over`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rhu_user`
--
ALTER TABLE `rhu_user`
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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=685;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `receipt`
--
ALTER TABLE `receipt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rhu_announcement`
--
ALTER TABLE `rhu_announcement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `rhu_appointment`
--
ALTER TABLE `rhu_appointment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `rhu_blood_type`
--
ALTER TABLE `rhu_blood_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `rhu_client`
--
ALTER TABLE `rhu_client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `rhu_medical_history`
--
ALTER TABLE `rhu_medical_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `rhu_medicine`
--
ALTER TABLE `rhu_medicine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `rhu_supplies`
--
ALTER TABLE `rhu_supplies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `rhu_test`
--
ALTER TABLE `rhu_test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `rhu_turned_over`
--
ALTER TABLE `rhu_turned_over`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `rhu_user`
--
ALTER TABLE `rhu_user`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=222;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
