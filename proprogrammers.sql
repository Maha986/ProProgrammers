-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 02, 2021 at 07:11 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `proprogrammers`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignment_comment`
--

CREATE TABLE `assignment_comment` (
  `assignment_id` int(11) NOT NULL,
  `assignment_comment_id` int(11) NOT NULL,
  `assignment_commet` varchar(2000) NOT NULL,
  `assignment_topic` varchar(255) DEFAULT NULL,
  `sender_name` varchar(255) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `assignment_reviewers`
--

CREATE TABLE `assignment_reviewers` (
  `reviewer_name` varchar(255) NOT NULL,
  `assignment_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `attemptquiz`
--

CREATE TABLE `attemptquiz` (
  `CourseId` int(15) NOT NULL,
  `ModuleId` int(15) NOT NULL,
  `username` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `Sno` int(11) NOT NULL,
  `Title` text NOT NULL,
  `Catogory` varchar(15) NOT NULL,
  `Language` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `CourseId` int(11) NOT NULL,
  `CourseName` varchar(20) NOT NULL,
  `Assignment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `enrollment`
--

CREATE TABLE `enrollment` (
  `CourseId` int(15) NOT NULL,
  `username` varchar(255) NOT NULL,
  `AssignmentUrl` text DEFAULT NULL,
  `Certification` varchar(15) DEFAULT NULL,
  `Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `mcqs`
--

CREATE TABLE `mcqs` (
  `McqId` int(15) NOT NULL,
  `CourseId` int(15) NOT NULL,
  `ModuleId` int(15) NOT NULL,
  `Question` text NOT NULL,
  `Answer` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE `module` (
  `ModuleId` int(15) NOT NULL,
  `CourseId` int(15) NOT NULL,
  `ModuleName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `SNo` int(215) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Detail` text NOT NULL,
  `username` varchar(255) NOT NULL,
  `color` varchar(25) NOT NULL DEFAULT 'darkcyan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `OptionId` int(15) NOT NULL,
  `CourseId` int(15) NOT NULL,
  `ModuleId` int(15) NOT NULL,
  `McqId` int(15) NOT NULL,
  `OptionStatement` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `practiceproblems`
--

CREATE TABLE `practiceproblems` (
  `CourseId` int(15) NOT NULL,
  `ProblemId` int(15) NOT NULL,
  `ProbQue` text NOT NULL,
  `ProbSolution` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `id` int(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `cpassword` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `profile` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `snippets`
--

CREATE TABLE `snippets` (
  `SnippetId` int(15) NOT NULL,
  `CourseId` int(15) NOT NULL,
  `ModuleId` int(15) NOT NULL,
  `TopicId` int(15) NOT NULL,
  `SubtopicId` int(15) NOT NULL,
  `Code` text NOT NULL,
  `Output` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `subtopics`
--

CREATE TABLE `subtopics` (
  `SubtopicId` int(15) NOT NULL,
  `CourseId` int(15) NOT NULL,
  `ModuleId` int(15) NOT NULL,
  `TopicId` int(15) NOT NULL,
  `SubtopicName` varchar(50) NOT NULL,
  `SubtopicDesc` text NOT NULL,
  `VideoDesc` text DEFAULT NULL,
  `VideoLinkId` int(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comment`
--

CREATE TABLE `tbl_comment` (
  `comment_id` int(11) NOT NULL,
  `parent_comment_id` int(11) NOT NULL,
  `comment` mediumtext NOT NULL,
  `comment_sender_name` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `TopicId` int(15) NOT NULL,
  `CourseId` int(15) NOT NULL,
  `ModuleId` int(15) NOT NULL,
  `TopicName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `uploadingmaterial`
--

CREATE TABLE `uploadingmaterial` (
  `id` int(215) NOT NULL,
  `filename` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignment_comment`
--
ALTER TABLE `assignment_comment`
  ADD PRIMARY KEY (`assignment_id`),
  ADD UNIQUE KEY `assignment_comment_id` (`assignment_comment_id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`Sno`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`CourseId`),
  ADD UNIQUE KEY `coursename` (`CourseName`);

--
-- Indexes for table `mcqs`
--
ALTER TABLE `mcqs`
  ADD PRIMARY KEY (`McqId`,`CourseId`,`ModuleId`);

--
-- Indexes for table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`ModuleId`,`CourseId`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`SNo`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`OptionId`,`McqId`,`CourseId`,`ModuleId`);

--
-- Indexes for table `practiceproblems`
--
ALTER TABLE `practiceproblems`
  ADD PRIMARY KEY (`CourseId`,`ProblemId`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `snippets`
--
ALTER TABLE `snippets`
  ADD PRIMARY KEY (`SnippetId`,`CourseId`,`ModuleId`,`TopicId`,`SubtopicId`);

--
-- Indexes for table `subtopics`
--
ALTER TABLE `subtopics`
  ADD PRIMARY KEY (`SubtopicId`,`CourseId`,`ModuleId`,`TopicId`);

--
-- Indexes for table `tbl_comment`
--
ALTER TABLE `tbl_comment`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`TopicId`,`CourseId`,`ModuleId`);

--
-- Indexes for table `uploadingmaterial`
--
ALTER TABLE `uploadingmaterial`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignment_comment`
--
ALTER TABLE `assignment_comment`
  MODIFY `assignment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `Sno` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `CourseId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `SNo` int(215) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_comment`
--
ALTER TABLE `tbl_comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `uploadingmaterial`
--
ALTER TABLE `uploadingmaterial`
  MODIFY `id` int(215) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
