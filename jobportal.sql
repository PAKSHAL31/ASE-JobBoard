-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2020 at 06:08 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`company_no`, `company_email`, `company_pass`, `company_name`, `company_phnumber`, `verified`) VALUES
(1, 'jobmix@gmail.com', '$2y$10$xbgLDfBiE3xtrM4hQCu0wecG8NcaNwnlHQ8IX0ceYliIffo/G3KOS', 'JOBMIX', '8574231120', 1),
(2, 'platoteam@gmail.com', '$2y$10$m5yz0KQfdqi8vpWDC27e8OrO.K6KfjREzYozdcUjX3cg7oKXzfby6', 'PlatoTeam', '9874561231', 1),
(3, 'globex@yahoo.com', '$2y$10$T7hGaUm4YMM6zBD/4CuUOuUjnBut7bc8D5rwt/2wGokZO76IMXLFW', 'Globex ', '8745612391', 1),
(4, 'xyz@yahoo.com', '$2y$10$YzGYqLLghPI5SxxQkyi2fevJvfzKSLzgOzQUm.7qPAcEtG3iq1RBS', 'XYZ', '7854213651', 0);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`emp_no`, `emp_email`, `emp_password`, `emp_phnumber`, `emp_name`, `emp_cv`, `emp_cvlink`) VALUES
(1, 'ranawatpakshal31@gmail.com', '$2y$10$t.uQLjPEHbeaeGJCCRZXQekJSC8S.zScisTMql8EQ7IduPE0jjT5y', '9612354783', 'Pakshal Ranawat', 0, ''),
(2, 'jivin123@gmail.com', '$2y$10$uXanq0z28LXYQ77vnkPUPu10pxXm1eCj0FpdHkhxtyhHcDSu8Oyfa', '8523641234', 'Jivin Varghesse', 1, 'https://drive.google.com/file/d/1gHgrq1gbzJW6P-t0Qo5_Lbu-YZGL8iXf/view?usp=sharing'),
(3, 'tejasredkar@yahoo.com', '$2y$10$Una6ltYu4jyGzbhtisE/iO5EWGk/bONDb7A3LE/3BlwZQhU5JQJl2', '9773829597', 'Tejas Redkar', 0, ''),
(4, 'aakash41@gmail.com', '$2y$10$6Ka1IOb.u7EnDzXNf1Q7X.BD8TNUFu619vgWUDBoUIym/ER5jCCpS', '8452312345', 'Aakash Shetty', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `employee_job`
--

CREATE TABLE `employee_job` (
  `inc_no` int(11) NOT NULL,
  `emp_no` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `ar_val` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employee_job`
--

INSERT INTO `employee_job` (`inc_no`, `emp_no`, `job_id`, `ar_val`) VALUES
(1, 1, 1, 1),
(2, 1, 48, -1),
(6, 1, 47, 0),
(9, 2, 8, -1),
(10, 3, 8, 0),
(12, 2, 1, 1),
(13, 1, 53, 1);

-- --------------------------------------------------------

--
-- Table structure for table `postajob`
--

CREATE TABLE `postajob` (
  `job_id` int(11) NOT NULL,
  `job_position` varchar(100) NOT NULL,
  `job_location` varchar(50) NOT NULL,
  `job_type` varchar(20) NOT NULL,
  `company_no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `postajob`
--

INSERT INTO `postajob` (`job_id`, `job_position`, `job_location`, `job_type`, `company_no`) VALUES
(1, 'Full Stack Developer', 'Mumbai', 'Part Time', 1),
(8, 'UI/UX Designer', 'Andheri', 'Full Time', 1),
(30, 'Front End Developer', 'Thane', 'Internship', 3),
(47, 'Data Scientist', 'Mumbai', 'Internship', 3),
(48, 'Software Developer', 'Thane', 'Freelancer', 1),
(49, 'Database Administrator', 'Kurla', 'Full Time', 3),
(51, 'Full Stack Developer', 'Andheri', 'Part Time', 3),
(53, 'Full Stack Developer', 'Mumbai', 'Full Time', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`company_no`);

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
  MODIFY `company_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `emp_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `employee_job`
--
ALTER TABLE `employee_job`
  MODIFY `inc_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `postajob`
--
ALTER TABLE `postajob`
  MODIFY `job_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
