-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 08, 2024 at 04:41 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `greekmyth`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `activity_id` int(11) NOT NULL,
  `post_id` varchar(36) DEFAULT NULL,
  `comment_id` varchar(36) DEFAULT NULL,
  `user_id` varchar(36) NOT NULL,
  `activity` varchar(225) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`activity_id`, `post_id`, `comment_id`, `user_id`, `activity`, `timestamp`) VALUES
(95, NULL, '66646a44b1ebf', '666324fad693b', 'commennted on your post titled Amongus', '2024-06-08 14:27:16'),
(96, '66646a9b9dbe4', NULL, '666324fad693b', 'created a post a with title ads', '2024-06-08 14:28:43'),
(97, '66646a9b9dbe4', NULL, '666324fad693b', 'edited a post with title ads', '2024-06-08 14:33:44');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` varchar(36) NOT NULL,
  `post_id` varchar(36) NOT NULL,
  `parent_comment` varchar(36) DEFAULT NULL,
  `author` varchar(36) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `post_id`, `parent_comment`, `author`, `content`, `created_at`) VALUES
('66646a44b1ebf', 'fa7d0ad5-25a2-11ef-95c0-7c05075eb45f', NULL, '666324fad693b', 'adsasd', '2024-06-08 22:27:16');

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `friend_id` varchar(36) NOT NULL,
  `user` varchar(36) NOT NULL,
  `friend` varchar(36) NOT NULL,
  `added_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `greeks`
--

CREATE TABLE `greeks` (
  `greek_id` varchar(36) NOT NULL,
  `name` varchar(36) NOT NULL,
  `age` int(36) NOT NULL,
  `image_url` varchar(225) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `like_id` varchar(36) NOT NULL,
  `liker` varchar(36) NOT NULL,
  `post_id` varchar(36) NOT NULL,
  `comment_id` varchar(36) NOT NULL,
  `timestamp` datetime NOT NULL,
  `vote_type` varchar(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` varchar(36) NOT NULL,
  `title` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `author` varchar(36) NOT NULL,
  `likes` int(11) NOT NULL DEFAULT 0,
  `dislikes` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `title`, `content`, `author`, `likes`, `dislikes`, `created_at`, `updated_at`) VALUES
('66646a9b9dbe4', 'ads', 'sadsdaadsdsasda', '666324fad693b', 0, 0, '2024-06-08 22:28:43', '2024-06-08 22:33:44'),
('fa7d0ad5-25a2-11ef-95c0-7c05075eb45f', 'Amongus', 'Amogusss', '6663eb029af37', 0, 0, '2024-06-08 22:25:38', '2024-06-08 22:25:38');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` varchar(36) NOT NULL,
  `username` varchar(225) NOT NULL,
  `email` varchar(225) NOT NULL,
  `password` varchar(225) NOT NULL,
  `profile_pic` varchar(225) DEFAULT NULL,
  `bio` varchar(36) DEFAULT NULL,
  `token` varchar(225) NOT NULL,
  `joined_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `profile_pic`, `bio`, `token`, `joined_at`) VALUES
('6662865c3867d', 'ZENZEN', 'merinojc25@gmail.com', '$2y$10$BeL1549p.a44bsqRSh9J1.Kclb/y63t4OQjgx5xmkyAsx7j5ETHf6', NULL, NULL, '', '2024-06-07 12:02:36'),
('66631c3c988a2', 'Omniman', 'henryalphia@gmail.com', '$2y$10$sXHKGqDpEakX72F4UDSunOSYPRXjrElktFRIeS7Ve9Xi5IxjeYJoy', NULL, NULL, '', '2024-06-07 22:42:04'),
('666324fad693b', 'GGG', 'ggg@gmail.com', '$2y$10$xTN/4fiNqNlYNieeI11eru5GYyfrl7llJm6RiAcQKRcCAz1VMDw56', '666326ed4fdd49.92745655.jpg', NULL, '', '2024-06-07 23:19:22'),
('6663eb029af37', 'Breme', 'breme@gmail.com', '$2y$10$bRMua1YU.puqevvk.w2CYuWnqU/IGcKU9/S9ovpMwTyOI5CwaSdYK', '6663eb1473bd73.90689395.jpg', 'I\'M GAEEEEEE', '', '2024-06-08 13:24:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`activity_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `comment_id` (`comment_id`),
  ADD KEY `activities_ibfk_3` (`user_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `comments_fk2` (`parent_comment`),
  ADD KEY `comments_fk3` (`post_id`),
  ADD KEY `comments_fk1` (`author`);

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`friend_id`),
  ADD KEY `friends_ibfk_1` (`user`),
  ADD KEY `friends_ibfk_2` (`friend`);

--
-- Indexes for table `greeks`
--
ALTER TABLE `greeks`
  ADD PRIMARY KEY (`greek_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`like_id`),
  ADD KEY `likes_ibfk_1` (`liker`),
  ADD KEY `likes_ibfk_2` (`post_id`),
  ADD KEY `likes_ibfk_3` (`comment_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `author` (`author`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activities`
--
ALTER TABLE `activities`
  ADD CONSTRAINT `activities_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `activities_ibfk_2` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`comment_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `activities_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_fk1` FOREIGN KEY (`author`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_fk2` FOREIGN KEY (`parent_comment`) REFERENCES `comments` (`comment_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_fk3` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE;

--
-- Constraints for table `friends`
--
ALTER TABLE `friends`
  ADD CONSTRAINT `friends_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `friends_ibfk_2` FOREIGN KEY (`friend`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`liker`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `likes_ibfk_3` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`comment_id`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`author`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
