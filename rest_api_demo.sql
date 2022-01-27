-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 27, 2022 at 01:40 AM
-- Server version: 5.7.11
-- PHP Version: 7.1.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rest_api_demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `reservation_details`
--

CREATE TABLE `reservation_details` (
  `id` bigint(20) NOT NULL,
  `user_id` int(20) NOT NULL,
  `trip_id` int(20) NOT NULL,
  `number_of_spots` int(11) UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `cancel_reason` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reservation_details`
--

INSERT INTO `reservation_details` (`id`, `user_id`, `trip_id`, `number_of_spots`, `is_active`, `cancel_reason`, `created_at`, `modified_at`) VALUES
(4, 1, 1, 3, 0, '', '2022-01-23 21:22:28', '2022-01-25 00:28:41'),
(5, 1, 1, 10, 1, '', '2022-01-23 21:22:52', '2022-01-25 01:34:59'),
(6, 2, 1, 10, 1, NULL, '2022-01-23 21:23:17', '2022-01-23 22:23:17'),
(9, 7, 1, 10, 1, NULL, '2022-01-23 22:22:34', '2022-01-23 23:22:34'),
(10, 7, 2, 2, 1, '', '2022-01-23 23:05:44', '2022-01-25 00:32:43'),
(11, 18, 3, 5, 1, NULL, '2022-01-23 23:13:41', '2022-01-24 00:13:41'),
(12, 18, 3, 15, 0, '', '2022-01-23 23:14:05', '2022-01-25 02:16:20'),
(13, 18, 3, 2, 1, NULL, '2022-01-23 23:14:51', '2022-01-24 00:14:51'),
(14, 18, 3, 2, 1, NULL, '2022-01-24 22:27:03', '2022-01-24 23:27:03'),
(15, 18, 2, 3, 1, NULL, '2022-01-25 01:01:18', '2022-01-25 02:01:18'),
(16, 18, 2, 3, 1, NULL, '2022-01-25 01:15:08', '2022-01-25 02:15:08'),
(17, 18, 1, 3, 1, NULL, '2022-01-25 01:23:14', '2022-01-25 02:23:14'),
(18, 14, 4, 2, 0, '', '2022-01-25 20:47:07', '2022-01-25 21:48:10'),
(19, 14, 4, 8, 1, NULL, '2022-01-25 20:47:20', '2022-01-25 21:47:20'),
(20, 16, 4, 1, 0, '', '2022-01-25 20:49:01', '2022-01-26 01:59:56'),
(21, 20, 14, 8000, 1, '', '2022-01-26 01:07:08', '2022-01-26 02:13:10'),
(22, 20, 14, 1000000001, 1, NULL, '2022-01-26 01:07:28', '2022-01-26 02:07:28'),
(23, 20, 15, 10, 1, NULL, '2022-01-26 01:26:41', '2022-01-26 02:26:41');

-- --------------------------------------------------------

--
-- Table structure for table `trips`
--

CREATE TABLE `trips` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `start_from` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `end_to` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `total_spot` int(11) UNSIGNED NOT NULL,
  `trip_date` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trips`
--

INSERT INTO `trips` (`id`, `name`, `start_from`, `end_to`, `total_spot`, `trip_date`, `created_at`, `modified_at`) VALUES
(1, 'Trip A', 'ÅÃ³dÅº', 'Munich', 27, '2022-02-22 21:00:00', '2022-01-22 22:34:14', '2022-01-26 01:53:13'),
(2, 'Warsaw To LODZ', 'Warsaw', 'ÅÃ³dÅº', 12, '2022-02-12 10:00:00', '2022-01-22 22:35:19', '2022-01-25 02:15:08'),
(3, 'Trip To Berlin', 'Lodz', 'Berlin', 46, '2022-02-12 10:00:00', '2022-01-23 23:12:32', '2022-01-25 02:16:20'),
(4, 'Trip to London', 'Lodz', 'London', 2, '2022-03-12 11:00:00', '2022-01-25 20:46:03', '2022-01-26 01:59:56'),
(5, 'Trip to Lublin', 'Lodz', 'Lublin', 10, '2022-03-12 11:00:00', '2022-01-25 20:50:11', '2022-01-25 21:50:53'),
(10, 'Trip to London ', 'Lodz', 'London', 10, '2022-03-12 11:00:00', '2022-01-25 23:43:17', '2022-01-26 00:43:17'),
(13, 'A Trip to Mars', 'Earth', 'Mars', 1000010001, '2022-02-22 21:00:00', '2022-01-26 01:04:17', '2022-01-26 02:05:17'),
(14, 'A Trip to Mars', 'Earth', 'Mars', 12000, '2022-03-12 11:00:00', '2022-01-26 01:04:42', '2022-01-26 02:13:10'),
(15, 'Trip to Krakow City ', 'Lodz', 'Krakow', 5, '2022-03-10 11:00:00', '2022-01-26 01:25:20', '2022-01-26 02:28:22');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_name`, `user_email`, `password`, `mobile_number`, `address`, `created_at`, `modified_at`) VALUES
(1, 'rajesh10', 'rajesh_test@myapp.com', 'test_pass_23', '+44 78267262', 'address_test', '2022-01-22 20:08:28', '2022-01-22 21:46:56'),
(2, 'test_user', 'test_user@myapp.com', 'thisispass', '+46 605122880', 'Warsaw, Poland', '2022-01-22 20:08:28', '2022-01-22 21:58:23'),
(7, 'JhonDoe', 'JhonDoe@myapp.com', 'test_pass_23', '+48 368745905', 'Berlin, Germany', '2022-01-22 20:08:28', '2022-01-22 21:50:57'),
(9, 'Linkon', 'linkon@myapp.com', '', '+46 72648474', 'Lodz, Poland', '2022-01-22 20:08:28', '2022-01-22 21:00:53'),
(12, 'sush130', 'sush13@myapp.com', '', '+44 77228899', 'Dhaka, Bangladesh', '2022-01-22 20:08:28', '2022-01-22 21:00:53'),
(13, 'dush', 'dush@myapp.com', '', '+48 605122880', 'Warsaw, Poland', '2022-01-22 20:08:28', '2022-01-22 21:00:53'),
(14, 'Jane', 'Jane@myapp.com', '---', '+49 604122880', 'Berlin, Germany', '2022-01-22 20:10:06', '2022-01-22 21:10:06'),
(15, 'Robin', 'robin@myapp.com', '***', '+49 578123887', 'Munich, Germany', '2022-01-22 20:13:00', '2022-01-22 21:13:00'),
(16, 'mike', 'mike123@myapp.com', 'my_password_13', '+44 78267262', 'Lodz, Poland', '2022-01-22 21:27:54', '2022-01-22 22:50:27'),
(18, 'Tyson', 'tyson@myapp.com', 'test_pass_23', '+44 78267262', 'address_test_lodz', '2022-01-23 23:10:43', '2022-01-24 00:10:43'),
(19, 'Barny', 'barny@myapp.com', 'test_pass_2323', '+44 78267262', 'address_test_lodz', '2022-01-25 01:20:59', '2022-01-25 02:21:38'),
(20, 'Barny_Thssexx', 'barny_no@myapp.com', '********', '+44 78267262', 'address_test_lodz', '2022-01-26 00:17:10', '2022-01-26 01:21:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `reservation_details`
--
ALTER TABLE `reservation_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `trip_id` (`trip_id`);

--
-- Indexes for table `trips`
--
ALTER TABLE `trips`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `reservation_details`
--
ALTER TABLE `reservation_details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `trips`
--
ALTER TABLE `trips`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
