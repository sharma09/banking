-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2019 at 02:45 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `banking`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_logs`
--

CREATE TABLE `admin_logs` (
  `id` int(11) NOT NULL,
  `adminuser` varchar(60) NOT NULL,
  `password` varchar(50) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `contactno` varchar(11) NOT NULL,
  `img_url` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_logs`
--

INSERT INTO `admin_logs` (`id`, `adminuser`, `password`, `fullname`, `contactno`, `img_url`) VALUES
(1, 'admin', 'admin123', 'Admin name', '900055555', '');

-- --------------------------------------------------------

--
-- Table structure for table `depositor`
--

CREATE TABLE `depositor` (
  `id` int(11) NOT NULL,
  `dates` date NOT NULL,
  `acc_no` int(11) NOT NULL,
  `remarks` varchar(85) NOT NULL,
  `creditor` decimal(12,2) NOT NULL,
  `debitor` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `depositor`
--

INSERT INTO `depositor` (`id`, `dates`, `acc_no`, `remarks`, `creditor`, `debitor`) VALUES
(1, '2019-03-10', 1000556215, 'Opening', '1000.00', '0.00'),
(2, '2019-03-10', 1000556215, 'FDR transfer amount -- A/c.550090620', '0.00', '500.00'),
(3, '2019-03-10', 1000556215, 'FDR transfer amount -- A/c.550090568', '0.00', '500.00'),
(4, '2019-03-10', 1000556215, 'Cash Deposit', '2000.00', '0.00'),
(5, '2019-03-10', 1000564981, 'Opening', '1000.00', '0.00'),
(6, '2019-03-10', 1000564981, 'FDR transfer amount -- A/c.550042068', '0.00', '500.00');

-- --------------------------------------------------------

--
-- Table structure for table `fixed_deposit`
--

CREATE TABLE `fixed_deposit` (
  `id` int(11) NOT NULL,
  `dates` date NOT NULL,
  `accountno` int(11) NOT NULL,
  `ddates` date NOT NULL,
  `fdr_accno` int(11) NOT NULL,
  `interest` decimal(5,2) NOT NULL,
  `period` varchar(40) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `maturity` decimal(12,2) NOT NULL,
  `mdates` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fixed_deposit`
--

INSERT INTO `fixed_deposit` (`id`, `dates`, `accountno`, `ddates`, `fdr_accno`, `interest`, `period`, `amount`, `maturity`, `mdates`) VALUES
(2, '2019-03-10', 1000556215, '2019-03-01', 550090620, '6.00', '60', '500.00', '505.00', '2019-04-30'),
(3, '2019-03-10', 1000556215, '2019-03-11', 550090568, '6.00', '60', '500.00', '505.00', '2019-04-30'),
(4, '2019-03-10', 1000564981, '2019-03-10', 550042068, '6.00', '60', '500.00', '505.00', '2019-05-30');

-- --------------------------------------------------------

--
-- Table structure for table `newaccount`
--

CREATE TABLE `newaccount` (
  `user_id` int(11) NOT NULL,
  `dates` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `acc_type` varchar(40) NOT NULL,
  `acc_no` int(11) NOT NULL,
  `text_pass` varchar(40) NOT NULL,
  `fname` varchar(60) NOT NULL,
  `fathername` varchar(60) NOT NULL,
  `mothername` varchar(60) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `img_url` varchar(50) NOT NULL,
  `mobileno` varchar(11) NOT NULL,
  `services` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `newaccount`
--

INSERT INTO `newaccount` (`user_id`, `dates`, `acc_type`, `acc_no`, `text_pass`, `fname`, `fathername`, `mothername`, `gender`, `address`, `city`, `state`, `img_url`, `mobileno`, `services`) VALUES
(1, '2019-03-10 15:21:42', 'Saving A/c', 1000556215, 'satnam', 'Satnam Dass', 'Raj Kumar', 'Pardhan Kaur', 'Male', 'patel angar', 'Malout', 'Punjab', 'satnam.jpg', '9023183600', ''),
(2, '2019-03-10 18:44:53', 'Saving A/c', 1000564981, 'gurpreet', 'GURPREET KAUR', 'Satnam Singh', 'Pardhan Kaur', 'Female', 'Patel nagar', 'Malout', 'Punjab', 'Gurpreet Kaur.jpg', '9914056539', 'enable');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_logs`
--
ALTER TABLE `admin_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `depositor`
--
ALTER TABLE `depositor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fixed_deposit`
--
ALTER TABLE `fixed_deposit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newaccount`
--
ALTER TABLE `newaccount`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_logs`
--
ALTER TABLE `admin_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `depositor`
--
ALTER TABLE `depositor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `fixed_deposit`
--
ALTER TABLE `fixed_deposit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `newaccount`
--
ALTER TABLE `newaccount`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
