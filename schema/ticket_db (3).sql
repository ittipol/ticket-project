-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2017 at 02:04 PM
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
(1, 'Ticket', 'kA8ekxas', NULL, NULL, NULL, 1, '2017-10-22 18:14:49');

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
  `date_1` date DEFAULT NULL,
  `date_2` date NOT NULL,
  `contact` text NOT NULL,
  `purpose` varchar(1) NOT NULL,
  `closing_option` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `closing_reason` text,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(1, NULL, NULL, '1', '$2y$12$/sh.edRN23AavlQyBYK5uOM45Upw9dyCkD.X9K.mhbbkVp/ybXqPO', 'Seller Name #1', 33, 'YiTR8ZMCJLfZPj47zD4gyWgxoHzrD8JoMCP2n3IHeUVHm8Er4NDo9gzBp0aN', 'P8MMnjylNpRuKJhPOUFMmD2LEqYSvDkI', '', 1, 0, 1, '2017-10-22 18:55:44', '2017-10-05 06:06:28', '2017-10-22 18:55:44'),
(2, NULL, NULL, '2', '$2y$12$/sh.edRN23AavlQyBYK5uOM45Upw9dyCkD.X9K.mhbbkVp/ybXqPO', 'new user !!!!', 34, 'WE45a3Zf7TNxYmRzq6jWRA2aCwYVnb4cMDTS4pueiTzPChWA5FLeg6V52Qjk', '0zS1Gz5j46atvP8MlVVT4Ts5ovyWSw2d', '', 1, 0, 0, '2017-10-21 11:58:21', '2017-10-05 09:18:40', '2017-10-21 11:59:14'),
(4, NULL, NULL, 'xxx@mail.com', '$2y$12$14L8axtvGyjd154cu/mxlOf/g/SBIoPX5CiPfS8jbw0mxeo9BqGVa', 'xxxx', NULL, NULL, 'e5d4cda72ae59f50fe0db2858b5eace2', '', 1, 0, 0, NULL, '2017-10-11 10:01:50', '2017-10-11 10:01:50'),
(5, NULL, NULL, 'test@mail.com', '$2y$12$0gYQ8EVrbtEuHCkNLl5OVOuXlzpRXckfkSx8wVraAJUm5ZxBnQ3Di', 'test', NULL, NULL, 'afe0ee8471d878ec731d9ae72b4c5a44', '', 1, 0, 0, NULL, '2017-10-11 10:04:26', '2017-10-11 10:04:26'),
(6, NULL, NULL, 'aaaaa@mail.com', '$2y$12$Cb9rkDgMvohjfrWxHdlSEO3CQSUF9DflimUTmYZ/DGby7ncAgINdW', 'aaaa', NULL, NULL, 'e49ced394567a59e9b8aebd645dcee2f', '', 1, 0, 0, NULL, '2017-10-11 10:04:46', '2017-10-11 10:04:46'),
(7, 1, '1433656016731239', 'ittipol_master@hotmail.com', NULL, 'Ittipol Kaewprasert', 35, 'cIemGiLjyuAE1W5AUDTvGmGEr2NHydXru89V3gllq02i1DcoW0CQqaMnxMOK', '1', 'vXIrCHaH6dvINxn0D5A0MMVN1cmjtDS9', 0, 0, 0, '2017-10-22 15:57:40', '2017-10-21 22:40:13', '2017-10-22 18:12:23');

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `chat_rooms`
--
ALTER TABLE `chat_rooms`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ticket_categories`
--
ALTER TABLE `ticket_categories`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `ticket_chat_rooms`
--
ALTER TABLE `ticket_chat_rooms`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `words`
--
ALTER TABLE `words`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
