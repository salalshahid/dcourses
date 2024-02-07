-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2023 at 09:24 AM
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
-- Database: `dcourses`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` varchar(100) NOT NULL,
  `updates` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `photo`, `name`, `price`, `updates`) VALUES
(1, 'img/1698114165.4_1697529392.6518_1696549943.7984_dwindows.jpg', 'Windows for Beginners', '10', '2023-10-24 02:22:45'),
(2, 'img/1698114186.5539_1697605948.9298_a.jpg', 'html for beginners', '15', '2023-10-24 02:23:06');

-- --------------------------------------------------------

--
-- Table structure for table `lectures`
--

CREATE TABLE `lectures` (
  `id` int(11) NOT NULL,
  `cid` varchar(100) NOT NULL,
  `yid` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `mark` varchar(100) NOT NULL,
  `updates` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lectures`
--

INSERT INTO `lectures` (`id`, `cid`, `yid`, `title`, `mark`, `updates`) VALUES
(1, '1', 'C68BCWiKB3c', 'desktop and taskbar', '', '2023-10-24 04:38:10'),
(2, '1', 'p8kN5cKAzTA', 'taskbar options', '', '2023-10-24 04:45:32'),
(3, '1', '-ZaKAdBU4wQ', 'start button options', '', '2023-10-24 04:45:32'),
(4, '1', 'p9Uo8nRPigo', 'connect mobile', '', '2023-10-24 04:47:15'),
(5, '1', 'Vp1szWxF4gw', 'android internet', '', '2023-10-24 04:47:15'),
(6, '1', '05bNw1YQHo', 'install and uninstall ', '', '2023-10-24 04:47:16'),
(7, '2', 'p9Uo8nRPigo', 'part 1', '', '2023-10-24 05:44:33'),
(8, '2', 'p9Uo8nRPigo', 'part 2', '', '2023-10-24 05:44:33'),
(9, '2', 'p9Uo8nRPigo', 'part  3', '', '2023-10-24 05:44:33');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `id` int(11) UNSIGNED NOT NULL,
  `photo` varchar(100) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(200) NOT NULL,
  `reset` varchar(200) NOT NULL,
  `updates` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`id`, `photo`, `name`, `email`, `password`, `reset`, `updates`) VALUES
(1, 'img/user.png', 'admin', 'admin@admin.com', '$2y$10$z2mB7Rg9RcDd6EOyZg3NCe8oH1BjAmObaM.vl9Smn4L8ONn7z.BAa', '', '2023-10-24 01:57:08'),
(2, 'img/user.png', 'Raja', 'r@r.com', '$2y$10$N48Gsf4ZLk6mE6/IgVY/q.mPMeBaT1qQZ6Ba9x7uiQWm0fW/8DKw.', '', '2023-10-24 06:22:26'),
(3, 'img/user.png', 'Baba', 'b@b.com', '$2y$10$IGiur9tIahXeadXmLllb..gCGNdPpAx0TNgIfuER/XQlOh2kSyuMO', '', '2023-10-24 06:47:26');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) UNSIGNED NOT NULL,
  `option` varchar(50) NOT NULL,
  `features` varchar(50) NOT NULL,
  `action` varchar(11) NOT NULL,
  `updates` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `option`, `features`, `action`, `updates`) VALUES
(1, 'settings', 'header', 'dcourses', '2022-09-10 19:29:44');

-- --------------------------------------------------------

--
-- Table structure for table `vip`
--

CREATE TABLE `vip` (
  `id` int(11) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `mid` varchar(100) NOT NULL,
  `cid` varchar(100) NOT NULL,
  `course` varchar(100) NOT NULL,
  `price` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `updates` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vip`
--

INSERT INTO `vip` (`id`, `photo`, `mid`, `cid`, `course`, `price`, `status`, `updates`) VALUES
(1, 'img/1698114186.5539_1697605948.9298_a.jpg', '1', '2', 'html for beginners', '15', 'in process', '2023-10-24 06:40:29'),
(5, 'img/1698114165.4_1697529392.6518_1696549943.7984_dwindows.jpg', '2', '1', 'Windows for Beginners', '10', 'active', '2023-10-24 06:35:54'),
(6, 'img/1698114186.5539_1697605948.9298_a.jpg', '2', '2', 'html for beginners', '15', 'in process', '2023-10-24 06:40:29'),
(7, 'img/1698114186.5539_1697605948.9298_a.jpg', '3', '2', 'html for beginners', '15', 'in process', '2023-10-24 07:02:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lectures`
--
ALTER TABLE `lectures`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vip`
--
ALTER TABLE `vip`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `lectures`
--
ALTER TABLE `lectures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vip`
--
ALTER TABLE `vip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
