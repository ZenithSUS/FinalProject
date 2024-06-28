-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 28, 2024 at 11:19 AM
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
(243, '40dac99c-352d-11ef-8228-7c05075eb45f', NULL, '21de9475-3526-11ef-8228-7c05075eb45f', 'created a post a with title Hi', '2024-06-28 09:03:20'),
(244, NULL, '667e7deccc18f', '21de9475-3526-11ef-8228-7c05075eb45f', 'commennted on a post titled Hi', '2024-06-28 09:10:04');

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
('667e7deccc18f', '40dac99c-352d-11ef-8228-7c05075eb45f', NULL, '21de9475-3526-11ef-8228-7c05075eb45f', 'DSA', 0, 0, '2024-06-28 17:10:04');

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
('6d76c3be-352f-11ef-8228-7c05075eb45f', '28b41183-352c-11ef-8228-7c05075eb45f', '21de9475-3526-11ef-8228-7c05075eb45f', '2024-06-28 09:18:53'),
('6d84427b-352f-11ef-8228-7c05075eb45f', '21de9475-3526-11ef-8228-7c05075eb45f', '28b41183-352c-11ef-8228-7c05075eb45f', '2024-06-28 09:18:53');

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
  `description` text DEFAULT NULL,
  `image_url` varchar(225) DEFAULT NULL,
  `creator` varchar(36) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `greeks`
--

