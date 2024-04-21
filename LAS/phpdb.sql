-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2024 at 09:05 PM
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
(1, 'admin', 'admin@123', 'CE', 20, 25, 10),
(2, 'it_hod', '5ad239cb8a44f659eaaee0aa1ea5b94947abe557', 'IT', 11, 11, 11),
(3, 'mh_hod', '8ead6354003c3f4fa80c692081bc8265af11220e', 'MH', 15, 10, 30),
(4, 'ec_hod', '69e8ee2d1cc1f429960a8637125d15e19e9daa8b', 'EC', 15, 10, 30),
(5, 'ic_hod', '8723baf2cf4683b85ee1c815495dd27835ab6fa7', 'IC', 15, 10, 30),
(6, 'cl_hod', 'ef4999d1761ed18bf1a96c80fe81a0a117cace25', 'CL', 15, 10, 30),
(7, 'ch_hod', '72c5a4143e012d2d999449d7d42bbc63d5693779', 'CH', 15, 10, 30);

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
(101, 'BhargavJupalli', 'Bhargav@123', 'Bhargav Jupalli', 'jupallibhargav2003@gmail.com', 'CSE AIML', 0, 0, 0, '0000-00-00', '', '', '2003-11-08'),
(102, 'Dhamodar', 'Dhamodar@123', 'Dhamodar', 'Dhamdor@gmail.com', 'Software', 1, 1, 1, '2024-04-20', '12 LPA', 'Full Time', '1998-09-11');

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
-- Dumping data for table `emp_leaves`
--

INSERT INTO `emp_leaves` (`RequestId`, `EmpId`, `EmpName`, `LeaveType`, `RequestDate`, `StartDate`, `EndDate`, `Reason`, `Status`, `RejectionReason`) VALUES
(1, 101, 'Bhargav Jupalli', 'sick', '0000-00-00', '2024-04-19', '2024-04-25', 'Cold and Fever', 'Accepted', ''),
(2, 101, 'Bhargav Jupalli', 'earn', '0000-00-00', '2024-04-19', '2024-04-22', 'Trip to Manali', 'Rejected', 'Not valid Reason'),
(3, 101, 'Bhargav Jupalli', 'earn', '2024-04-20', '2024-04-19', '2024-04-25', 'Family function', 'Rejected', 'not accepted ,you have more work');

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
