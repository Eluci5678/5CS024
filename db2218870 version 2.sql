-- phpMyAdmin SQL Dump
-- version 5.2.0-dev
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 02, 2026 at 03:07 PM
-- Server version: 8.0.44-0ubuntu0.22.04.2
-- PHP Version: 8.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db2218870`
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

-- --------------------------------------------------------

--
-- Table structure for table `buildings`
--

CREATE TABLE `buildings` (
  `building_id` int NOT NULL,
  `building_initials` varchar(10) NOT NULL,
  `building_name` varchar(50) NOT NULL,
  `campus_location` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `buildings`
--

INSERT INTO `buildings` (`building_id`, `building_initials`, `building_name`, `campus_location`) VALUES
(1, 'MI', 'Alan Turing Building', 'City Campus'),
(2, 'MC', 'Millennium City Building', 'City Campus'),
(3, 'MD', 'Harrison Learning Centre', 'City Campus');

-- --------------------------------------------------------

--
-- Table structure for table `clubs`
--

CREATE TABLE `clubs` (
  `club_id` int NOT NULL,
  `club_name` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `owner_id` int NOT NULL,
  `schedule` varchar(255) NOT NULL,
  `club_creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `clubs`
--

INSERT INTO `clubs` (`club_id`, `club_name`, `description`, `owner_id`, `schedule`, `club_creation_date`) VALUES
(1, 'Computer Science Society', 'A club for students interested in coding, AI, and tech careers.', 1, 'Every Wednesday 6PM', '2026-02-02 14:38:57'),
(2, 'Football Club', 'University football training and competitive matches.', 2, 'Tuesdays & Fridays 5PM', '2026-02-02 14:38:57'),
(3, 'Entrepreneurship Club', 'Helping students build startups and side hustles.', 3, 'Mondays 7PM', '2026-02-02 14:38:57');

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
  `expiration_date` datetime NOT NULL,
  `created_by` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `title`, `events_description`, `event_type`, `associated_club`, `start_time`, `end_time`, `expiration_date`, `created_by`) VALUES
(1, 'Hackathon Night', 'Overnight coding event with prizes.', 'Workshop', 1, '2026-02-10 18:00:00', '2026-02-11 08:00:00', '2026-02-12 00:00:00', 1),
(2, 'Football Trials', 'Open trials for new players.', 'Sports', 2, '2026-02-15 16:00:00', '2026-02-15 18:00:00', '2026-02-16 00:00:00', 2),
(3, 'Startup Pitch Night', 'Pitch your business idea to judges.', 'Networking', 3, '2026-02-20 17:30:00', '2026-02-20 20:00:00', '2026-02-21 00:00:00', 3);

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
  `sender_id` int NOT NULL
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
(4, 'member');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int NOT NULL,
  `room_code` varchar(10) NOT NULL,
  `building_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(6, 'Walsall to Telford', 'Every 30 minutes (08:00–18:00)', '2026-02-02 14:38:57');

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
(2, 'User 2', 'user2@wlv.ac.uk', 'hashed_pw_2', '2026-02-02 14:38:57'),
(3, 'User 3', 'user3@wlv.ac.uk', 'hashed_pw_3', '2026-02-02 14:38:57'),
(4, 'User 4', 'user4@wlv.ac.uk', 'hashed_pw_4', '2026-02-02 14:38:57'),
(5, 'User 5', 'user5@wlv.ac.uk', 'hashed_pw_5', '2026-02-02 14:38:57'),
(6, 'User 6', 'user6@wlv.ac.uk', 'hashed_pw_6', '2026-02-02 14:38:57');

-- --------------------------------------------------------

--
-- Table structure for table `user_clubs`
--

CREATE TABLE `user_clubs` (
  `user_id` int NOT NULL,
  `club_id` int NOT NULL,
  `club_join_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `user_id` int NOT NULL,
  `role_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`user_id`, `role_id`) VALUES
(1, 2),
(2, 2),
(3, 2),
(4, 4),
(5, 4),
(6, 4);

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
  ADD PRIMARY KEY (`building_id`);

--
-- Indexes for table `clubs`
--
ALTER TABLE `clubs`
  ADD PRIMARY KEY (`club_id`),
  ADD UNIQUE KEY `club_name` (`club_name`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `fk_event_club` (`associated_club`),
  ADD KEY `fk_event_creator` (`created_by`);

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
-- Indexes for table `user_notifications`
--
ALTER TABLE `user_notifications`
  ADD PRIMARY KEY (`user_id`,`notification_id`),
  ADD KEY `fk_un_notif` (`notification_id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance_records`
--
ALTER TABLE `attendance_records`
  MODIFY `attendance_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `buildings`
--
ALTER TABLE `buildings`
  MODIFY `building_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `clubs`
--
ALTER TABLE `clubs`
  MODIFY `club_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transit_info`
--
ALTER TABLE `transit_info`
  MODIFY `transit_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance_records`
--
ALTER TABLE `attendance_records`
  ADD CONSTRAINT `fk_attendance_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `fk_event_club` FOREIGN KEY (`associated_club`) REFERENCES `clubs` (`club_id`),
  ADD CONSTRAINT `fk_event_creator` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `fk_notif_sender` FOREIGN KEY (`sender_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `fk_room_building` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`building_id`);

--
-- Constraints for table `user_clubs`
--
ALTER TABLE `user_clubs`
  ADD CONSTRAINT `fk_uc_club` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`club_id`),
  ADD CONSTRAINT `fk_uc_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `user_notifications`
--
ALTER TABLE `user_notifications`
  ADD CONSTRAINT `fk_un_notif` FOREIGN KEY (`notification_id`) REFERENCES `notifications` (`notification_id`),
  ADD CONSTRAINT `fk_un_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `user_roles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_roles_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
