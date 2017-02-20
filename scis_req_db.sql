-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 19, 2017 at 07:23 AM
-- Server version: 5.7.17
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `scis_req_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `request_form_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `quantity`, `description`, `request_form_id`, `created_at`, `updated_at`) VALUES
(1, 3, 'toyota corolla', 1, '2017-02-09 09:30:39', '2017-02-09 09:30:39'),
(2, 4, 'toothpaste', 2, '2017-02-19 06:17:45', '2017-02-19 06:17:45'),
(3, 3, 'kangkong', 2, '2017-02-19 06:17:45', '2017-02-19 06:17:45'),
(4, 1, 'sabon', 3, '2017-02-19 06:19:26', '2017-02-19 06:19:26'),
(5, 3, 'liha', 4, '2017-02-19 06:32:36', '2017-02-19 06:32:36');

-- --------------------------------------------------------

--
-- Table structure for table `request_form`
--

CREATE TABLE `request_form` (
  `request_id` int(11) NOT NULL,
  `requested_by` int(11) NOT NULL COMMENT 'user.id',
  `request_status` varchar(255) NOT NULL,
  `use_of_item` text NOT NULL,
  `date_needed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `request_form`
--

INSERT INTO `request_form` (`request_id`, `requested_by`, `request_status`, `use_of_item`, `date_needed`, `created_at`, `updated_at`) VALUES
(1, 1, 'approved', 'transportation', '2017-02-19 06:07:23', '2017-02-09 09:30:39', '2017-02-09 09:30:39'),
(2, 1, 'approved', 'panghugas ng kilikili', '2017-02-19 06:18:27', '2017-02-19 06:17:45', '2017-02-19 06:17:45'),
(3, 1, 'rejected', 'pang ilo', '2017-02-19 06:26:13', '2017-02-19 06:19:26', '2017-02-19 06:19:26'),
(4, 1, 'pending', 'kamuro', '2017-02-22 16:00:00', '2017-02-19 06:32:36', '2017-02-19 06:32:36');

-- --------------------------------------------------------

--
-- Table structure for table `status_report`
--

CREATE TABLE `status_report` (
  `id` int(11) NOT NULL,
  `received_by` int(11) NOT NULL,
  `request_form_id` int(11) NOT NULL,
  `remarks` text NOT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status_report`
--

INSERT INTO `status_report` (`id`, `received_by`, `request_form_id`, `remarks`, `filename`, `created_at`, `updated_at`) VALUES
(1, 6, 1, 'because pancit', '1487484443.jpeg', '2017-02-19 06:07:23', '2017-02-19 06:07:23'),
(2, 6, 2, 'baho mo', '1487485108.jpeg', '2017-02-19 06:18:27', '2017-02-19 06:18:27'),
(4, 6, 3, 'this is really not needed', NULL, '2017-02-19 06:26:13', '2017-02-19 06:26:13');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` varchar(255) NOT NULL COMMENT 'scis/accounting',
  `user_status` varchar(255) NOT NULL COMMENT 'active/disabled',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `user_type`, `user_status`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$/lfdJjl.CyQ0TWeleHxYhusT0zYX2wfvjbXbiwqTD.zmn34xacq1m', 'scis', 'active', '2017-02-09 08:37:50', '2017-02-09 08:37:50'),
(3, 'janlorenz', '$2y$10$9aEKYU5Ry1AtStAAvNKVaOSK3GFgAnt3eA2wSzdlccvMEtAbkrbBe', 'scis', 'disabled', '2017-02-09 08:38:19', '2017-02-09 08:38:19'),
(4, 'clint', '$2y$10$eqH.xpRgAc8IQEx/pcj.Bu3/BqBxNjIc2GQkhnN726zEFOGs13O4a', 'scis', 'disabled', '2017-02-09 08:38:37', '2017-02-09 08:38:37'),
(5, 'miguel', '$2y$10$lkjFosjlqMQQfE94coD.Z.JchLWCfXgOqsr6kUJI7Z8n8cBeCYcbC', 'scis', 'disabled', '2017-02-09 08:39:04', '2017-02-09 08:39:04'),
(6, 'accounting', '$2y$10$9CEIIolUC8FXbeGSPHNzA.9DTvT1N0sStZt46wol5LNuZDbAxS6zG', 'accounting', 'active', '2017-02-19 03:26:47', '2017-02-09 09:41:21');

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `middlename` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`id`, `user_id`, `firstname`, `middlename`, `lastname`, `created_at`, `updated_at`) VALUES
(1, 1, 'Galo Berlyn', 'Dulas', 'Garlejo', '2017-02-09 08:37:50', '2017-02-09 08:37:50'),
(3, 3, 'Jan Lorenz', 'Bekkel', 'Aurelio', '2017-02-09 08:38:19', '2017-02-09 08:38:19'),
(4, 4, 'Clint Deric', 'Famorac', 'Dalayoan', '2017-02-09 08:38:37', '2017-02-09 08:38:37'),
(5, 5, 'Juan Miguel', 'Bangiacan', 'Delos Santos', '2017-02-09 08:39:05', '2017-02-09 08:39:05'),
(6, 6, 'Ed', 'B', 'Kidayan', '2017-02-09 09:41:21', '2017-02-09 09:41:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `request_form`
--
ALTER TABLE `request_form`
  ADD PRIMARY KEY (`request_id`);

--
-- Indexes for table `status_report`
--
ALTER TABLE `status_report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `request_form`
--
ALTER TABLE `request_form`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `status_report`
--
ALTER TABLE `status_report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_details`
--
ALTER TABLE `user_details`
  ADD CONSTRAINT `user_details_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
