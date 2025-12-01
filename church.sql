-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2025 at 12:06 PM
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
-- Database: `church`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_account`
--

CREATE TABLE `admin_account` (
  `id` int(11) NOT NULL,
  `admin_username` varchar(255) NOT NULL,
  `admin_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_account`
--

INSERT INTO `admin_account` (`id`, `admin_username`, `admin_password`) VALUES
(1, 'junverlymorada@gmail.com', '$2y$10$/T.gWDCTfLvbJBnxoKUdW.tmEd7t5TnHKrz7kOpFJjSah4Jp68.J2');

-- --------------------------------------------------------

--
-- Table structure for table `carousel`
--

CREATE TABLE `carousel` (
  `id` int(10) UNSIGNED NOT NULL,
  `picture_1` varchar(255) NOT NULL,
  `picture_2` varchar(255) NOT NULL,
  `picture_3` varchar(255) NOT NULL,
  `picture_4` varchar(255) NOT NULL,
  `picture_5` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carousel`
--

INSERT INTO `carousel` (`id`, `picture_1`, `picture_2`, `picture_3`, `picture_4`, `picture_5`, `created_at`, `updated_at`) VALUES
(1, 'carousel_1.jpg', 'carousel_2.jpg', 'carousel_3.jpg', 'carousel_4.jpg', 'carousel_5.jpg', '2025-08-31 23:46:32', '2025-09-01 00:01:16');

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `id` int(11) NOT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `user_full_name` varchar(255) DEFAULT NULL,
  `sponsor_1` varchar(255) DEFAULT NULL,
  `sponsor_2` varchar(255) DEFAULT NULL,
  `receipt` varchar(255) DEFAULT NULL,
  `receipt_code` varchar(255) DEFAULT NULL,
  `age` varchar(20) DEFAULT NULL,
  `date_column` date DEFAULT NULL,
  `father_name` varchar(255) DEFAULT NULL,
  `mother_maiden_name` varchar(255) DEFAULT NULL,
  `purpose_for` varchar(255) DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `pending` tinyint(1) DEFAULT NULL,
  `approval_status` tinyint(1) DEFAULT NULL,
  `user_full_name_pamisa` varchar(255) DEFAULT NULL,
  `purpose_for_pamisa` varchar(255) DEFAULT NULL,
  `sponsor_pamisa` varchar(255) DEFAULT NULL,
  `date_column_pamisa` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`id`, `user_email`, `user_full_name`, `sponsor_1`, `sponsor_2`, `receipt`, `receipt_code`, `age`, `date_column`, `father_name`, `mother_maiden_name`, `purpose_for`, `contact_number`, `pending`, `approval_status`, `user_full_name_pamisa`, `purpose_for_pamisa`, `sponsor_pamisa`, `date_column_pamisa`) VALUES
