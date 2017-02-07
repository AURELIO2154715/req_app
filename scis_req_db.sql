-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 07, 2017 at 02:40 PM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

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
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `quantity`, `description`, `request_form_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'alcohol', 1, '2017-02-05 10:53:38', '2017-02-05 10:53:38'),
(2, 2, 'paper', 1, '2017-02-05 10:53:38', '2017-02-05 10:53:38'),
(3, 3, 'ballpen', 1, '2017-02-05 10:53:38', '2017-02-05 10:53:38'),
(4, 3, 'chairs', 2, '2017-02-05 10:55:45', '2017-02-05 10:55:45'),
(5, 5, 'Tables', 2, '2017-02-05 10:55:45', '2017-02-05 10:55:45'),
(6, 1, 'adobo', 3, '2017-02-05 11:37:20', '2017-02-05 11:37:20'),
(7, 3, 'tinola', 3, '2017-02-05 11:37:20', '2017-02-05 11:37:20'),
(8, 4, 'lechon', 3, '2017-02-05 11:37:20', '2017-02-05 11:37:20'),
(9, 4, 'papel', 4, '2017-02-06 08:24:01', '2017-02-06 08:24:01'),
(10, 3, 'bolpen', 4, '2017-02-06 08:24:01', '2017-02-06 08:24:01'),
(11, 4, 'wala lang', 5, '2017-02-07 08:17:02', '2017-02-07 08:17:02'),
(12, 2131231, 'wew', 6, '2017-02-07 08:22:11', '2017-02-07 08:22:11'),
(13, 22, 'wewewew', 6, '2017-02-07 08:22:11', '2017-02-07 08:22:11'),
(14, 3, 'yyyyy', 6, '2017-02-07 08:22:11', '2017-02-07 08:22:11');

-- --------------------------------------------------------

--
-- Table structure for table `request_form`
--

CREATE TABLE `request_form` (
  `request_id` int(11) NOT NULL,
  `requested_by` int(11) NOT NULL COMMENT 'user.id',
  `request_status` varchar(255) NOT NULL,
  `use_of_item` text NOT NULL,
  `date_needed` timestamp NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `request_form`
--

INSERT INTO `request_form` (`request_id`, `requested_by`, `request_status`, `use_of_item`, `date_needed`, `created_at`, `updated_at`) VALUES
(1, 1, 'pending', 'For Examination', '2017-02-13 16:00:00', '2017-02-05 10:53:38', '2017-02-05 10:53:38'),
(2, 1, 'pending', 'Classroom', '2017-02-21 16:00:00', '2017-02-05 10:55:45', '2017-02-05 10:55:45'),
(3, 1, 'pending', 'Lunch', '2017-02-09 16:00:00', '2017-02-05 11:37:20', '2017-02-05 11:37:20'),
(4, 1, 'pending', 'sdasdasdasdasdas', '2017-02-24 16:00:00', '2017-02-06 08:24:01', '2017-02-06 08:24:01'),
(5, 1, 'pending', 'heeeeeeeeeeeeeeeeeeeeeeeyyy', '2017-02-24 16:00:00', '2017-02-07 08:17:02', '2017-02-07 08:17:02'),
(6, 3, 'pending', 'wala lang bto', '2017-02-07 16:00:00', '2017-02-07 08:22:11', '2017-02-07 08:22:11');

-- --------------------------------------------------------

--
-- Table structure for table `status_report`
--

CREATE TABLE `status_report` (
  `id` int(11) NOT NULL,
  `received_by` int(11) NOT NULL,
  `request_form_id` int(11) NOT NULL,
  `remarks` text NOT NULL,
  `filename` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL,
  `update_at` timestamp NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `user_type`, `user_status`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$z.ucDvW0WeS64VCU.bHeR.O/bL6.Lifiz13jtCO9B3ui5x2rCadzy', 'scis', 'active', '2017-02-06 11:36:10', '2017-02-06 11:36:10'),
(2, 'accounting', '$2y$10$3Gi.7VB00mB9Vqaz1wiCheE1MKthfJXaE/yk5.bWZsfL2PHPzIHeK', 'accounting', 'active', '2017-02-06 11:36:29', '2017-02-06 11:36:29'),
(3, 'testing', '$2y$10$QjCwEyzoM81/T5TQAvPj0.Jk2fNR8JN8k13RQ0xGamW.HVyyOrzG6', 'scis', 'active', '2017-02-07 08:21:19', '2017-02-07 08:21:19');

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
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`id`, `user_id`, `firstname`, `middlename`, `lastname`, `created_at`, `updated_at`) VALUES
(1, 1, 'Galo Berlyn', 'Dullas', 'Garlejo', '2017-02-06 11:36:10', '2017-02-06 11:36:10'),
(2, 2, 'Accounting', '', '', '2017-02-06 11:36:29', '2017-02-06 11:36:29'),
(3, 3, 'Galo Other', 'Request', '', '2017-02-07 08:21:19', '2017-02-07 08:21:19');

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
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `request_form`
--
ALTER TABLE `request_form`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `status_report`
--
ALTER TABLE `status_report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
