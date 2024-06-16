-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 16, 2024 at 04:51 PM
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
(199, '666e625a2df0a', NULL, '66690a8bafcdb', 'created a post a with title asdsa', '2024-06-16 03:56:10'),
(200, '666e7a6772b98', NULL, '66690a8bafcdb', 'created a post a with title asdsasda', '2024-06-16 05:38:47'),
(201, NULL, '666ecfb56182b', '66690a8bafcdb', 'commennted on a post titled asdsasda', '2024-06-16 11:42:45'),
(202, NULL, '666ed16dac6a4', '66690a8bafcdb', 'commennted on a post titled asdsasda', '2024-06-16 11:50:05'),
(203, NULL, '666ed7c57859f', '66690a8bafcdb', 'commennted on a post titled asdsasda', '2024-06-16 12:17:09'),
(204, NULL, '666ed865bce67', '66690a8bafcdb', 'replied to a comment titled asdsasda', '2024-06-16 12:19:50'),
(205, NULL, '666ed8bf377f7', '66690a8bafcdb', 'commennted on a post titled asdsa', '2024-06-16 12:21:19');

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
  `likes` int(11) NOT NULL DEFAULT 0,
  `dislikes` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `post_id`, `parent_comment`, `author`, `content`, `likes`, `dislikes`, `created_at`) VALUES
('666ecfb56182b', '666e7a6772b98', NULL, '66690a8bafcdb', 'YEY', 0, 0, '2024-06-16 19:42:45'),
('666ed16dac6a4', '666e7a6772b98', NULL, '66690a8bafcdb', 'wqeqw', 0, 1, '2024-06-16 19:50:05'),
('666ed7c57859f', '666e7a6772b98', NULL, '66690a8bafcdb', 'dsfds', 0, 0, '2024-06-16 20:17:09'),
('666ed865bce67', '666e7a6772b98', '666ed7c57859f', '66690a8bafcdb', 'Yeahhh', 1, 0, '2024-06-16 20:19:49'),
('666ed8bf377f7', '666e625a2df0a', NULL, '66690a8bafcdb', 'asdsad', 0, 0, '2024-06-16 20:21:19');

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `id` varchar(36) NOT NULL,
  `user_id` varchar(36) NOT NULL,
  `friend_id` varchar(36) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`id`, `user_id`, `friend_id`, `created_at`) VALUES
('6669cf2a2420d', '66690a8bafcdb', '666919a7f382e', '2024-06-12 16:39:06'),
('6669cf2a512b9', '666919a7f382e', '66690a8bafcdb', '2024-06-12 16:39:06'),
('6669df7ee01f5', '6669de93d8815', '66690a8bafcdb', '2024-06-12 17:48:46'),
('6669df7f04606', '66690a8bafcdb', '6669de93d8815', '2024-06-12 17:48:47'),
('666bcf086627c', '666bb88698452', '66690a8bafcdb', '2024-06-14 05:03:04'),
('666bcf086e75d', '66690a8bafcdb', '666bb88698452', '2024-06-14 05:03:04'),
('666d0ddc6e284', '66690a8bafcdb', '666b229d7cd3d', '2024-06-15 03:43:24'),
('666d0ddc7bf6c', '666b229d7cd3d', '66690a8bafcdb', '2024-06-15 03:43:24'),
('666d0f5a85470', '666bb88698452', '6669de93d8815', '2024-06-15 03:49:46'),
('666d0f5aad992', '6669de93d8815', '666bb88698452', '2024-06-15 03:49:46'),
('666e87f24abab', '6669de93d8815', '666b229d7cd3d', '2024-06-16 06:36:34'),
('666e87f2588fd', '666b229d7cd3d', '6669de93d8815', '2024-06-16 06:36:34');

-- --------------------------------------------------------

--
-- Table structure for table `friend_requests`
--

