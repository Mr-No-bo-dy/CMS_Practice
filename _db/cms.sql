-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 22, 2023 at 12:34 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(3) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cat_title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `user_id`, `cat_title`) VALUES
(1, 1, 'Bootstrap'),
(2, 1, 'Javascript'),
(3, 47, 'PHP'),
(4, 47, 'Java'),
(8, 1, 'HTML'),
(9, 1, 'CSS');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(3) NOT NULL,
  `comment_post_id` int(3) NOT NULL,
  `comment_author` varchar(255) NOT NULL,
  `comment_email` varchar(255) NOT NULL,
  `comment_content` text NOT NULL,
  `comment_status` varchar(255) NOT NULL,
  `comment_date` date NOT NULL,
  `comment_edit_author` varchar(255) NOT NULL,
  `comment_editors_comment` text NOT NULL,
  `comment_edited_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `comment_post_id`, `comment_author`, `comment_email`, `comment_content`, `comment_status`, `comment_date`, `comment_edit_author`, `comment_editors_comment`, `comment_edited_date`) VALUES
(1, 1, 'John', 'john_doe@doe.com', 'This is just an example', 'approved', '2022-09-15', '', '', '0000-00-00'),
(4, 2, 'Sandra', 'sandra@mail.com', 'sandra qwerqwer', 'approved', '2022-09-17', '', '', '0000-00-00'),
(7, 1, 'Peter', 'Peter@mail.com', 'Test comment', 'unapproved', '2022-09-17', '', '', '0000-00-00'),
(15, 7, 'Sandra', 'sandra@mail.com', '<p>Sandra made test comment.</p>', 'approved', '2022-10-29', 'peter', 'Edited', '2022-10-29'),
(17, 2, 'Peter', 'Peter@mail.com', '<p>Belinda, please call me!</p>', 'approved', '2022-09-27', 'nick11', 'Never.', '2022-10-29'),
(18, 2, 'Cindy', 'cindy@mail.com', 'I hate Javascript.', 'approved', '2022-09-29', '', '', '0000-00-00'),
(19, 8, 'John', 'john@asd.com', '<p>Comment test</p>', 'unapproved', '2022-09-29', '', '', '0000-00-00'),
(23, 13, 'Peter', 'Peter@mail.com', '<p>Is this really PHP post?</p>', 'approved', '2022-10-05', '', '', '0000-00-00'),
(25, 1, 'John', 'john@asd.com', '<p>Please, spread my classes!</p>', 'approved', '2022-10-25', 'peter', 'Ok.', '2022-12-29'),
(27, 4, 'Peter', 'Peter@mail.com', '<p>I don_t like Java.</p>', 'approved', '2022-10-25', 'pila2', 'Me too..', '2022-11-11'),
(28, 13, 'Sandra', 'sandra@mail.com', '<p>Yeah, this is PHP Post.</p>', 'approved', '2022-10-25', '', '', '0000-00-00'),
(29, 1, 'Peter', 'Peter@mail.com', '<p>Some comment here.</p>', 'unapproved', '2022-10-28', '', '', '0000-00-00'),
(30, 16, 'John', 'john@asd.com', '<p>Just some comment from John.</p>', 'approved', '2022-11-03', '', '', '0000-00-00'),
(31, 7, 'Cindy', 'cindy@mail.com', '<p>I dont like Bootstrap.</p>', 'approved', '2022-11-03', 'peter', 'It\'s ok.', '2022-11-11'),
(34, 7, 'Peter', 'Peter@mail.com', '<p>Me either.</p>', 'approved', '2022-11-11', '', '', '0000-00-00'),
(37, 42, 'Cindy', 'cindy@mail.com', '<p>Cindy made a comment here.</p>', 'unapproved', '2023-01-04', '', '', '0000-00-00'),
(38, 42, 'Sandra', 'sandra@mail.com', '<p>Sandra too.</p>', 'unapproved', '2023-01-04', '', '', '0000-00-00'),
(39, 1, 'Peter', 'Peter@mail.com', '<p>I just leave it here.</p>', 'approved', '2023-01-20', '', '', '0000-00-00'),
(40, 1, 'Peter', 'Peter@mail.com', '<p>One more comment</p>', 'approved', '2023-01-20', '', '', '0000-00-00'),
(41, 20, 'Peter', 'Peter@mail.com', '<p>Comment count test</p>', 'approved', '2023-01-20', '', '', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `post_id`) VALUES
(17, 47, 13),
(18, 86, 2),
(19, 47, 2),
(20, 1, 1),
(21, 1, 4),
(23, 1, 7),
(24, 1, 48),
(25, 1, 61);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(3) NOT NULL,
  `post_category_id` int(3) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_title` varchar(255) NOT NULL,
  `post_author` varchar(255) NOT NULL,
  `post_date` date NOT NULL,
  `post_image` text NOT NULL,
  `post_content` text NOT NULL,
  `post_tags` varchar(255) NOT NULL,
  `post_comment_count` int(11) NOT NULL,
  `post_status` varchar(255) NOT NULL DEFAULT 'draft',
  `post_views_count` int(11) NOT NULL,
  `likes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `post_category_id`, `user_id`, `post_title`, `post_author`, `post_date`, `post_image`, `post_content`, `post_tags`, `post_comment_count`, `post_status`, `post_views_count`, `likes`) VALUES
(1, 3, 8, 'John\'s CMS PHP course is nice', 'John', '2023-01-04', 'image_1.jpg', '<p>Wow I like this course</p>', 'john, cms, php', 1, 'draft', 76, 1),
(2, 2, 3, 'Javascript course Post', 'Belinda', '2022-12-28', 'image_4.jpg', '<p>Not Wow. This is not cool post. Belinda, don\\\'t call me.</p>', 'javascript, course, class, belinda', 3, 'published', 118, 2),
(4, 4, 7, 'Jane\'s Java course', 'Jane', '2023-01-04', 'image_2.jpg', '<p>Updated Updated content 3.</p>', 'JS, PHP, class', 4, 'published', 51, 1),
(7, 1, 8, 'Lorem Ipsum', 'John', '2022-09-17', 'image_3.jpg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'JS, PHP, class', 5, 'published', 160, 1),
(8, 4, 78, 'Test cat_title', 'James', '2022-10-16', 'image_5.jpg', 'Some content of Post.', 'asdf', 6, 'published', 43, 0),
(13, 3, 78, 'PHP Post 1', 'James', '2022-11-03', 'image_1.jpg', '<p>PHP Post. That is it.</p>', 'PHP, CMS', 2, 'draft', 19, 1),
(14, 2, 8, 'Lorem Ipsum', 'John', '2022-11-04', 'image_5.jpg', '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry_s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>', 'PHP, CMS, john', 0, 'published', 0, 0),
(15, 4, 8, 'This is another post', 'John', '2022-09-27', 'image_4.jpg', 'This is another post. One more post.', 'JS, class, john', 0, 'published', 0, 0),
(16, 1, 3, 'Lorem Ipsum2', 'Belinda', '2022-09-28', 'image_3.jpg', 'Just test massage post.', 'JS, PHP, class', 0, 'published', 9, 0),
(20, 3, 47, 'PHP Post 2', 'Peter', '2022-11-03', 'image_1.jpg', '<p>This is some PHP Post.</p>', 'PHP, CMS, Qwerty', 0, 'published', 9, 0),
(21, 3, 47, 'PHP Post 3', 'Peter', '2022-10-04', 'image_1.jpg', '<p>Post text CMS <strong>PHP</strong> Smth….</p>', 'PHP, CMS', 0, 'draft', 13, 0),
(24, 2, 8, 'Add post test 2', 'John', '2022-10-19', 'image_4.jpg', '<p>This is another <strong>Add post</strong> <i>test</i>.</p>', 'JS, PHP, class', 2, 'published', 5, 0),
(32, 1, 7, 'Java course', 'Jane', '2022-10-13', 'image_2.jpg', 'Updated content 2', 'JS, PHP, class, jane', 0, 'published', 5, 0),
(33, 1, 47, 'Lorem Ipsum', 'Peter', '2022-10-13', 'image_3.jpg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'JS, PHP, class', 0, 'published', 1, 0),
(35, 3, 47, 'PHP Post 4', 'Peter', '2022-10-17', 'image_1.jpg', '<p>This is the new shit.</p>', 'PHP, CMS', 0, 'draft', 1, 0),
(36, 2, 78, 'JS 3', 'James', '2022-10-17', 'image_4.jpg', '<p>Some JavaScript but not Java scripts…</p>', 'JS, class', 0, 'published', 3, 0),
(42, 8, 8, 'HTML Post 1', 'John', '2022-11-03', 'image_2.jpg', '<p>This is HTML post by John.</p>', 'html, bootstrap, john', 0, 'draft', 6, 0),
(43, 2, 78, 'JS 3', 'James', '2022-11-04', 'image_4.jpg', '<p>Some JavaScript but not Java scripts…</p>', 'JS, class', 0, 'published', 0, 0),
(44, 3, 8, 'PHP Post 4', 'John', '2022-11-04', 'image_1.jpg', '<p>This is the new shit.</p>', 'PHP, CMS', 0, 'draft', 2, 0),
(45, 1, 47, 'Lorem Ipsum', 'Peter', '2022-11-04', 'image_3.jpg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'JS, PHP, class', 0, 'published', 0, 0),
(46, 2, 78, 'JS 3', 'James', '2022-11-06', 'image_4.jpg', '<p>Some JavaScript but not Java scripts…</p>', 'JS, class', 0, 'published', 1, 0),
(48, 1, 8, 'Lorem Ipsum', 'John', '2022-11-06', 'image_3.jpg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'JS, PHP, class', 0, 'published', 2, 1),
(59, 2, 7, 'Javascript post', 'Jane', '2022-12-29', 'image_4.jpg', '<p>This is just another Javascript post.</p>', 'JS, javascript, jane', 0, 'published', 3, 0),
(60, 8, 86, 'My Post', 'user86', '2023-01-13', '', '<p>This is my 1st post.</p>', 'html, bootstrap', 0, 'published', 4, 0),
(61, 3, 1, 'User_id test post', 'rico', '2023-01-20', 'image_1.jpg', '<p>Just testing inserting into Database author_s User_id.</p>', 'PHP, CMS', 0, 'published', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(3) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_firstname` varchar(255) NOT NULL,
  `user_lastname` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_image` text NOT NULL,
  `user_role` varchar(255) NOT NULL,
  `token` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_password`, `user_firstname`, `user_lastname`, `user_email`, `user_image`, `user_role`, `token`) VALUES
