-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 24, 2025 at 05:58 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `education`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblfiles`
--

CREATE TABLE `tblfiles` (
  `fileid` int(5) NOT NULL,
  `filetitle` varchar(255) DEFAULT NULL,
  `filedescription` varchar(255) DEFAULT NULL,
  `filename` varchar(100) DEFAULT NULL,
  `userid` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblfiles`
--

INSERT INTO `tblfiles` (`fileid`, `filetitle`, `filedescription`, `filename`, `userid`) VALUES
(12, NULL, NULL, 'what is MACHINE LEARNING.docx', 4),
(13, NULL, NULL, 'Linear Regression Algorithm.mp4', 5),
(14, NULL, NULL, 'AI - Machine Learning .pdf', 6),
(15, NULL, NULL, 'Natural_Language_Processing_Basics(1).pptx', 7),
(16, NULL, NULL, 'crop.jpeg', 8),
(17, NULL, NULL, 'invideo-ai-1080 Mastering eBay_ A Comprehensive Guide to 2024-01-11.mp4', 9),
(18, NULL, NULL, 'Project Stream Documentation (1).docx', 11);

-- --------------------------------------------------------

--
-- Table structure for table `tblmembers`
--

CREATE TABLE `tblmembers` (
  `memberid` int(8) NOT NULL,
  `memberfirstname` varchar(100) DEFAULT NULL,
  `memberlastname` varchar(50) DEFAULT NULL,
  `memberusername` varchar(100) DEFAULT NULL,
  `memberdateofbirth` date DEFAULT NULL,
  `memberaddress` varchar(100) DEFAULT NULL,
  `memberphone` varchar(20) DEFAULT NULL,
  `memberemail` varchar(100) DEFAULT NULL,
  `memberpassword` varchar(255) DEFAULT NULL,
  `memberpicture` varchar(100) DEFAULT NULL,
  `memberbio` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblmembers`
--

INSERT INTO `tblmembers` (`memberid`, `memberfirstname`, `memberlastname`, `memberusername`, `memberdateofbirth`, `memberaddress`, `memberphone`, `memberemail`, `memberpassword`, `memberpicture`, `memberbio`) VALUES
(4, 'Muhammad', 'Zain', 'zain', NULL, 'Jhang Road Faisalabad', '0327-0502273', 'zain1@gmail.com', '12345', 'Zain.jpeg', 'I am a student of BSCS at UAF-PARS Campus Jhang Road Faisalabad'),
(5, 'Sibtain ', 'Dastgir', 'Sibtain21', NULL, NULL, NULL, 'Sibtain21@gmail.com', '12345', 'Bagga.jpeg', NULL),
(6, 'Saqib ', 'Latif', 'Saqib90', NULL, NULL, NULL, 'Saqib90@gmail.com', '12345', NULL, NULL),
(7, 'Husnain', 'Jutt', 'Husnain2', NULL, NULL, NULL, 'Husnain2@gmail.com', '12345', NULL, NULL),
(8, 'Irhas', 'Rasool', 'Irhas3', NULL, NULL, NULL, 'Irhas3@gmail.com', '12345', NULL, NULL),
(9, 'Abdul ', 'Rehman', 'maan7', NULL, 'Chak No 71 JB Sarli Faisalabad', '03231100771', 'maan7@gmail.com', '12345', 'Maan.jpg', 'Advocate by Profession'),
(10, 'MUHAMMAD', 'ABDULLAH', 'abdullahdogar10', NULL, 'Faisalabad', '03097481006', 'abdullahdogar10@gmail.com', '12345', 'WhatsApp Image 2024-04-28 at 12.00.21_e46fda14.jpg', 'IEIS Consultant'),
(11, 'HASSAN', 'AHMAD', 'hasan1', NULL, NULL, NULL, 'hasan1@gmail.com', '12345', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblposts`
--

CREATE TABLE `tblposts` (
  `postid` int(10) NOT NULL,
  `posttitle` varchar(250) DEFAULT NULL,
  `posturl` varchar(250) DEFAULT NULL,
  `postbrief` varchar(255) DEFAULT NULL,
  `userid` int(11) DEFAULT 1,
  `postcontents` text DEFAULT NULL,
  `fileid` int(5) DEFAULT NULL,
  `date` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblposts`
--

INSERT INTO `tblposts` (`postid`, `posttitle`, `posturl`, `postbrief`, `userid`, `postcontents`, `fileid`, `date`) VALUES
(15, NULL, NULL, NULL, 4, 'Today’s Lecture Summary\r\n\r\nDear Students,\r\n\r\nThis is to inform you that the lecture delivered today by Sir was on the topic “What is Machine Learning? Definition, Types, Tools & More.”\r\n\r\nPlease review them carefully, as the content will help you build a strong foundation in Machine Learning and assist with upcoming class discussions and assessments.\r\n\r\nIf anyone has questions or needs further clarification, feel free to reach out.', 12, 'Fri, 12 Dec 2025'),
(21, NULL, NULL, NULL, 5, 'In this video, I explain the Linear Regression algorithm step by step, including intuition, mathematical formulation, cost function, gradient descent, and implementation in Python using scikit-learn. Ideal for beginners in Machine Learning.', 13, 'Tue, 23 Dec 2025'),
(22, NULL, NULL, NULL, 6, 'This is our today\'s lecture of Artificial Intelligence', 14, 'Tue, 23 Dec 2025'),
(23, NULL, NULL, NULL, 7, 'In this file, i explain the Natural Language Processing', 15, 'Tue, 23 Dec 2025'),
(24, NULL, NULL, NULL, 8, 'Today\'s Photo', 16, 'Tue, 23 Dec 2025'),
(25, NULL, NULL, NULL, 9, 'Today\'s Lecture', 17, 'Tue, 23 Dec 2025'),
(27, NULL, NULL, NULL, 11, 'it is', 18, 'Wed, 24 Dec 2025');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblfiles`
--
ALTER TABLE `tblfiles`
  ADD PRIMARY KEY (`fileid`);

--
-- Indexes for table `tblmembers`
--
ALTER TABLE `tblmembers`
  ADD PRIMARY KEY (`memberid`);

--
-- Indexes for table `tblposts`
--
ALTER TABLE `tblposts`
  ADD PRIMARY KEY (`postid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblfiles`
--
ALTER TABLE `tblfiles`
  MODIFY `fileid` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tblmembers`
--
ALTER TABLE `tblmembers`
  MODIFY `memberid` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tblposts`
--
ALTER TABLE `tblposts`
  MODIFY `postid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
