-- phpMyAdmin SQL Dump
-- version 4.6.5.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Feb 18, 2017 at 05:18 AM
-- Server version: 5.6.34
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `photoApp`
--

-- --------------------------------------------------------

--
-- Table structure for table `photoApp_user`
--

CREATE TABLE `photoApp_user` (
  `username` varchar(20) NOT NULL DEFAULT '',
  `password` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL DEFAULT '',
  `name` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `photoApp_user`
--

INSERT INTO `photoApp_user` (`username`, `password`, `email`, `name`) VALUES
('', '', '', 'Den Mark'),
('Kim', '1234', 'kim.xang@nyu.edu', 'Kim Xang'),
('Lewis', '123', 'vdls@df.df', 'Lon Zeng'),
('vinit5320', '1234', 'vinit5320@gmail.com', 'Vinit Jasoliya');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `photoApp_user`
--
ALTER TABLE `photoApp_user`
  ADD PRIMARY KEY (`username`,`email`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);
