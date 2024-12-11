-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 11, 2024 at 09:44 AM
-- Server version: 8.0.30
-- PHP Version: 7.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e_katalog`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Makanan'),
(2, 'Minuman');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int NOT NULL,
  `table_number` int NOT NULL,
  `customer_name` varchar(50) NOT NULL,
  `order_date` date NOT NULL,
  `status` enum('diproses','selesai','dibatalkan') NOT NULL,
  `total` int NOT NULL,
  `amount_paid` int NOT NULL,
  `change` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `table_number`, `customer_name`, `order_date`, `status`, `total`, `amount_paid`, `change`, `created_at`) VALUES
(16, 2, 'deni', '2024-12-08', 'selesai', 35000, 50000, 15000, '2024-12-08 12:04:59'),
(17, 2, 'Deni', '2024-12-08', 'selesai', 25000, 30000, 5000, '2024-12-08 12:26:16'),
(18, 1, 'as', '2024-12-11', 'selesai', 25007, 50000, 24993, '2024-12-11 10:56:05'),
(19, 3, 'gh', '2024-12-11', 'selesai', 15000, 15000, 0, '2024-12-11 10:56:49'),
(20, 3, 'ghandi', '2024-12-11', 'selesai', 25007, 30000, 4993, '2024-12-11 13:21:06'),
(21, 6, 'gh', '2024-12-11', 'selesai', 15000, 15000, 0, '2024-12-11 13:24:44'),
(22, 4, 'g', '2024-12-11', 'diproses', 25000, 25000, 0, '2024-12-11 16:23:32');

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` int NOT NULL,
  `subtotal` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`id`, `order_id`, `product_id`, `quantity`, `price`, `subtotal`) VALUES
(31, 16, 16, 2, 10000, 20000),
(32, 16, 15, 1, 15000, 15000),
(33, 17, 16, 1, 10000, 10000),
(34, 17, 15, 1, 15000, 15000),
(35, 18, 17, 1, 1, 1),
(36, 18, 16, 1, 10000, 10000),
(37, 18, 15, 1, 15000, 15000),
(38, 18, 18, 1, 2, 2),
(39, 18, 19, 1, 4, 4),
(40, 19, 15, 1, 15000, 15000),
(41, 20, 15, 1, 15000, 15000),
(42, 20, 16, 1, 10000, 10000),
(43, 20, 17, 1, 1, 1),
(44, 20, 18, 1, 2, 2),
(45, 20, 19, 1, 4, 4),
(46, 21, 15, 1, 15000, 15000),
(47, 22, 15, 1, 15000, 15000),
(48, 22, 16, 1, 10000, 10000);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` double NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` int NOT NULL,
  `category_id` int NOT NULL,
  `desc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `price`, `image`, `status`, `category_id`, `desc`) VALUES
(15, 'Kopi', 15000, 'coffee-4550347_1280.jpg', 1, 2, ''),
(16, 'Mie', 10000, 'kuliner-indonesia.jpg', 1, 1, ''),
(17, 'Baso', 15000, 'no-profil.jpg', 1, 1, ''),
(18, 'Susu Jahe', 50000, 'no-profil1.jpg', 1, 1, ''),
(19, 'c', 4, 'no-profil2.jpg', 1, 1, ''),
(20, 'f', 50000, 'no-profil3.jpg', 1, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(72) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2a$12$hv8Ge6v9PfU0Ju1Eqz7HEO.m6E0UJzv3FkMCTrj3dMKr1LhMFHpVW');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `order_detail_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_detail_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