INSERT INTO `greeks` (`greek_id`, `name`, `description`, `image_url`, `creator`) VALUES
('0db1bfad-2ba8-11ef-a131-7c05075eb45f', 'Hermes', 'Hermes, the quick-witted Greek god of trade, thieves, travelers, sports, athletes, and border crossings, is often portrayed as a young, athletic man wearing a winged hat and sandals. He is known for his cunning and mischievous nature, as well as his role as the messenger of the gods. Hermes is also associated with fertility, luck, and wealth, and is often depicted carrying a caduceus, a winged staff entwined with two serpents.', 'HERMES.webp', 'Default'),
('1c87d062-2ba3-11ef-a131-7c05075eb45f', 'Hades', 'Hades, in ancient Greek religion, is the god of the underworld. He was a son of the Titans Cronus and Rhea and the brother of Zeus, Poseidon, and Hera. Hades ruled alongside his queen, Persephone, over the dead, although he was not typically a judge or responsible for torturing the guilty—tasks assigned to the Furies', 'HADES.webp', 'Default'),
('2adbfbd3-2ba2-11ef-a131-7c05075eb45f', 'Apollo', 'Apollo, one of the Twelve Olympians in Greek mythology, is the son of Zeus and Leto, and the twin brother of Artemis. He embodies a multitude of roles: the god of healing, medicine, archery, music, dance, poetry, prophecy, knowledge, light, and the sun. Apollo is also the leader of the Muses', 'APOLLO.webp', 'Default'),
('2b013a64-2ba0-11ef-a131-7c05075eb45f', 'Aphrodite', 'Aphrodite, the ancient Greek goddess of sexual love and beauty, is closely associated with Venus in Roman mythology. According to Hesiod’s Theogony, she emerged from the white foam created by the severed genitals of Uranus (Heaven) after his son Cronus threw them into the sea. Aphrodite was widely worshipped as a goddess of the sea, seafaring, love, and fertility. While her public cult was generally solemn, she occasionally presided over marriage. Notably, she had mortal lovers, including the Trojan shepherd Anchises (with whom she became the mother of Aeneas) and the youth Adonis.', 'APHRODITE.webp', 'Default'),
('44c24fcc-2ba4-11ef-a131-7c05075eb45f', 'Artemis', 'Artemis, in ancient Greek religion and mythology, is the goddess of the hunt, the wilderness, wild animals, nature, vegetation, childbirth, care of children, and chastity. She was often said to roam the forests and mountains, attended by her entourage of nymphs. Artemis is the daughter of Zeus and Leto, and the twin sister of Apollo. She was very protective of her and her priestesses innocence.', 'ARTEMIS.webp', 'Default'),
('5e965592-2ba6-11ef-a131-7c05075eb45f', 'Poseidon', 'Poseidon, in Greek mythology, is the god of the sea, earthquakes, and horses. He is one of the Twelve Olympians, the major deities of the Greek pantheon. Often depicted with a trident, Poseidon is known for his tempestuous nature, capable of both fury and benevolence. He is considered a protector of seafarers and a creator of storms and floods. In Roman mythology, he is identified with Neptune.', 'POSEIDON.webp', 'Default'),
('8d2d3e82-2ba4-11ef-a131-7c05075eb45f', 'Athena', 'Athena, in Greek religion, is the city protectress, goddess of war, handicraft, and practical reason. The Romans identified her with Minerva. Unlike Ares, the god of war who represents mere bloodlust, Athena embodies the intellectual and civilized side of war, emphasizing justice and skill. She was also associated paradoxically with peace and handicrafts, particularly spinning and weaving. Majestic and stern, Athena surpassed all others in her domains.', 'ATHENA.webp', 'Default'),
('8e3c6da0-2ba3-11ef-a131-7c05075eb45f', 'Ares', 'Ares, the Greek god of war, is one of the Twelve Olympians. He is often depicted as a fierce and bloodthirsty warrior. Ares is the son of Zeus and Hera, and his siblings include Athena, Apollo, and Hermes. In Greek mythology, he is associated with violence, conflict, and the brutality of war', 'ARES.Webp', 'Default'),
('b9da2016-2ba7-11ef-a131-7c05075eb45f', 'Demeter', 'Demeter, the revered Greek goddess of agriculture, grain, and fertility, holds a prominent position in Greek mythology and the hearts of ancient people. As the giver of life and sustenance, her influence extended far beyond the fields, touching upon the very cycles of life, death, and rebirth. Demeter is often depicted as a mature woman, her presence radiating warmth and abundance. She is adorned with symbols of her dominion, such as sheaves of wheat, a cornucopia overflowing with fruits and grains, or a torch symbolizing enlightenment and knowledge.\r\n\r\nDemeter\'s significance is deeply intertwined with the Eleusinian Mysteries, secretive rituals centered around the myth of her daughter Persephone\'s abduction by Hades, the god of the underworld. This tragic event plunged Demeter into grief, causing the earth to wither and die. However, upon Persephone\'s eventual return, the world bloomed anew, signifying the renewal of life and the cyclical nature of the seasons. The Eleusinian Mysteries offered initiates a glimpse into these profound concepts, promising a blessed afterlife and fostering a sense of connection to the divine.', 'DEMETER.webp', 'Default'),
('b9da2cb2-2ba7-11ef-a131-7c05075eb45f', 'Dionysius', 'Dionysus, the enigmatic and captivating Greek god of wine, revelry, theater, and religious ecstasy, holds a unique place in the pantheon of Greek deities. Often depicted as a youthful and exuberant figure, adorned with ivy wreaths and holding a thyrsus (a pinecone-tipped staff), Dionysus embodies the spirit of uninhibited joy, transformation, and the blurring of boundaries between the human and divine.\r\n\r\nHis origins are shrouded in mystery, with various myths attributing his birthplace to different regions. Some tales claim he is a foreign god who arrived in Greece from the East, bringing with him the knowledge of viticulture and the intoxicating power of wine. Others describe him as the son of Zeus and the mortal Semele, who perished due to Hera\'s jealousy. Regardless of his origin, Dionysus quickly became a beloved figure, celebrated for his ability to liberate people from their inhibitions and connect them to the primal forces of nature.', 'DIONYSIUS.webp', 'Default'),
('cec09d13-2b9d-11ef-a131-7c05075eb45f', 'Zeus', 'Zeus, the sky and thunder god in ancient Greek mythology, rules as the king of the gods on Mount Olympus. As the chief Greek deity, he is considered the protector and father of all gods and humans. Zeus is often depicted as an older man with a beard, and his symbols include the lightning bolt and the eagle. He was notorious for his numerous divine and heroic offspring, including Apollo, Artemis, Hermes, and Heracles. His traditional weapon is the thunderbolt, and he is equated with the Roman god Jupiter.', 'ZEUS.webp', 'Default'),
('eb824654-2ba6-11ef-a131-7c05075eb45f', 'Hera', 'Hera, the queen of Olympus in Greek mythology, is the goddess of marriage, women, family, and childbirth. She is the wife and sister of Zeus, the king of the gods. While revered for her role as a protector of women, Hera is also known for her jealous and vengeful nature, often directed towards Zeus\'s lovers and their offspring. Her stories are filled with drama, passion, and divine retribution, making her a compelling figure in ancient Greek lore.', 'HERA.webp', 'Default');

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
('40dac99c-352d-11ef-8228-7c05075eb45f', 'Hi', 'Hi', '21de9475-3526-11ef-8228-7c05075eb45f', 0, 0, '0db1bfad-2ba8-11ef-a131-7c05075eb45f', '2024-06-28 17:03:20', '2024-06-28 17:03:20');

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
('21de9475-3526-11ef-8228-7c05075eb45f', 'GoldenSight', 'merinojc25@gmail.com', '$2y$10$eunfvzXhwdL5t75oD/zDqORsrZdmdyqZckVXDtO9sg8Vjr0I9d.EG', '667e706abc6412.96445453.jpg', 'Hi', '6486c0d0dd46d84dc7b255f9838d4e71', '2024-06-28 16:12:21'),
('28b41183-352c-11ef-8228-7c05075eb45f', 'Hendrick', 'hen@gmail.com', '$2y$10$aUiCLzBWzsgsmqmm3QXTm.WaxcOfWNUSqq0k6s5wtdyEazGOh324G', '667e7b02cf3a35.70659534.jpg', NULL, '9c9f5555934f167f23135ac92a0920c5', '2024-06-28 16:55:30'),
('511e6602-3526-11ef-8228-7c05075eb45f', 'ZenithSUS', 'jeranmerino147@gmail.com', '$2y$10$6umraqi2K9N9f8wABVa1kuKNy.b8RiMO3hTj8hJc4Rx11OakxkRYS', NULL, NULL, 'feb82c43d2d2560c7a6814042c784ee9', '2024-06-28 16:13:40');

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

