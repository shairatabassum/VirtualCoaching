-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 27, 2019 at 08:45 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `virtualcoaching`
--

-- --------------------------------------------------------

--
-- Table structure for table `channel`
--

CREATE TABLE `channel` (
  `Email` varchar(100) DEFAULT NULL,
  `ChannelID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `channel`
--

INSERT INTO `channel` (`Email`, `ChannelID`) VALUES
('swakkhar@cse.uiu.ac.bd', 4),
('mittahad@gmail.com', 5),
('md.sabbir.ullah@gmail.com', 6),
('samon@gmail.com', 7);

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `CourseID` int(11) NOT NULL,
  `ChannelID` int(11) DEFAULT NULL,
  `Subject` varchar(100) DEFAULT NULL,
  `Topic` varchar(100) DEFAULT NULL,
  `CourseTitle` varchar(100) DEFAULT NULL,
  `Image` varchar(100) DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `About` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`CourseID`, `ChannelID`, `Subject`, `Topic`, `CourseTitle`, `Image`, `Date`, `About`) VALUES
(9, 4, 'Computer Science and Engineering', 'Object-Oriented Programming', 'Introduction to OOP', '1_KmFzveXeGZNH5kdepynd4A.png', '2019-01-01', 'This is an introductory course to Object-Oriented Programming for beginners. This is an introductory course to Object-Oriented Programming for beginners. This is an introductory course to Object-Oriented Programming for beginners. This is an introductory course to Object-Oriented Programming for beginners. This is an introductory course to Object-Oriented Programming for beginners. This is an introductory course to Object-Oriented Programming for beginners. This is an introductory course to Object-Oriented Programming for beginners. This is an introductory course to Object-Oriented Programming for beginners. '),
(10, 4, 'Computer Science and Engineering', 'Algorithms', 'Introduction to Algorithms', 'Competitive-Programming-1.jpg', '2019-01-01', 'This is an introductory course to algorithms for the beginners. This is an introductory course to algorithms for the beginners. This is an introductory course to algorithms for the beginners. This is an introductory course to algorithms for the beginners. This is an introductory course to algorithms for the beginners. This is an introductory course to algorithms for the beginners. '),
(11, 5, 'Developers', 'Android Development', 'Android Development for Beginners', 'Android-app-development.jpg', '2019-01-01', 'This course is for the beginners'),
(12, 5, 'Developers', 'Android Development', 'Advanced Android Development', 'ailt-splash.png', '2019-01-01', 'Advanced course for android developers'),
(13, 6, 'Robotics', 'Electronics', 'Introduction to Robotics', 'course_image_csmm_103x_378x225.jpg', '2019-01-01', 'This is an introduction This is an introduction This is an introduction'),
(14, 7, 'Computer Science and Engineering', 'Random', 'Random video', '_89716241_thinkstockphotos-523060154.jpg', '2019-01-01', 'Random test course for video'),
(15, 7, 'Random', 'Random', 'Random Course', 'download.jpg', '2019-01-01', 'This is a random test course');

-- --------------------------------------------------------

--
-- Table structure for table `enroll`
--

CREATE TABLE `enroll` (
  `Email` varchar(100) DEFAULT NULL,
  `CourseID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `enroll`
--

INSERT INTO `enroll` (`Email`, `CourseID`) VALUES
('mittahad@gmail.com', 9),
('mittahad@gmail.com', 10),
('md.sabbir.ullah@gmail.com', 9),
('md.sabbir.ullah@gmail.com', 11),
('mittahad@gmail.com', 13),
('samon@gmail.com', 9),
('samon@gmail.com', 13),
('shaira.sheba@gmail.com', 14),
('shaira.sheba@gmail.com', 9),
('shaira.sheba@gmail.com', 10),
('swakkhar@cse.uiu.ac.bd', 15);

-- --------------------------------------------------------

--
-- Table structure for table `material`
--

CREATE TABLE `material` (
  `MaterialID` int(11) NOT NULL,
  `CourseID` int(11) DEFAULT NULL,
  `Chapter` int(11) DEFAULT NULL,
  `Section` varchar(10) DEFAULT NULL,
  `MaterialTitle` varchar(100) DEFAULT NULL,
  `File` varchar(255) DEFAULT NULL,
  `FileType` varchar(20) NOT NULL,
  `Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `material`
--

INSERT INTO `material` (`MaterialID`, `CourseID`, `Chapter`, `Section`, `MaterialTitle`, `File`, `FileType`, `Date`) VALUES
(42, 9, 1, '1.1', 'Java: An Introduction', 'sample.pdf', 'PDF File', '2019-01-01'),
(43, 9, 1, '1.2', 'Introduction to Java: Extended', 'sample.pdf', 'PDF File', '2019-01-01'),
(44, 9, 2, '2.1', 'Object-Oriented Programming in Java', 'sample.pdf', 'PDF File', '2019-01-01'),
(45, 9, 2, '2.2', 'Object-Oriented Programming in Java: Extended', 'sample.pdf', 'PDF File', '2019-01-01'),
(46, 9, 3, '3.1', 'Inheritance', 'sample.pdf', 'PDF File', '2019-01-01'),
(47, 9, 4, '4.1', 'Abstract Classes and Interfaces', 'sample.pdf', 'PDF File', '2019-01-01'),
(48, 9, 5, '5.1', 'Exceptions and Others', 'sample.pdf', 'PDF File', '2019-01-01'),
(49, 9, 6, '6.1', 'Swing: Introduction to GUI Design', 'sample.pdf', 'PDF File', '2019-01-01'),
(50, 9, 7, '7.1', 'Concurrency', 'sample.pdf', 'PDF File', '2019-01-01'),
(51, 9, 8, '8.1', 'Wrappers and Collections', 'sample.pdf', 'PDF File', '2019-01-01'),
(52, 9, 9, '9.1', 'Generics', 'sample.pdf', 'PDF File', '2019-01-01'),
(53, 9, 10, '10.1', 'Lambda and I/O', 'sample.pdf', 'PDF File', '2019-01-01'),
(54, 10, 1, '1.1', 'Introduction', 'sample.pdf', 'PDF File', '2019-01-01'),
(55, 10, 2, '2.1', 'Merge Sort', 'sample.pdf', 'PDF File', '2019-01-01'),
(56, 10, 3, '3.1', 'Divide n Conquer', 'sample.pdf', 'PDF File', '2019-01-01'),
(57, 10, 4, '4.1', 'Greedy Algorithm', 'sample.pdf', 'PDF File', '2019-01-01'),
(59, 10, 5, '5.1', 'Dynamic Programming', 'sample.pdf', 'PDF File', '2019-01-01'),
(60, 14, 1, '1.1', 'First video', 'samplevideo.mp4', 'Video File', '2019-01-01'),
(61, 14, 2, '2.1', 'Second Video', 'samplevideo.mp4', 'Video File', '2019-01-01'),
(62, 14, 3, '3.1', 'Third Video', 'samplevideo.mp4', 'Video File', '2019-01-01'),
(63, 14, 4, '4.1', 'Sample PDF', 'sample.pdf', 'PDF File', '2019-01-01'),
(64, 14, 5, '5.1', 'Fourth Video', 'samplevideo.mp4', 'Video File', '2019-01-01'),
(65, 14, 6, '6.1', 'Sample PDF 2', 'sample.pdf', 'PDF File', '2019-01-01');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `Email_sender` varchar(100) DEFAULT NULL,
  `Email_receiver` varchar(100) DEFAULT NULL,
  `Date` datetime DEFAULT NULL,
  `Message` text,
  `Seen` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`Email_sender`, `Email_receiver`, `Date`, `Message`, `Seen`) VALUES
('shaira.sheba@gmail.com', 'samon@gmail.com', '2019-01-01 02:21:00', 'Hello', 1),
('shaira.sheba@gmail.com', 'md.sabbir.ullah@gmail.com', '2019-01-01 02:21:09', 'Hello ', 1),
('shaira.sheba@gmail.com', 'mittahad@gmail.com', '2019-01-01 02:21:17', 'Hello', 1),
('samon@gmail.com', 'shaira.sheba@gmail.com', '2019-01-01 02:24:21', 'hi', 1),
('shaira.sheba@gmail.com', 'samon@gmail.com', '2019-01-01 02:24:34', 'How are you?', 1),
('samon@gmail.com', 'shaira.sheba@gmail.com', '2019-01-01 02:25:05', 'I am fine', 1),
('shaira.sheba@gmail.com', 'samon@gmail.com', '2019-01-01 02:25:16', 'Thanks for your response.', 1),
('samon@gmail.com', 'shaira.sheba@gmail.com', '2019-01-01 02:25:24', 'My pleasure.', 1),
('mittahad@gmail.com', 'shaira.sheba@gmail.com', '2019-01-01 02:26:17', 'How can I help you?', 1),
('md.sabbir.ullah@gmail.com', 'shaira.sheba@gmail.com', '2019-01-01 02:27:01', 'Hello', 1),
('md.sabbir.ullah@gmail.com', 'shaira.sheba@gmail.com', '2019-01-01 02:27:33', 'Are you a subscriber? Please subscribe my channel if you have not already.', 1),
('samon@gmail.com', 'shaira.sheba@gmail.com', '2019-01-01 12:19:53', 'Bla bla Test', 1),
('shaira.sheba@gmail.com', 'md.sabbir.ullah@gmail.com', '2019-01-01 12:27:51', 'osidfjoir', 1),
('shaira.sheba@gmail.com', 'md.sabbir.ullah@gmail.com', '2019-01-01 12:28:37', 'jgoierojg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `Email_sender` varchar(100) DEFAULT NULL,
  `Email_receiver` varchar(100) DEFAULT NULL,
  `Date` datetime DEFAULT NULL,
  `Type` varchar(100) DEFAULT NULL,
  `TypeID` int(11) DEFAULT NULL,
  `Seen` int(11) DEFAULT NULL,
  `Click` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`Email_sender`, `Email_receiver`, `Date`, `Type`, `TypeID`, `Seen`, `Click`) VALUES
('swakkhar@cse.uiu.ac.bd', 'shaira.sheba@gmail.com', '2019-01-01 01:20:07', 'course', 9, 0, 1),
('swakkhar@cse.uiu.ac.bd', 'md.sabbir.ullah@gmail.com', '2019-01-01 01:20:07', 'course', 9, 0, 0),
('swakkhar@cse.uiu.ac.bd', 'samon@gmail.com', '2019-01-01 01:20:07', 'course', 9, 0, 1),
('swakkhar@cse.uiu.ac.bd', 'mittahad@gmail.com', '2019-01-01 01:20:07', 'course', 9, 0, 1),
('swakkhar@cse.uiu.ac.bd', 'shaira.sheba@gmail.com', '2019-01-01 01:21:07', 'material', 9, 1, 1),
('swakkhar@cse.uiu.ac.bd', 'md.sabbir.ullah@gmail.com', '2019-01-01 01:21:07', 'material', 9, 0, 0),
('swakkhar@cse.uiu.ac.bd', 'samon@gmail.com', '2019-01-01 01:21:07', 'material', 9, 0, 1),
('swakkhar@cse.uiu.ac.bd', 'mittahad@gmail.com', '2019-01-01 01:21:07', 'material', 9, 0, 1),
('swakkhar@cse.uiu.ac.bd', 'shaira.sheba@gmail.com', '2019-01-01 01:27:59', 'course', 10, 1, 1),
('swakkhar@cse.uiu.ac.bd', 'md.sabbir.ullah@gmail.com', '2019-01-01 01:27:59', 'course', 10, 0, 0),
('swakkhar@cse.uiu.ac.bd', 'samon@gmail.com', '2019-01-01 01:27:59', 'course', 10, 1, 1),
('swakkhar@cse.uiu.ac.bd', 'mittahad@gmail.com', '2019-01-01 01:27:59', 'course', 10, 0, 1),
('swakkhar@cse.uiu.ac.bd', 'shaira.sheba@gmail.com', '2019-01-01 01:28:32', 'material', 10, 0, 1),
('swakkhar@cse.uiu.ac.bd', 'md.sabbir.ullah@gmail.com', '2019-01-01 01:28:32', 'material', 10, 0, 0),
('swakkhar@cse.uiu.ac.bd', 'samon@gmail.com', '2019-01-01 01:28:32', 'material', 10, 0, 1),
('swakkhar@cse.uiu.ac.bd', 'mittahad@gmail.com', '2019-01-01 01:28:32', 'material', 10, 0, 1),
('mittahad@gmail.com', 'samon@gmail.com', '2019-01-01 01:36:38', 'course', 11, 0, 1),
('mittahad@gmail.com', 'shaira.sheba@gmail.com', '2019-01-01 01:36:38', 'course', 11, 1, 1),
('mittahad@gmail.com', 'samon@gmail.com', '2019-01-01 01:37:33', 'course', 12, 1, 1),
('mittahad@gmail.com', 'shaira.sheba@gmail.com', '2019-01-01 01:37:33', 'course', 12, 1, 1),
('samon@gmail.com', 'shaira.sheba@gmail.com', '2019-01-01 12:26:27', 'material', 14, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `CourseID` int(11) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Rating` int(11) DEFAULT NULL,
  `Review` text,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`CourseID`, `Email`, `Rating`, `Review`, `Date`) VALUES
(9, 'mittahad@gmail.com', 5, 'Amazing course, learned a great deal from Sir.', '2019-01-01'),
(10, 'mittahad@gmail.com', 5, 'Best course', '2019-01-01'),
(9, 'md.sabbir.ullah@gmail.com', 4, 'Great course', '2019-01-01'),
(11, 'md.sabbir.ullah@gmail.com', 4, 'Great work', '2019-01-01'),
(13, 'mittahad@gmail.com', 4, 'good work', '2019-01-01'),
(9, 'samon@gmail.com', 4, 'Thanks for such a great course', '2019-01-01'),
(13, 'samon@gmail.com', 5, 'awesome, loved this course.', '2019-01-01');

-- --------------------------------------------------------

--
-- Table structure for table `subscription`
--

CREATE TABLE `subscription` (
  `Email` varchar(100) DEFAULT NULL,
  `ChannelID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subscription`
--

INSERT INTO `subscription` (`Email`, `ChannelID`) VALUES
('shaira.sheba@gmail.com', 4),
('md.sabbir.ullah@gmail.com', 4),
('samon@gmail.com', 4),
('mittahad@gmail.com', 4),
('shaira.sheba@gmail.com', 5),
('md.sabbir.ullah@gmail.com', 5),
('mittahad@gmail.com', 6),
('samon@gmail.com', 6),
('shaira.sheba@gmail.com', 6),
('shaira.sheba@gmail.com', 7),
('swakkhar@cse.uiu.ac.bd', 7);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `Email` varchar(100) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Image` varchar(100) DEFAULT 'user.jpg',
  `Password` varchar(100) DEFAULT NULL,
  `DOB` date NOT NULL,
  `Phone` varchar(30) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Bio` text NOT NULL,
  `Position` varchar(255) NOT NULL,
  `Organization` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Email`, `Name`, `Image`, `Password`, `DOB`, `Phone`, `Address`, `Bio`, `Position`, `Organization`) VALUES
('md.sabbir.ullah@gmail.com', 'Md. Sabbir Ullah', '596.jpg', 'e10adc3949ba59abbe56e057f20f883e', '1994-01-03', '01711111111', 'Keraniganj, Dhaka', 'Studying Computer Science and Engineering Studying Computer Science and Engineering Studying Computer Science and Engineering Studying Computer Science and Engineering Studying Computer Science and Engineering Studying Computer Science and Engineering Studying Computer Science and Engineering ', 'Undergrad Assistant, CSE student', 'United International University'),
('mittahad@gmail.com', 'Md. Ittahad Uz Zaman', '232.jpg', 'e10adc3949ba59abbe56e057f20f883e', '1995-09-10', '01711111111', 'Niketon, Gulshan, Dhaka', 'Studying Computer Science and Engineering Studying Computer Science and Engineering Studying Computer Science and Engineering Studying Computer Science and Engineering Studying Computer Science and Engineering Studying Computer Science and Engineering Studying Computer Science and Engineering ', 'Undergrad Assistant, CSE student', 'United International University'),
('samon@gmail.com', 'Samsun Nahar', '197.jpg', 'e10adc3949ba59abbe56e057f20f883e', '1996-03-03', '01711111111', 'Siddique Bazar, Old Dhaka', 'Studying Computer Science and Engineering Studying Computer Science and Engineering Studying Computer Science and Engineering Studying Computer Science and Engineering Studying Computer Science and Engineering Studying Computer Science and Engineering Studying Computer Science and Engineering Studying Computer Science and Engineering ', 'CSE student', 'United International University'),
('shaira.sheba@gmail.com', 'Shaira Tabassum', '372.png', 'e10adc3949ba59abbe56e057f20f883e', '1995-11-10', '01711111111', 'Baridhara J Block, Natunbazar, Dhaka', 'Studying Computer Science and Engineering Studying Computer Science and Engineering Studying Computer Science and Engineering Studying Computer Science and Engineering Studying Computer Science and Engineering Studying Computer Science and Engineering Studying Computer Science and Engineering ', 'Undergrad Assistant, CSE student', 'United International University'),
('swakkhar@cse.uiu.ac.bd', 'Swakkhar Shatabda', '277.jpg', 'e10adc3949ba59abbe56e057f20f883e', '1980-01-16', '01711111111', 'United City, Madani Avenue, Badda, Dhaka 1212', 'Dr. Shatabda is Associate Professor and Undergraduate Program Co-ordinator of Computer Science and Engineering Department. He achieved his Ph. D degree from the Institute for Integrated and Intelligent Systems (IIIS), Griffith University in 2014. His thesis is titled â€œLocal Search Heuristics for Protein Structure Predictionâ€.  He completed his BSc. in Computer Science and Engineering from Bangladesh University of Engineering and Technology (BUET) in 2007. Research interest of Dr. Shatabda includes bioinformatics, optimization, search and meta-heuristics, data Mining, constraint programming, approximation Algorithms and graph theory. He has a number of quality publications in both national and international conferences and journals. He has worked as Graduate Researcher in Queensland Research Laboratory, NICTA, Australia. Prior entering the teaching line he worked  as a Software Engineer in Vonair Inc, Bangladesh.', 'Associate Professor ', 'United International University');

-- --------------------------------------------------------

--
-- Table structure for table `watchlist`
--

CREATE TABLE `watchlist` (
  `Email` varchar(100) DEFAULT NULL,
  `MaterialID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `watchlist`
--

INSERT INTO `watchlist` (`Email`, `MaterialID`) VALUES
('samon@gmail.com', 42),
('samon@gmail.com', 43),
('samon@gmail.com', 44),
('shaira.sheba@gmail.com', 43),
('shaira.sheba@gmail.com', 45),
('shaira.sheba@gmail.com', 46),
('shaira.sheba@gmail.com', 54),
('shaira.sheba@gmail.com', 55);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `channel`
--
ALTER TABLE `channel`
  ADD PRIMARY KEY (`ChannelID`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`CourseID`);

--
-- Indexes for table `material`
--
ALTER TABLE `material`
  ADD PRIMARY KEY (`MaterialID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `channel`
--
ALTER TABLE `channel`
  MODIFY `ChannelID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `CourseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `material`
--
ALTER TABLE `material`
  MODIFY `MaterialID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
