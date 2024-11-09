-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2024 at 05:42 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jobportal`
--

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `company_no` int(11) NOT NULL,
  `company_email` varchar(20) NOT NULL,
  `company_pass` varchar(300) NOT NULL,
  `company_name` varchar(30) NOT NULL,
  `company_phnumber` varchar(10) NOT NULL,
  `verified` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`company_no`, `company_email`, `company_pass`, `company_name`, `company_phnumber`, `verified`) VALUES
(1, 'jobx@gmail.com', '$2y$10$w1EX0mFxP.xn.MGTqWl6v.OHfyNHXHTncqgk4gNTCcZdm.SN.6wE.', 'JOBX', '6825219936', 1),
(2, 'abcX@gmail.com', '$2y$10$MWvjst3ZgkSw3u6oJ6A98.kUiOoDIQeI1IygSZF311.eAkvYj1luO', 'ABCx`', '6825219937', 1),
(3, 'xyz@gmail.com', '$2y$10$keKn1LZtPGwavJqxHx/HQezBd7yOICQ0rW4UG70Tze56XLkOBGRkS', 'XYZ', '6825219936', 1),
(4, 'xyz5432@example.com', '$2y$10$ArzW7W.9oS4Gbz8OaC9AX.sSgObmg5KKcR9xmn7V.SvJ2L9SdoWuC', 'XYZ 5432', '1234567890', 0),
(5, 'xyz2268@example.com', '$2y$10$rOax7PiiO8gPy2VbMoVNeOGhkhpZewqPYOt5zYhTMc.Tkt2BycYbO', 'XYZ 2268', '1234567890', 1);

-- --------------------------------------------------------

--
-- Table structure for table `company_reviews`
--

CREATE TABLE `company_reviews` (
  `id` int(11) NOT NULL,
  `company_no` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `commentDescription` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `company_reviews`
--

INSERT INTO `company_reviews` (`id`, `company_no`, `rating`, `commentDescription`, `created_at`) VALUES
(1, 1, 2, ' tbtbthbthbt', '2024-10-20 23:52:17'),
(2, 1, 1, 'sadsw', '2024-11-07 00:13:36');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `emp_no` int(11) NOT NULL,
  `emp_email` varchar(40) NOT NULL,
  `emp_password` varchar(300) NOT NULL,
  `emp_phnumber` varchar(10) NOT NULL,
  `emp_name` varchar(30) NOT NULL,
  `emp_cv` int(11) NOT NULL,
  `emp_cvlink` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`emp_no`, `emp_email`, `emp_password`, `emp_phnumber`, `emp_name`, `emp_cv`, `emp_cvlink`) VALUES
(1, 'pakshal@gmail.com', '$2y$10$go86WtNvm0RyqH5EYvocAehskrPoAzRWH2VfycQsj6A4N6eF3kZyK', '6825219939', 'Pakshal Ranawat', 0, ''),
(2, 'pranav@gmail.com', '$2y$10$FZ36rexLUJYAjX4YjasY6OpIZzfris0LSzQOYZVf0BH1UcOCQbdO2', '6825219934', 'Pranav Reddy', 0, ''),
(3, 'keshav@gmail.com', '$2y$10$KClqszvAmhcih68Nl9EXN.N0KnRi960tHopaZStpbHLnrnZT6FkqW', '6825219936', 'Keshav Harish Rohan', 0, ''),
(4, 'user3108@example.com', '$2y$10$VS.y4yaYjBu9Y7T2Jl8AjOUokNbPjgEkxdtwnvRtW79c/VXyYRwmy', '1234567890', 'New User', 0, ''),
(5, 'user3109@example.com', '$2y$10$zOk0yW1ZOMOyPuGNsX9fo..F1515cVr3UjlTe15sQ3niMNPE308Lq', '1234567890', 'New User', 0, ''),
(6, 'user3826@example.com', '$2y$10$431wzQbV42v31NJQbJr3d.cV0DOr7joRHzIU/TKSUT4yJbLZKP/92', '1234567890', 'New User', 0, ''),
(7, 'user9664@example.com', '$2y$10$Vq.yEYRt/6xbtiJPIzhAuumL.qoyvwYpaGrXRoQzkIVzLLwejGaie', '1234567890', 'User 9664', 0, ''),
(8, 'user1285@example.com', '$2y$10$DeY/fM5mLbZaF5oSKkgMZeDvftAUMRDWCP/D5mzbc0Ns/4H/g4KCy', '1234567890', 'User 1285', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `employee_job`
--

CREATE TABLE `employee_job` (
  `inc_no` int(11) NOT NULL,
  `emp_no` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `dob` date DEFAULT NULL,
  `resume` varchar(255) NOT NULL,
  `ar_val` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_job`
--

INSERT INTO `employee_job` (`inc_no`, `emp_no`, `job_id`, `name`, `dob`, `resume`, `ar_val`) VALUES
(1, 2, 1, 'Pranav ', '2020-06-20', '../uploads/resume_2_job_1_1729468306.pdf', 0),
(5, 5, 3, 'John Doe', '1990-01-01', '../uploads/resume_5_job_3_1730605596.pdf', 0),
(6, 8, 5, 'John Doe', '1990-01-01', '../uploads/resume_8_job_5_1730943673.pdf', 0),
(7, 5, 4, 'Pakshal', '2024-11-05', '../uploads/resume_5_job_4_1731168901.pdf', 1);

-- --------------------------------------------------------

--
-- Table structure for table `postajob`
--

CREATE TABLE `postajob` (
  `job_id` int(11) NOT NULL,
  `job_position` varchar(100) NOT NULL,
  `job_location` varchar(50) NOT NULL,
  `job_description` text NOT NULL,
  `job_type` varchar(20) NOT NULL,
  `company_no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `postajob`
--

INSERT INTO `postajob` (`job_id`, `job_position`, `job_location`, `job_description`, `job_type`, `company_no`) VALUES
(3, 'Software Engineer', 'Remote', 'Looking for a skilled Software Engineer.', 'Full Time', 1),
(4, 'Software Engineer', 'Arlington TX', 'Looking for a skilled Software Engineer.', 'Part Time', 1),
(5, 'Cloud Computing', 'Arlington TX', 'Looking for a skilled Cloud Computing Engineer.', 'Part Time', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`company_no`);

--
-- Indexes for table `company_reviews`
--
ALTER TABLE `company_reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`emp_no`);

--
-- Indexes for table `employee_job`
--
ALTER TABLE `employee_job`
  ADD PRIMARY KEY (`inc_no`);

--
-- Indexes for table `postajob`
--
ALTER TABLE `postajob`
  ADD PRIMARY KEY (`job_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `company_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `company_reviews`
--
ALTER TABLE `company_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `emp_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `employee_job`
--
ALTER TABLE `employee_job`
  MODIFY `inc_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `postajob`
--
ALTER TABLE `postajob`
  MODIFY `job_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