(1, 'rico', '$2y$12$Vpo0VwPhaZODHhN7Q11Vg.Ic2wDkoueb4VXu9/40hKvlLzWh9dXBG', 'Rico', '123', 'rico123@mail.com', 'image_1.jpg', 'admin', ''),
(3, 'Belinda', '$2y$12$JeJdz5vwBLm0SUmrbWbgiOHHOi1.OHN8WRD2KWYjOVqhzzLyFPyY2', 'Belinda', 'uber', 'belinda@mail.com', 'image_4.jpg', 'subscriber', ''),
(5, 'Nicki', '$2y$12$eZlSk47tq3AedvY1c58WQeFrG8Qf0plw2q.cyYc7KuKYUF.CmSpHe', 'Nicki', 'parsons', 'nicki@mail.com', 'image_1.jpg', 'subscriber', ''),
(6, 'Marcus', '$2y$12$n.cEkicGAFLrX50AMknXnOlZmg4wGU8JBb0tRCZOhtAbfwWu0soha', 'Marcus', 'mars', 'marcus@mail.com', 'image_3.jpg', 'subscriber', ''),
(7, 'Jane', '$2y$12$F9fcCsKCMACXA8HXs38rDOkVdxiKLMHmbx44fSmtlauQ9BKAbCNrS', 'Jane', 'doe2', 'jane@mail.com', 'image_5.jpg', 'subscriber', ''),
(8, 'John', '$2y$12$bO3ijOoUXQbC6AKsmZQziO1FGHBY6Qti/WVh2n7RBgsLt41ECppBm', 'John', 'doe', 'john@mail.com', 'image_1.jpg', 'subscriber', ''),
(11, 'Juan', '$2y$12$RcjrzpCuR0ekB96Q1noFkuxlOw3.MdqcbmyiIqFXU/hr/MRCgFSJ6', 'Juan', 'whatever', 'juan@mail.com', 'image_3.jpg', 'subscriber', ''),
(18, 'robert', '$2y$12$FIzdkUNnDaMzJzNzkYatm.UTypPco7fla0Am6UOwmeu6sgHcpgv0u', 'Robert', 'patrick', 'robert@mail.com', 'image_1.jpg', 'admin', ''),
(39, 'Ricki', '$2y$12$7SKhtb7Sv6ZR8iqrT8dmYumIxlhh29ZDThsl0cGnSue7A8d8zGDwu', 'Ricki', 'martin', 'rick@mail.com', 'image_5.jpg', 'subscriber', ''),
(41, 'demo40', '$2y$12$GMks9/l5wGMhP1sNWgPT2eRFqxdAX0yZEKxH9Mw.AArNmeg4c/GhK', 'demo', '40', 'demo40@mail.com', 'image_2.jpg', 'subscriber', ''),
(45, 'nick11', '$2y$12$JQGMJjsrLRbBHGRBKKq63uep6SmnlzDKw6Pg8uRBQQNnlMkn2qJWG', 'Nick', 'n11', 'nick11@mail.com', 'image_1.jpg', 'subscriber', ''),
(46, 'petee', '$2y$12$Qkrvp3M2pDLtTeID.KENPuHkQYs4ZkwfDk21WUwiiUx8UNi7EkdyC', 'Petee', '12345', 'petee@mail.com', 'image_1.jpg', 'subscriber', ''),
(47, 'Peter', '$2y$12$OBjD4S5xaSpUwzwoFoiSNOf1114lZd0iB6ssxtTNVnMn7EiIlTF7u', 'Peter', 'pen', 'peter@mail.com', 'image_1.jpg', 'admin', ''),
(59, 'Jason', '$2y$12$91rt35hDFy94vBptXoOhJ.0bSevcVidgLMu2uwothXCK0Nar4mYm.', 'Jason', 'born', 'jason@mail.com', 'image_2.jpg', 'subscriber', ''),
(78, 'james', '$2y$12$.gh9k3lgBhPBSnbIDa2pJu.22xioDXdjSeJYuHBbgzu/lugxrp1LK', 'James', 'din', 'james@mail.com', 'image_5.jpg', 'subscriber', ''),
(85, 'pila', '$2y$12$3EDb0FELuWhVZswihO.g9.kMS0SKi4WZyP9xGyojR1Gg.ZHIL6qhu', 'Pila', 'pila', 'pila@mail.com', 'image_5.jpg', 'subscriber', ''),
(86, 'user86', '$2y$12$2PYwHF1g/HgTIcbnmIq4LecEuyQIFAbll8WzijMliX2i3OVfjmf1a', 'user86', '86', 'user86@mail.com', 'image_3.jpg', 'subscriber', '');

-- --------------------------------------------------------

--
-- Table structure for table `users_online`
--

CREATE TABLE `users_online` (
  `id` int(11) NOT NULL,
  `session` varchar(255) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_online`
--

INSERT INTO `users_online` (`id`, `session`, `time`) VALUES
(1, '3tc19hgb6jhhplmq86ueslgrks', 1673634108),
(2, 'cerp2vnrnrmfeuoju35cglajo0', 1666275478),
(3, 'h2i931c6p66bqmv2k6i5caj2f1', 1666182690),
(4, '19kst44f4iig2l3hm0dfkfujro', 1674387267),
(5, 'a96oo9cpgag6aq7lhi06ovdr4c', 1674036638);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_name`);

--
-- Indexes for table `users_online`
--
ALTER TABLE `users_online`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `users_online`
--
ALTER TABLE `users_online`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
