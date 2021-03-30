-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 26, 2021 at 06:27 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lms_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `info_visitor`
--

CREATE TABLE `info_visitor` (
  `id` int(11) NOT NULL,
  `barcode_ID` varchar(100) NOT NULL,
  `barcode` text NOT NULL,
  `name` varchar(100) NOT NULL,
  `dob` varchar(100) NOT NULL,
  `aadhar_no` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `info_visitor`
--

INSERT INTO `info_visitor` (`id`, `barcode_ID`, `barcode`, `name`, `dob`, `aadhar_no`, `address`, `status`, `created_at`, `updated_at`) VALUES
(1, '643296', '1616037194.png', 'TEST', '1992-03-29', '789456123456789', 'Indore 452001', '0', '2021-03-18 08:43:14', '2021-03-18 08:43:14'),
(4, '233118', '1616039275.png', 'TEST3', '2000-02-22', '1215454111111', 'TEST3\r\n', '0', '2021-03-18 09:17:55', '2021-03-18 09:17:55'),
(5, '211976', '1616043269.png', 'TEST4', '1992-05-21', '545454556556', 'TEST4', '1', '2021-03-18 10:24:29', '2021-03-18 10:24:29'),
(6, '322657', '1616043475.png', 'TEST5', '1990-02-05', '2121212121', 'TEST5', '1', '2021-03-18 10:27:55', '2021-03-18 10:27:55'),
(7, '373526', '1616043641.png', 'TEST6', '1992-03-12', '212548825', 'TEST6', '1', '2021-03-18 10:30:41', '2021-03-18 10:30:41'),
(8, '563360', '1616066333.png', 'tests223', '2002-02-23', 'eewrwet234234', 'testt223', '1', '2021-03-18 16:48:53', '2021-03-18 16:48:53'),
(9, '845296', '1616066681.png', 'Test', '2000-01-01', '1234567887654321', 'Test', '1', '2021-03-18 16:54:41', '2021-03-18 16:54:41'),
(10, '540806', '1616128103.png', 'TEST55', '1990-02-12', '542154872356', 'TEST55', '1', '2021-03-19 09:58:23', '2021-03-19 09:58:23'),
(11, '792599', '1616136690.png', 'TEST30', '2000-02-22', '215487542121', 'TEST30', '1', '2021-03-19 12:21:30', '2021-03-19 12:21:30'),
(12, '872933', '1616219279.png', 'TEST 2323', '1990-03-02', '21345215421', ' TEST232300', '0', '2021-03-20 11:17:59', '2021-03-20 11:17:59'),
(17, '265500', '1616394081.png', 'Rakesh Goyal', '1990-12-12', '124578451212', '123, MG Road Indore (M.P.) - 452000', '1', '2021-03-22 11:51:21', '2021-03-22 11:51:21'),
(18, '503119', '1616404748.png', 'TEST1232', '1990-02-20', '215421542154', 'TEST1232', '1', '2021-03-22 14:49:08', '2021-03-22 14:49:08'),
(19, '401469', '1616404960.png', 'TEST1144', '1990-02-02', '789562347', 'TEST1144', '1', '2021-03-22 14:52:40', '2021-03-22 14:52:40'),
(20, '572462', '1616405013.png', 'test32', '1990-12-12', '789456123', 'test123', '1', '2021-03-22 14:53:33', '2021-03-22 14:53:33'),
(21, '697442', '1616405359.png', 'TEST22', '1900-02-22', '321789', 'TEST', '1', '2021-03-22 14:59:19', '2021-03-22 14:59:19'),
(22, '787069', '1616405434.png', 'TEST120', '1900-02-12', '120230', 'TEST12313 2132123 21231 21231', '1', '2021-03-22 15:00:34', '2021-03-22 15:00:34'),
(23, '136184', '1616405932.png', 'TEST1144', '1900-12-06', '98562314', 'TEST TEST TEST TEST TESTTEST TEST TEST', '1', '2021-03-22 15:08:52', '2021-03-22 15:08:52'),
(24, '211251', '1616406700.png', 'TEST TEST 123456', '1990-02-05', '693245121254', '123, MG Road Indore (M.P.) - 452000', '1', '2021-03-22 15:21:40', '2021-03-22 15:21:40'),
(25, '216640', '1616471054.png', 'TEST 23 MAR', '1990-02-22', '874554965442', 'TEST ADDRESS TEST 23 MAR', '1', '2021-03-23 09:14:14', '2021-03-23 09:14:14');

-- --------------------------------------------------------

--
-- Table structure for table `in_out_visitor_info`
--

CREATE TABLE `in_out_visitor_info` (
  `id` int(11) NOT NULL,
  `barcode_id` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `aadhar_no` varchar(100) NOT NULL,
  `in_time` datetime NOT NULL,
  `out_time` datetime NOT NULL,
  `total_hrs` time NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `in_out_visitor_info`
--

INSERT INTO `in_out_visitor_info` (`id`, `barcode_id`, `name`, `aadhar_no`, `in_time`, `out_time`, `total_hrs`, `status`, `created_at`, `updated_at`) VALUES
(1, '233118', 'TEST3', '1215454111111', '2021-03-18 09:24:36', '0000-00-00 00:00:00', '00:00:00', '1', '2021-03-18 13:54:36', '2021-03-18 13:54:36'),
(2, '643296', 'TEST', '789456123456789', '2021-03-18 13:58:31', '0000-00-00 00:00:00', '00:00:00', '1', '2021-03-18 13:58:31', '2021-03-18 13:58:31'),
(7, '792599', 'TEST30', '215487542121', '2021-03-19 12:23:22', '0000-00-00 00:00:00', '00:00:00', '1', '2021-03-19 12:23:22', '2021-03-19 12:23:22'),
(14, '373526', 'TEST6', '212548825', '2021-03-20 09:05:15', '2021-03-20 09:40:49', '00:00:00', '1', '2021-03-20 09:05:15', '2021-03-20 09:05:15'),
(15, '792599', 'TEST30', '215487542121', '2021-03-20 11:20:27', '0000-00-00 00:00:00', '00:00:00', '1', '2021-03-20 11:20:27', '2021-03-20 11:20:27'),
(16, '872933', 'TEST 2323', '21345215421', '2021-03-20 11:30:26', '0000-00-00 00:00:00', '00:00:00', '1', '2021-03-20 11:30:26', '2021-03-20 11:30:26'),
(17, '845296', 'Test', '1234567887654321', '2021-03-22 12:10:36', '2021-03-22 12:13:23', '00:00:00', '1', '2021-03-22 12:10:36', '2021-03-22 12:10:36'),
(18, '211251', 'TEST TEST 123456', '693245121254', '2021-03-22 15:24:57', '0000-00-00 00:00:00', '00:00:00', '1', '2021-03-22 15:24:57', '2021-03-22 15:24:57'),
(34, '211251', 'TEST TEST 123456', '693245121254', '2021-03-26 10:32:10', '2021-03-26 10:55:25', '00:23:15', '1', '2021-03-26 10:32:10', '2021-03-26 10:32:10');

-- --------------------------------------------------------

--
-- Table structure for table `login_info`
--

CREATE TABLE `login_info` (
  `SnoPrimary` int(11) NOT NULL,
  `userName` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `pass` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT '1',
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login_info`
--

INSERT INTO `login_info` (`SnoPrimary`, `userName`, `pass`, `status`, `role`) VALUES
(1, 'Admin', '123456', '1', 'admin'),
(3, 'Gate', 'gate@123', '1', 'gate');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `info_visitor`
--
ALTER TABLE `info_visitor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `in_out_visitor_info`
--
ALTER TABLE `in_out_visitor_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_info`
--
ALTER TABLE `login_info`
  ADD PRIMARY KEY (`SnoPrimary`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `info_visitor`
--
ALTER TABLE `info_visitor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `in_out_visitor_info`
--
ALTER TABLE `in_out_visitor_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `login_info`
--
ALTER TABLE `login_info`
  MODIFY `SnoPrimary` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
