-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2024 at 07:55 AM
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
-- Database: `uap_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_type`
--

CREATE TABLE `account_type` (
  `account_type_id` int(11) NOT NULL,
  `account_type_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account_type`
--

INSERT INTO `account_type` (`account_type_id`, `account_type_name`) VALUES
(1, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `member_id` int(11) NOT NULL,
  `account_type_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `membership_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`member_id`, `account_type_id`, `name`, `email`, `password`, `membership_date`) VALUES
(27, 1, 'Ezio Auditore', 'ezio', '$2y$10$/iW36sUvATEjVJGM2S42I.XRWtVxNOCBXQdiLDysozRdzADThnAHW', '2024-03-03'),
(31, NULL, 'Bob Anderson', 'bob', '$2y$10$baEQBBEhH/1wMSiJqC3rJOxeZU1rsFk3pCpEsJWayr7PAY5S4BG9W', '1999-03-03'),
(41, NULL, 'Aldrin Montefalcon', 'aldrin', '$2y$10$zfody3SunvTIP2ayXORQve/jlgZ5d8VbmsAr9vNAPwHo6VOK.SMDa', '2024-03-07');

-- --------------------------------------------------------

--
-- Table structure for table `membership`
--

CREATE TABLE `membership` (
  `membership_fee_id` int(11) NOT NULL,
  `membership_fee` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `membership`
--

INSERT INTO `membership` (`membership_fee_id`, `membership_fee`) VALUES
(1, 20);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `year_id` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `member_id`, `year_id`, `status`) VALUES
(95, 31, 2, 'PAID'),
(96, 31, 3, 'PAID'),
(97, 31, 4, 'PAID'),
(98, 31, 5, 'PAID'),
(99, 31, 6, 'PAID'),
(100, 31, 7, 'PAID'),
(101, 31, 8, 'PAID'),
(102, 31, 9, 'PAID'),
(104, 31, 11, 'PAID'),
(105, 31, 12, 'PAID'),
(106, 31, 13, 'PAID'),
(107, 31, 14, 'PAID'),
(108, 31, 15, 'PAID'),
(109, 31, 16, 'PAID'),
(130, 28, 18, 'PAID'),
(131, 28, 19, 'PAID'),
(132, 28, 20, 'PAID'),
(133, 28, 24, 'PAID'),
(134, 28, 25, 'PAID'),
(138, 28, 29, 'PAID'),
(139, 28, 30, 'PAID'),
(140, 28, 31, 'PAID'),
(144, 32, 18, 'PAID'),
(145, 32, 19, 'PAID'),
(146, 32, 20, 'PAID'),
(147, 32, 24, 'PAID'),
(148, 32, 25, 'PAID'),
(150, 32, 29, 'PAID'),
(151, 32, 30, 'PAID'),
(152, 32, 31, 'PAID'),
(156, 33, 18, 'PAID'),
(157, 33, 19, 'PAID'),
(158, 33, 20, 'PAID'),
(159, 33, 24, 'PAID'),
(160, 33, 25, 'PAID'),
(162, 33, 29, 'PAID'),
(163, 33, 30, 'PAID'),
(164, 33, 31, 'PAID'),
(178, 34, 18, 'PAID'),
(179, 34, 19, 'PAID'),
(180, 34, 20, 'PAID'),
(181, 34, 24, 'PAID'),
(182, 34, 25, 'PAID'),
(184, 34, 29, 'PAID'),
(185, 34, 30, 'PAID'),
(186, 34, 31, 'PAID'),
(191, 35, 18, 'PAID'),
(192, 35, 19, 'PAID'),
(193, 35, 20, 'PAID'),
(194, 35, 24, 'PAID'),
(195, 35, 25, 'PAID'),
(196, 35, 28, 'PAID'),
(197, 35, 29, 'PAID'),
(198, 35, 30, 'PAID'),
(199, 35, 31, 'PAID'),
(200, 35, 32, 'PAID'),
(204, 36, 18, 'PAID'),
(205, 36, 19, 'PAID'),
(206, 36, 20, 'PAID'),
(207, 36, 24, 'PAID'),
(208, 36, 25, 'PAID'),
(209, 36, 28, 'PAID'),
(210, 36, 29, 'PAID'),
(211, 36, 30, 'PAID'),
(212, 36, 31, 'PAID'),
(213, 36, 32, 'PAID'),
(232, 38, 18, 'PAID'),
(233, 38, 19, 'PAID'),
(234, 38, 20, 'PAID'),
(235, 38, 24, 'PAID'),
(236, 38, 25, 'PAID'),
(237, 38, 28, 'PAID'),
(238, 38, 29, 'PAID'),
(239, 38, 30, 'PAID'),
(240, 38, 31, 'PAID'),
(241, 38, 32, 'PAID'),
(264, 41, 18, 'PAID'),
(265, 41, 19, 'PAID'),
(266, 41, 20, 'PAID'),
(267, 41, 24, 'PAID'),
(268, 41, 25, 'PAID'),
(269, 41, 28, 'PAID'),
(270, 41, 29, 'PAID'),
(271, 41, 30, 'PAID'),
(272, 41, 31, 'PAID'),
(273, 41, 32, 'PAID'),
(280, 31, 18, 'PAID'),
(281, 31, 19, 'PAID'),
(282, 31, 20, 'PAID'),
(283, 31, 24, 'PAID'),
(284, 31, 25, 'PAID'),
(285, 31, 28, 'PAID'),
(286, 31, 29, 'PAID'),
(287, 31, 30, 'PAID'),
(288, 31, 31, 'PAID'),
(289, 31, 32, 'PAID'),
(312, 31, 63, 'PAID'),
(313, 31, 64, 'PAID'),
(314, 31, 65, 'PAID'),
(315, 31, 66, 'PAID'),
(318, 31, 69, 'PAID'),
(319, 31, 70, 'PAID'),
(320, 31, 71, 'PAID'),
(321, 31, 72, 'PAID'),
(322, 31, 73, 'PAID'),
(323, 31, 74, 'PAID'),
(324, 31, 75, 'PAID'),
(325, 31, 76, 'PAID'),
(326, 31, 77, 'PAID'),
(341, 41, 63, 'PAID'),
(342, 41, 64, 'PAID'),
(343, 41, 65, 'PAID'),
(344, 41, 66, 'PAID'),
(345, 41, 69, 'PAID'),
(346, 41, 70, 'PAID'),
(347, 41, 71, 'PAID'),
(348, 41, 72, 'PAID'),
(349, 41, 73, 'PAID'),
(350, 41, 74, 'PAID'),
(351, 41, 75, 'PAID'),
(352, 41, 76, 'PAID'),
(353, 41, 77, 'PAID'),
(363, 41, 95, 'PAID'),
(364, 41, 96, 'PAID'),
(365, 31, 95, 'PAID'),
(366, 31, 96, 'PAID'),
(367, 31, 97, 'PAID'),
(368, 31, 98, 'PAID'),
(369, 41, 97, 'PAID'),
(370, 41, 98, 'PAID'),
(371, 41, 99, 'PAID'),
(372, 31, 99, 'PAID'),
(373, 41, 100, 'PAID');

-- --------------------------------------------------------

--
-- Table structure for table `years`
--

CREATE TABLE `years` (
  `year_id` int(11) NOT NULL,
  `year_value` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `years`
--

INSERT INTO `years` (`year_id`, `year_value`) VALUES
(2, '2001'),
(3, '2002'),
(4, '2003'),
(5, '2004'),
(6, '2005'),
(7, '2006'),
(8, '2007'),
(9, '2008'),
(11, '2010'),
(12, '2011'),
(13, '2012'),
(14, '2013'),
(15, '2014'),
(16, '2015'),
(18, '2024'),
(19, '2025'),
(20, '2026'),
(24, '2027'),
(25, '2028'),
(28, '2029'),
(29, '2030'),
(30, '2031'),
(31, '2032'),
(32, '2033'),
(63, '2034'),
(64, '2035'),
(65, '2036'),
(66, '2037'),
(69, '2038'),
(70, '2039'),
(71, '2040'),
(72, '2041'),
(73, '2042'),
(74, '2043'),
(75, '2044'),
(76, '2045'),
(77, '2046'),
(95, '2047'),
(96, '2048'),
(97, '2049'),
(98, '2050'),
(99, '2051'),
(100, '2052');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_type`
--
ALTER TABLE `account_type`
  ADD PRIMARY KEY (`account_type_id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`member_id`),
  ADD KEY `members_ibfk_1` (`account_type_id`);

--
-- Indexes for table `membership`
--
ALTER TABLE `membership`
  ADD PRIMARY KEY (`membership_fee_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `year_id` (`year_id`),
  ADD KEY `payments_ibfk_1` (`member_id`);

--
-- Indexes for table `years`
--
ALTER TABLE `years`
  ADD PRIMARY KEY (`year_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_type`
--
ALTER TABLE `account_type`
  MODIFY `account_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `membership`
--
ALTER TABLE `membership`
  MODIFY `membership_fee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=374;

--
-- AUTO_INCREMENT for table `years`
--
ALTER TABLE `years`
  MODIFY `year_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
