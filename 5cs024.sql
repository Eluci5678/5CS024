-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 09, 2026 at 10:47 PM
-- Server version: 8.0.45-0ubuntu0.24.04.1
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `5cs024`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance_records`
--

CREATE TABLE `attendance_records` (
  `attendance_id` int NOT NULL,
  `user_id` int NOT NULL,
  `source_type` varchar(50) NOT NULL,
  `source_id` int NOT NULL,
  `week` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `attendance_status` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `attendance_records`
--

INSERT INTO `attendance_records` (`attendance_id`, `user_id`, `source_type`, `source_id`, `week`, `attendance_status`) VALUES
(708, 28, 'lesson', 1, '2026-01-01 09:00:00', 1),
(709, 29, 'lesson', 1, '2026-01-01 09:00:00', 1),
(710, 30, 'lesson', 1, '2026-01-01 09:00:00', 1),
(711, 31, 'lesson', 1, '2026-01-01 09:00:00', 0),
(712, 32, 'lesson', 1, '2026-01-01 09:00:00', 0),
(713, 33, 'lesson', 1, '2026-01-01 09:00:00', 0),
(714, 28, 'lesson', 1, '2026-01-01 10:00:00', 0),
(715, 29, 'lesson', 1, '2026-01-01 10:00:00', 1),
(716, 30, 'lesson', 1, '2026-01-01 10:00:00', 1),
(717, 31, 'lesson', 1, '2026-01-01 10:00:00', 1),
(718, 32, 'lesson', 1, '2026-01-01 10:00:00', 0),
(719, 33, 'lesson', 1, '2026-01-01 10:00:00', 0),
(720, 28, 'lesson', 1, '2026-01-02 09:00:00', 1),
(721, 29, 'lesson', 1, '2026-01-02 09:00:00', 0),
(722, 30, 'lesson', 1, '2026-01-02 09:00:00', 0),
(723, 31, 'lesson', 1, '2026-01-02 09:00:00', 1),
(724, 32, 'lesson', 1, '2026-01-02 09:00:00', 1),
(725, 33, 'lesson', 1, '2026-01-02 09:00:00', 0),
(726, 28, 'lesson', 1, '2026-01-02 10:00:00', 0),
(727, 29, 'lesson', 1, '2026-01-02 10:00:00', 0),
(728, 30, 'lesson', 1, '2026-01-02 10:00:00', 1),
(729, 31, 'lesson', 1, '2026-01-02 10:00:00', 1),
(730, 32, 'lesson', 1, '2026-01-02 10:00:00', 0),
(731, 33, 'lesson', 1, '2026-01-02 10:00:00', 1),
(732, 28, 'lesson', 1, '2026-01-03 09:00:00', 0),
(733, 29, 'lesson', 1, '2026-01-03 09:00:00', 0),
(734, 30, 'lesson', 1, '2026-01-03 09:00:00', 1),
(735, 31, 'lesson', 1, '2026-01-03 09:00:00', 0),
(736, 32, 'lesson', 1, '2026-01-03 09:00:00', 0),
(737, 33, 'lesson', 1, '2026-01-03 09:00:00', 1),
(738, 28, 'lesson', 1, '2026-01-01 10:00:00', 1),
(739, 29, 'lesson', 1, '2026-01-01 10:00:00', 0),
(740, 30, 'lesson', 1, '2026-01-01 10:00:00', 0),
(741, 31, 'lesson', 1, '2026-01-01 10:00:00', 1),
(742, 32, 'lesson', 1, '2026-01-01 10:00:00', 1),
(743, 33, 'lesson', 1, '2026-01-01 10:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `buildings`
--

CREATE TABLE `buildings` (
  `building_id` int NOT NULL,
  `building_initials` varchar(10) NOT NULL,
  `building_name` varchar(50) NOT NULL,
  `campus_location` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `buildings`
--

INSERT INTO `buildings` (`building_id`, `building_initials`, `building_name`, `campus_location`) VALUES
(1, 'MI', 'Alan Turing Building', 1),
(2, 'MC', 'Millennium City Building', 1),
(3, 'MD', 'Harrison Learning Centre', 1),
(6, 'MX', 'Housman Building', 1),
(7, 'MA', 'Wulfruna Building', 1),
(9, 'MB', 'Rosalind Franklin Building', 1);

-- --------------------------------------------------------

--
-- Table structure for table `campus_opening_times`
--

CREATE TABLE `campus_opening_times` (
  `id` bigint UNSIGNED NOT NULL,
  `campus_name` varchar(80) NOT NULL,
  `day_of_week` varchar(10) NOT NULL,
  `opens_at` time NOT NULL,
  `closes_at` time NOT NULL,
  `note` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `campus_opening_times`
--

INSERT INTO `campus_opening_times` (`id`, `campus_name`, `day_of_week`, `opens_at`, `closes_at`, `note`) VALUES
(1, 'City Campus', 'Monday', '06:30:00', '22:00:00', 'Opening hours can change around bank holidays.'),
(2, 'City Campus', 'Tuesday', '06:30:00', '22:00:00', 'Opening hours can change around bank holidays.'),
(3, 'City Campus', 'Wednesday', '06:30:00', '22:00:00', 'Opening hours can change around bank holidays.'),
(4, 'City Campus', 'Thursday', '06:30:00', '22:00:00', 'Opening hours can change around bank holidays.'),
(5, 'City Campus', 'Friday', '06:30:00', '22:00:00', 'Opening hours can change around bank holidays.'),
(6, 'City Campus', 'Saturday', '08:00:00', '18:00:00', 'Opening hours can change around bank holidays.'),
(7, 'City Campus', 'Sunday', '08:00:00', '18:00:00', 'Opening hours can change around bank holidays.');

-- --------------------------------------------------------

--
-- Table structure for table `clubs`
--

CREATE TABLE `clubs` (
  `club_id` int NOT NULL,
  `club_name` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `club_creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `start_time` time DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `availability` tinyint UNSIGNED NOT NULL COMMENT '1=Mon, 2=Tue, 4=Wed, 8=Thu, 16=Fri, 32=Sat, 64=Sun'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `clubs`
