-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 19, 2019 at 07:29 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `18119107`
--
CREATE DATABASE IF NOT EXISTS `18119107` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `18119107`;

-- --------------------------------------------------------

--
-- Table structure for table `categoriesTable`
--

CREATE TABLE `categoriesTable` (
  `categorid` int(5) NOT NULL,
  `category` varchar(30) NOT NULL,
  `color` varchar(20) NOT NULL,
  `userid` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `eventsTable`
--

CREATE TABLE `eventsTable` (
  `eventid` int(11) NOT NULL,
  `userid` int(10) NOT NULL,
  `StartDate` datetime(6) NOT NULL,
  `EndDate` datetime(6) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Description` text NOT NULL,
  `Location` varchar(20) NOT NULL,
  `category` text NOT NULL,
  `categorid` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `usersTable`
--

CREATE TABLE `usersTable` (
  `userid` int(100) NOT NULL,
  `Username` varchar(100) DEFAULT NULL,
  `FirstName` varchar(100) NOT NULL,
  `LastName` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categoriesTable`
--
ALTER TABLE `categoriesTable`
  ADD PRIMARY KEY (`categorid`),
  ADD UNIQUE KEY `category` (`category`);

--
-- Indexes for table `eventsTable`
--
ALTER TABLE `eventsTable`
  ADD PRIMARY KEY (`eventid`);

--
-- Indexes for table `usersTable`
--
ALTER TABLE `usersTable`
  ADD PRIMARY KEY (`userid`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categoriesTable`
--
ALTER TABLE `categoriesTable`
  MODIFY `categorid` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `eventsTable`
--
ALTER TABLE `eventsTable`
  MODIFY `eventid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usersTable`
--
ALTER TABLE `usersTable`
  MODIFY `userid` int(100) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