CREATE TABLE `user_groups` (
  `id` varchar(36) NOT NULL,
  `user_id` varchar(36) NOT NULL,
  `greek_id` varchar(36) NOT NULL,
  `date_joined` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_groups`
--

INSERT INTO `user_groups` (`id`, `user_id`, `greek_id`, `date_joined`) VALUES
('21eb6e76-3526-11ef-8228-7c05075eb45f', '21de9475-3526-11ef-8228-7c05075eb45f', '0db1bfad-2ba8-11ef-a131-7c05075eb45f', '2024-06-28 16:12:21'),
('21fac27a-3526-11ef-8228-7c05075eb45f', '21de9475-3526-11ef-8228-7c05075eb45f', '1c87d062-2ba3-11ef-a131-7c05075eb45f', '2024-06-28 16:12:21'),
('222da498-3526-11ef-8228-7c05075eb45f', '21de9475-3526-11ef-8228-7c05075eb45f', '2adbfbd3-2ba2-11ef-a131-7c05075eb45f', '2024-06-28 16:12:22'),
('2243afcf-3526-11ef-8228-7c05075eb45f', '21de9475-3526-11ef-8228-7c05075eb45f', '2b013a64-2ba0-11ef-a131-7c05075eb45f', '2024-06-28 16:12:22'),
('224dd141-3526-11ef-8228-7c05075eb45f', '21de9475-3526-11ef-8228-7c05075eb45f', '44c24fcc-2ba4-11ef-a131-7c05075eb45f', '2024-06-28 16:12:22'),
('22581776-3526-11ef-8228-7c05075eb45f', '21de9475-3526-11ef-8228-7c05075eb45f', '5e965592-2ba6-11ef-a131-7c05075eb45f', '2024-06-28 16:12:22'),
('22622c63-3526-11ef-8228-7c05075eb45f', '21de9475-3526-11ef-8228-7c05075eb45f', '8d2d3e82-2ba4-11ef-a131-7c05075eb45f', '2024-06-28 16:12:22'),
('226e10b6-3526-11ef-8228-7c05075eb45f', '21de9475-3526-11ef-8228-7c05075eb45f', '8e3c6da0-2ba3-11ef-a131-7c05075eb45f', '2024-06-28 16:12:22'),
('2276720c-3526-11ef-8228-7c05075eb45f', '21de9475-3526-11ef-8228-7c05075eb45f', 'b9da2016-2ba7-11ef-a131-7c05075eb45f', '2024-06-28 16:12:22'),
('227f28b9-3526-11ef-8228-7c05075eb45f', '21de9475-3526-11ef-8228-7c05075eb45f', 'b9da2cb2-2ba7-11ef-a131-7c05075eb45f', '2024-06-28 16:12:22'),
('22897839-3526-11ef-8228-7c05075eb45f', '21de9475-3526-11ef-8228-7c05075eb45f', 'cec09d13-2b9d-11ef-a131-7c05075eb45f', '2024-06-28 16:12:22'),
('22934548-3526-11ef-8228-7c05075eb45f', '21de9475-3526-11ef-8228-7c05075eb45f', 'eb824654-2ba6-11ef-a131-7c05075eb45f', '2024-06-28 16:12:22'),
('28d24446-352c-11ef-8228-7c05075eb45f', '28b41183-352c-11ef-8228-7c05075eb45f', '0db1bfad-2ba8-11ef-a131-7c05075eb45f', '2024-06-28 16:55:30'),
('28de72e8-352c-11ef-8228-7c05075eb45f', '28b41183-352c-11ef-8228-7c05075eb45f', '1c87d062-2ba3-11ef-a131-7c05075eb45f', '2024-06-28 16:55:30'),
('28e860a5-352c-11ef-8228-7c05075eb45f', '28b41183-352c-11ef-8228-7c05075eb45f', '2adbfbd3-2ba2-11ef-a131-7c05075eb45f', '2024-06-28 16:55:30'),
('28fad811-352c-11ef-8228-7c05075eb45f', '28b41183-352c-11ef-8228-7c05075eb45f', '2b013a64-2ba0-11ef-a131-7c05075eb45f', '2024-06-28 16:55:30'),
('290870a7-352c-11ef-8228-7c05075eb45f', '28b41183-352c-11ef-8228-7c05075eb45f', '44c24fcc-2ba4-11ef-a131-7c05075eb45f', '2024-06-28 16:55:30'),
('2943b8af-352c-11ef-8228-7c05075eb45f', '28b41183-352c-11ef-8228-7c05075eb45f', '5e965592-2ba6-11ef-a131-7c05075eb45f', '2024-06-28 16:55:30'),
('294c969e-352c-11ef-8228-7c05075eb45f', '28b41183-352c-11ef-8228-7c05075eb45f', '8d2d3e82-2ba4-11ef-a131-7c05075eb45f', '2024-06-28 16:55:31'),
('2958c5d8-352c-11ef-8228-7c05075eb45f', '28b41183-352c-11ef-8228-7c05075eb45f', '8e3c6da0-2ba3-11ef-a131-7c05075eb45f', '2024-06-28 16:55:31'),
('29626b1b-352c-11ef-8228-7c05075eb45f', '28b41183-352c-11ef-8228-7c05075eb45f', 'b9da2016-2ba7-11ef-a131-7c05075eb45f', '2024-06-28 16:55:31'),
('296ac620-352c-11ef-8228-7c05075eb45f', '28b41183-352c-11ef-8228-7c05075eb45f', 'b9da2cb2-2ba7-11ef-a131-7c05075eb45f', '2024-06-28 16:55:31'),
('29734dbe-352c-11ef-8228-7c05075eb45f', '28b41183-352c-11ef-8228-7c05075eb45f', 'cec09d13-2b9d-11ef-a131-7c05075eb45f', '2024-06-28 16:55:31'),
('297baa37-352c-11ef-8228-7c05075eb45f', '28b41183-352c-11ef-8228-7c05075eb45f', 'eb824654-2ba6-11ef-a131-7c05075eb45f', '2024-06-28 16:55:31'),
('51336106-3526-11ef-8228-7c05075eb45f', '511e6602-3526-11ef-8228-7c05075eb45f', '0db1bfad-2ba8-11ef-a131-7c05075eb45f', '2024-06-28 16:13:40'),
('513bab22-3526-11ef-8228-7c05075eb45f', '511e6602-3526-11ef-8228-7c05075eb45f', '1c87d062-2ba3-11ef-a131-7c05075eb45f', '2024-06-28 16:13:41'),
('5142a26e-3526-11ef-8228-7c05075eb45f', '511e6602-3526-11ef-8228-7c05075eb45f', '2adbfbd3-2ba2-11ef-a131-7c05075eb45f', '2024-06-28 16:13:41'),
('5182dc1b-3526-11ef-8228-7c05075eb45f', '511e6602-3526-11ef-8228-7c05075eb45f', '2b013a64-2ba0-11ef-a131-7c05075eb45f', '2024-06-28 16:13:41'),
('51974093-3526-11ef-8228-7c05075eb45f', '511e6602-3526-11ef-8228-7c05075eb45f', '44c24fcc-2ba4-11ef-a131-7c05075eb45f', '2024-06-28 16:13:41'),
('51a2fe00-3526-11ef-8228-7c05075eb45f', '511e6602-3526-11ef-8228-7c05075eb45f', '5e965592-2ba6-11ef-a131-7c05075eb45f', '2024-06-28 16:13:41'),
('51aee702-3526-11ef-8228-7c05075eb45f', '511e6602-3526-11ef-8228-7c05075eb45f', '8d2d3e82-2ba4-11ef-a131-7c05075eb45f', '2024-06-28 16:13:41'),
('51bad36b-3526-11ef-8228-7c05075eb45f', '511e6602-3526-11ef-8228-7c05075eb45f', '8e3c6da0-2ba3-11ef-a131-7c05075eb45f', '2024-06-28 16:13:41'),
('51bfe4db-3526-11ef-8228-7c05075eb45f', '511e6602-3526-11ef-8228-7c05075eb45f', 'b9da2016-2ba7-11ef-a131-7c05075eb45f', '2024-06-28 16:13:41'),
('51c51da9-3526-11ef-8228-7c05075eb45f', '511e6602-3526-11ef-8228-7c05075eb45f', 'b9da2cb2-2ba7-11ef-a131-7c05075eb45f', '2024-06-28 16:13:41'),
('51cd82c0-3526-11ef-8228-7c05075eb45f', '511e6602-3526-11ef-8228-7c05075eb45f', 'cec09d13-2b9d-11ef-a131-7c05075eb45f', '2024-06-28 16:13:41'),
('51db5a73-3526-11ef-8228-7c05075eb45f', '511e6602-3526-11ef-8228-7c05075eb45f', 'eb824654-2ba6-11ef-a131-7c05075eb45f', '2024-06-28 16:13:42');

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
-- Indexes for table `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `greek_id` (`greek_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=245;

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

--
-- Constraints for table `user_groups`
--
ALTER TABLE `user_groups`
  ADD CONSTRAINT `user_groups_ibfk_1` FOREIGN KEY (`greek_id`) REFERENCES `greeks` (`greek_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_groups_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
