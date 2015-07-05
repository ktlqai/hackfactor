-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 05, 2015 at 12:06 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hackfactor`
--

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE IF NOT EXISTS `course` (
`id` int(11) NOT NULL,
  `name` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `schoolid` int(11) NOT NULL,
  `factorid` int(11) NOT NULL,
  `goalpoint` decimal(10,0) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `name`, `link`, `schoolid`, `factorid`, `goalpoint`) VALUES
(1, 'Advanced PHP', 'https://www.google.com/webhp?sourceid=chrome-instant&ion=1&espv=2&ie=UTF-8#q=advanced%20php', 3, 1, '10'),
(2, 'Pro English', 'https://www.google.com/webhp?sourceid=chrome-instant&ion=1&espv=2&ie=UTF-8#q=advanced%20php', 3, 2, '10'),
(3, 'Pro public speaking', 'https://www.google.com/webhp?sourceid=chrome-instant&ion=1&espv=2&ie=UTF-8#q=advanced%20php', 3, 3, '10');

-- --------------------------------------------------------

--
-- Table structure for table `factor`
--

CREATE TABLE IF NOT EXISTS `factor` (
`id` int(11) NOT NULL,
  `name` varchar(1000) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `factor`
--

INSERT INTO `factor` (`id`, `name`) VALUES
(1, 'programming PHP skill'),
(2, 'using English'),
(3, 'public speaking');

-- --------------------------------------------------------

--
-- Table structure for table `job`
--

CREATE TABLE IF NOT EXISTS `job` (
`id` int(11) NOT NULL,
  `name` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `companyid` int(11) NOT NULL,
  `pay` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `job`
--

INSERT INTO `job` (`id`, `name`, `link`, `companyid`, `pay`) VALUES
(1, 'Senior PHP dev', 'https://www.google.com/webhp?sourceid=chrome-instant&ion=1&espv=2&ie=UTF-8#q=advanced%20php', 4, 1000),
(2, 'PR staff', 'https://www.google.com/webhp?sourceid=chrome-instant&ion=1&espv=2&ie=UTF-8#q=advanced%20php', 4, 1000);

-- --------------------------------------------------------

--
-- Table structure for table `jobfactor`
--

CREATE TABLE IF NOT EXISTS `jobfactor` (
`id` int(11) NOT NULL,
  `jobid` int(11) NOT NULL,
  `factorid` int(11) NOT NULL,
  `minimumpoint` decimal(10,0) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jobfactor`
--

INSERT INTO `jobfactor` (`id`, `jobid`, `factorid`, `minimumpoint`) VALUES
(1, 1, 1, '9'),
(2, 1, 2, '7'),
(3, 2, 2, '8'),
(4, 2, 3, '8');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`id` int(11) NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `averagefactor` decimal(10,0) NOT NULL,
  `name` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `web` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(1000) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `averagefactor`, `name`, `web`, `type`) VALUES
(1, 'ktlqai@gmail.com', '1', '5', 'Ai Le', 'google.com', 'admin'),
(2, 'user@gmail.com', '1', '5', 'User 1', 'google.com', 'user'),
(3, 'school@gmail.com', '1', '5', 'School 1', 'google.com', 'school'),
(4, 'company@gmail.com', '1', '5', 'Company 1', 'google.com', 'company'),
(5, 'user2@gmail.com', '1', '5', 'User 2', 'google.com', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `userfactor`
--

CREATE TABLE IF NOT EXISTS `userfactor` (
`id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `factorid` int(11) NOT NULL,
  `point` decimal(10,0) NOT NULL,
  `atdatetime` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `userfactor`
--

INSERT INTO `userfactor` (`id`, `userid`, `factorid`, `point`, `atdatetime`) VALUES
(21, 2, 1, '10', '2015-07-05 00:00:00'),
(22, 2, 2, '10', '2015-07-05 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course`
--
ALTER TABLE `course`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `factor`
--
ALTER TABLE `factor`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job`
--
ALTER TABLE `job`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobfactor`
--
ALTER TABLE `jobfactor`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userfactor`
--
ALTER TABLE `userfactor`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `factor`
--
ALTER TABLE `factor`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `job`
--
ALTER TABLE `job`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `jobfactor`
--
ALTER TABLE `jobfactor`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `userfactor`
--
ALTER TABLE `userfactor`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
