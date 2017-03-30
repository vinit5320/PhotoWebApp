-- phpMyAdmin SQL Dump
-- version 4.6.5.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Mar 30, 2017 at 05:16 AM
-- Server version: 5.6.34
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `photoApp`
--

-- --------------------------------------------------------

--
-- Table structure for table `photoApp_photos`
--

CREATE TABLE `photoApp_photos` (
  `username` varchar(20) NOT NULL,
  `imageName` varchar(100) NOT NULL,
  `caption` varchar(100) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `photoApp_photos`
--

INSERT INTO `photoApp_photos` (`username`, `imageName`, `caption`, `timestamp`) VALUES
('Kim', '1CohotBanner.jpg', 'myCo', '2017-02-14 23:53:53'),
('vinit5320', '800.png', '', '2017-02-14 18:15:39'),
('vinit5320', 'as-header.png', '5', '2017-02-15 05:02:32'),
('vinit5320', 'cas-header.png', '6', '2017-02-15 05:02:40'),
('vinit5320', 'cohortBanner.jpg', 'Cohort Banner', '2017-02-14 23:45:18'),
('vinit5320', 'img14335.png', '8', '2017-02-15 05:04:51'),
('vinit5320', 'img22778.png', '9', '2017-02-15 05:05:05'),
('vinit5320', 'img22784.png', '3', '2017-02-15 05:02:08'),
('vinit5320', 'img28101.png', '1', '2017-02-15 05:01:53'),
('vinit5320', 'img34849.png', '2', '2017-02-15 05:02:01'),
('vinit5320', 'Screen Shot 2017-02-11 at 6.51.24 PM.png', '', '2017-02-14 18:43:42'),
('vinit5320', 'search-mg.png', '4', '2017-02-15 05:02:25'),
('vinit5320', 'vinit5320_1487203443.jpg', 'newBanner', '2017-02-16 00:04:02'),
('vinit5320', 'vinit5320_1490576043.png', '<html>hello</html>', '2017-03-27 00:54:02');

-- --------------------------------------------------------

--
-- Table structure for table `photoApp_user`
--

CREATE TABLE `photoApp_user` (
  `username` varchar(20) NOT NULL DEFAULT '',
  `password` varchar(40) NOT NULL,
  `email` varchar(20) NOT NULL DEFAULT '',
  `name` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `photoApp_user`
--

INSERT INTO `photoApp_user` (`username`, `password`, `email`, `name`) VALUES
('Kim', '81dc9bdb52d04dc20036dbd8313ed055', 'kim.xang@nyu.edu', 'Kim Xang'),
('Lewis', '202cb962ac59075b964b07152d234b70', 'vdls@df.df', 'Lon Zeng'),
('vinit5320', '81dc9bdb52d04dc20036dbd8313ed055', 'vinit5320@gmail.com', 'Vinit Jasoliya');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `photoApp_photos`
--
ALTER TABLE `photoApp_photos`
  ADD PRIMARY KEY (`imageName`);

--
-- Indexes for table `photoApp_user`
--
ALTER TABLE `photoApp_user`
  ADD PRIMARY KEY (`username`,`email`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);
