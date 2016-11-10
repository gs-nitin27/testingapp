-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2016 at 08:48 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.5.37

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `getsport_gs`
--

-- --------------------------------------------------------

--
-- Table structure for table `gs_city`
--

CREATE TABLE `gs_city` (
  `id` int(12) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gs_city`
--

INSERT INTO `gs_city` (`id`, `name`) VALUES
(1, 'Mumbai'),
(2, 'Bangalore'),
(3, 'Ahmedabad'),
(4, 'Chennai'),
(5, 'Delhi'),
(6, 'Kolkata'),
(7, 'Hyderabad'),
(8, 'Surat'),
(9, 'Jaipur'),
(10, 'Lucknow'),
(11, 'Kanpur'),
(12, 'Nagpur'),
(13, 'Visakhapatnam'),
(14, 'Indore'),
(15, 'Bhopal'),
(16, 'Patna'),
(17, 'Ghaziabad'),
(18, 'Surat'),
(19, 'Jaipur'),
(20, 'Lucknow'),
(21, 'Kanpur'),
(22, 'Nagpur'),
(23, 'Visakhapatnam'),
(24, 'Indore'),
(25, 'Bhopal'),
(26, 'Patna'),
(27, 'Ghaziabad'),
(28, 'Agra'),
(29, 'Faridabad'),
(30, 'Srinagar'),
(31, 'Aurangabad'),
(32, 'Amritsar'),
(33, 'Ranchi'),
(34, 'Jabalpur'),
(35, 'Raipur'),
(36, 'Guwahati'),
(37, 'Chandigarh'),
(38, 'Agra'),
(39, 'Faridabad'),
(40, 'Srinagar'),
(41, 'Aurangabad'),
(42, 'Amritsar'),
(43, 'Ranchi'),
(44, 'Jabalpur'),
(45, 'Raipur'),
(46, 'Guwahati'),
(47, 'Chandigarh'),
(48, 'Moradabad'),
(49, 'Gurgaon'),
(50, 'Aligarh'),
(51, 'Bhubaneswar'),
(52, 'Saharanpur'),
(53, 'Gorakhpur'),
(54, 'Noida'),
(55, 'Firozabad'),
(56, 'Ujjain'),
(57, 'Jhansi'),
(58, 'Moradabad'),
(59, 'Gurgaon'),
(60, 'Aligarh'),
(61, 'Bhubaneswar'),
(62, 'Saharanpur'),
(63, 'Gorakhpur'),
(64, 'Noida'),
(65, 'Firozabad'),
(66, 'Ujjain'),
(67, 'Jhansi'),
(68, 'Gaya'),
(69, 'Udaipur'),
(70, 'Karnal'),
(71, 'Haridwar'),
(72, 'Bulandshahr'),
(73, 'Shimla'),
(74, 'Gaya'),
(75, 'Udaipur'),
(76, 'Karnal'),
(77, 'Haridwar'),
(78, 'Bulandshahr'),
(79, 'Shimla');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gs_city`
--
ALTER TABLE `gs_city`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gs_city`
--
ALTER TABLE `gs_city`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
