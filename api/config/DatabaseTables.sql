-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 08, 2020 at 09:54 AM
-- Server version: 8.0.18
-- PHP Version: 7.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `usermanagement`
--

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `Company_ID` int(11) NOT NULL,
  `Company_Name` varchar(50) NOT NULL,
  `Company_rank` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`Company_ID`, `Company_Name`, `Company_rank`) VALUES
(8, 'ala bala porto', 'Principal'),
(9, 'ala ba', 'Secondary');

-- --------------------------------------------------------

--
-- Table structure for table `company_adress`
--

CREATE TABLE `company_adress` (
  `Company_ID` int(11) NOT NULL,
  `Main_Country` varchar(50) NOT NULL,
  `Main_City` varchar(50) NOT NULL,
  `Main_Street` varchar(50) NOT NULL,
  `Main_number` varchar(50) NOT NULL,
  `Secondary_Country` varchar(50) DEFAULT NULL,
  `Secondary_City` varchar(50) DEFAULT NULL,
  `Secondary_Street` varchar(50) DEFAULT NULL,
  `Secondary_number` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `company_adress`
--

INSERT INTO `company_adress` (`Company_ID`, `Main_Country`, `Main_City`, `Main_Street`, `Main_number`, `Secondary_Country`, `Secondary_City`, `Secondary_Street`, `Secondary_number`) VALUES
(8, 'Romania', 'Oradea', 'xcvxv', 'xcvxv', 'p', 'f', 'd', 's'),
(9, 'Cluj', 'Iasi', 'xcvxv', 'xcvxv', 'p', 'f', 'd', 's');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `User_ID` int(11) NOT NULL,
  `personal_id_number` varchar(50) NOT NULL,
  `First_name` varchar(50) NOT NULL,
  `Last_name` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`User_ID`, `personal_id_number`, `First_name`, `Last_name`, `Email`, `Password`) VALUES
(2, '1234', 'Marius', 'Andro', 'marius@marius.com', '456f'),
(3, '1234567', 'Andreea Ioana', 'Neacsu', 'andreea@abc.com', 'asdf'),
(8, '456', 'Ion', 'Pop', 'pop@pop.c', 'aaa');

-- --------------------------------------------------------

--
-- Table structure for table `users_adress`
--

CREATE TABLE `users_adress` (
  `User_ID` varchar(50) NOT NULL,
  `Country` varchar(50) NOT NULL,
  `City` varchar(50) NOT NULL,
  `Street` varchar(50) NOT NULL,
  `Number` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users_adress`
--

INSERT INTO `users_adress` (`User_ID`, `Country`, `City`, `Street`, `Number`) VALUES
('2', 'Romania', 'Oradea', 'Republicii', '1'),
('3', 'Ro', 'Cluj', 'df', 's'),
('8', 'Romania', 'Cluj', 'Horea', '1');

-- --------------------------------------------------------

--
-- Table structure for table `users_company`
--

CREATE TABLE `users_company` (
  `User_ID` int(11) NOT NULL,
  `Company_ID` int(11) NOT NULL,
  `User_Rank` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users_company`
--

INSERT INTO `users_company` (`User_ID`, `Company_ID`, `User_Rank`) VALUES
(2, 8, 'Administrator'),
(3, 8, 'User'),
(8, 9, 'Administrator');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`Company_ID`);

--
-- Indexes for table `company_adress`
--
ALTER TABLE `company_adress`
  ADD PRIMARY KEY (`Company_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`User_ID`);

--
-- Indexes for table `users_adress`
--
ALTER TABLE `users_adress`
  ADD PRIMARY KEY (`User_ID`);

--
-- Indexes for table `users_company`
--
ALTER TABLE `users_company`
  ADD PRIMARY KEY (`User_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `Company_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

