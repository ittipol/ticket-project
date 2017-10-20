-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 20, 2017 at 06:24 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ticket_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` int(11) UNSIGNED NOT NULL,
  `chat_room_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `chat_messages`
--

INSERT INTO `chat_messages` (`id`, `chat_room_id`, `user_id`, `message`, `created_at`) VALUES
(1, 1, 2, 'hello', '2017-10-17 14:41:49'),
(2, 1, 2, '111', '2017-10-17 14:42:26'),
(3, 1, 2, 'sss', '2017-10-17 14:43:26'),
(4, 1, 2, 'www', '2017-10-17 14:44:12'),
(5, 1, 2, 'hhhh', '2017-10-17 14:47:14'),
(6, 1, 2, 'sss', '2017-10-17 14:47:42'),
(7, 2, 2, 'ลดได้ไหม', '2017-10-17 17:48:56'),
(8, 3, 2, 'ใช้ได้ที่ไหนบ้างครับ', '2017-10-17 20:05:02'),
(9, 4, 2, 'hello', '2017-10-18 00:45:09'),
(10, 4, 1, 'w', '2017-10-18 01:42:36'),
(11, 4, 2, 'gg', '2017-10-18 11:49:59'),
(12, 3, 2, '...', '2017-10-18 11:50:16'),
(13, 1, 2, 'hello', '2017-10-18 11:50:47'),
(14, 1, 2, 'sss', '2017-10-18 11:51:58'),
(15, 1, 2, 'ttt', '2017-10-18 11:53:07'),
(16, 1, 2, 'wwww', '2017-10-18 11:53:50'),
(17, 1, 2, 'yyy', '2017-10-18 11:54:35'),
(18, 1, 2, 'ggggg', '2017-10-18 11:55:54'),
(19, 1, 2, 'hell', '2017-10-18 11:57:51'),
(20, 1, 2, 'niw', '2017-10-18 11:58:29'),
(21, 1, 2, 'kk', '2017-10-18 11:58:41');

-- --------------------------------------------------------

--
-- Table structure for table `chat_rooms`
--

CREATE TABLE `chat_rooms` (
  `id` int(11) UNSIGNED NOT NULL,
  `room_key` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `chat_rooms`
--

INSERT INTO `chat_rooms` (`id`, `room_key`, `type`, `created_at`, `updated_at`) VALUES
(1, 'G1orFUSGBUnEwzPU', NULL, '2017-10-17 14:39:38', '2017-10-17 14:39:38'),
(2, 'JpmUN1pNBubF4wCJ', NULL, '2017-10-17 17:48:46', '2017-10-17 17:48:46'),
(3, 'y0VJHC4HZlAEmJUV', NULL, '2017-10-17 20:04:53', '2017-10-17 20:04:53'),
(4, 'ijX8T1x3pMyJ9EgA', NULL, '2017-10-18 00:45:05', '2017-10-18 00:45:05');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) UNSIGNED NOT NULL,
  `model` varchar(255) NOT NULL,
  `model_id` int(11) UNSIGNED NOT NULL,
  `path` varchar(255) DEFAULT NULL,
  `filename` varchar(255) NOT NULL,
  `description` text,
  `image_type_id` int(11) UNSIGNED NOT NULL,
  `created_by` int(11) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `model`, `model_id`, `path`, `filename`, `description`, `image_type_id`, `created_by`, `created_at`, `updated_at`) VALUES
