-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3308
-- Generation Time: Dec 18, 2023 at 05:17 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `website`
--

-- --------------------------------------------------------

--
-- Table structure for table `addpatient`
--

CREATE TABLE `addpatient` (
  `id` int(11) NOT NULL,
  `drname` varchar(250) NOT NULL,
  `name` varchar(200) NOT NULL,
  `age` int(2) NOT NULL,
  `experience` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `addpatient`
--

INSERT INTO `addpatient` (`id`, `drname`, `name`, `age`, `experience`) VALUES
(6, 'Rameen khan', 'rameen@gmail.com', 24, '1 year'),
(8, 'Ali khan', 'ali@gmail.com', 31, '3 year'),
(9, 'Rahat ali', 'rahat@gmail.com', 28, '1 year'),
(10, 'Bilal khan', 'bilal@gmail.com', 32, '4 year'),
(11, 'Ayesha ali', 'ayesha@gmail.com', 40, '5 years'),
(12, 'Muhammad Ali', 'khan@gmail.com', 32, '4 year');

-- --------------------------------------------------------

--
-- Table structure for table `availabledoctors`
--

CREATE TABLE `availabledoctors` (
  `ID` varchar(11) NOT NULL,
  `FullName` varchar(30) NOT NULL,
  `Age` varchar(2) NOT NULL,
  `WorkingPlace` varchar(50) NOT NULL,
  `Fee` varchar(6) NOT NULL,
  `Experience` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `Email` varchar(250) NOT NULL,
  `id` varchar(255) NOT NULL,
  `image` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mri_images`
--

CREATE TABLE `mri_images` (
  `id` int(10) NOT NULL,
  `doctor_email` varchar(250) NOT NULL,
  `patient_email` varchar(250) NOT NULL,
  `image` varchar(250) NOT NULL,
  `patient_name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mri_images`
--

INSERT INTO `mri_images` (`id`, `doctor_email`, `patient_email`, `image`, `patient_name`) VALUES
(106, 'rameen@gmail.com', '123@gmail.com', 'images/26 (19).jpg', 'Ali khan'),
(107, 'rameen@gmail.com', 'ahmed@gmail.com', 'images/26 (19) (2).jpg', 'ahmed ali'),
(108, 'rameen@gmail.com', '123@gmail.com', 'images/26 (19) (2) (1).jpg', 'ahmed');

-- --------------------------------------------------------

--
-- Table structure for table `newpatient`
--

CREATE TABLE `newpatient` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `age` int(20) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `inherited` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `newpatient`
--

INSERT INTO `newpatient` (`id`, `name`, `email`, `age`, `gender`, `inherited`) VALUES
(4, 'ali khaan', 'rameen@gmail.com', 32, 'Male', 'Yes'),
(5, 'Shiza kabir', 'shiza@gmail.com', 23, 'Female', 'Yes'),
(6, 'Rameen Naeem', 'rameen@gmail.com', 21, 'Female', 'Yes'),
(7, 'ayesha ali', 'ayesha@gmail.com', 32, 'Female', 'No'),
(8, 'zeenia khan', 'zee@gmail.com', 21, 'Female', 'No'),
(9, 'muhammad', 'm@gmail.com', 50, 'Male', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `patient_inbox`
--

CREATE TABLE `patient_inbox` (
  `id` int(20) NOT NULL,
  `doctor_email` varchar(255) NOT NULL,
  `report` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prescriptions`
--

CREATE TABLE `prescriptions` (
  `id` int(11) NOT NULL,
  `doctorname` varchar(50) NOT NULL,
  `patientname` varchar(50) NOT NULL,
  `age` varchar(20) NOT NULL,
  `disease` varchar(50) NOT NULL,
  `stage` varchar(50) NOT NULL,
  `prescription` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prescriptions`
--

INSERT INTO `prescriptions` (`id`, `doctorname`, `patientname`, `age`, `disease`, `stage`, `prescription`) VALUES
(9, '', 'ali khan', '12', 'Yes', 'Mild Demented', 'none'),
(10, 'rameen@gmail.com', 'ayesha khan', '32', 'Yes', 'Mild Demented', '..'),
(11, '', 'Ahmed khan ', '21', 'Yes', 'Mild Demented', 'take androl ');

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `id` int(1) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(50) NOT NULL,
  `usertype` varchar(50) NOT NULL DEFAULT 'doctor'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`id`, `username`, `email`, `password`, `usertype`) VALUES
(2, 'sheez56', '123@gmail.com', '789', 'patient'),
(3, 'Shiza kabir', 'sk@gmail.com', 'sa', 'doctor'),
(6, 'rameen', 'rameen@gmail.com', 'rameen', 'doctor'),
(8, 'Dr.Ali', 'ali@gmail.com', 'Ali22', 'doctor'),
(9, 'Dr.Rahat', 'rahat@gmail.com', 'rahat', 'doctor'),
(10, 'Dr.Bilal', 'bilal@gmail.com', 'bilal', 'doctor'),
(11, 'Dr.Ayesha', 'ayesha@gmail.com', 'ayesha', 'doctor'),
(12, 'khan', 'khan@gmail.com', 'khan', 'doctor'),
(13, 'Shizakhan', 'sheez@gmail.com', 'shiza', 'doctor'),
(14, 'Ahmed21', 'ahmed@gmail.com', 'ahmed', 'patient'),
(15, 'fatima', 'fatima@gmail.com', 'fatima', 'patient');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(20) NOT NULL,
  `doctor_email` varchar(255) NOT NULL,
  `patient_email` varchar(255) NOT NULL,
  `patient_name` varchar(250) NOT NULL,
  `report` mediumtext NOT NULL,
  `report_date` date NOT NULL,
  `report_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `doctor_email`, `patient_email`, `patient_name`, `report`, `report_date`, `report_time`) VALUES
(7, 'rameen@gmail.com', '123@gmail.com', 'Ali khan', 'Disease Stage: Mild\r\nTake Androl tb 2 times a day\r\nsend MRI after 5 days\r\n', '2023-12-16', '22:27:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addpatient`
--
ALTER TABLE `addpatient`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `availabledoctors`
--
ALTER TABLE `availabledoctors`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `mri_images`
--
ALTER TABLE `mri_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newpatient`
--
ALTER TABLE `newpatient`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patient_inbox`
--
ALTER TABLE `patient_inbox`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addpatient`
--
ALTER TABLE `addpatient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `mri_images`
--
ALTER TABLE `mri_images`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `newpatient`
--
ALTER TABLE `newpatient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `patient_inbox`
--
ALTER TABLE `patient_inbox`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prescriptions`
--
ALTER TABLE `prescriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
