-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2026 at 09:01 PM
-- Server version: 10.4.32-MariaDB-log
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
  `target_name` varchar(50) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'success',
  `action_type` enum('CREATE','UPDATE','DELETE','LOGIN','LOGOUT') NOT NULL,
  `run_id` varchar(100) DEFAULT NULL,
  `source` varchar(50) DEFAULT 'manual'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`log_id`, `user_id`, `action`, `timestamp`, `ip_address`, `user_agent`, `target_id`, `target_name`, `status`, `action_type`, `run_id`, `source`) VALUES
(1, 10, 'เปลี่ยนสิทธิ์เป็น user', '2026-03-09 10:51:49', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 2, NULL, 'success', 'CREATE', NULL, 'manual'),
(2, 10, 'ออกจากระบบ', '2026-03-09 14:36:06', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGOUT', NULL, 'manual'),
(3, 10, 'เข้าสู่ระบบสำเร็จ', '2026-03-09 14:36:10', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(4, 10, 'ออกจากระบบ', '2026-03-09 14:49:49', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGOUT', NULL, 'manual'),
(5, 9, 'เข้าสู่ระบบสำเร็จ', '2026-03-09 14:50:14', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(6, 9, 'ออกจากระบบ', '2026-03-09 14:53:21', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGOUT', NULL, 'manual'),
(7, 9, 'เข้าสู่ระบบสำเร็จ', '2026-03-09 14:53:33', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(8, 9, 'ออกจากระบบ', '2026-03-09 14:55:13', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGOUT', NULL, 'manual'),
(9, 11, 'เข้าสู่ระบบสำเร็จ', '2026-03-09 14:55:26', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(10, 11, 'ออกจากระบบ', '2026-03-09 14:58:05', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGOUT', NULL, 'manual'),
(11, 11, 'เข้าสู่ระบบสำเร็จ', '2026-03-09 14:58:17', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(12, 11, 'ลบผู้ใช้งานรหัส 1', '2026-03-09 15:05:59', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 1, NULL, 'success', 'DELETE', NULL, 'manual'),
(13, 11, 'ออกจากระบบ', '2026-03-09 16:26:57', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGOUT', NULL, 'manual'),
(14, 11, 'เข้าสู่ระบบสำเร็จ', '2026-03-10 09:21:01', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(15, 11, 'ออกจากระบบ', '2026-03-10 11:03:50', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGOUT', NULL, 'manual'),
(16, 9, 'เข้าสู่ระบบสำเร็จ', '2026-03-10 11:04:09', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(17, 9, 'ออกจากระบบ', '2026-03-10 11:04:32', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGOUT', NULL, 'manual'),
(18, 9, 'เข้าสู่ระบบสำเร็จ', '2026-03-10 11:15:11', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(19, 9, 'เข้าสู่ระบบสำเร็จ', '2026-03-10 11:15:39', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(20, 9, 'เข้าสู่ระบบสำเร็จ', '2026-03-10 11:16:27', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(21, 9, 'ออกจากระบบ', '2026-03-10 11:16:44', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGOUT', NULL, 'manual'),
(22, 10, 'เข้าสู่ระบบสำเร็จ', '2026-03-10 11:16:54', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(23, 10, 'ออกจากระบบ', '2026-03-10 11:31:07', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGOUT', NULL, 'manual'),
(24, 10, 'เข้าสู่ระบบสำเร็จ', '2026-03-10 11:31:16', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(25, 10, 'ออกจากระบบ', '2026-03-10 11:37:12', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGOUT', NULL, 'manual'),
(26, 12, 'เข้าสู่ระบบสำเร็จ', '2026-03-10 11:37:47', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(27, 12, 'ออกจากระบบ', '2026-03-10 11:42:41', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGOUT', NULL, 'manual'),
(28, 10, 'เข้าสู่ระบบสำเร็จ', '2026-03-10 11:42:48', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(29, 10, 'ลบผู้ใช้งานรหัส 2', '2026-03-10 13:38:28', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 2, NULL, 'success', 'DELETE', NULL, 'manual'),
(30, 10, 'เปลี่ยนสิทธิ์ผู้ใช้รหัส 12 เป็น admin', '2026-03-10 13:38:33', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 12, NULL, 'success', 'UPDATE', NULL, 'manual'),
(31, 10, 'ลบผู้ใช้งานรหัส 5', '2026-03-10 14:02:21', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 5, NULL, 'success', 'DELETE', NULL, 'manual'),
(32, 10, 'ลบผู้ใช้งานรหัส 4', '2026-03-10 14:23:49', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'DELETE', NULL, 'manual'),
(33, 10, 'ลบผู้ใช้งานรหัส 4', '2026-03-10 14:23:49', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'UPDATE', NULL, 'manual'),
(34, 10, 'ลบผู้ใช้งานชื่อ: stars', '2026-03-10 14:30:05', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, 'stars', 'success', 'DELETE', NULL, 'manual'),
(35, 10, 'เปลี่ยนสิทธิ์ผู้ใช้ชื่อ test03 เป็น user', '2026-03-10 14:32:17', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 12, 'test03', 'success', 'UPDATE', NULL, 'manual'),
(36, 10, 'ออกจากระบบ', '2026-03-10 14:37:03', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGOUT', NULL, 'manual'),
(37, 13, 'สมัครสมาชิกใหม่ชื่อ: seasky', '2026-03-10 14:38:24', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, 'seasky', 'success', 'CREATE', NULL, 'manual'),
(38, 13, 'เข้าสู่ระบบสำเร็จ', '2026-03-10 14:38:36', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(39, 13, 'ออกจากระบบ', '2026-03-10 14:38:41', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGOUT', NULL, 'manual'),
(40, 10, 'เข้าสู่ระบบสำเร็จ', '2026-03-10 14:38:51', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(41, 10, 'เปลี่ยนสิทธิ์ผู้ใช้ชื่อ test03 เป็น admin', '2026-03-10 14:43:28', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 12, 'test03', 'success', 'UPDATE', NULL, 'manual'),
(42, 10, 'เปลี่ยนสิทธิ์ผู้ใช้ชื่อ seasky เป็น admin', '2026-03-10 14:46:27', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 13, 'seasky', 'success', 'UPDATE', NULL, 'manual'),
(43, 10, 'เปลี่ยนสิทธิ์ผู้ใช้ชื่อ seasky เป็น user', '2026-03-10 14:46:37', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 13, 'seasky', 'success', 'UPDATE', NULL, 'manual'),
(44, 10, 'ออกจากระบบ', '2026-03-10 15:00:23', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGOUT', NULL, 'manual'),
(45, 13, 'เข้าสู่ระบบสำเร็จ', '2026-03-10 15:00:38', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(46, 13, 'ออกจากระบบ', '2026-03-10 15:04:14', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGOUT', NULL, 'manual'),
(47, 11, 'เข้าสู่ระบบสำเร็จ', '2026-03-10 15:04:33', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(48, 9, 'เข้าสู่ระบบสำเร็จ', '2026-03-10 15:19:46', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(49, 9, 'ออกจากระบบ', '2026-03-10 15:23:29', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGOUT', NULL, 'manual'),
(50, 14, 'สมัครสมาชิกใหม่ชื่อ: kan007', '2026-03-10 15:50:57', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, 'kan007', 'success', 'CREATE', NULL, 'manual'),
(51, 14, 'เข้าสู่ระบบสำเร็จ', '2026-03-10 15:51:09', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(52, 14, 'ออกจากระบบ', '2026-03-10 15:51:27', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGOUT', NULL, 'manual'),
(53, 10, 'เข้าสู่ระบบสำเร็จ', '2026-03-10 15:51:37', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(54, 10, 'เปลี่ยนสิทธิ์ผู้ใช้ชื่อ kan007 เป็น admin', '2026-03-10 15:51:55', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 14, 'kan007', 'success', 'UPDATE', NULL, 'manual'),
(55, 10, 'ออกจากระบบ', '2026-03-10 15:55:20', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGOUT', NULL, 'manual'),
(56, 15, 'สมัครสมาชิกใหม่ชื่อ: kokoza555', '2026-03-10 16:18:38', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, 'kokoza555', 'success', 'CREATE', NULL, 'manual'),
(57, 15, 'เข้าสู่ระบบสำเร็จ', '2026-03-10 16:18:57', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(58, 15, 'ออกจากระบบ', '2026-03-10 16:19:04', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGOUT', NULL, 'manual'),
(59, 10, 'เข้าสู่ระบบสำเร็จ', '2026-03-10 16:19:12', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(60, 10, 'ออกจากระบบ', '2026-03-10 16:20:06', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGOUT', NULL, 'manual'),
(61, 16, 'สมัครสมาชิกใหม่ชื่อ: banana', '2026-03-10 16:21:26', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, 'banana', 'success', 'CREATE', NULL, 'manual'),
(62, 16, 'เข้าสู่ระบบสำเร็จ', '2026-03-10 16:21:39', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(63, 16, 'ออกจากระบบ', '2026-03-10 16:22:07', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGOUT', NULL, 'manual'),
(64, 10, 'เข้าสู่ระบบสำเร็จ', '2026-03-10 16:22:13', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(65, 10, 'เข้าสู่ระบบสำเร็จ', '2026-03-17 14:24:11', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(66, 10, 'ออกจากระบบ', '2026-03-17 14:37:09', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGOUT', NULL, 'manual'),
(67, 9, 'เข้าสู่ระบบสำเร็จ', '2026-03-17 16:09:01', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(68, 17, 'สมัครสมาชิกใหม่ชื่อ: pun', '2026-03-18 10:17:13', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, 'pun', 'success', 'CREATE', NULL, 'manual'),
(69, 17, 'เข้าสู่ระบบสำเร็จ', '2026-03-18 10:17:47', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(70, 17, 'ออกจากระบบ', '2026-03-18 11:31:41', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGOUT', NULL, 'manual'),
(71, 10, 'เข้าสู่ระบบสำเร็จ', '2026-03-18 14:14:28', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(72, 10, 'ลบผู้ใช้งานชื่อ: kan007', '2026-03-18 14:39:54', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, 'kan007', 'success', 'DELETE', NULL, 'manual'),
(73, 10, 'ออกจากระบบ', '2026-03-18 15:52:36', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGOUT', NULL, 'manual'),
(74, 9, 'เข้าสู่ระบบสำเร็จ', '2026-03-19 10:52:02', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(75, 9, 'ออกจากระบบ', '2026-03-19 11:20:42', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGOUT', NULL, 'manual'),
(76, 10, 'เข้าสู่ระบบสำเร็จ', '2026-03-19 13:10:38', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(77, 10, 'เข้าสู่ระบบสำเร็จ', '2026-03-23 09:36:44', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(78, 10, 'ออกจากระบบ', '2026-03-23 10:03:29', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGOUT', NULL, 'manual'),
(79, 10, 'เข้าสู่ระบบสำเร็จ', '2026-03-23 14:17:18', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(80, 10, 'เข้าสู่ระบบสำเร็จ', '2026-03-24 09:12:29', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(81, 10, 'ออกจากระบบ', '2026-03-24 14:36:33', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGOUT', NULL, 'manual'),
(82, 10, 'เข้าสู่ระบบสำเร็จ', '2026-03-25 09:39:10', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(83, 10, 'ออกจากระบบ', '2026-03-25 11:05:34', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGOUT', NULL, 'manual'),
(84, 10, 'เข้าสู่ระบบสำเร็จ', '2026-03-25 11:05:48', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(85, 10, 'ออกจากระบบ', '2026-03-25 11:06:19', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGOUT', NULL, 'manual'),
(86, 10, 'เข้าสู่ระบบสำเร็จ', '2026-03-25 11:07:18', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(87, 10, 'เข้าสู่ระบบสำเร็จ', '2026-03-25 11:11:17', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(88, 10, 'เข้าสู่ระบบสำเร็จ', '2026-03-25 11:14:24', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(89, 10, 'เข้าสู่ระบบสำเร็จ', '2026-03-25 11:16:04', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(90, 0, 'High', '2026-03-25 11:19:41', '192.168.1.100', NULL, NULL, 'Server-01', 'success', '', 'test-001', 'SOAR'),
(91, 9, 'เข้าสู่ระบบสำเร็จ', '2026-03-25 14:36:49', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(92, 9, 'ออกจากระบบ', '2026-03-25 14:50:25', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGOUT', NULL, 'manual'),
(93, 10, 'เข้าสู่ระบบสำเร็จ', '2026-03-25 14:51:51', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(94, 10, 'เข้าสู่ระบบสำเร็จ', '2026-03-26 10:44:27', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(95, 10, 'เข้าสู่ระบบสำเร็จ', '2026-03-26 13:08:34', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(96, 10, 'เข้าสู่ระบบสำเร็จ', '2026-03-27 09:24:18', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(97, 10, 'เข้าสู่ระบบสำเร็จ', '2026-04-01 09:20:19', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(98, 10, 'ออกจากระบบ', '2026-04-01 09:33:20', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGOUT', NULL, 'manual'),
(99, 10, 'เข้าสู่ระบบสำเร็จ', '2026-04-01 13:05:31', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(100, 10, 'ออกจากระบบ', '2026-04-01 13:26:59', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGOUT', NULL, 'manual'),
(101, 10, 'เข้าสู่ระบบสำเร็จ', '2026-04-01 14:47:30', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(102, 10, 'ออกจากระบบ', '2026-04-01 14:48:50', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGOUT', NULL, 'manual'),
(103, 10, 'เข้าสู่ระบบสำเร็จ', '2026-04-01 14:49:02', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(104, 10, 'ออกจากระบบ', '2026-04-01 15:47:59', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGOUT', NULL, 'manual'),
(105, 10, 'เข้าสู่ระบบสำเร็จ', '2026-04-01 15:54:16', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(106, 10, 'ออกจากระบบ', '2026-04-01 15:59:06', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGOUT', NULL, 'manual'),
(107, 10, 'เข้าสู่ระบบสำเร็จ', '2026-04-01 16:02:57', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(108, 10, 'ออกจากระบบ', '2026-04-01 16:15:44', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGOUT', NULL, 'manual'),
(109, 10, 'เข้าสู่ระบบสำเร็จ', '2026-04-01 16:21:02', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(110, 10, 'เข้าสู่ระบบสำเร็จ', '2026-04-02 09:08:07', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(111, 10, 'เข้าสู่ระบบสำเร็จ', '2026-04-03 09:36:29', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(112, 10, 'เข้าสู่ระบบสำเร็จ', '2026-04-05 22:45:56', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(113, 10, 'เข้าสู่ระบบสำเร็จ', '2026-04-14 18:38:08', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGIN', NULL, 'manual'),
(114, 10, 'ออกจากระบบ', '2026-04-14 19:20:36', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', NULL, NULL, 'success', 'LOGOUT', NULL, 'manual'),
(115, 8, 'Wrong password', '2026-04-14 23:24:53', '::1', NULL, NULL, 'alan', 'failed', '', NULL, 'application'),
(116, 8, 'Wrong password', '2026-04-14 23:25:02', '::1', NULL, NULL, 'alan', 'failed', '', NULL, 'application'),
(117, 8, 'Wrong password', '2026-04-14 23:25:11', '::1', NULL, NULL, 'alan', 'failed', '', NULL, 'application'),
(118, 8, 'Wrong password', '2026-04-14 23:25:13', '::1', NULL, NULL, 'alan', 'failed', '', NULL, 'application'),
(119, 0, 'Unknown username', '2026-04-14 23:25:23', '::1', NULL, NULL, 'alann', 'failed', '', NULL, 'application'),
(120, 0, 'Unknown username', '2026-04-14 23:25:25', '::1', NULL, NULL, 'alann', 'failed', '', NULL, 'application'),
(121, 0, 'Unknown username', '2026-04-14 23:25:27', '::1', NULL, NULL, 'alann', 'failed', '', NULL, 'application'),
(122, 0, 'Unknown username', '2026-04-14 23:25:29', '::1', NULL, NULL, 'alann', 'failed', '', NULL, 'application'),
(123, 8, 'Wrong password', '2026-04-14 23:25:39', '::1', NULL, NULL, 'alan', 'failed', '', NULL, 'application'),
(124, 8, 'Wrong password', '2026-04-14 23:25:48', '::1', NULL, NULL, 'alan', 'failed', '', NULL, 'application'),
(125, 8, 'Wrong password', '2026-04-14 23:36:27', '::1', NULL, NULL, 'alan', 'failed', '', NULL, 'application'),
(126, 8, 'Wrong password', '2026-04-14 23:37:13', '::1', NULL, NULL, 'alan', 'failed', '', NULL, 'application'),
(127, 8, 'Wrong password', '2026-04-14 23:37:22', '::1', NULL, NULL, 'alan', 'failed', '', NULL, 'application'),
(128, 8, 'Wrong password', '2026-04-14 23:37:33', '::1', NULL, NULL, 'alan', 'failed', '', NULL, 'application'),
(129, 8, 'Wrong password', '2026-04-14 23:38:50', '::1', NULL, NULL, 'alan', 'failed', '', NULL, 'application'),
(130, 8, 'Wrong password', '2026-04-14 23:39:00', '::1', NULL, NULL, 'alan', 'failed', '', NULL, 'application'),
(131, 8, 'Wrong password', '2026-04-14 23:39:47', '::1', NULL, NULL, 'alan', 'failed', '', NULL, 'application'),
(132, 8, 'Wrong password', '2026-04-14 23:39:59', '::1', NULL, NULL, 'alan', 'failed', '', NULL, 'application'),
(133, 8, 'Wrong password', '2026-04-14 23:40:09', '::1', NULL, NULL, 'alan', 'failed', '', NULL, 'application'),
(134, 8, 'Wrong password', '2026-04-14 23:40:18', '::1', NULL, NULL, 'alan', 'failed', '', NULL, 'application'),
(135, 8, 'Wrong password', '2026-04-14 23:40:27', '::1', NULL, NULL, 'alan', 'failed', '', NULL, 'application'),
(136, 8, 'Wrong password', '2026-04-15 00:05:01', '::1', NULL, NULL, 'alan', 'failed', '', NULL, 'application'),
(137, 8, 'Wrong password', '2026-04-15 00:05:12', '::1', NULL, NULL, 'alan', 'failed', '', NULL, 'application'),
(138, 8, 'Wrong password', '2026-04-15 00:05:22', '::1', NULL, NULL, 'alan', 'failed', '', NULL, 'application'),
(139, 8, 'Wrong password', '2026-04-15 00:05:30', '::1', NULL, NULL, 'alan', 'failed', '', NULL, 'application'),
(140, 8, 'Wrong password', '2026-04-15 00:05:43', '::1', NULL, NULL, 'alan', 'failed', '', NULL, 'application'),
(141, 8, 'Wrong password', '2026-04-15 00:05:53', '::1', NULL, NULL, 'alan', 'failed', '', NULL, 'application'),
(142, 8, 'User temporarily locked', '2026-04-15 00:08:00', 'secops-agent', NULL, NULL, 'alan', 'success', '', NULL, 'secops'),
(143, 8, 'User temporarily locked', '2026-04-15 00:09:42', 'secops-agent', NULL, NULL, 'alan', 'success', '', NULL, 'secops'),
(144, 8, 'User temporarily locked', '2026-04-15 00:09:42', 'secops-agent', NULL, NULL, 'alan', 'success', '', NULL, 'secops'),
(145, 8, 'User temporarily locked', '2026-04-15 00:09:42', 'secops-agent', NULL, NULL, 'alan', 'success', '', NULL, 'secops'),
(146, 8, 'User temporarily locked', '2026-04-15 00:09:43', 'secops-agent', NULL, NULL, 'alan', 'success', '', NULL, 'secops'),
(147, 8, 'User temporarily locked', '2026-04-15 00:09:43', 'secops-agent', NULL, NULL, 'alan', 'success', '', NULL, 'secops'),
(148, 8, 'User temporarily locked', '2026-04-15 00:11:55', 'secops-agent', NULL, NULL, 'alan', 'success', '', NULL, 'secops');

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

CREATE TABLE `notices` (
  `id` int(11) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(20) NOT NULL DEFAULT 'info',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notices`
--

INSERT INTO `notices` (`id`, `message`, `type`, `is_active`, `created_at`) VALUES
(1, 'test', 'info', 0, '2026-03-31 14:36:35'),
(2, 'test', 'info', 1, '2026-03-31 14:55:54'),
(3, 'พบการ login ผิดปกติจาก IP {{alert.sourceAddress}}', 'warning', 1, '2026-03-31 15:56:49'),
(4, 'พบการ login ผิดปกติจาก IP {{alert.sourceAddress}}', 'warning', 1, '2026-03-31 15:56:50'),
(5, 'พบการ login ผิดปกติจาก IP {{alert.sourceAddress}}', 'warning', 1, '2026-04-01 10:07:04'),
(6, 'พบการ login ผิดปกติจาก IP {{alert.sourceAddress}}', 'warning', 1, '2026-04-01 10:07:04'),
(7, 'พบการ login ผิดปกติจาก IP {{alert.sourceAddress}}', 'warning', 1, '2026-04-01 10:07:04'),
(8, 'พบการ login ผิดปกติจาก IP {{alert.sourceAddress}}', 'warning', 1, '2026-04-01 10:07:04'),
(9, 'พบการ login ผิดปกติจาก IP {{alert.sourceAddress}}', 'warning', 1, '2026-04-01 10:07:05'),
(10, 'พบการ login ผิดปกติจาก IP {{alert.sourceAddress}}', 'warning', 1, '2026-04-01 10:11:37'),
(11, 'พบการ login ผิดปกติจาก IP {{alert.sourceAddress}}', 'warning', 1, '2026-04-01 11:42:54'),
(12, 'พบการ login ผิดปกติจาก IP {{alert.sourceAddress}}', 'warning', 1, '2026-04-01 11:42:54'),
(13, 'พบการ login ผิดปกติจาก IP {{alert.sourceAddress}}', 'warning', 1, '2026-04-01 11:42:55'),
(14, 'พบการ login ผิดปกติจาก IP {{alert.sourceAddress}}', 'warning', 1, '2026-04-01 11:42:55'),
(16, 'test from secops', 'warning', 1, '2026-04-01 16:07:12'),
(17, 'พบการ login ผิดปกติจาก IP  ผู้ใช้: ', 'warning', 1, '2026-04-01 16:19:54'),
(18, 'พบการ login ผิดปกติจาก IP  ผู้ใช้: ', 'warning', 1, '2026-04-01 16:19:55'),
(19, 'พบการ login ผิดปกติจาก IP  ผู้ใช้: ', 'warning', 1, '2026-04-01 16:19:55'),
(20, 'พบการ login ผิดปกติจาก IP  ผู้ใช้: ', 'warning', 1, '2026-04-01 16:19:55'),
(21, 'พบการ login ผิดปกติจาก IP  ผู้ใช้: ', 'warning', 1, '2026-04-01 16:19:55'),
(22, 'พบการ login ผิดปกติจาก IP  ผู้ใช้: ', 'warning', 1, '2026-04-01 16:19:56'),
(23, 'พบการ login ผิดปกติจาก IP  ผู้ใช้: ', 'warning', 1, '2026-04-01 16:19:56'),
(24, 'พบการ login ผิดปกติจาก IP  ผู้ใช้: ', 'warning', 1, '2026-04-01 16:22:08'),
(25, 'พบการ login ผิดปกติจาก IP  ผู้ใช้: ', 'warning', 1, '2026-04-14 18:04:13'),
(26, 'พบการ login ผิดปกติจาก IP  ผู้ใช้: ', 'warning', 1, '2026-04-14 18:04:13'),
(27, 'พบการ login ผิดปกติจาก IP  ผู้ใช้: ', 'warning', 1, '2026-04-14 18:04:14'),
(28, 'พบการ login ผิดปกติจาก IP  ผู้ใช้: ', 'warning', 1, '2026-04-14 18:04:14'),
(29, 'พบการ login ผิดปกติจาก IP  ผู้ใช้: ', 'warning', 1, '2026-04-14 18:04:14'),
(30, 'พบการ login ผิดปกติจาก IP  ผู้ใช้: ', 'warning', 1, '2026-04-14 18:04:14'),
(31, 'พบการ login ผิดปกติจาก IP  ผู้ใช้: ', 'warning', 1, '2026-04-14 18:04:14'),
(32, 'พบการ login ผิดปกติจาก IP  ผู้ใช้: ', 'warning', 1, '2026-04-14 18:04:17'),
(33, 'พบการ login ผิดปกติจาก IP  ผู้ใช้: ', 'warning', 1, '2026-04-14 18:04:24'),
(34, 'พบการ login ผิดปกติจาก IP  ผู้ใช้: ', 'warning', 1, '2026-04-14 18:04:24'),
(35, 'พบการ login ผิดปกติจาก IP  ผู้ใช้: ', 'warning', 1, '2026-04-14 18:04:25'),
(36, 'พบการ login ผิดปกติจาก IP  ผู้ใช้: ', 'warning', 1, '2026-04-14 18:04:25'),
(37, 'พบการ login ผิดปกติจาก IP  ผู้ใช้: ', 'warning', 1, '2026-04-14 18:05:19'),
(38, 'พบการ login ผิดปกติจาก IP  ผู้ใช้: ', 'warning', 1, '2026-04-14 18:05:19'),
(39, 'พบการ login ผิดปกติจาก IP  ผู้ใช้: ', 'warning', 1, '2026-04-14 18:12:09'),
(40, 'พบการ login ผิดปกติจาก IP  ผู้ใช้: ', 'warning', 1, '2026-04-14 18:12:13');

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
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(50) DEFAULT NULL,
  `locked_until` datetime DEFAULT NULL,
  `lock_reason` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `m_level`, `name`, `time`, `status`, `locked_until`, `lock_reason`) VALUES
(3, 'alanw', '$2y$10$CQCz/tkEPRTObHFsmrUHqe4s0rMAnDPyuiPfdQ4WARh3Zx/3T56bq', 'user', 'Alan Walker', '2026-03-09 03:02:22', NULL, NULL, NULL),
(8, 'alan', '$2y$10$tFzM/4n8DgaVDEO1g.k/DuEHys7.xPPbTBMD2qiZzd4RKTHXldPX6', 'user', 'Alan Walker', '2026-04-14 17:11:55', 'temporary_locked', '2026-04-14 19:26:55', 'apache_login_failed'),
(9, 'robot', '$2y$10$9MAbRVXMVUzkd5olQG2Y1eY8k2cuJMcPsaKIbIa19kAiN1BRLaO2K', 'user', 'Iam Robot', '2026-03-03 09:24:29', NULL, NULL, NULL),
(10, 'test01', '$2y$10$M7z7U78qKuXdTHS5ng7GbOlW0WNP.8jW9H3UvJ8ObkdBv6cXRw9dG', 'admin', 'test 01', '2026-03-03 09:42:56', NULL, NULL, NULL),
(11, 'test2', '$2y$10$DUsRlIZcAbFRGEVfV585j.4HMlofUO94xDFYjjuzzcT/pYdMijNwi', 'admin', 'tester 02', '2026-03-09 06:50:04', NULL, NULL, NULL),
(12, 'test03', '$2y$10$wy0l0JTEVoAtJpRRDNg4YOxHV7cYpaDlOh0o9ZTjVV0r2vGgIyFA6', 'admin', 'Tester 03', '2026-03-10 07:43:28', NULL, NULL, NULL),
(13, 'seasky', '$2y$10$wffltx71tJnv7X7CX8qkie1P7QdsBgLiNZ/njR1BHOeiTDBrP1iAS', 'user', 'Sea Sky', '2026-03-10 07:46:37', NULL, NULL, NULL),
(15, 'kokoza555', '$2y$10$7o0WlleWntli7ne5frOS/uAXYaEsfC5Az5qg8laGvO6w0YSo1wfVm', 'user', 'thanppe', '2026-03-10 09:18:38', NULL, NULL, NULL),
(16, 'banana', '$2y$10$UK07k6IFjBzA7GAx9zR34.OlL80iFvj3NzJ1sDrLB2EbE/YrclAy2', 'user', 'I am banana', '2026-03-10 09:21:26', NULL, NULL, NULL),
(17, 'pun', '$2y$10$uoVsQGLVuTvgz0SrnJB0C.iffQsnVYVqXZStvNhNEcf5QhNaWelNu', 'user', 'Pun Pun', '2026-03-18 03:17:13', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `notices`
--
ALTER TABLE `notices`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT for table `notices`
--
ALTER TABLE `notices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