(1, 'renzmapa0321@gmail.com', NULL, NULL, NULL, 'Blank diagram.png', '68b4e9da99a4c', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Renz Daneco', 'Thanksgiving', 'Sammie', '2025-09-04'),
(2, 'renzmapa0321@gmail.com', 'Renz Daneco Mapa', 'Sammie', 'Chaves', 'Blank diagram.png', '68b4eaa937dfd', '21', '2025-09-21', 'Danilo Mapa', 'Rosa Mapa', 'marriage purpose', '01234567899', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `records`
--

CREATE TABLE `records` (
  `id` int(11) NOT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `user_full_name` varchar(255) DEFAULT NULL,
  `sponsor_1` varchar(255) DEFAULT NULL,
  `sponsor_2` varchar(255) DEFAULT NULL,
  `receipt` varchar(255) DEFAULT NULL,
  `receipt_code` varchar(255) DEFAULT NULL,
  `age` varchar(20) DEFAULT NULL,
  `date_column` date DEFAULT NULL,
  `father_name` varchar(255) DEFAULT NULL,
  `mother_maiden_name` varchar(255) DEFAULT NULL,
  `purpose_for` varchar(255) DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `pending` tinyint(1) DEFAULT NULL,
  `approval` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `records`
--

INSERT INTO `records` (`id`, `user_email`, `user_full_name`, `sponsor_1`, `sponsor_2`, `receipt`, `receipt_code`, `age`, `date_column`, `father_name`, `mother_maiden_name`, `purpose_for`, `contact_number`, `pending`, `approval`) VALUES
(1, 'renzmapa0321@gmail.com', 'Renz Daneco Mapa', 'Sammie', 'Chaves', 'Blank diagram.png', '68b4eaa937dfd', '21', '2025-09-21', 'Danilo Mapa', 'Rosa Mapa', 'marriage purpose', '01234567899', NULL, 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `records_2`
--

CREATE TABLE `records_2` (
  `id` int(11) NOT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `receipt` varchar(255) DEFAULT NULL,
  `receipt_code` varchar(255) DEFAULT NULL,
  `approval_status` tinyint(1) DEFAULT NULL,
  `user_full_name_pamisa` varchar(255) DEFAULT NULL,
  `purpose_for_pamisa` varchar(255) DEFAULT NULL,
  `sponsor_pamisa` varchar(255) DEFAULT NULL,
  `date_column_pamisa` date DEFAULT NULL,
  `approval` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `records_2`
--

INSERT INTO `records_2` (`id`, `user_email`, `receipt`, `receipt_code`, `approval_status`, `user_full_name_pamisa`, `purpose_for_pamisa`, `sponsor_pamisa`, `date_column_pamisa`, `approval`) VALUES
(1, 'renzmapa0321@gmail.com', 'Blank diagram.png', '68b4e9da99a4c', NULL, 'Renz Daneco', 'Thanksgiving', 'Sammie', '2025-09-04', 'declined');

-- --------------------------------------------------------

--
-- Table structure for table `users_account`
--

CREATE TABLE `users_account` (
  `id` int(11) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_full_name` varchar(255) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `father_name` varchar(255) DEFAULT NULL,
  `mother_maiden_name` varchar(255) DEFAULT NULL,
  `purpose_for` varchar(255) DEFAULT NULL,
  `sponsor_1` varchar(255) DEFAULT NULL,
  `sponsor_2` varchar(255) DEFAULT NULL,
  `receipt` varchar(255) DEFAULT NULL,
  `receipt_code` varchar(100) DEFAULT NULL,
  `user_full_name_pamisa` varchar(255) DEFAULT NULL,
  `purpose_for_pamisa` varchar(255) DEFAULT NULL,
  `sponsor_pamisa` varchar(255) DEFAULT NULL,
  `date_column_pamisa` varchar(255) DEFAULT NULL,
  `pending` tinyint(1) DEFAULT 1,
  `approval_status` tinyint(1) NOT NULL DEFAULT 0,
  `date_column` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_account`
--

INSERT INTO `users_account` (`id`, `user_email`, `user_password`, `user_full_name`, `age`, `contact_number`, `father_name`, `mother_maiden_name`, `purpose_for`, `sponsor_1`, `sponsor_2`, `receipt`, `receipt_code`, `user_full_name_pamisa`, `purpose_for_pamisa`, `sponsor_pamisa`, `date_column_pamisa`, `pending`, `approval_status`, `date_column`, `created_at`) VALUES
(1, 'renzmapa0321@gmail.com', '$2y$10$rLad3LgV5yUJ5E4SBM6.w./WjSTd5dGDhCtBiJd1Et.gdhf9S0El6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2025-09-01 00:30:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_account`
--
ALTER TABLE `admin_account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carousel`
--
ALTER TABLE `carousel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `records`
--
ALTER TABLE `records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `records_2`
--
ALTER TABLE `records_2`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_account`
--
ALTER TABLE `users_account`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_account`
--
ALTER TABLE `admin_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `carousel`
--
ALTER TABLE `carousel`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `records`
--
ALTER TABLE `records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `records_2`
--
ALTER TABLE `records_2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users_account`
--
ALTER TABLE `users_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