--

INSERT INTO `clubs` (`club_id`, `club_name`, `description`, `club_creation_date`, `start_time`, `end_time`, `availability`) VALUES
(1, 'Computer Science Society', 'A club for students interested in coding, AI, and tech careers.', '2026-02-02 14:38:57', NULL, NULL, 0),
(2, 'Football Club', 'University football training and competitive matches.', '2026-02-02 14:38:57', NULL, NULL, 0),
(3, 'Entrepreneurship Club', 'Helping students build startups and side hustles.', '2026-02-02 14:38:57', NULL, NULL, 0),
(10, 'Anime Club', 'Club for anime', '2026-03-16 14:05:12', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int NOT NULL,
  `course_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_name`) VALUES
(1, 'BSc (Hons) Accounting and Finance'),
(2, 'BSc (Hons) Biomedical Science'),
(3, 'Computer Science and Cyber Security'),
(4, 'BA (Hons) Digital Marketing Management with Foundation Year'),
(5, 'BA (Hons) Early Childhood Studies'),
(6, 'BA (Hons) Film Production'),
(7, 'BA (Hons) Game Design with Foundation Year'),
(8, 'BSc (Hons) Healthcare Science (Cardiac Physiology)'),
(9, 'BA (Hons) Illustration'),
(10, 'BA (Hons) Journalism with Foundation Year');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int NOT NULL,
  `title` varchar(50) NOT NULL,
  `events_description` text NOT NULL,
  `event_type` varchar(50) NOT NULL,
  `associated_club` int NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `created_by` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exercise_classes`
--

CREATE TABLE `exercise_classes` (
  `id` bigint UNSIGNED NOT NULL,
  `class_date` date DEFAULT NULL,
  `day_of_week` varchar(10) NOT NULL,
  `class_name` varchar(120) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `campus_name` varchar(80) NOT NULL,
  `location` varchar(160) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `exercise_classes`
--

INSERT INTO `exercise_classes` (`id`, `class_date`, `day_of_week`, `class_name`, `start_time`, `end_time`, `campus_name`, `location`) VALUES
(1, '2024-09-17', 'Tuesday', 'WLV HIIT', '07:00:00', '07:45:00', 'Walsall Campus', 'Sports Centre, Walsall Campus'),
(2, '2024-09-17', 'Tuesday', 'Functional Fit', '09:30:00', '10:15:00', 'Walsall Campus', 'Sports Centre, Walsall Campus'),
(3, '2024-09-17', 'Tuesday', 'Flex & Stretch', '12:15:00', '12:55:00', 'Walsall Campus', 'Sports Centre, Walsall Campus'),
(4, '2024-09-17', 'Tuesday', 'Pilates', '13:00:00', '13:55:00', 'Walsall Campus', 'Sports Centre, Walsall Campus'),
(5, '2024-09-17', 'Tuesday', 'Total Body Fitness', '18:00:00', '18:55:00', 'Walsall Campus', 'Sports Centre, Walsall Campus'),
(6, '2024-09-19', 'Thursday', 'Abs Blast', '07:00:00', '07:45:00', 'Walsall Campus', 'Sports Centre, Walsall Campus'),
(7, '2024-09-19', 'Thursday', 'Body Conditioning', '09:30:00', '10:30:00', 'Walsall Campus', 'Sports Centre, Walsall Campus'),
(8, '2024-09-19', 'Thursday', 'Functional Fit', '12:15:00', '12:45:00', 'Walsall Campus', 'Sports Centre, Walsall Campus'),
(9, '2024-09-19', 'Thursday', 'Yoga', '17:15:00', '18:10:00', 'Walsall Campus', 'Sports Centre, Walsall Campus'),
(20, '2026-04-24', 'Friday', 'WLV HIIT', '07:00:00', '07:45:00', 'Walsall Campus', 'Sports Centre, Walsall CampusSports Centre, Walsall Campus');

-- --------------------------------------------------------

--
-- Table structure for table `gym_opening_times`
--

CREATE TABLE `gym_opening_times` (
  `id` bigint UNSIGNED NOT NULL,
  `campus_name` varchar(80) NOT NULL,
  `day_of_week` varchar(10) NOT NULL,
  `opens_at` time NOT NULL,
  `closes_at` time NOT NULL,
  `note` text,
  `source_ref` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `gym_opening_times`
--

INSERT INTO `gym_opening_times` (`id`, `campus_name`, `day_of_week`, `opens_at`, `closes_at`, `note`, `source_ref`) VALUES
(5, 'Walsall Campus', 'Monday', '06:30:00', '22:00:00', 'Opening hours can change around bank holidays', ''),
(6, 'Walsall Campus', 'Tuesday', '06:30:00', '22:00:00', 'Opening hours can change around bank holidays', ''),
(7, 'Walsall Campus', 'Wednesday', '06:30:00', '22:00:00', 'Opening hours can change around bank holidays', ''),
(8, 'Walsall Campus', 'Thursday', '06:30:00', '22:00:00', 'Opening hours can change around bank holidays', ''),
(9, 'Walsall Campus', 'Friday', '06:30:00', '22:00:00', 'Opening hours can change around bank holidays', ''),
(10, 'Walsall Campus', 'Saturday', '08:00:00', '18:00:00', 'Opening hours can change around bank holidays', ''),
(12, 'Walsall Campus', 'Sunday', '08:00:00', '18:00:00', 'Opening hours can change around bank holidaysOpening hours can change around bank holidays', '');

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` int NOT NULL,
  `module_code` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `module_title` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `semester` tinyint NOT NULL,
  `lecture_day` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `lecture_start` time DEFAULT NULL,
  `lecture_finish` time DEFAULT NULL,
  `workshop_day` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `workshop_start` time DEFAULT NULL,
  `workshop_finish` time DEFAULT NULL,
  `campus` enum('City Campus','Walsall Campus','Telford Campus','Springfield Campus') COLLATE utf8mb4_general_ci NOT NULL,
  `lecture_room` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `workshop_room` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `module_code`, `module_title`, `semester`, `lecture_day`, `lecture_start`, `lecture_finish`, `workshop_day`, `workshop_start`, `workshop_finish`, `campus`, `lecture_room`, `workshop_room`) VALUES
