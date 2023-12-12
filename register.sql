-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2023 at 12:00 AM
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
-- Database: `register`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image_link` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `title`, `image_link`, `price`, `description`) VALUES
(3, 'React Js', 'https://www.tatvasoft.com/blog/wp-content/uploads/2022/07/Why-Use-React.jpg', 140.00, 'React est une bibliothèque JavaScript libre. Elle est maintenue par Meta ainsi que par une communauté de développeurs individuels et d\'entreprises depuis 2013.'),
(4, 'Angular Js', 'https://cdn.sayonetech.com/media/zinnia/Challenges_in_Angular_js_Development_Projects_copy.jpg', 120.00, 'AngularJS est un framework JavaScript libre et open source développé par Google. Il permet de développer des pages web.'),
(5, 'Vue Js', 'https://logixbuilt.com/wp-content/uploads/2023/10/cover_Vue.png', 169.00, 'Vue.js, est un framework JavaScript open-source utilisé pour construire des interfaces utilisateur et des applications web monopages.');

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `duration` time NOT NULL,
  `video_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`id`, `course_id`, `name`, `description`, `duration`, `video_path`, `created_at`) VALUES
(21, 3, 'Introduction', 'React is a little JavaScript library with a big influence over the webdev world. Learn the basics of React in 100 Seconds.\r\n', '00:02:02', 'uploads/React in 100 Seconds (2).mp4', '2023-12-10 21:06:14'),
(22, 3, 'React Native in 100 Seconds', 'React Native allows developers to build cross-platform apps for iOS, Android, and the Web from a single JavaScript codebase. Get started building your first native mobile app with React Native.', '00:03:20', 'uploads/React Native in 100 Seconds.mp4', '2023-12-10 21:12:39'),
(24, 4, 'Angular is back with a vengeance', 'Angular is adding a new feature called signals that will give it a reactive primitive similar to Vue.js and Solid. Learn how it compares to other popular JavaScript frameworks like React.js and Svelte. ', '00:03:30', 'uploads/Angular is back with a vengeance.mp4', '2023-12-10 21:15:59'),
(25, 4, 'Angular in 100 Seconds', 'Angular is arguably the most advanced frontend JavaScript framework ever created. Learn the basics of Angular in 100 Seconds. \r\n', '00:04:00', 'uploads/Angular in 100 Seconds (1).mp4', '2023-12-10 21:16:47');

-- --------------------------------------------------------

--
-- Table structure for table `tusers`
--

CREATE TABLE `tusers` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `profile_picture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tusers`
--

INSERT INTO `tusers` (`id`, `email`, `name`, `password`, `role`, `profile_picture`) VALUES
(14, 'admin@gmail.com', 'wassim', 'admin', 'admin', 'wassimmmmmmmmmmmm.jpg'),
(22, 'wassimrahali40@gmail.com', 'Wassim Rahali', 'wassimrahali40@gmail.com', 'user', 'tttttttt.jpg'),
(23, 'wassim', 'wassim', 'wassim', 'user', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_courses`
--

CREATE TABLE `user_courses` (
  `id` int(11) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_courses`
--

INSERT INTO `user_courses` (`id`, `user_email`, `course_id`) VALUES
(0, 'karim@gmail.com ', 6),
(0, 'adem@gmail.com', 1),
(0, 'karim@gmail.com ', 2),
(0, 'wassimrahali40@gmail.com', 1),
(0, 'karim@gmail.com ', 1),
(0, 'admin@gmail.com', 5),
(0, 'wassimrahali40@gmail.com', 3),
(0, 'wassimrahali40@gmail.com', 5),
(0, 'wassimrahali40@gmail.com', 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `tusers`
--
ALTER TABLE `tusers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tusers`
--
ALTER TABLE `tusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lessons`
--
ALTER TABLE `lessons`
  ADD CONSTRAINT `fk_course_id` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
