-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 17, 2017 at 06:40 AM
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
(1, 1, 2, '111', '2017-10-17 11:34:00'),
(2, 1, 2, '222', '2017-10-17 11:34:02'),
(3, 1, 1, 'aaa', '2017-10-17 11:34:50');

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
(1, 'ZAS5tfH3DFFpikM19X2jiQIW8mZWdRqI', NULL, '2017-10-17 11:33:46', '2017-10-17 11:33:46');

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
(16, 'Ticket', 9, NULL, '1507485327847286156964926720659.jpg', NULL, 1, 1, '2017-10-08 17:55:28', '2017-10-08 17:55:28');

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
(2, 'profile image', 'profile-image', 'profile'),
(3, 'cover', 'cover', 'profile'),
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
-- Table structure for table `seller_chat_rooms`
--

CREATE TABLE `seller_chat_rooms` (
  `id` int(11) UNSIGNED NOT NULL,
  `chat_room_id` int(11) UNSIGNED NOT NULL,
  `seller` int(11) UNSIGNED NOT NULL,
  `buyer` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `seller_chat_rooms`
--

INSERT INTO `seller_chat_rooms` (`id`, `chat_room_id`, `seller`, `buyer`) VALUES
(1, 1, 1, 2);

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
(25, 'Ticket', 'x6jKglRM', NULL, NULL, NULL, 1, '2017-10-08 17:55:27');

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
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `title`, `description`, `place_location`, `price`, `original_price`, `date_type`, `date_1`, `date_2`, `contact`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'DATA \\w images', 'xxxxxxxxxxxxx', 'Siam Center', '2500.00', '3000.00', 1, '0000-00-00 00:00:00', '2017-10-31 00:00:00', '', 1, '2017-10-08 03:25:44', '2017-10-09 14:49:01'),
(2, 'DATA', 'xxx', 'Asok', '1500.00', '3500.00', 1, '2017-10-05 00:00:00', '2017-12-31 00:00:00', '', 1, '2017-10-08 03:28:05', '2017-10-09 14:40:53'),
(3, 'test', 'test', 'xxxx', '1111.00', '3000.00', 1, '2017-10-05 00:00:00', '2017-10-31 00:00:00', '', 1, '2017-10-08 09:03:56', '2017-10-09 14:40:53'),
(4, 'nnnn', 'xxxx', 'test', '300.00', '6000.00', 1, '2017-10-03 00:00:00', '2017-10-10 00:00:00', '', 1, '2017-10-08 09:10:00', '2017-10-09 14:40:53'),
(5, 'Voucher ที่พักโรงแรม ชาโต เดอ เขาใหญ่ ห้อง standard 1 คืน 2ท่าน พร้อมอาหารเช้า สามารถใช้ได้ทุกวัน', 'ขายวอยเชอร์ Gift Voucher ที่พักโรงแรม ชาโต เดอ เขาใหญ่ Chateau de Khaoyai Hotel & Resort ห้อง standard 1 คืน 2ท่าน พร้อมอาหารเช้า สามารถใช้ได้ทุกวัน ไม่เว้นวันหยุด ส,อา,นักขัตฤกษ์ (ไม่ต้องเสียค่าใช้จ่ายใดๆเพิ่ม) \r\n\r\nใช้ได้ตั้งแต่ วันนี้ - 28 กุมภาพันธ์ 2561 **ไม่สามารถใช้คูปองช่วงระหว่างวันท่ี 25 ธันวาคม 2560 ถึง 5 มกราคม 2561** \r\nห้อง standard ขนาด 30 ตร.ม. สามารถใช้ได้กับ 4 ตึก เลือกได้หลายบรรยากาศทั้งริมทะเลสาบและใกล้ขุนเขา\r\n1. Chateau ชาโต้ว\r\n2. Mountain Villa\r\n3. Lakeside Villa\r\n4. Monet House\r\n\r\nสนใจติดต่อ\r\n-โทร+ Line แนน 0842494461\r\n-Web : https://shopee.co.th/nanny_189 (ยินดีรับบัตรเครดิต)', 'เขาใหญ่', '2500.00', '4200.00', 1, '2017-10-01 00:00:00', '2018-02-28 00:00:00', '', 1, '2017-10-08 11:20:01', '2017-10-09 14:40:53'),
(6, 'Grab voucher', 'ส่วนลดgrab100บาทใช้ได้10ครั้ง', 'กรุงเทพมหานคร', '700.00', '1000.00', 1, '2017-10-25 00:00:00', '2017-10-26 00:00:00', 'Line:jobmicro tel0953126843', 1, '2017-10-08 11:29:01', '2017-10-12 15:17:10'),
(7, 'ตั๋วการบินไทยบินตรงกรุงเทพ-ฟุคูโอกะ', 'โดยบริษัทสยามนิปปอนจำกัด', 'xxx', '23500.00', '29990.00', 1, '2017-10-03 00:00:00', '2017-10-11 00:00:00', '', 1, '2017-10-08 17:45:55', '2017-10-09 14:40:53'),
(8, 'ขายบัตร J-DNA วันเสาร์ที่ 16 ธันวา Zone A1 แถว A17-A19 ราคาใบละ 4000 สนใจทัก IB ครับ', 'ขายบัตร J-DNA วันเสาร์ที่ 16 ธันวา Zone A1 แถว A17-A19 ราคาใบละ 4000 สนใจทัก IB ครับ', NULL, '4000.00', NULL, 1, '2017-10-05 00:00:00', '2017-10-17 00:00:00', '', 1, '2017-10-08 17:52:15', '2017-10-09 14:40:53'),
(9, 'ขาย voucher ห้องพัก centara watergate pavillion', 'ขาย voucher ห้องพัก centara watergate pavillion ห้องซูพีเรีย\r\nเข้าพักได้ 2 คน 2 คืนพร้อมรับประทานอาหารเช้า ขายราคา 3500 บาท\r\n*** หมดเขต 30 Nov 2017 ***\r\n**** ก่อนเข้าพักให้โทรแจ้งทางโรงแรมก่อนล่วงหน้า 7 วัน ****', NULL, '3500.00', '8000.00', 1, NULL, '2017-10-11 00:00:00', '', 1, '2017-10-08 17:55:28', '2017-10-09 14:58:40'),
(10, '1111', '111', NULL, '111.00', NULL, 1, NULL, '2017-10-17 00:00:00', '', 1, '2017-10-12 00:15:29', '2017-10-12 00:15:29'),
(11, '333', '3333', NULL, '1111.00', NULL, 1, NULL, '2017-10-25 23:59:59', '', 1, '2017-10-12 00:19:36', '2017-10-12 00:19:36'),
(12, 'eee', 'www', NULL, '333.00', NULL, 1, '2017-10-03 00:00:00', '2017-10-31 23:59:59', '', 1, '2017-10-12 00:20:00', '2017-10-12 00:20:00'),
(13, 'dddfgddfg', 'dfgfdgfdgd', NULL, '4444.00', NULL, 2, '2017-10-18 00:00:00', '2017-10-18 23:59:59', '', 1, '2017-10-12 00:21:04', '2017-10-12 00:21:04');

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
  `avatar` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `user_key` varchar(32) NOT NULL,
  `jwt_secret_key` varchar(128) NOT NULL,
  `has_password` tinyint(1) NOT NULL DEFAULT '0',
  `email_verified` tinyint(1) NOT NULL DEFAULT '0',
  `online` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `social_provider_id`, `social_user_id`, `email`, `password`, `name`, `avatar`, `remember_token`, `user_key`, `jwt_secret_key`, `has_password`, `email_verified`, `online`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, '1', '$2y$12$/sh.edRN23AavlQyBYK5uOM45Upw9dyCkD.X9K.mhbbkVp/ybXqPO', 'Seller Name #1', '1508087415622489821464736116100.jpg', 'KXi3a6jiwIy8TdC42FWcxwgBt6cxnx32rEifDrLKUvSHF6Sh3L18diqhD4hk', 'Mb2AwdKVhATbq5Q26hfvfs8qIwLtBkDf', '', 1, 0, 1, '2017-10-05 06:06:28', '2017-10-17 11:30:03'),
