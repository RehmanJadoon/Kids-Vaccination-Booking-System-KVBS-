-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 09, 2025 at 03:06 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kidsvacc`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `fullname`, `created_at`) VALUES
(1, 'admin', '$2y$10$2L09BRlpVWCJDp0PxORlReuumSt6LnhynW6jtqccuKnjbVq1ecc7a', 'System Administrator', '2025-06-09 04:02:41');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
CREATE TABLE IF NOT EXISTS `bookings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `child_id` int NOT NULL,
  `vaccine_id` int NOT NULL,
  `preferred_date` date NOT NULL,
  `preferred_time` time NOT NULL,
  `status` enum('Pending','Approved','Rejected','Completed') DEFAULT 'Pending',
  `admin_notes` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `child_id` (`child_id`),
  KEY `vaccine_id` (`vaccine_id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `child_id`, `vaccine_id`, `preferred_date`, `preferred_time`, `status`, `admin_notes`, `created_at`, `updated_at`) VALUES
(3, 3, 3, '2025-06-15', '23:00:00', 'Rejected', 'name spell error', '2025-06-14 09:12:34', '2025-06-14 17:50:15'),
(4, 2, 9, '2025-06-15', '12:00:00', 'Approved', '', '2025-06-14 11:06:32', '2025-06-15 05:39:06'),
(5, 5, 11, '2025-09-16', '11:00:00', 'Approved', '', '2025-06-14 15:20:28', '2025-09-14 16:13:20'),
(6, 6, 3, '2025-06-16', '12:00:00', 'Rejected', 'put detailed address', '2025-06-14 15:21:08', '2025-06-14 18:10:36'),
(7, 7, 8, '2025-06-16', '10:00:00', 'Approved', '', '2025-06-15 05:57:43', '2025-06-15 06:09:42'),
(8, 2, 9, '2025-06-16', '12:00:00', 'Rejected', 'already booked for 15 June 2025 12:00:00 hours', '2025-06-15 06:10:45', '2025-06-15 06:19:14'),
(9, 8, 2, '2025-06-17', '11:00:00', 'Approved', '', '2025-06-15 06:39:31', '2025-06-15 06:41:11'),
(10, 9, 3, '2025-06-18', '00:00:00', 'Rejected', 'vaccine available for 1 year old kid', '2025-06-15 06:39:53', '2025-06-15 06:41:34'),
(11, 10, 3, '2025-06-22', '15:00:00', 'Rejected', 'Date due, kindly book visit again. We\'re sorry for inconvenience.', '2025-06-19 14:13:19', '2025-06-22 15:18:08'),
(12, 11, 9, '2025-06-23', '14:00:00', 'Approved', '', '2025-06-19 14:17:32', '2025-06-22 15:15:20'),
(13, 12, 10, '2025-06-29', '10:30:00', 'Approved', '', '2025-06-28 13:27:12', '2025-06-28 13:30:49'),
(14, 12, 10, '2025-07-08', '10:00:00', 'Rejected', 'Already vaccinated on 29 Jun 2025 at 10:30:00 hours', '2025-07-06 10:42:36', '2025-07-06 10:44:23'),
(15, 6, 10, '2025-07-14', '10:30:00', 'Approved', '', '2025-07-13 11:10:17', '2025-07-13 11:11:23'),
(16, 4, 10, '2025-08-17', '12:00:00', 'Approved', '', '2025-08-16 13:03:22', '2025-08-16 13:04:59'),
(17, 13, 9, '2025-08-17', '14:00:00', 'Approved', '', '2025-08-17 06:57:13', '2025-08-17 06:57:48'),
(18, 3, 3, '2025-08-19', '09:00:00', 'Rejected', 'Date due, kindly book again for vaccination. Sorry for inconvenience. ', '2025-08-17 15:17:48', '2025-09-06 07:51:13'),
(19, 3, 3, '2025-09-10', '09:00:00', 'Approved', '', '2025-09-08 13:11:44', '2025-09-08 13:13:12'),
(20, 2, 2, '2025-09-12', '00:00:00', 'Rejected', 'Vaccine for Typhoid for 7 years old kid is not available. ', '2025-09-08 13:14:44', '2025-09-08 13:15:47'),
(21, 11, 9, '2025-09-12', '16:00:00', 'Approved', '', '2025-09-08 14:13:42', '2025-09-08 14:14:26'),
(22, 12, 11, '2025-09-13', '13:00:00', 'Rejected', 'Vaccine available for 12+ years kids only.', '2025-09-08 14:23:13', '2025-09-08 14:23:56'),
(23, 18, 9, '2025-12-09', '10:00:00', 'Rejected', 'N/A', '2025-09-14 03:22:53', '2025-09-14 13:05:53'),
(24, 17, 8, '2025-09-15', '11:00:00', 'Approved', '', '2025-09-14 13:02:27', '2025-09-14 13:07:42'),
(25, 20, 10, '2025-09-17', '10:00:00', 'Approved', '', '2025-09-14 13:10:06', '2025-09-14 13:11:02'),
(27, 20, 10, '2025-09-18', '11:00:00', 'Rejected', 'Already booked', '2025-09-15 14:13:09', '2025-09-15 16:34:54'),
(28, 4, 9, '2025-09-18', '00:00:00', 'Approved', '', '2025-09-16 15:49:21', '2025-09-16 16:02:13'),
(29, 23, 10, '2025-10-04', '06:00:00', 'Rejected', 'Visit Booking Request for 0600 AM is not available.', '2025-09-30 15:54:31', '2025-09-30 16:06:06'),
(30, 23, 10, '2025-10-04', '10:30:00', 'Approved', '', '2025-09-30 16:07:03', '2025-09-30 16:07:42'),
(31, 24, 10, '2025-10-04', '10:00:00', 'Approved', '', '2025-10-01 16:50:56', '2025-10-02 16:30:13');

-- --------------------------------------------------------

--
-- Table structure for table `children`
--

DROP TABLE IF EXISTS `children`;
CREATE TABLE IF NOT EXISTS `children` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `parent_name` varchar(100) NOT NULL,
  `age` varchar(20) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `blood_group` varchar(10) DEFAULT NULL,
  `city` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `children`
--

INSERT INTO `children` (`id`, `user_id`, `name`, `parent_name`, `age`, `gender`, `blood_group`, `city`, `address`, `created_at`) VALUES
(5, 2, 'Jaffar', 'Muhammad Ali', '8 Months', 'Male', 'AB-', 'Sukkur', 'Street # 1, House 123, Sukkur', '2025-06-14 15:17:06'),
(2, 3, 'Jaffar', 'Mahdi Ali', '6 Months', 'Male', 'A+', 'Islamabad', 'House 123, Street # 1, Islamabad', '2025-06-14 07:00:43'),
(3, 3, 'Sadiq', 'Mahdi Ali', '12 Months', 'Male', 'B-', 'Karachi', 'House 123, Street # 01, DHA Karachi', '2025-06-14 07:03:36'),
(4, 3, 'Hanif', 'Mahdi Ali', '1.5 years', 'Male', 'AB+', 'Lahore', 'House 123, Street # 1, Lahore', '2025-06-14 07:17:52'),
(6, 2, 'Abdullah', 'Muhammad Ali', '2 years', 'Male', 'O+', 'Tando Yar Muhammad', 'Street # 1, House 123, Tando Yar Muhammad', '2025-06-14 15:19:33'),
(7, 2, 'Siddique', 'Muhammad Ali', '3 years', 'Male', 'A-', 'Lahore', 'Street # 1, House 123, Shadrah, Lahore', '2025-06-14 15:22:31'),
(8, 4, 'Muhammad Yousuf', 'Ahmed Hussain', '10 Months', 'Male', 'B-', 'Multan', 'Street # 1, House 123, Multan Cantt', '2025-06-15 06:38:25'),
(9, 4, 'Sania', 'Ahmed Hussain', '2 months', 'Female', 'A+', 'Lodhran', 'Street # 1, House 123, Lodhran', '2025-06-15 06:39:01'),
(10, 2, 'Jan Muhammad', 'Muhammad Ali', '3 Months', 'Male', 'AB-', 'Khyber', 'Street # 1, House 123, Khyber, FATA', '2025-06-19 14:12:17'),
(11, 6, 'Umar', 'Abdul Aziz', '9 Months', 'Male', 'A+', 'Peshawar City', 'Street # 1, House 123, Hayatabad Peshawar', '2025-06-19 14:16:42'),
(12, 6, 'Usman Ali', 'Abdul Aziz', '01 Year', 'Male', 'B+', 'Islamabad', 'Street # 1, House 123, Islamabad', '2025-06-28 13:22:38'),
(13, 6, 'Nadia', 'Abdul Aziz', '2 Months', 'Female', 'B-', 'Mianwali', 'Street # 1, House 123, Mianwali', '2025-08-17 06:55:44'),
(22, 2, 'Abdul Wudood', 'Muhammad Ali Ahmed', '5 years', 'Male', 'B+', 'Rawalpindi', 'House # 123 Street 01 Rawalpindi', '2025-09-29 15:48:04'),
(20, 5, 'Mehmood Khalid', 'Abdul Saboor', '2 years', 'Male', 'AB+', 'Islamabad', 'House # 123 Street # 01, Islamabad', '2025-09-14 13:09:36'),
(18, 5, 'Fatima', 'Abdul Saboor', '6 Months', 'Female', 'AB+', 'Karachi', 'House # 12 Street 01 Clifton, Karachi', '2025-09-14 02:13:51'),
(17, 5, 'Ali Ahmed', 'Abdul Saboor', '1 year', 'Male', 'B+', 'Islamabad', 'House # 123 Street 1, Islamabad', '2025-09-12 14:21:54'),
(23, 7, 'Muhammad Ameen', 'Abdul Qudoos', '3 years', 'Male', 'B-', 'Quetta', 'House # 123 Street 03, Quetta Cantt', '2025-09-30 15:50:47'),
(24, 1, 'Amna', 'Ali Rehman', '4 years', 'Female', 'A-', 'Islamabad', 'House # 123 Street 01, Islamabad', '2025-10-01 16:47:00'),
(25, 7, 'Maryam', 'Abdul Qudoos', '6 Months', 'Female', 'B+', 'Quetta', 'House # 123 Street 01 Quetta City', '2025-10-07 13:34:38');

-- --------------------------------------------------------

--
-- Table structure for table `consult`
--

DROP TABLE IF EXISTS `consult`;
CREATE TABLE IF NOT EXISTS `consult` (
  `id` int NOT NULL AUTO_INCREMENT,
  `child_name` varchar(100) NOT NULL,
  `parent_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `comments` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `consult`
--

INSERT INTO `consult` (`id`, `child_name`, `parent_name`, `email`, `phone`, `city`, `comments`) VALUES
(1, '', '', '', '', '', ''),
(2, '', '', '', '', '', ''),
(3, 'Ali', 'Abdullah', 'abdullah@gmail.com', '923001234567', 'Islamabad', 'I want to schedule home vaccination, how can I do that?');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `address` varchar(255) DEFAULT NULL,
  `confirm_password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `phone` (`phone`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `phone`, `password`, `created_at`, `address`, `confirm_password`) VALUES
(1, 'Ali', 'Rehman', 'ali@gmail.com', '923156487913', '$2y$10$W8/EzjUwWY6ylrEIxBN41uSAsVfJXGhFaDsAmtpVQB7P2XOje.5Rq', '2025-06-08 17:42:05', 'House#123, Bahria Town Lahore', NULL),
(2, 'Muhammad', 'Ali Ahmed', 'muhammad.ali@gmail.com', '923012345678', '$2y$10$6mLHFCnINxZltW7OnM9uU.zGMcgW7bn/vZtRDj9hlg9ODK3eeBq/.', '2025-06-08 17:53:57', 'House # 123, Bahria Town, Rawalpindi', NULL),
(3, 'Mahdi', 'Ali', 'mahdi.ali@gmail.com', '923001245006', '$2y$10$BXJES2zJ7fiPW6OLtqwFguY4d4piGYoF9eRrdW7DhRg1uOMqPOfLa', '2025-06-08 18:02:32', 'House # 123, Street 02, Clifton, Karachi', NULL),
(4, 'Ahmed', 'Hussain', 'hussain@gmail.com', '923010123456', '$2y$10$fpOCuhGwOL3DXbC2LtPzOuz95pFxzSaTLnxL4hCWeiOltcnqWp24i', '2025-06-09 03:40:10', 'Karachi', NULL),
(5, 'Abdul', 'Saboor', 'a.saboor@gmail.com', '923657801593', '$2y$10$XvNZ.rZNlouMD5tlM/zSXuKsYUqGAKbGrs7XroS.NZyLCs609E08a', '2025-06-14 15:35:08', 'House # 123 Street 01 Peshawar City', NULL),
(6, 'Abdul', 'Aziz', 'abdul.aziz@gmail.com', '932456872309', '$2y$10$Qbw7AtyecFSaoMiPzY9fj.327iEAWuFuK0Kkh/Ygz8M8lGfuUj58m', '2025-06-19 14:15:21', 'Karachi', NULL),
(7, 'Abdul', 'Qudoos', 'abdul.qudoos@gmail.com', '03123456789', '$2y$10$SfiBJOhnl4a/hoeX8SZBTuhJCLlsbY2piYYtvm2hLwqU/CIQsw7tW', '2025-09-28 13:39:30', 'House # 123, Street 03, Quetta Cantt', '$2y$10$SfiBJOhnl4a/hoeX8SZBTuhJCLlsbY2piYYtvm2hLwqU/CIQsw7tW');

-- --------------------------------------------------------

--
-- Table structure for table `vaccines`
--

DROP TABLE IF EXISTS `vaccines`;
CREATE TABLE IF NOT EXISTS `vaccines` (
  `id` int NOT NULL AUTO_INCREMENT,
  `disease` varchar(100) NOT NULL,
  `vaccine_name` varchar(100) NOT NULL,
  `brand` varchar(100) NOT NULL,
  `age_range` varchar(50) NOT NULL COMMENT 'e.g., "0-6 months", "1-2 years"',
  `status` enum('Available','Unavailable') DEFAULT 'Available',
  `can_book` tinyint(1) DEFAULT '1' COMMENT '1=Book Now enabled, 0=disabled',
  `description` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `vaccines`
--

INSERT INTO `vaccines` (`id`, `disease`, `vaccine_name`, `brand`, `age_range`, `status`, `can_book`, `description`, `created_at`, `updated_at`) VALUES
(2, 'Typhoid', 'Typbar', 'Amson', '9 Months', 'Available', 1, 'This vaccine is for 9 Months old kids, after vaccination the kids will stay safe from typhoid.', '2025-06-09 15:20:19', '2025-10-06 16:08:21'),
(3, 'Chickenpox', 'Varicella', 'Sinpharm', '1 Year', 'Available', 1, '', '2025-06-09 15:21:45', '2025-10-12 10:25:38'),
(4, 'Hepatitis A', 'Havris Jr 720', 'Gsk', '1 Year', 'Available', 1, 'This kids vaccine will stay safe from hepatitis A.', '2025-06-09 15:25:02', '2025-06-09 15:25:02'),
(11, 'Redness in Eye', 'EyeCare', 'Eye', '12+ years', 'Available', 1, '', '2025-09-07 13:24:45', '2025-09-07 13:24:45'),
(12, 'Hepatitis B', 'Havris 720', 'Gsk', '10+ years', 'Available', 1, '', '2025-09-07 13:26:52', '2025-09-07 13:26:52'),
(6, 'Yellow Fever', 'STAMARIL', 'Gsk', '9 Months', 'Available', 0, '', '2025-06-09 15:28:50', '2025-09-08 14:12:12'),
(7, 'Polio', 'Polyvac', 'Gsk', '3 Months', 'Available', 1, '', '2025-06-09 15:36:25', '2025-06-09 15:36:25'),
(8, 'Malaria', 'Malvac', 'Getz', '1 Year', 'Available', 1, '', '2025-06-09 15:36:53', '2025-06-09 15:36:53'),
(9, 'Diarrhea', 'Divac', 'Pfizer', '6 Months', 'Available', 1, '', '2025-06-09 15:37:17', '2025-06-09 15:37:17'),
(10, 'Sore Throat', 'Amoxil', 'Gsk', '2+ years', 'Available', 0, '', '2025-06-28 13:25:45', '2025-09-08 14:11:17'),
(13, 'Chikunguniya', 'GuniyaPlus', 'Gps', 'Upto 10 years', 'Unavailable', 1, '', '2025-09-15 17:26:08', '2025-09-15 17:26:35');

-- --------------------------------------------------------

--
-- Table structure for table `workers`
--

DROP TABLE IF EXISTS `workers`;
CREATE TABLE IF NOT EXISTS `workers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `available_time` varchar(100) NOT NULL COMMENT 'e.g., "9:00 AM - 5:00 PM"',
  `appointment_fee` decimal(10,2) NOT NULL,
  `specialization` varchar(100) NOT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `workers`
--

INSERT INTO `workers` (`id`, `full_name`, `email`, `phone`, `address`, `gender`, `available_time`, `appointment_fee`, `specialization`, `status`, `created_at`, `updated_at`) VALUES
(8, 'Zarah', 'zarah@kvbs.com', '92366666666', 'San Antonio, United States', 'Female', 'Tue - Wed (1000 - 1200)', 0.00, 'Skin Care Vaccination', 'Active', '2025-09-06 14:10:01', '2025-10-12 10:24:09'),
(3, 'Muhammad Hassan', 'muhammad.hassan@gmail.com', '923111111111', 'Flower Street, Clifton, Karachi', 'Male', '12:00 PM - 5:00 PM', 0.00, 'Malaria Vaccination', 'Active', '2025-06-09 11:14:38', '2025-09-06 10:28:14'),
(6, 'Ahmed Hassan Khan', 'ahmed.hassan@kvbs.com', '923444444444', 'Gulberg Lahore, Punjab', 'Male', 'Wed (12:00 AM - 3:00 PM)', 0.00, 'Chickenpox Vaccine', 'Active', '2025-06-09 15:35:30', '2025-10-06 16:07:56'),
(7, 'Hasnain Raza', 'hasnain@gmail.com', '923122112212', 'Hayatabad, Peshawar, KPK', 'Male', 'Fri (9:00 AM - 12:00 PM)', 0.00, 'Pollen Vaccination', 'Active', '2025-06-13 17:14:35', '2025-06-13 17:14:35'),
(10, 'Amna', 'amna@kvbs.com', '92377777777', 'New York, United States', 'Female', 'Sat - Sun (1000 - 1500)', 0.00, 'Health Care', 'Active', '2025-09-06 14:16:47', '2025-10-12 10:24:22'),
(11, 'Ayesha Altaf', 'ayesha@kvbs.com', '92388888888', 'Birmingham, United Kingdom ', 'Female', 'Thu - Fri (1500 - 1900)', 0.00, 'Eye Care', 'Active', '2025-09-06 14:22:36', '2025-10-12 10:24:40');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
