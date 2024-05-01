-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 01, 2024 at 11:11 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `ActivityLog`
--

CREATE TABLE `ActivityLog` (
  `activityID` varchar(255) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `timestamp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Badge`
--

CREATE TABLE `Badge` (
  `name` varchar(255) NOT NULL,
  `timestamp` datetime NOT NULL,
  `uid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Category`
--

CREATE TABLE `Category` (
  `categoryID` enum('Fertilizer','Plant','Shop','Tool') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Comment`
--

CREATE TABLE `Comment` (
  `commentID` varchar(255) NOT NULL,
  `content` varchar(1000) NOT NULL,
  `timestamp` datetime NOT NULL,
  `likeID` varchar(255) DEFAULT NULL,
  `replyTo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ForumPost`
--

CREATE TABLE `ForumPost` (
  `postID` varchar(255) NOT NULL,
  `title` varchar(1000) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `timestamp` datetime NOT NULL,
  `likeID` varchar(255) DEFAULT NULL,
  `commentID` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Likes`
--

CREATE TABLE `Likes` (
  `likeID` varchar(255) NOT NULL,
  `timestamp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Page`
--

CREATE TABLE `Page` (
  `pageID` varchar(255) NOT NULL,
  `title` varchar(1000) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `timestamp` datetime NOT NULL,
  `commentID` varchar(255) DEFAULT NULL,
  `categoryID` enum('Fertilizer','Plant','Shop','Tool') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `uid` int(11) NOT NULL,
  `username` varchar(1000) NOT NULL,
  `password` varchar(1000) NOT NULL,
  `displayName` varchar(1000) NOT NULL,
  `permissionLevel` varchar(1000) NOT NULL,
  `timestamp` datetime NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `commentID` varchar(255) DEFAULT NULL,
  `postID` varchar(255) DEFAULT NULL,
  `likeID` varchar(255) DEFAULT NULL,
  `activityID` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ActivityLog`
--
ALTER TABLE `ActivityLog`
  ADD PRIMARY KEY (`activityID`);

--
-- Indexes for table `Badge`
--
ALTER TABLE `Badge`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `Category`
--
ALTER TABLE `Category`
  ADD PRIMARY KEY (`categoryID`);

--
-- Indexes for table `Comment`
--
ALTER TABLE `Comment`
  ADD PRIMARY KEY (`commentID`),
  ADD KEY `FK_ComLikes` (`likeID`),
  ADD KEY `FK_ComReply` (`replyTo`);

--
-- Indexes for table `ForumPost`
--
ALTER TABLE `ForumPost`
  ADD PRIMARY KEY (`postID`),
  ADD KEY `FK_PostLikes` (`likeID`),
  ADD KEY `FK_PostComment` (`commentID`);

--
-- Indexes for table `Likes`
--
ALTER TABLE `Likes`
  ADD PRIMARY KEY (`likeID`);

--
-- Indexes for table `Page`
--
ALTER TABLE `Page`
  ADD PRIMARY KEY (`pageID`),
  ADD KEY `FK_PageComment` (`commentID`),
  ADD KEY `FK_PageCategory` (`categoryID`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `username` (`username`) USING HASH,
  ADD KEY `FK_Badge` (`name`),
  ADD KEY `FK_Comment` (`commentID`),
  ADD KEY `FK_ForumPost` (`postID`),
  ADD KEY `FK_Likes` (`likeID`),
  ADD KEY `FK_Log` (`activityID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Comment`
--
ALTER TABLE `Comment`
  ADD CONSTRAINT `FK_ComLikes` FOREIGN KEY (`likeID`) REFERENCES `Likes` (`likeID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_ComReply` FOREIGN KEY (`replyTo`) REFERENCES `Comment` (`commentID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ForumPost`
--
ALTER TABLE `ForumPost`
  ADD CONSTRAINT `FK_PostComment` FOREIGN KEY (`commentID`) REFERENCES `Comment` (`commentID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_PostLikes` FOREIGN KEY (`likeID`) REFERENCES `Likes` (`likeID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Page`
--
ALTER TABLE `Page`
  ADD CONSTRAINT `FK_PageCategory` FOREIGN KEY (`categoryID`) REFERENCES `Category` (`categoryID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_PageComment` FOREIGN KEY (`commentID`) REFERENCES `Comment` (`commentID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `User`
--
ALTER TABLE `User`
  ADD CONSTRAINT `FK_Badge` FOREIGN KEY (`name`) REFERENCES `Badge` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_Comment` FOREIGN KEY (`commentID`) REFERENCES `Comment` (`commentID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_ForumPost` FOREIGN KEY (`postID`) REFERENCES `ForumPost` (`postID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_Likes` FOREIGN KEY (`likeID`) REFERENCES `Likes` (`likeID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_Log` FOREIGN KEY (`activityID`) REFERENCES `ActivityLog` (`activityID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