CREATE TABLE `friend_requests` (
  `id` varchar(36) NOT NULL,
  `requester_id` varchar(36) NOT NULL,
  `requestee_id` varchar(36) NOT NULL,
  `status` enum('pending','accepted','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `greeks`
--

CREATE TABLE `greeks` (
  `greek_id` varchar(36) NOT NULL,
  `name` varchar(36) NOT NULL,
  `gender` varchar(36) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(225) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `greeks`
--

INSERT INTO `greeks` (`greek_id`, `name`, `gender`, `description`, `image_url`) VALUES
('0db1bfad-2ba8-11ef-a131-7c05075eb45f', 'Hermes', 'Male', 'Hermes, the quick-witted Greek god of trade, thieves, travelers, sports, athletes, and border crossings, is often portrayed as a young, athletic man wearing a winged hat and sandals. He is known for his cunning and mischievous nature, as well as his role as the messenger of the gods. Hermes is also associated with fertility, luck, and wealth, and is often depicted carrying a caduceus, a winged staff entwined with two serpents.', 'HERMES.webp'),
('1c87d062-2ba3-11ef-a131-7c05075eb45f', 'Hades', 'Male', 'Hades, in ancient Greek religion, is the god of the underworld. He was a son of the Titans Cronus and Rhea and the brother of Zeus, Poseidon, and Hera. Hades ruled alongside his queen, Persephone, over the dead, although he was not typically a judge or responsible for torturing the guilty—tasks assigned to the Furies', 'HADES.webp'),
('2adbfbd3-2ba2-11ef-a131-7c05075eb45f', 'Apollo', 'Male', 'Apollo, one of the Twelve Olympians in Greek mythology, is the son of Zeus and Leto, and the twin brother of Artemis. He embodies a multitude of roles: the god of healing, medicine, archery, music, dance, poetry, prophecy, knowledge, light, and the sun. Apollo is also the leader of the Muses', 'APOLLO.webp'),
('2b013a64-2ba0-11ef-a131-7c05075eb45f', 'Aphrodite', 'Female', 'Aphrodite, the ancient Greek goddess of sexual love and beauty, is closely associated with Venus in Roman mythology. According to Hesiod’s Theogony, she emerged from the white foam created by the severed genitals of Uranus (Heaven) after his son Cronus threw them into the sea. Aphrodite was widely worshipped as a goddess of the sea, seafaring, love, and fertility. While her public cult was generally solemn, she occasionally presided over marriage. Notably, she had mortal lovers, including the Trojan shepherd Anchises (with whom she became the mother of Aeneas) and the youth Adonis.', 'APHRODITE.webp'),
('44c24fcc-2ba4-11ef-a131-7c05075eb45f', 'Artemis', 'Female', 'Artemis, in ancient Greek religion and mythology, is the goddess of the hunt, the wilderness, wild animals, nature, vegetation, childbirth, care of children, and chastity. She was often said to roam the forests and mountains, attended by her entourage of nymphs. Artemis is the daughter of Zeus and Leto, and the twin sister of Apollo. She was very protective of her and her priestesses innocence.', 'ARTEMIS.webp'),
('5e965592-2ba6-11ef-a131-7c05075eb45f', 'Poseiddon', 'Male', 'Poseidon, in Greek mythology, is the god of the sea, earthquakes, and horses. He is one of the Twelve Olympians, the major deities of the Greek pantheon. Often depicted with a trident, Poseidon is known for his tempestuous nature, capable of both fury and benevolence. He is considered a protector of seafarers and a creator of storms and floods. In Roman mythology, he is identified with Neptune.', 'POSEIDON.webp'),
('8d2d3e82-2ba4-11ef-a131-7c05075eb45f', 'Athena', 'Female', 'Athena, in Greek religion, is the city protectress, goddess of war, handicraft, and practical reason. The Romans identified her with Minerva. Unlike Ares, the god of war who represents mere bloodlust, Athena embodies the intellectual and civilized side of war, emphasizing justice and skill. She was also associated paradoxically with peace and handicrafts, particularly spinning and weaving. Majestic and stern, Athena surpassed all others in her domains.', 'ATHENA.webp'),
('8e3c6da0-2ba3-11ef-a131-7c05075eb45f', 'Ares', 'Male', 'Ares, the Greek god of war, is one of the Twelve Olympians. He is often depicted as a fierce and bloodthirsty warrior. Ares is the son of Zeus and Hera, and his siblings include Athena, Apollo, and Hermes. In Greek mythology, he is associated with violence, conflict, and the brutality of war', 'ARES.Webp'),
('b9da2016-2ba7-11ef-a131-7c05075eb45f', 'Demeter', 'Female', 'Demeter, the revered Greek goddess of agriculture, grain, and fertility, holds a prominent position in Greek mythology and the hearts of ancient people. As the giver of life and sustenance, her influence extended far beyond the fields, touching upon the very cycles of life, death, and rebirth. Demeter is often depicted as a mature woman, her presence radiating warmth and abundance. She is adorned with symbols of her dominion, such as sheaves of wheat, a cornucopia overflowing with fruits and grains, or a torch symbolizing enlightenment and knowledge.\r\n\r\nDemeter\'s significance is deeply intertwined with the Eleusinian Mysteries, secretive rituals centered around the myth of her daughter Persephone\'s abduction by Hades, the god of the underworld. This tragic event plunged Demeter into grief, causing the earth to wither and die. However, upon Persephone\'s eventual return, the world bloomed anew, signifying the renewal of life and the cyclical nature of the seasons. The Eleusinian Mysteries offered initiates a glimpse into these profound concepts, promising a blessed afterlife and fostering a sense of connection to the divine.', 'DEMETER.webp'),
('b9da2cb2-2ba7-11ef-a131-7c05075eb45f', 'Dionysius', 'Male', 'Dionysus, the enigmatic and captivating Greek god of wine, revelry, theater, and religious ecstasy, holds a unique place in the pantheon of Greek deities. Often depicted as a youthful and exuberant figure, adorned with ivy wreaths and holding a thyrsus (a pinecone-tipped staff), Dionysus embodies the spirit of uninhibited joy, transformation, and the blurring of boundaries between the human and divine.\r\n\r\nHis origins are shrouded in mystery, with various myths attributing his birthplace to different regions. Some tales claim he is a foreign god who arrived in Greece from the East, bringing with him the knowledge of viticulture and the intoxicating power of wine. Others describe him as the son of Zeus and the mortal Semele, who perished due to Hera\'s jealousy. Regardless of his origin, Dionysus quickly became a beloved figure, celebrated for his ability to liberate people from their inhibitions and connect them to the primal forces of nature.', 'DIONYSIUS.webp'),
('cec09d13-2b9d-11ef-a131-7c05075eb45f', 'Zeus', 'Male', 'Zeus, the sky and thunder god in ancient Greek mythology, rules as the king of the gods on Mount Olympus. As the chief Greek deity, he is considered the protector and father of all gods and humans. Zeus is often depicted as an older man with a beard, and his symbols include the lightning bolt and the eagle. He was notorious for his numerous divine and heroic offspring, including Apollo, Artemis, Hermes, and Heracles. His traditional weapon is the thunderbolt, and he is equated with the Roman god Jupiter.', 'ZEUS.webp'),
('eb824654-2ba6-11ef-a131-7c05075eb45f', 'Hera', 'Female', 'Hera, the queen of Olympus in Greek mythology, is the goddess of marriage, women, family, and childbirth. She is the wife and sister of Zeus, the king of the gods. While revered for her role as a protector of women, Hera is also known for her jealous and vengeful nature, often directed towards Zeus\'s lovers and their offspring. Her stories are filled with drama, passion, and divine retribution, making her a compelling figure in ancient Greek lore.', 'HERA.webp');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `like_id` varchar(36) NOT NULL,
  `liker` varchar(36) NOT NULL,
  `post_id` varchar(36) DEFAULT NULL,
  `comment_id` varchar(36) DEFAULT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp(),
  `vote_type` varchar(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`like_id`, `liker`, `post_id`, `comment_id`, `timestamp`, `vote_type`) VALUES
('666ed50e7332d', '66690a8bafcdb', '666e625a2df0a', NULL, '2024-06-16 20:05:34', 'dislike'),
('666ed84af2b77', '66690a8bafcdb', NULL, '666ed16dac6a4', '2024-06-16 20:19:22', 'dislike'),
('666ed86dccf9e', '66690a8bafcdb', NULL, '666ed865bce67', '2024-06-16 20:19:57', 'like');

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
  `greek_group` varchar(36) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `title`, `content`, `author`, `likes`, `dislikes`, `greek_group`, `created_at`, `updated_at`) VALUES
('666e625a2df0a', 'asdsa', 'dsasa', '66690a8bafcdb', 0, 1, NULL, '2024-06-16 11:56:10', '2024-06-16 11:56:10'),
('666e7a6772b98', 'asdsasda', 'asdasddsa', '66690a8bafcdb', 0, 0, NULL, '2024-06-16 13:38:47', '2024-06-16 13:38:47');

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
('66690a8bafcdb', 'ZenithSUS', 'merinojc25@gmail.com', '$2y$10$cLz07hLHY0.or2jTY7xbzOzTabwQ1I2XOqkZ24VFGznNsWwRAwAvu', NULL, NULL, '', '2024-06-12 10:40:11'),
('666919a7f382e', 'DaeWae', 'DoUKnow@gmail.com', '$2y$10$K0YZCSRwuEbdblEJC2jP..ntRQOkHIVkMKdMCan4MphROxjTgPb/O', NULL, NULL, '', '2024-06-12 11:44:40'),
('6669de93d8815', 'ggg', 'ggg@gmail.com', '$2y$10$tOMVmG.Y5toyB.EITIYyk.ioQkvA6Y5hBTxvnGuk2PEVNUlUWLN7a', '6669df359f6391.82006395.jpg', 'Du u knuw da wae\r\n', '', '2024-06-13 01:44:51'),
('666b229d7cd3d', 'Tyson20', 'tsyon@gmail.com', '$2y$10$fBCaMFUpFfzhEOGdpsmtm.zmv4oSaxf1h2.fmlheGTVC4wTOFqzdy', '666b22ae4e9eb4.11505004.jpg', 'ONE PUNCHHHH\r\n', '', '2024-06-14 00:47:25'),
('666bb88698452', 'gggg', 'gggg@gmail.com', '$2y$10$aKz.V3bpTSG/ob6UkALgM.WReCm1hDL/s4F/NIbxk1abUfG1q4sui', '666bb89f89ce43.56407451.jpg', 'De Waeee', '', '2024-06-14 11:27:02');

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `friends_ibfk_3` (`user_id`),
  ADD KEY `friends_ibfk_4` (`friend_id`);

--
-- Indexes for table `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `friend_requests_ibfk_1` (`requester_id`),
  ADD KEY `friend_requests_ibfk_2` (`requestee_id`);

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
  ADD KEY `posts_ibfk_1` (`author`),
  ADD KEY `posts_ibfk_2` (`greek_group`);

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
  MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206;

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
  ADD CONSTRAINT `friends_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `friends_ibfk_2` FOREIGN KEY (`friend_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD CONSTRAINT `friend_requests_ibfk_1` FOREIGN KEY (`requester_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `friend_requests_ibfk_2` FOREIGN KEY (`requestee_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

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
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`author`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`greek_group`) REFERENCES `greeks` (`greek_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
