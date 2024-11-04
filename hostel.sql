-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 11, 2024 at 02:06 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hostel`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_login`
--

CREATE TABLE `admin_login` (
  `admin_id` int(5) NOT NULL,
  `admin_email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` varchar(5) NOT NULL DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_login`
--

INSERT INTO `admin_login` (`admin_id`, `admin_email`, `username`, `password`, `role`) VALUES
(1, 'admin1@gmail.com', 'QWERTY', 'sayaadmin1', 'admin'),
(2, 'admin2@gmail.com', 'Public', 'admin2', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `book_room`
--

CREATE TABLE `book_room` (
  `registrationno_id` int(5) NOT NULL,
  `registration_no` varchar(3) NOT NULL,
  `room_no` varchar(8) NOT NULL,
  `food_status` varchar(50) NOT NULL,
  `stay_from` date NOT NULL,
  `duration` varchar(8) NOT NULL,
  `apply_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book_room`
--

INSERT INTO `book_room` (`registrationno_id`, `registration_no`, `room_no`, `food_status`, `stay_from`, `duration`, `apply_date`) VALUES
(73, '1', '101', 'With Food', '2024-07-10', '1 Month', '2024-07-10'),
(74, '2', '102', 'Without Food', '2024-07-14', '1 Month', '2024-07-10');

-- --------------------------------------------------------

--
-- Table structure for table `complaint_action`
--

CREATE TABLE `complaint_action` (
  `complaint_action_id` int(5) NOT NULL,
  `register_complaint_id` int(5) NOT NULL,
  `complaint_remark` varchar(200) NOT NULL DEFAULT 'Unprocessed',
  `posting_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complaint_action`
--

INSERT INTO `complaint_action` (`complaint_action_id`, `register_complaint_id`, `complaint_remark`, `posting_date`) VALUES
(92, 33, 'tes', '2024-07-10 11:08:17'),
(93, 34, 'our staff have cleaned your room', '2024-07-10 15:47:34');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(5) NOT NULL,
  `registration_no` int(5) NOT NULL,
  `accessibility_to_warden` varchar(13) NOT NULL,
  `accessibility_to_hostel_committee_members` varchar(13) NOT NULL,
  `redressal_of_problems` varchar(13) NOT NULL,
  `room` varchar(13) NOT NULL,
  `mess` varchar(13) NOT NULL,
  `hostel_surroundings` varchar(13) NOT NULL,
  `overall_rating` varchar(13) NOT NULL,
  `feedback_message` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `registration_no`, `accessibility_to_warden`, `accessibility_to_hostel_committee_members`, `redressal_of_problems`, `room`, `mess`, `hostel_surroundings`, `overall_rating`, `feedback_message`) VALUES
(11, 1, 'Very Good', 'Very Good', 'Very Good', 'Very Good', 'Very Good', 'Very Good', 'Very Good', '');

-- --------------------------------------------------------

--
-- Table structure for table `personal_info`
--

CREATE TABLE `personal_info` (
  `personal_info_id` int(5) NOT NULL,
  `registration_no` varchar(3) NOT NULL,
  `course` varchar(100) NOT NULL,
  `emergency_contact` varchar(20) NOT NULL,
  `guardian_name` varchar(100) NOT NULL,
  `guardian_relation` varchar(30) NOT NULL,
  `guardian_contact_no` varchar(20) NOT NULL,
  `correspondense_address` varchar(100) NOT NULL,
  `correspondense_city` varchar(50) NOT NULL,
  `correspondense_state` varchar(30) NOT NULL,
  `correspondense_pincode` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `personal_info`
--

INSERT INTO `personal_info` (`personal_info_id`, `registration_no`, `course`, `emergency_contact`, `guardian_name`, `guardian_relation`, `guardian_contact_no`, `correspondense_address`, `correspondense_city`, `correspondense_state`, `correspondense_pincode`) VALUES
(73, '1', 'Sarjana Teknik Informatika', '01111111111', 'qwerty', 'father', '011111111', 'jalan sampul', 'medan', 'Indonesia', '22022'),
(74, '2', 'gambar', '011111', 'swrf', 'father', '08888888', 'jalan hm said', 'medan', 'Indonesia', '22323');

-- --------------------------------------------------------

--
-- Table structure for table `register_complaint`
--

CREATE TABLE `register_complaint` (
  `register_complaint_id` int(5) NOT NULL,
  `registration_no` int(3) NOT NULL,
  `room_no` varchar(8) NOT NULL,
  `complaint_type` varchar(12) NOT NULL,
  `explain_complaint` varchar(300) NOT NULL,
  `file_name` varchar(500) NOT NULL,
  `complaint_status` varchar(30) NOT NULL DEFAULT 'Unprocessed',
  `complaint_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `register_complaint`
--

INSERT INTO `register_complaint` (`register_complaint_id`, `registration_no`, `room_no`, `complaint_type`, `explain_complaint`, `file_name`, `complaint_status`, `complaint_date`) VALUES
(33, 1, '101', 'Food related', 'Not yummy', '', 'In Process', '2024-07-10 11:07:39'),
(34, 1, '101', 'Room related', 'not clean', '', 'Closed', '2024-07-10 11:08:51');

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `registration_no` int(3) UNSIGNED NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `contact_no` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `confirm_password` varchar(100) NOT NULL,
  `role` varchar(5) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`registration_no`, `full_name`, `gender`, `contact_no`, `email`, `password`, `confirm_password`, `role`) VALUES
(1, 'Ferico Carvius Wivano', 'Male', '08222222', 'user1@gmail.com', 'sayauser1', '', 'user'),
(2, 'publik', 'Male', '0877', 'user2@gmail.com', 'saya1', '', 'user'),
(3, 'Ferico Carvius Wivano', 'Male', '01111111', 'user3@gmail.com', 'user3', '', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `room_info`
--

CREATE TABLE `room_info` (
  `room_no` int(10) NOT NULL,
  `seater` int(3) NOT NULL,
  `fees_per_month` int(50) NOT NULL,
  `remaining_seater` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_info`
--

INSERT INTO `room_info` (`room_no`, `seater`, `fees_per_month`, `remaining_seater`) VALUES
(101, 1, 2000000, 0),
(102, 2, 5000000, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_login`
--
ALTER TABLE `admin_login`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `admin_email` (`admin_email`);

--
-- Indexes for table `book_room`
--
ALTER TABLE `book_room`
  ADD PRIMARY KEY (`registrationno_id`);

--
-- Indexes for table `complaint_action`
--
ALTER TABLE `complaint_action`
  ADD PRIMARY KEY (`complaint_action_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`);

--
-- Indexes for table `personal_info`
--
ALTER TABLE `personal_info`
  ADD PRIMARY KEY (`personal_info_id`);

--
-- Indexes for table `register_complaint`
--
ALTER TABLE `register_complaint`
  ADD PRIMARY KEY (`register_complaint_id`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`registration_no`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `room_info`
--
ALTER TABLE `room_info`
  ADD PRIMARY KEY (`room_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_login`
--
ALTER TABLE `admin_login`
  MODIFY `admin_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `book_room`
--
ALTER TABLE `book_room`
  MODIFY `registrationno_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `complaint_action`
--
ALTER TABLE `complaint_action`
  MODIFY `complaint_action_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `personal_info`
--
ALTER TABLE `personal_info`
  MODIFY `personal_info_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `register_complaint`
--
ALTER TABLE `register_complaint`
  MODIFY `register_complaint_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `registration_no` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