(3, 'Ticket', 3, NULL, '1507453395460061332718200779047.jpg', NULL, 1, 1, '2017-10-08 09:03:56', '2017-10-08 09:03:56'),
(4, 'Ticket', 3, NULL, '1507453404003164816258714380796.jpg', NULL, 1, 1, '2017-10-08 09:03:56', '2017-10-08 09:03:56'),
(5, 'Ticket', 3, NULL, '15074534076145285893718296112828.png', NULL, 1, 1, '2017-10-08 09:03:56', '2017-10-08 09:03:56'),
(6, 'Ticket', 3, NULL, '15074534242723224420782578116100.jpg', NULL, 1, 1, '2017-10-08 09:03:56', '2017-10-08 09:03:56'),
(7, 'Ticket', 3, NULL, '1507453427798478675338297930658.jpg', NULL, 1, 1, '2017-10-08 09:03:57', '2017-10-08 09:03:57'),
(8, 'Ticket', 4, NULL, '1507453760370865908172639830658.jpg', NULL, 1, 1, '2017-10-08 09:10:00', '2017-10-08 09:10:00'),
(9, 'Ticket', 4, NULL, '15074537627206025006795945116100.jpg', NULL, 1, 1, '2017-10-08 09:10:01', '2017-10-08 09:10:01'),
(10, 'Ticket', 5, NULL, '1507461595714780438693565928073.jpg', NULL, 1, 1, '2017-10-08 11:20:01', '2017-10-08 11:20:01'),
(11, 'Ticket', 5, NULL, '15074615976142953392526571116100.jpg', NULL, 1, 1, '2017-10-08 11:20:01', '2017-10-08 11:20:01'),
(12, 'Ticket', 5, NULL, '1507461599461042420384151230658.jpg', NULL, 1, 1, '2017-10-08 11:20:01', '2017-10-08 11:20:01'),
(13, 'Ticket', 6, NULL, '1507462124803870935629055941456.jpg', NULL, 1, 1, '2017-10-08 11:29:01', '2017-10-08 11:29:01'),
(14, 'Ticket', 6, NULL, '1507462139116569804205285343653.jpg', NULL, 1, 1, '2017-10-08 11:29:01', '2017-10-08 11:29:01'),
(15, 'Ticket', 7, NULL, '1507484749985392409550280294790.jpg', NULL, 1, 1, '2017-10-08 17:45:55', '2017-10-08 17:45:55'),
(16, 'Ticket', 9, NULL, '1507485327847286156964926720659.jpg', NULL, 1, 1, '2017-10-08 17:55:28', '2017-10-08 17:55:28'),
(17, 'Ticket', 14, NULL, '150831593733375467910137930658.jpg', NULL, 1, 2, '2017-10-18 15:40:24', '2017-10-18 15:40:24'),
(25, 'User', 1, NULL, '1508323228540805056411372116100.jpg', NULL, 2, 1, '2017-10-18 17:40:15', '2017-10-18 17:40:30'),
(26, 'User', 2, NULL, '1508388499075518739697036116100.jpg', NULL, 2, 2, '2017-10-19 11:48:28', '2017-10-19 11:48:28');

-- --------------------------------------------------------

--
-- Table structure for table `image_types`
--

CREATE TABLE `image_types` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `image_types`
--

INSERT INTO `image_types` (`id`, `name`, `alias`, `path`) VALUES
(1, 'photo', 'photo', 'photo'),
(2, 'avatar', 'avatar', 'avatar'),
(3, 'cover', 'cover', 'cover'),
(4, 'Banner', 'banner', 'banner');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `sender` int(11) UNSIGNED NOT NULL,
  `receiver` int(11) UNSIGNED NOT NULL,
  `url` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `place_locations`
--

CREATE TABLE `place_locations` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `place_locations`
--

INSERT INTO `place_locations` (`id`, `name`) VALUES
(1, 'Siam Center'),
(2, 'Asok'),
(3, 'xxxx'),
(4, 'test'),
(5, 'เขาใหญ่'),
(6, 'กรุงเทพมหานคร'),
(7, 'xxx'),
(8, '');

-- --------------------------------------------------------

--
-- Table structure for table `social_providers`
--

CREATE TABLE `social_providers` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `alias` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `social_providers`
--

INSERT INTO `social_providers` (`id`, `name`, `alias`) VALUES
(1, 'facebook', 'fb'),
(2, 'twitter', '');

-- --------------------------------------------------------

--
-- Table structure for table `taggings`
--