(2, NULL, NULL, '2', '$2y$12$/sh.edRN23AavlQyBYK5uOM45Upw9dyCkD.X9K.mhbbkVp/ybXqPO', 'USER ##1', NULL, 'FrIkiQtFT4k8FPhoCxmo13SHRGFvdEcapGlK6XoV2nTNHkq9Z9RqeDpawlPa', 'erwSRNxU3xi4CwhH79rhWwgSdA779Aem', '', 1, 0, 1, '2017-10-05 09:18:40', '2017-10-17 11:35:09'),
(4, NULL, NULL, 'xxx@mail.com', '$2y$12$14L8axtvGyjd154cu/mxlOf/g/SBIoPX5CiPfS8jbw0mxeo9BqGVa', 'xxxx', NULL, NULL, 'e5d4cda72ae59f50fe0db2858b5eace2', '', 1, 0, 0, '2017-10-11 10:01:50', '2017-10-11 10:01:50'),
(5, NULL, NULL, 'test@mail.com', '$2y$12$0gYQ8EVrbtEuHCkNLl5OVOuXlzpRXckfkSx8wVraAJUm5ZxBnQ3Di', 'test', NULL, NULL, 'afe0ee8471d878ec731d9ae72b4c5a44', '', 1, 0, 0, '2017-10-11 10:04:26', '2017-10-11 10:04:26'),
(6, NULL, NULL, 'aaaaa@mail.com', '$2y$12$Cb9rkDgMvohjfrWxHdlSEO3CQSUF9DflimUTmYZ/DGby7ncAgINdW', 'aaaa', NULL, NULL, 'e49ced394567a59e9b8aebd645dcee2f', '', 1, 0, 0, '2017-10-11 10:04:46', '2017-10-11 10:04:46');

-- --------------------------------------------------------

--
-- Table structure for table `user_in_chat_room`
--

CREATE TABLE `user_in_chat_room` (
  `chat_room_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `notify` tinyint(1) NOT NULL DEFAULT '0',
  `message_read` int(11) UNSIGNED DEFAULT NULL,
  `message_read_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_in_chat_room`
--

INSERT INTO `user_in_chat_room` (`chat_room_id`, `user_id`, `notify`, `message_read`, `message_read_date`) VALUES
(1, 1, 0, 3, '2017-10-17 11:35:01'),
(1, 2, 0, 3, '2017-10-17 11:35:04');

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
-- Indexes for table `seller_chat_rooms`
--
ALTER TABLE `seller_chat_rooms`
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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `chat_rooms`
--
ALTER TABLE `chat_rooms`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
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
-- AUTO_INCREMENT for table `seller_chat_rooms`
--
ALTER TABLE `seller_chat_rooms`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `social_providers`
--
ALTER TABLE `social_providers`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `temporary_files`
--
ALTER TABLE `temporary_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
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
