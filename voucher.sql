-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:8111
-- Generation Time: Dec 09, 2022 at 11:07 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `voucher`
--

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20221209125144', '2022-12-09 13:51:56', 119),
('DoctrineMigrations\\Version20221209135852', '2022-12-09 14:59:02', 160);

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `total_amount` decimal(4,2) NOT NULL,
  `voucher_id` int(11) DEFAULT NULL,
  `paid_amount` decimal(4,2) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `total_amount`, `voucher_id`, `paid_amount`, `created_at`) VALUES
(1, '10.00', 2, '0.01', '2022-12-09 21:32:25'),
(2, '10.00', 1, '2.00', '2022-12-09 22:26:35');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `roles` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `status`, `created_at`, `updated_at`) VALUES
(1, 'test38@gmail.com', 'ROLE_CREATOR', '$2y$13$PXOPNf4PAuUdWlAgsTdwOepJgCi1FtlvWYYzwljXsoZuSlcZg8Fki', 1, '2022-12-09 14:13:50', '2022-12-09 14:13:50'),
(2, 'test3@gmail.com', 'ROLE_CREATOR', '$2y$13$8o/Ag933Zf7/ohxZ5nMToO13e5Zjs3EtXcjTBXmf.QyriZPeUqIyi', 1, '2022-12-09 22:31:01', '2022-12-09 22:31:01'),
(3, 'test31@gmail.com', 'ROLE_CREATOR', '$2y$13$LV.0lsQWVbiom.dSJQ2AROVnA7c32QgRzTU8OJoMUpDvzIDfzTEgm', 1, '2022-12-09 22:58:30', '2022-12-09 22:58:30');

-- --------------------------------------------------------

--
-- Table structure for table `voucher`
--

CREATE TABLE `voucher` (
  `id` int(11) NOT NULL,
  `code` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `discount` decimal(3,2) NOT NULL,
  `status` smallint(6) NOT NULL,
  `expired_at` date NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `voucher`
--

INSERT INTO `voucher` (`id`, `code`, `discount`, `status`, `expired_at`, `created_at`, `updated_at`) VALUES
(1, 'njohs5n', '8.00', 2, '2022-12-15', '2022-12-09 16:54:09', '2022-12-09 22:26:35'),
(2, '19e84dk', '9.99', 0, '2022-12-13', '2022-12-09 16:55:04', '2022-12-09 22:33:19'),
(3, 'znewpal', '9.99', 1, '2022-12-11', '2022-12-09 22:31:40', '2022-12-09 22:31:40'),
(4, '3y9bu1h', '9.99', 1, '2022-12-11', '2022-12-09 23:04:52', '2022-12-09 23:04:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `voucher`
--
ALTER TABLE `voucher`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_1392A5D877153098` (`code`),
  ADD KEY `voucher_voucher_idx` (`code`,`status`,`expired_at`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `voucher`
--
ALTER TABLE `voucher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
