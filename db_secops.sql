-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 09, 2026 at 10:25 AM
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
-- Database: `db.secops`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `log_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `timestamp` datetime DEFAULT current_timestamp(),
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `target_id` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'success',
  `action_type` enum('CREATE','UPDATE','DELETE','LOGIN','LOGOUT') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`log_id`, `user_id`, `action`, `timestamp`, `ip_address`, `user_agent`, `target_id`, `status`, `action_type`) VALUES
(1, 10, 'เปลี่ยนสิทธิ์เป็น user', '2026-03-09 10:51:49', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 2, 'success', 'CREATE'),
(2, 10, 'ออกจากระบบ', '2026-03-09 14:36:06', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, 'success', 'LOGOUT'),
(3, 10, 'เข้าสู่ระบบสำเร็จ', '2026-03-09 14:36:10', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, 'success', 'LOGIN'),
(4, 10, 'ออกจากระบบ', '2026-03-09 14:49:49', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, 'success', 'LOGOUT'),
(5, 9, 'เข้าสู่ระบบสำเร็จ', '2026-03-09 14:50:14', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, 'success', 'LOGIN'),
(6, 9, 'ออกจากระบบ', '2026-03-09 14:53:21', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, 'success', 'LOGOUT'),
(7, 9, 'เข้าสู่ระบบสำเร็จ', '2026-03-09 14:53:33', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, 'success', 'LOGIN'),
(8, 9, 'ออกจากระบบ', '2026-03-09 14:55:13', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, 'success', 'LOGOUT'),
(9, 11, 'เข้าสู่ระบบสำเร็จ', '2026-03-09 14:55:26', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, 'success', 'LOGIN'),
(10, 11, 'ออกจากระบบ', '2026-03-09 14:58:05', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, 'success', 'LOGOUT'),
(11, 11, 'เข้าสู่ระบบสำเร็จ', '2026-03-09 14:58:17', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, 'success', 'LOGIN'),
(12, 11, 'ลบผู้ใช้งานรหัส 1', '2026-03-09 15:05:59', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 1, 'success', 'DELETE');

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE `permission` (
  `user_id` int(11) NOT NULL,
  `permission` varchar(20) NOT NULL,
  `edit` text NOT NULL,
  `view` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `user_id` int(11) NOT NULL,
  `m_level` varchar(20) NOT NULL,
  `admin` varchar(20) NOT NULL,
  `user` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `table_data`
--

CREATE TABLE `table_data` (
  `data_id` int(11) NOT NULL,
  `permission` varchar(20) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `action` varchar(60) NOT NULL,
  `source_ip` varchar(20) NOT NULL,
  `port` varchar(20) NOT NULL,
  `result` varchar(30) NOT NULL,
  `detail` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(500) NOT NULL,
  `m_level` varchar(20) NOT NULL COMMENT 'admin,user',
  `name` varchar(50) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `m_level`, `name`, `time`) VALUES
(2, 'lisa', '$2y$10$kZzBu/9pf7sK4rjiEpgVaufSqfIU6Uom5/1xN6JZX2vkAufQKtCde', 'user', 'Lisa list', '2026-03-09 03:02:26'),
(3, 'alanw', '$2y$10$CQCz/tkEPRTObHFsmrUHqe4s0rMAnDPyuiPfdQ4WARh3Zx/3T56bq', 'user', 'Alan Walker', '2026-03-09 03:02:22'),
(4, 'love', '$2y$10$E5yGferHk496klqsbmgMB.AGAC6d8J1zXG2N4Ccc/SUbc0Su.U6vG', 'user', 'Love Love', '2026-02-26 08:09:01'),
(5, 'lala', '$2y$10$g6EbvIvsG7Sjf0gZSWgBRe5PMwVIz5eZViBcfNBoaOGxFmQadoFyy', 'user', 'lala lulu', '2026-02-26 08:09:01'),
(7, 'stars', '$2y$10$wOQtTnwB8LEbjgtHXChs3eqRQzkTu0H8WTbb.giGcMj54NVtkxaY2', 'user', 'Stars Moon', '2026-03-02 08:07:43'),
(8, 'alan', '$2y$10$tFzM/4n8DgaVDEO1g.k/DuEHys7.xPPbTBMD2qiZzd4RKTHXldPX6', 'user', 'Alan Walker', '2026-03-09 03:02:15'),
(9, 'robot', '$2y$10$9MAbRVXMVUzkd5olQG2Y1eY8k2cuJMcPsaKIbIa19kAiN1BRLaO2K', 'user', 'Iam Robot', '2026-03-03 09:24:29'),
(10, 'test01', '$2y$10$M7z7U78qKuXdTHS5ng7GbOlW0WNP.8jW9H3UvJ8ObkdBv6cXRw9dG', 'admin', 'test 01', '2026-03-03 09:42:56'),
(11, 'test2', '$2y$10$DUsRlIZcAbFRGEVfV585j.4HMlofUO94xDFYjjuzzcT/pYdMijNwi', 'admin', 'tester 02', '2026-03-09 06:50:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `permission` (`permission`),
  ADD KEY `m_level` (`permission`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD KEY `m_level` (`m_level`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `admin` (`admin`,`user`),
  ADD KEY `user` (`user`);

--
-- Indexes for table `table_data`
--
ALTER TABLE `table_data`
  ADD PRIMARY KEY (`data_id`),
  ADD KEY `permission` (`permission`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `password` (`password`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `m_level` (`m_level`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `permission`
--
ALTER TABLE `permission`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `table_data`
--
ALTER TABLE `table_data`
  MODIFY `data_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `permission`
--
ALTER TABLE `permission`
  ADD CONSTRAINT `role` FOREIGN KEY (`permission`) REFERENCES `user` (`m_level`);

--
-- Constraints for table `roles`
--
ALTER TABLE `roles`
  ADD CONSTRAINT `admin` FOREIGN KEY (`admin`) REFERENCES `user` (`m_level`),
  ADD CONSTRAINT `id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `permission` FOREIGN KEY (`m_level`) REFERENCES `user` (`m_level`),
  ADD CONSTRAINT `user` FOREIGN KEY (`user`) REFERENCES `user` (`m_level`);

--
-- Constraints for table `table_data`
--
ALTER TABLE `table_data`
  ADD CONSTRAINT `data` FOREIGN KEY (`permission`) REFERENCES `permission` (`permission`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
