-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2024 at 09:21 PM
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
-- Database: `phpdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(200) NOT NULL,
  `Dept` varchar(50) NOT NULL,
  `SetSickLeave` int(11) NOT NULL DEFAULT 15,
  `SetCasualLeave` int(11) NOT NULL DEFAULT 10,
  `SetEarnLeave` int(11) NOT NULL DEFAULT 30
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `Dept`, `SetSickLeave`, `SetCasualLeave`, `SetEarnLeave`) VALUES
(1, 'admin', 'admin@123', 'HR', 20, 25, 10);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `UserName` varchar(50) NOT NULL,
  `EmpPass` varchar(200) NOT NULL,
  `EmpName` varchar(50) NOT NULL,
  `EmpEmail` varchar(40) NOT NULL,
  `Dept` varchar(30) NOT NULL,
  `EarnLeave` int(5) UNSIGNED NOT NULL,
  `SickLeave` int(5) UNSIGNED NOT NULL,
  `CasualLeave` int(5) UNSIGNED NOT NULL,
  `DateOfJoin` date NOT NULL,
  `EmpFee` varchar(40) NOT NULL,
  `EmpType` varchar(40) NOT NULL,
  `DateOfBirth` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `UserName`, `EmpPass`, `EmpName`, `EmpEmail`, `Dept`, `EarnLeave`, `SickLeave`, `CasualLeave`, `DateOfJoin`, `EmpFee`, `EmpType`, `DateOfBirth`) VALUES
(101, 'BhargavJupalli', 'Bhargav@123', 'Bhargav Jupalli', 'jupallibhargav2003@gmail.com', 'software developer', 0, 0, 0, '2024-04-28', '15 LPA', 'full time', '2003-08-11'),
(102, 'Dhamodar', 'Dhamodar@123', 'Dhamodar', 'Dhamdor@gmail.com', 'Full stack developer', 0, 0, 0, '2024-04-20', '12 LPA', 'Full Time', '1998-09-11');

-- --------------------------------------------------------

--
-- Table structure for table `emp_leaves`
--

CREATE TABLE `emp_leaves` (
  `RequestId` int(10) NOT NULL,
  `EmpId` int(10) NOT NULL,
  `EmpName` varchar(20) NOT NULL,
  `LeaveType` varchar(60) NOT NULL,
  `RequestDate` date NOT NULL,
  `StartDate` date NOT NULL,
  `EndDate` date NOT NULL,
  `Reason` text NOT NULL DEFAULT '\'Requested\'',
  `Status` varchar(20) NOT NULL,
  `RejectionReason` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emp_leaves`
--
ALTER TABLE `emp_leaves`
  ADD PRIMARY KEY (`RequestId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `emp_leaves`
--
ALTER TABLE `emp_leaves`
  MODIFY `RequestId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
