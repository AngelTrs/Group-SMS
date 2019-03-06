-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 06, 2019 at 12:02 AM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sms_data`
--
CREATE DATABASE IF NOT EXISTS `sms_data` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `sms_data`;

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `ID` int(11) NOT NULL,
  `EMAIL` varchar(300) NOT NULL,
  `PASSWORD` varchar(300) NOT NULL,
  `FIRST_NAME` varchar(200) NOT NULL,
  `MOBILE_NUMBER` varchar(12) NOT NULL,
  `LAST_LOGIN` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `brute_protection`
--

CREATE TABLE `brute_protection` (
  `ID` int(11) NOT NULL,
  `IP_ADDRESS` varchar(30) NOT NULL,
  `DATE_TIME` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `incoming_sms`
--

CREATE TABLE `incoming_sms` (
  `ID` int(11) NOT NULL,
  `FROM_NUMBER` varchar(12) NOT NULL,
  `BODY` text NOT NULL,
  `DATETIME` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `ID` int(11) NOT NULL,
  `ADMIN_USER_ID` int(11) NOT NULL COMMENT 'FK: USER_ADMIN1:ID ',
  `RECIPIENT_GROUP` varchar(200) NOT NULL,
  `BODY` text NOT NULL,
  `DATE_SENT` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `NUM_SENT` int(11) NOT NULL,
  `NUM_SUCCESS` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `ID` int(8) NOT NULL,
  `EMAIL` varchar(250) NOT NULL,
  `FIRST_NAME` varchar(100) NOT NULL,
  `LAST_NAME` varchar(100) NOT NULL,
  `MOBILE_NUMBER` varchar(12) NOT NULL,
  `ZIP_CODE` varchar(10) NOT NULL,
  `DATE_JOIN` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ACTIVE` tinyint(1) NOT NULL DEFAULT '1',
  `VALIDATED` tinyint(1) NOT NULL DEFAULT '0',
  `ERROR` tinyint(1) NOT NULL DEFAULT '0',
  `STOP` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `brute_protection`
--
ALTER TABLE `brute_protection`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `incoming_sms`
--
ALTER TABLE `incoming_sms`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `brute_protection`
--
ALTER TABLE `brute_protection`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `incoming_sms`
--
ALTER TABLE `incoming_sms`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `ID` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