(1, '5CS024', 'Collaborative Development', 2, 'Monday', '13:00:00', '14:00:00', 'Monday', '14:00:00', '17:00:00', 'City Campus', 'MC001', 'MD212b'),
(2, '4CS001', 'Introductory Programming and Problem Solving', 1, 'Tuesday', '09:00:00', '10:00:00', 'Tuesday', '10:00:00', '13:00:00', 'City Campus', 'MC001', 'MI102c'),
(3, '4CS015', 'Fundamentals of Computing', 1, 'Friday', '09:00:00', '10:00:00', 'Friday', '10:00:00', '13:00:00', 'City Campus', 'MC001', NULL),
(4, '4CS017', 'Internet Software Architecture', 1, 'Monday', '00:00:09', '00:00:10', 'Monday', '00:00:10', '00:00:13', 'City Campus', 'MC001', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int NOT NULL,
  `title` varchar(50) NOT NULL,
  `message_body` text NOT NULL,
  `creation_date` datetime NOT NULL,
  `expiration_date` datetime NOT NULL,
  `sender_id` int NOT NULL,
  `source_id` int DEFAULT NULL,
  `source_type` enum('club','module','event') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int NOT NULL,
  `role_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(1, 'admin'),
(2, 'owner'),
(3, 'co_owner'),
(4, 'gym'),
(5, 'transport');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int NOT NULL,
  `room_code` varchar(10) NOT NULL,
  `building_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `room_code`, `building_id`) VALUES