CREATE TABLE `taggings` (
  `model` varchar(25) NOT NULL,
  `model_id` int(11) NOT NULL,
  `word_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `taggings`
--

INSERT INTO `taggings` (`model`, `model_id`, `word_id`, `created_at`) VALUES
('Ticket', 1, 1, '2017-10-08 03:25:44'),
('Ticket', 1, 2, '2017-10-08 03:25:44'),
('Ticket', 1, 3, '2017-10-08 03:25:44'),
('Ticket', 2, 4, '2017-10-08 03:28:06'),
('Ticket', 3, 3, '2017-10-08 09:03:56'),
('Ticket', 8, 5, '2017-10-08 17:52:15');

-- --------------------------------------------------------

--
-- Table structure for table `temporary_files`
--

CREATE TABLE `temporary_files` (
  `id` int(11) NOT NULL,
  `model` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `filesize` varchar(20) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `temporary_files`
--

INSERT INTO `temporary_files` (`id`, `model`, `token`, `filename`, `filesize`, `alias`, `created_by`, `created_at`) VALUES
(1, 'Ticket', 'Xo36VSVu', NULL, NULL, NULL, 1, '2017-10-08 03:25:40'),
(2, 'Ticket', 'Xo36VSVu', NULL, NULL, NULL, 1, '2017-10-08 03:25:42'),
(3, 'Ticket', 'OcGuZ5LR', NULL, NULL, NULL, 1, '2017-10-08 07:17:40'),
(4, 'Ticket', 'OcGuZ5LR', NULL, NULL, NULL, 1, '2017-10-08 07:17:42'),
(5, 'Ticket', 'OcGuZ5LR', NULL, NULL, NULL, 1, '2017-10-08 07:17:51'),
(6, 'Ticket', 'mJkdlEm6', NULL, NULL, NULL, 1, '2017-10-08 08:54:37'),
(7, 'Ticket', '8DMco97f', NULL, NULL, NULL, 1, '2017-10-08 08:58:24'),
(8, 'Ticket', 'd6LYEZuv', NULL, NULL, NULL, 1, '2017-10-08 08:59:14'),
(9, 'Ticket', 'd6LYEZuv', NULL, NULL, NULL, 1, '2017-10-08 08:59:22'),
(10, 'Ticket', '0RJ9soE2', NULL, NULL, NULL, 1, '2017-10-08 09:01:42'),
(11, 'Ticket', '0RJ9soE2', NULL, NULL, NULL, 1, '2017-10-08 09:01:55'),
(12, 'Ticket', '0RJ9soE2', NULL, NULL, NULL, 1, '2017-10-08 09:03:15'),
(13, 'Ticket', '0RJ9soE2', NULL, NULL, NULL, 1, '2017-10-08 09:03:24'),
(14, 'Ticket', '0RJ9soE2', NULL, NULL, NULL, 1, '2017-10-08 09:03:27'),
(15, 'Ticket', '0RJ9soE2', NULL, NULL, NULL, 1, '2017-10-08 09:03:44'),
(16, 'Ticket', '0RJ9soE2', NULL, NULL, NULL, 1, '2017-10-08 09:03:47'),
(17, 'Ticket', 'UXsis6iT', NULL, NULL, NULL, 1, '2017-10-08 09:09:20'),
(18, 'Ticket', 'UXsis6iT', NULL, NULL, NULL, 1, '2017-10-08 09:09:22'),
(19, 'Ticket', '4QFOVEPc', NULL, NULL, NULL, 1, '2017-10-08 11:19:55'),
(20, 'Ticket', '4QFOVEPc', NULL, NULL, NULL, 1, '2017-10-08 11:19:57'),
(21, 'Ticket', '4QFOVEPc', NULL, NULL, NULL, 1, '2017-10-08 11:19:59'),
(22, 'Ticket', 'zuHHmuKY', NULL, NULL, NULL, 1, '2017-10-08 11:28:44'),
(23, 'Ticket', 'zuHHmuKY', NULL, NULL, NULL, 1, '2017-10-08 11:28:59'),
(24, 'Ticket', 'ZU8efMhe', NULL, NULL, NULL, 1, '2017-10-08 17:45:50'),
(25, 'Ticket', 'x6jKglRM', NULL, NULL, NULL, 1, '2017-10-08 17:55:27'),
(26, 'User', 'IhE7j55y', NULL, NULL, NULL, 2, '2017-10-18 15:26:40'),
(27, 'User', 'ARIDifTq', NULL, NULL, NULL, 2, '2017-10-18 15:35:38'),
(28, 'Ticket', 'hktIxGjm', NULL, NULL, NULL, 2, '2017-10-18 15:38:57'),
(29, 'User', '2bHnqntG', NULL, NULL, NULL, 2, '2017-10-18 15:54:02'),
(30, 'User', 'caCuH7eM', NULL, NULL, NULL, 2, '2017-10-18 15:54:51'),
(31, 'User', 'fUMl3RQQ', NULL, NULL, NULL, 1, '2017-10-18 16:52:29'),
(32, 'User', 'UFMqnUsr', NULL, NULL, NULL, 1, '2017-10-18 16:53:41'),
(33, 'User', 'LOI0jz83', NULL, NULL, NULL, 1, '2017-10-18 16:54:41'),
(34, 'User', 'SWQSUvWZ', NULL, NULL, NULL, 1, '2017-10-18 16:59:52'),
(35, 'User', 'SMEbLK37', NULL, NULL, NULL, 1, '2017-10-18 17:01:04'),
(36, 'User', '0lOjuHwk', NULL, NULL, NULL, 1, '2017-10-18 17:05:24'),
(37, 'User', 'Zwai935t', NULL, NULL, NULL, 1, '2017-10-18 17:26:28'),
(38, 'User', '7vySyxRb', NULL, NULL, NULL, 1, '2017-10-18 17:27:21'),
(39, 'User', '45irFwej', NULL, NULL, NULL, 1, '2017-10-18 17:29:48'),
(40, 'User', 'bfOoxY49', NULL, NULL, NULL, 1, '2017-10-18 17:39:40'),
(41, 'User', 'cxELBEks', NULL, NULL, NULL, 1, '2017-10-18 17:40:28'),
(42, 'User', 'lwkK5Fbx', NULL, NULL, NULL, 2, '2017-10-19 11:33:19'),
(43, 'User', 'q0OHIp19', NULL, NULL, NULL, 2, '2017-10-19 11:33:51'),
(44, 'User', 'tCmBBAWe', NULL, NULL, NULL, 2, '2017-10-19 11:34:20'),
(45, 'User', 'j7YWT08i', NULL, NULL, NULL, 2, '2017-10-19 11:43:40'),
(46, 'User', 'fiMPAjhP', NULL, NULL, NULL, 2, '2017-10-19 11:45:58'),
(47, 'User', 'TWDVp2Ot', NULL, NULL, NULL, 2, '2017-10-19 11:48:19'),
(48, 'Ticket', 'IsfvcrfD', NULL, NULL, NULL, 2, '2017-10-19 11:52:44'),
(49, 'Ticket', 'JQRdDmiQ', NULL, NULL, NULL, 2, '2017-10-20 11:02:47');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `place_location` varchar(255) DEFAULT NULL,
  `price` decimal(15,2) NOT NULL,
  `original_price` decimal(15,2) DEFAULT NULL,
  `date_type` int(11) NOT NULL,
  `date_1` datetime DEFAULT NULL,
  `date_2` datetime NOT NULL,
  `contact` text NOT NULL,
  `purpose` varchar(1) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `title`, `description`, `place_location`, `price`, `original_price`, `date_type`, `date_1`, `date_2`, `contact`, `purpose`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'DATA \\w images', 'xxxxxxxxxxxxx', 'Siam Center', '2500.00', '3000.00', 1, '0000-00-00 00:00:00', '2017-10-31 00:00:00', '', '', 1, '2017-10-08 03:25:44', '2017-10-09 14:49:01'),
(2, 'DATA', 'xxx', 'Asok', '1500.00', '3500.00', 1, '2017-10-05 00:00:00', '2017-12-31 00:00:00', '', '', 1, '2017-10-08 03:28:05', '2017-10-09 14:40:53'),
(3, 'test', 'test', 'xxxx', '1111.00', '3000.00', 1, '2017-10-05 00:00:00', '2017-10-31 00:00:00', '', '', 1, '2017-10-08 09:03:56', '2017-10-09 14:40:53'),
(4, 'nnnn', 'xxxx', 'test', '300.00', '6000.00', 1, '2017-10-03 00:00:00', '2017-10-10 00:00:00', '', '', 1, '2017-10-08 09:10:00', '2017-10-09 14:40:53'),
(5, 'Voucher ที่พักโรงแรม ชาโต เดอ เขาใหญ่ ห้อง standard 1 คืน 2ท่าน พร้อมอาหารเช้า สามารถใช้ได้ทุกวัน', 'ขายวอยเชอร์ Gift Voucher ที่พักโรงแรม ชาโต เดอ เขาใหญ่ Chateau de Khaoyai Hotel & Resort ห้อง standard 1 คืน 2ท่าน พร้อมอาหารเช้า สามารถใช้ได้ทุกวัน ไม่เว้นวันหยุด ส,อา,นักขัตฤกษ์ (ไม่ต้องเสียค่าใช้จ่ายใดๆเพิ่ม) \r\n\r\nใช้ได้ตั้งแต่ วันนี้ - 28 กุมภาพันธ์ 2561 **ไม่สามารถใช้คูปองช่วงระหว่างวันท่ี 25 ธันวาคม 2560 ถึง 5 มกราคม 2561** \r\nห้อง standard ขนาด 30 ตร.ม. สามารถใช้ได้กับ 4 ตึก เลือกได้หลายบรรยากาศทั้งริมทะเลสาบและใกล้ขุนเขา\r\n1. Chateau ชาโต้ว\r\n2. Mountain Villa\r\n3. Lakeside Villa\r\n4. Monet House\r\n\r\nสนใจติดต่อ\r\n-โทร+ Line แนน 0842494461\r\n-Web : https://shopee.co.th/nanny_189 (ยินดีรับบัตรเครดิต)', 'เขาใหญ่', '2500.00', '4200.00', 1, '2017-10-01 00:00:00', '2018-02-28 00:00:00', '', '', 1, '2017-10-08 11:20:01', '2017-10-09 14:40:53'),
(6, 'Grab voucher', 'ส่วนลดgrab100บาทใช้ได้10ครั้ง', 'กรุงเทพมหานคร', '700.00', '1000.00', 1, '2017-10-25 00:00:00', '2017-10-26 00:00:00', 'Line:jobmicro tel0953126843', '', 1, '2017-10-08 11:29:01', '2017-10-12 15:17:10'),
(7, 'ตั๋วการบินไทยบินตรงกรุงเทพ-ฟุคูโอกะ', 'โดยบริษัทสยามนิปปอนจำกัด', 'xxx', '23500.00', '29990.00', 1, '2017-10-03 00:00:00', '2017-10-11 00:00:00', '', '', 1, '2017-10-08 17:45:55', '2017-10-09 14:40:53'),
(8, 'ขายบัตร J-DNA วันเสาร์ที่ 16 ธันวา Zone A1 แถว A17-A19 ราคาใบละ 4000 สนใจทัก IB ครับ', 'ขายบัตร J-DNA วันเสาร์ที่ 16 ธันวา Zone A1 แถว A17-A19 ราคาใบละ 4000 สนใจทัก IB ครับ', NULL, '4000.00', NULL, 1, '2017-10-05 00:00:00', '2017-10-17 00:00:00', '', '', 1, '2017-10-08 17:52:15', '2017-10-09 14:40:53'),
(9, 'ขาย voucher ห้องพัก centara watergate pavillion', 'ขาย voucher ห้องพัก centara watergate pavillion ห้องซูพีเรีย\r\nเข้าพักได้ 2 คน 2 คืนพร้อมรับประทานอาหารเช้า ขายราคา 3500 บาท\r\n*** หมดเขต 30 Nov 2017 ***\r\n**** ก่อนเข้าพักให้โทรแจ้งทางโรงแรมก่อนล่วงหน้า 7 วัน ****', NULL, '3500.00', '8000.00', 1, NULL, '2017-10-11 00:00:00', '', '', 1, '2017-10-08 17:55:28', '2017-10-09 14:58:40'),
(10, '1111', '111', NULL, '111.00', NULL, 1, NULL, '2017-10-17 00:00:00', '', '', 1, '2017-10-12 00:15:29', '2017-10-12 00:15:29'),
(11, '333', '3333', NULL, '1111.00', NULL, 1, NULL, '2017-10-25 23:59:59', '', '', 1, '2017-10-12 00:19:36', '2017-10-12 00:19:36'),
(12, 'eee', 'www', NULL, '333.00', NULL, 1, '2017-10-03 00:00:00', '2017-10-31 23:59:59', '', '', 1, '2017-10-12 00:20:00', '2017-10-12 00:20:00'),
(13, 'dddfgddfg', 'dfgfdgfdgd', NULL, '4444.00', NULL, 2, '2017-10-18 00:00:00', '2017-10-18 23:59:59', '', '', 1, '2017-10-12 00:21:04', '2017-10-12 00:21:04'),
(14, 'test', 'xxxx', NULL, '11111.00', NULL, 1, NULL, '2017-10-06 23:59:59', 'xxx', 's', 2, '2017-10-18 15:40:24', '2017-10-18 15:40:24');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_categories`
--

CREATE TABLE `ticket_categories` (
  `id` int(11) UNSIGNED NOT NULL,
  `parent_id` int(11) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ticket_categories`
--

INSERT INTO `ticket_categories` (`id`, `parent_id`, `name`, `description`, `active`) VALUES
(1, NULL, 'ดนตรี', NULL, 1),
(2, NULL, 'การแสดง', NULL, 1),
(3, NULL, 'กีฬา', NULL, 1),
(4, NULL, 'ตั๋วเครื่องบิน', NULL, 1),
(5, NULL, 'แพ็คเกจท่องเที่ยว', NULL, 1),
(6, NULL, 'ที่พัก', NULL, 1),
(7, NULL, 'สวนสนุก สวนน้ำ', NULL, 1),
(8, NULL, 'ตั๋วหนัง', NULL, 1),
(9, NULL, 'กิจกรรม บันเทิง', NULL, 1),
(10, NULL, 'ช๊อปปิง ส่วนลด', NULL, 1),
(11, NULL, 'อาหาร', NULL, 1),
(12, NULL, 'เครื่องดื่ม', NULL, 1),
(13, NULL, 'สุขภาพ ความงาม', NULL, 1),
(14, NULL, 'บัตรรายเดือน คูปอง', NULL, 1),
(15, NULL, 'คะแนนสะสม ไมล์บิน', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ticket_category_paths`
--

CREATE TABLE `ticket_category_paths` (
  `ticket_category_id` int(11) UNSIGNED NOT NULL,
  `path_id` int(11) UNSIGNED NOT NULL,
  `level` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_chat_rooms`
--

CREATE TABLE `ticket_chat_rooms` (
  `id` int(11) UNSIGNED NOT NULL,
  `chat_room_id` int(11) UNSIGNED NOT NULL,
  `ticket_id` int(11) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ticket_chat_rooms`
--

INSERT INTO `ticket_chat_rooms` (`id`, `chat_room_id`, `ticket_id`, `created_at`) VALUES
(1, 1, 6, '2017-10-17 14:39:38'),
(2, 2, 9, '2017-10-17 17:48:46'),
(3, 3, 3, '2017-10-17 20:04:53'),
(4, 4, 2, '2017-10-18 00:45:05');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_to_categories`
--

CREATE TABLE `ticket_to_categories` (
  `ticket_id` int(11) UNSIGNED NOT NULL,
  `ticket_category_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `social_provider_id` int(11) DEFAULT NULL,
  `social_user_id` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `avatar` int(11) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `user_key` varchar(32) NOT NULL,
  `jwt_secret_key` varchar(128) NOT NULL,
  `has_password` tinyint(1) NOT NULL DEFAULT '0',
  `email_verified` tinyint(1) NOT NULL DEFAULT '0',
  `online` tinyint(1) NOT NULL DEFAULT '0',
  `last_active` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `social_provider_id`, `social_user_id`, `email`, `password`, `name`, `avatar`, `remember_token`, `user_key`, `jwt_secret_key`, `has_password`, `email_verified`, `online`, `last_active`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, '1', '$2y$12$/sh.edRN23AavlQyBYK5uOM45Upw9dyCkD.X9K.mhbbkVp/ybXqPO', 'Seller Name #1', NULL, 'l27vJniZ0P5M6bmr2kA0BqYKcuETX76gEOU2xOiGl1VMZ3h1ZnwTpcC8o6vu', 'oTqfDJBFZzZZSDM7zCOqjezDno2DlPqJ', '', 1, 0, 0, '2017-10-19 09:43:40', '2017-10-05 06:06:28', '2017-10-19 11:48:06'),
(2, NULL, NULL, '2', '$2y$12$/sh.edRN23AavlQyBYK5uOM45Upw9dyCkD.X9K.mhbbkVp/ybXqPO', 'new user !!!!', 26, 'WE45a3Zf7TNxYmRzq6jWRA2aCwYVnb4cMDTS4pueiTzPChWA5FLeg6V52Qjk', 'L3GNzbttbFgFQoa0Af5G2c9cm2FBbkLW', '', 1, 0, 0, '2017-10-20 11:14:37', '2017-10-05 09:18:40', '2017-10-20 11:15:00'),
(4, NULL, NULL, 'xxx@mail.com', '$2y$12$14L8axtvGyjd154cu/mxlOf/g/SBIoPX5CiPfS8jbw0mxeo9BqGVa', 'xxxx', NULL, NULL, 'e5d4cda72ae59f50fe0db2858b5eace2', '', 1, 0, 0, NULL, '2017-10-11 10:01:50', '2017-10-11 10:01:50'),
(5, NULL, NULL, 'test@mail.com', '$2y$12$0gYQ8EVrbtEuHCkNLl5OVOuXlzpRXckfkSx8wVraAJUm5ZxBnQ3Di', 'test', NULL, NULL, 'afe0ee8471d878ec731d9ae72b4c5a44', '', 1, 0, 0, NULL, '2017-10-11 10:04:26', '2017-10-11 10:04:26'),
(6, NULL, NULL, 'aaaaa@mail.com', '$2y$12$Cb9rkDgMvohjfrWxHdlSEO3CQSUF9DflimUTmYZ/DGby7ncAgINdW', 'aaaa', NULL, NULL, 'e49ced394567a59e9b8aebd645dcee2f', '', 1, 0, 0, NULL, '2017-10-11 10:04:46', '2017-10-11 10:04:46');

-- --------------------------------------------------------

--
-- Table structure for table `user_in_chat_room`
--

CREATE TABLE `user_in_chat_room` (
  `chat_room_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `role` varchar(1) NOT NULL,
  `notify` tinyint(1) NOT NULL DEFAULT '0',
  `message_read` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `message_read_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_in_chat_room`
--

INSERT INTO `user_in_chat_room` (`chat_room_id`, `user_id`, `role`, `notify`, `message_read`, `message_read_date`) VALUES
(1, 1, 's', 0, 21, '2017-10-18 17:44:22'),
(1, 2, 'b', 0, 19, '2017-10-18 11:58:19'),
(2, 1, 's', 0, 0, '2017-10-17 17:49:00'),
(2, 2, 'b', 0, 7, '2017-10-18 13:58:59'),
(3, 1, 's', 0, 0, '2017-10-18 11:50:20'),
(3, 2, 'b', 0, 8, '2017-10-18 11:50:14'),
(4, 1, 's', 0, 10, '2017-10-18 11:50:03'),
(4, 2, 'b', 0, 10, '2017-10-18 11:49:55');

-- --------------------------------------------------------

--
-- Table structure for table `words`
--

CREATE TABLE `words` (
  `id` int(11) UNSIGNED NOT NULL,
  `word` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `words`
--

INSERT INTO `words` (`id`, `word`, `created_at`) VALUES
(1, 'image', '2017-10-08 03:25:44'),
(2, 'siam', '2017-10-08 03:25:44'),
(3, 'test', '2017-10-08 03:25:44'),
(4, 'world', '2017-10-08 03:28:06'),
(5, 'J-DNA', '2017-10-08 17:52:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chat_rooms`
--
ALTER TABLE `chat_rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `image_types`
--
ALTER TABLE `image_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `place_locations`
--
ALTER TABLE `place_locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_providers`
--
ALTER TABLE `social_providers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temporary_files`
--
ALTER TABLE `temporary_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket_categories`
--
ALTER TABLE `ticket_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket_category_paths`
--
ALTER TABLE `ticket_category_paths`
  ADD PRIMARY KEY (`ticket_category_id`,`path_id`);

--
-- Indexes for table `ticket_chat_rooms`
--
ALTER TABLE `ticket_chat_rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket_to_categories`
--
ALTER TABLE `ticket_to_categories`
  ADD PRIMARY KEY (`ticket_id`,`ticket_category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_in_chat_room`
--
ALTER TABLE `user_in_chat_room`
  ADD PRIMARY KEY (`chat_room_id`,`user_id`);

--
-- Indexes for table `words`
--
ALTER TABLE `words`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `chat_rooms`
--
ALTER TABLE `chat_rooms`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `image_types`
--
ALTER TABLE `image_types`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `place_locations`
--
ALTER TABLE `place_locations`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `social_providers`
--
ALTER TABLE `social_providers`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `temporary_files`
--
ALTER TABLE `temporary_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `ticket_categories`
--
ALTER TABLE `ticket_categories`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `ticket_chat_rooms`
--
ALTER TABLE `ticket_chat_rooms`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `words`
--
ALTER TABLE `words`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
