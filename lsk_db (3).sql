-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 17, 2024 at 01:26 PM
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
-- Database: `lsk_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_id` varchar(50) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `batch_number` varchar(50) NOT NULL,
  `production_date` date NOT NULL,
  `product_type` varchar(200) NOT NULL,
  `route` varchar(200) NOT NULL,
  `hardness` varchar(100) NOT NULL,
  `oven_setting` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `qr_code_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_id`, `product_name`, `batch_number`, `production_date`, `product_type`, `route`, `hardness`, `oven_setting`, `created_at`, `updated_at`, `qr_code_path`) VALUES
(68, 'LSK626', 'Deborah Guthrie', '418', '2015-02-03', '---select type---', '3', 'DX < UD', '1b to 16b', '2024-09-14 21:00:00', '2024-09-14 21:00:00', '9878'),
(69, 'LSK537', 'Edan Watson', '57', '1993-08-16', '---select type---', '7', 'SELECT HARDNESS TYPE', '1b to 16b', '2024-09-14 21:00:00', '2024-09-14 21:00:00', '9878'),
(70, 'LSK42', 'Ria Russell', '25', '2024-02-26', 'Matress', '2', 'SELECT HARDNESS TYPE', 'Choose Oven Setting', '2024-09-14 21:00:00', '2024-09-14 21:00:00', '9878');

-- --------------------------------------------------------

--
-- Table structure for table `product_verifications`
--

CREATE TABLE `product_verifications` (
  `id` int(11) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `auth_code` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_verifications`
--

INSERT INTO `product_verifications` (`id`, `product_id`, `email`, `auth_code`, `created_at`) VALUES
(20, '', 'Atugonzabenjaminm@gmail.com', '932301', '2024-09-10 02:57:22'),
(21, '', 'Atugonzabenjaminm@gmail.com', '291173', '2024-09-10 13:12:06'),
(22, '', 'Atugonzabenjaminm@gmail.com', '120121', '2024-09-10 13:35:33'),
(23, '', 'Atugonzabenjaminm@gmail.com', '657852', '2024-09-10 13:52:41'),
(24, '', 'davidcheng@aismartuallearning.com', '388147', '2024-09-10 13:58:51'),
(25, '', 'brevin@vlearned.com', '844252', '2024-09-10 14:00:52'),
(26, '', 'kiggundubrevin@gmail.com', '606110', '2024-09-10 14:01:37'),
(27, '', 'Atugonzabenjaminm@gmail.com', 'WTVoczBsMmxldnJSS3RQcmR6ZWxwQT09OjoyYmVjb3U1bkZkNGlIR3VEUDBEd1ZRPT0=', '2024-09-10 14:06:07'),
(28, '', 'Atugonzabenjaminm@gmail.com', 'bUFaWDZmY1hxMzFGSTJLaGJoV2N6QT09OjpDKzd3NVJWRE81ZTdqSHFxWmRGMVN3PT0=', '2024-09-10 14:28:13'),
(29, '', 'Atugonzabenjaminm@gmail.com', '', '2024-09-10 14:29:27'),
(30, '', 'Atugonzabenjaminm@gmail.com', '738922', '2024-09-10 14:36:17'),
(31, '', 'Atugonzabenjaminm@gmail.com', '626366', '2024-09-10 14:45:24'),
(32, '', 'Atugonzabenjaminm@gmail.com', '738922', '2024-09-10 14:47:25'),
(33, '', 'Atugonzabenjaminm@gmail.com', '738922', '2024-09-10 14:52:52'),
(34, '', 'Atugonzabenjaminm@gmail.com', '751737', '2024-09-11 12:38:35'),
(35, '', 'benjamin@vlearned.com', '810375', '2024-09-11 14:34:44');

-- --------------------------------------------------------

--
-- Table structure for table `qr_codes`
--

CREATE TABLE `qr_codes` (
  `id` int(11) NOT NULL,
  `product_id` varchar(50) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `auth_code` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `qr_codes`
--

INSERT INTO `qr_codes` (`id`, `product_id`, `product_name`, `auth_code`, `file_path`, `created_at`) VALUES
(199, '', 'Ria Russell', '700251', 'qrcodes/66e701388edc2.png', '2024-09-15 15:46:00'),
(201, '', 'Edan Watson', '814775', 'qrcodes/66e702235d375.png', '2024-09-15 15:49:55'),
(202, '', 'Deborah Guthrie', '349339', 'qrcodes/66e7022b3878f.png', '2024-09-15 15:50:03'),
(204, 'LSK626', 'Deborah Guthrie', '272742', 'qrcodes/66e71b7c9b440.png', '2024-09-15 17:38:04');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `national_id` varchar(20) NOT NULL,
  `user_role` enum('admin','super admin') DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `national_id`, `user_role`, `password`, `photo`, `created_at`, `updated_at`) VALUES
(1, 'Matsiko Elia', 'admin@gmail.com', 'HGIU540584973H9U', 'admin', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'http://localhost/lsk/uploads/9460922519656.jpg', '2024-09-04 14:07:30', '2024-09-08 08:02:14'),
(2, 'Mikelson', 'superadmin@gmail.com', '98765467890', 'super admin', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'http://localhost/lsk/uploads/98765467890-987654325678908765.jpg', '2024-09-05 09:49:12', '2024-09-08 08:01:59'),
(3, 'zyqafixulo', 'deqeca@mailinator.com', 'Perferendis placeat', 'admin', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'http://localhost/lskauth/uploads/1129695624239', '2024-09-15 15:31:40', '2024-09-15 15:31:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_verifications`
--
ALTER TABLE `product_verifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qr_codes`
--
ALTER TABLE `qr_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `national_id` (`national_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `product_verifications`
--
ALTER TABLE `product_verifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `qr_codes`
--
ALTER TABLE `qr_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=205;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