(1, '206', 1),
(3, '205', 1);

-- --------------------------------------------------------

--
-- Table structure for table `transit_info`
--

CREATE TABLE `transit_info` (
  `transit_id` int NOT NULL,
  `route_name` varchar(100) NOT NULL,
  `schedule` varchar(255) NOT NULL,
  `last_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transit_info`
--

INSERT INTO `transit_info` (`transit_id`, `route_name`, `schedule`, `last_updated`) VALUES
(1, 'Wolverhampton to Telford', 'Every 30 minutes (08:00–18:00)', '2026-02-02 14:38:57'),
(2, 'Wolverhampton to Walsall', 'Every 30 minutes (08:00–18:00)', '2026-02-02 14:38:57'),
(3, 'Telford to Wolverhampton', 'Every 30 minutes (08:00–18:00)', '2026-02-02 14:38:57'),
(4, 'Telford to Walsall', 'Every 30 minutes (08:00–18:00)', '2026-02-02 14:38:57'),
(5, 'Walsall to Wolverhampton', 'Every 30 minutes (08:00–18:00)', '2026-02-02 14:38:57'),
(12, 'Walsall to Telford', 'Every 30 minutes (08:00–18:00) - Delayed', '2026-03-16 10:02:52');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `account_creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password_hash`, `account_creation_date`) VALUES
(1, 'User 1', 'user1@wlv.ac.uk', 'hashed_pw_1', '2026-02-02 14:38:57'),
(3, 'User 3', 'user3@wlv.ac.uk', 'hashed_pw_3', '2026-02-02 14:38:57'),
(4, 'User 4', 'user4@wlv.ac.uk', 'hashed_pw_4', '2026-02-02 14:38:57'),
(5, 'User 5', 'user5@wlv.ac.uk', 'hashed_pw_5', '2026-02-02 14:38:57'),
(6, 'User 6', 'user6@wlv.ac.uk', 'hashed_pw_6', '2026-02-02 14:38:57'),
(24, 'admin', 'admin@email.com', '$2y$10$2P5jC6JgZAkM3u1Y3THsIO8pXsz1tfSo1jaeIFBtrm7drIBVflSra', '2026-03-08 12:58:29'),
(28, 'Aaron Greening', 'a.j.greening@wlv.ac.uk', '$2y$10$nObuDHo3UTjZLAeYoNcHc.96ApywmexEMDgmFzLBY7wSgAVDdPav2', '2026-03-16 10:38:26'),
(29, 'Calum Bowen', 'c.bowen5@wlv.ac.uk', '$2y$10$Dmav.Sv6eexYw/d8JLj8luVnPTdM6n4NZT8Gr5qtz5ww..hwupRzO', '2026-03-16 10:38:46'),
(30, 'Scott Kelly', 's.kelly10@wlv.ac.uk', '$2y$10$dFfVN.V6XT2o3C6.iuO3puVCBLDN3Z6TdJap38u5CUxvvaIkSPJyu', '2026-03-16 10:39:01'),
(31, 'Nana Owusu-Gyimah', 'n.owusu-gyimah@wlv.ac.uk', '$2y$10$TXngbCL8T6HRIPRLHuRMtuAxYuVt0ZrY6nyq34BZJiFqB0NY/Qh96', '2026-03-16 10:39:55'),
(32, 'David Keates', 'd.keates@wlv.ac.uk', '$2y$10$p9VXTsYrSOzUzojYSj3A4exb3PzH2dQlcodrbIf24Ud7oxzFTGDVW', '2026-03-16 10:40:14'),
(33, 'Brandon Barnes', 'b.c.barnes2@wlv.ac.uk', '$2y$10$9Q2KdQp4w1TEc6aGgTVCi.uK.L0b9pHSNqn0Q3IQMDUaMHhJxWXey', '2026-03-16 10:40:31'),
(34, 'test user', 'test@email.com', '$2y$10$7UZXKwsycNj7OpW.0tlnsuq6K4mMMnm/X/HAcUQz8RCjJH86wgx9O', '2026-03-16 13:53:50'),
(35, 'another user', 'user@email.com', '$2y$10$Nc3ff8yQfwpb6.5VZbh.Iusa6PPZNR03k0Q8Qx2NX4ojBLljy.1rC', '2026-03-16 14:01:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_clubs`
--

CREATE TABLE `user_clubs` (
  `user_id` int NOT NULL,
  `club_id` int NOT NULL,
  `club_join_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_clubs`
--

INSERT INTO `user_clubs` (`user_id`, `club_id`, `club_join_date`) VALUES
(3, 2, '2026-03-08 12:56:03'),
(24, 1, '2026-03-12 19:50:11'),
(24, 10, '2026-03-16 14:13:30'),
(30, 10, '2026-03-16 14:06:02'),
(34, 1, '2026-03-16 13:53:54'),
(34, 3, '2026-03-16 13:54:19');

-- --------------------------------------------------------

--
-- Table structure for table `user_events`
--

CREATE TABLE `user_events` (
  `user_id` int NOT NULL,
  `event_id` int NOT NULL,
  `event_join_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_modules`
--

CREATE TABLE `user_modules` (
  `user_id` int NOT NULL,
  `module_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_modules`
--

INSERT INTO `user_modules` (`user_id`, `module_id`) VALUES
(28, 1),
(29, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_notifications`
--

CREATE TABLE `user_notifications` (
  `user_id` int NOT NULL,
  `notification_id` int NOT NULL,
  `read_status` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `user_role_id` int NOT NULL,
  `user_id` int NOT NULL,
  `role_id` int NOT NULL,
  `club_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`user_role_id`, `user_id`, `role_id`, `club_id`) VALUES
(74, 1, 2, 1),
(42, 1, 5, NULL),
(75, 3, 2, 2),
(40, 3, 5, NULL),
(76, 4, 4, NULL),
(77, 5, 5, NULL),
(78, 6, 4, NULL),
(59, 24, 1, NULL),
(84, 30, 3, 10),
(83, 30, 4, NULL),
(79, 33, 2, 10),
(86, 35, 2, 3),
(82, 35, 4, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance_records`
--
ALTER TABLE `attendance_records`
  ADD PRIMARY KEY (`attendance_id`),
  ADD KEY `fk_attendance_user` (`user_id`);

--
-- Indexes for table `buildings`
--
ALTER TABLE `buildings`
  ADD PRIMARY KEY (`building_id`),
  ADD KEY `campus_location` (`campus_location`);

--
-- Indexes for table `campus_opening_times`
--
ALTER TABLE `campus_opening_times`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `clubs`
--
ALTER TABLE `clubs`
  ADD PRIMARY KEY (`club_id`),
  ADD UNIQUE KEY `club_name` (`club_name`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `fk_event_club` (`associated_club`),
  ADD KEY `fk_event_creator` (`created_by`);

--
-- Indexes for table `exercise_classes`
--
ALTER TABLE `exercise_classes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `gym_opening_times`
--
ALTER TABLE `gym_opening_times`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `module_code` (`module_code`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `fk_notif_sender` (`sender_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`),
  ADD UNIQUE KEY `room_code` (`room_code`),
  ADD KEY `fk_room_building` (`building_id`);

--
-- Indexes for table `transit_info`
--
ALTER TABLE `transit_info`
  ADD PRIMARY KEY (`transit_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_clubs`
--
ALTER TABLE `user_clubs`
  ADD PRIMARY KEY (`user_id`,`club_id`),
  ADD KEY `fk_uc_club` (`club_id`);

--
-- Indexes for table `user_events`
--
ALTER TABLE `user_events`
  ADD PRIMARY KEY (`user_id`,`event_id`),
  ADD KEY `event_id` (`event_id`) USING BTREE;

--
-- Indexes for table `user_modules`
--
ALTER TABLE `user_modules`
  ADD PRIMARY KEY (`user_id`,`module_id`),
  ADD KEY `module_id` (`module_id`);

--
-- Indexes for table `user_notifications`
--
ALTER TABLE `user_notifications`
  ADD PRIMARY KEY (`user_id`,`notification_id`),
  ADD KEY `fk_un_notif` (`notification_id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`user_role_id`),
  ADD UNIQUE KEY `uniq_user_role_club` (`user_id`,`role_id`,`club_id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `fk_clubs` (`club_id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance_records`
--
ALTER TABLE `attendance_records`
  MODIFY `attendance_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=744;

--
-- AUTO_INCREMENT for table `buildings`
--
ALTER TABLE `buildings`
  MODIFY `building_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `campus_opening_times`
--
ALTER TABLE `campus_opening_times`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `clubs`
--
ALTER TABLE `clubs`
  MODIFY `club_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `exercise_classes`
--
ALTER TABLE `exercise_classes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `gym_opening_times`
--
ALTER TABLE `gym_opening_times`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transit_info`
--
ALTER TABLE `transit_info`
  MODIFY `transit_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `user_role_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance_records`
--
ALTER TABLE `attendance_records`
  ADD CONSTRAINT `fk_attendance_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `fk_event_club` FOREIGN KEY (`associated_club`) REFERENCES `clubs` (`club_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_event_creator` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `fk_notif_sender` FOREIGN KEY (`sender_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `fk_room_building` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`building_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_clubs`
--
ALTER TABLE `user_clubs`
  ADD CONSTRAINT `fk_uc_club` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`club_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_uc_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_events`
--
ALTER TABLE `user_events`
  ADD CONSTRAINT `fk_user_events_event` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_events_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_modules`
--
ALTER TABLE `user_modules`
  ADD CONSTRAINT `fk_um_module` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_um_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_notifications`
--
ALTER TABLE `user_notifications`
  ADD CONSTRAINT `fk_un_notif` FOREIGN KEY (`notification_id`) REFERENCES `notifications` (`notification_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_un_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `fk_clubs` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`club_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_roles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_roles_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
