-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 05, 2024 at 09:02 AM
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
-- Database: `todo_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `sub_todos`
--

CREATE TABLE `sub_todos` (
  `id` bigint(30) NOT NULL,
  `userid` bigint(30) NOT NULL,
  `todo_id` bigint(30) NOT NULL,
  `title` text NOT NULL,
  `is_complete` tinyint(2) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sub_todos`
--

INSERT INTO `sub_todos` (`id`, `userid`, `todo_id`, `title`, `is_complete`, `created_at`, `updated_at`) VALUES
(3, 2, 1, 'test 1', 1, '2024-06-05 10:52:18', '2024-06-05 12:31:07'),
(4, 2, 4, 'test 2', 0, '2024-06-05 12:17:15', '2024-06-05 12:17:46');

-- --------------------------------------------------------

--
-- Table structure for table `todo_card`
--

CREATE TABLE `todo_card` (
  `id` bigint(30) NOT NULL,
  `user_id` bigint(30) NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `color` varchar(9) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `todo_card`
--

INSERT INTO `todo_card` (`id`, `user_id`, `title`, `description`, `color`, `created_at`, `updated_at`) VALUES
(1, 2, 'Todo', 'Todo', '#FC4100', '2024-05-19 15:49:34', '2024-05-19 15:49:34'),
(4, 2, 'sports', 'sports', '#F5DAD2', '2024-05-19 16:29:38', '2024-05-19 16:29:38');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(30) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile_no` varchar(11) NOT NULL,
  `avatar_url` text NOT NULL,
  `pass` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `user_name`, `email`, `mobile_no`, `avatar_url`, `pass`) VALUES
(2, 'bhavesh', 'patil', 'Bhavesh_patil', 'temp@gmail.com', '9000000021', 'uploads/Screenshot from 2023-08-25 08-37-48.png', '$2y$10$txuXn61wJWnBuNXGBKHV9eLGOfdFeQmVAAWxYjKo2EYlb5FrJeZIG');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sub_todos`
--
ALTER TABLE `sub_todos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Foreign key 4` (`userid`),
  ADD KEY `Foreign key 5` (`todo_id`);

--
-- Indexes for table `todo_card`
--
ALTER TABLE `todo_card`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Foreign key` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_name` (`user_name`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sub_todos`
--
ALTER TABLE `sub_todos`
  MODIFY `id` bigint(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `todo_card`
--
ALTER TABLE `todo_card`
  MODIFY `id` bigint(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sub_todos`
--
ALTER TABLE `sub_todos`
  ADD CONSTRAINT `Foreign key 4` FOREIGN KEY (`userid`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `Foreign key 5` FOREIGN KEY (`todo_id`) REFERENCES `todo_card` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `todo_card`
--
ALTER TABLE `todo_card`
  ADD CONSTRAINT `Foreign key` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
