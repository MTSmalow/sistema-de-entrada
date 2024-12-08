-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 07, 2024 at 03:15 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistema_entrada`
--

-- --------------------------------------------------------

--
-- Table structure for table `presencas`
--

CREATE TABLE `presencas` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `presencas`
--

INSERT INTO `presencas` (`id`, `user_id`, `data`) VALUES
(2, 1, '2024-12-02'),
(1, 1, '2024-12-04');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `hash_username_password` varchar(64) NOT NULL,
  `hash_email_password` varchar(64) NOT NULL,
  `codigo_unico` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `hash_username_password`, `hash_email_password`, `codigo_unico`) VALUES
(null, 'MTSmalow', 'medeirosdinieduardo@gmail.com', '12754bf3a18e1d01fb230e76181e7ef73f830068b1238e4cf410d027915a0cff', '8a902f261321f4437c97dfd316f60d8b88a8acb5fa51fb1a2f780caf8a983ef5', 78924);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `presencas`
--
ALTER TABLE `presencas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`data`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo_unico` (`codigo_unico`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `presencas`
--
ALTER TABLE `presencas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `presencas`
--
ALTER TABLE `presencas`
  ADD CONSTRAINT `presencas_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
