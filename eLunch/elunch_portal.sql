-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 18, 2015 at 10:59 AM
-- Server version: 5.5.44-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `elunch_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_messages`
--

CREATE TABLE IF NOT EXISTS `admin_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `meal_date` date NOT NULL,
  `table` int(11) DEFAULT NULL,
  `shift` int(11) DEFAULT NULL,
  `user` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `admin_messages`
--

INSERT INTO `admin_messages` (`id`, `user_id`, `title`, `content`, `meal_date`, `table`, `shift`, `user`, `created_at`, `updated_at`) VALUES
(1, 1, 'Announce for table 1', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam dignissim nulla at arcu dignissim consequat accumsan diam, id efficitur nisi consequat non. Aliquam vulputate finibus nulla et tincidunt.\r\n\r\n', '2015-09-10', 1, NULL, NULL, '2015-09-04 02:08:56', '0000-00-00 00:00:00'),
(2, 1, 'Announce for shift 2', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam dignissim nulla at arcu dignissim placehicula quam quis ante porta, eget aliquam tellus blandit.', '2015-09-02', NULL, 2, NULL, '2015-09-04 02:08:56', '0000-00-00 00:00:00'),
(3, 1, 'Announce for all users', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam dignissim nulla at arcu dignissim pla', '2015-09-01', NULL, NULL, 'all', '2015-09-04 02:08:56', '0000-00-00 00:00:00'),
(4, 1, 'Announce for table 9', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam dignissim nulla at arcu dignissim placerat. Morbi maximus purus a semper', '2015-09-10', 9, NULL, NULL, '2015-09-04 02:08:56', '0000-00-00 00:00:00'),
(5, 1, 'Announce for user 30', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam dignissim nulla at arcu dignissim placerat. Morbi maximus purus a semper posuere. Pellentesque varius lacinia nibh, a interdum purus dictum ut. Praesent hendrerit, est eu cursus dignissim, purus est feugiat velit, a convallis dui augue non enim. Nullam efficitur quam a ligula pretium sagittis. Vivamus accumsan viverra risus eu scelerisque. Mauris consequat accumsan diam, id efficitur nisi consequat non. Aliquam vulputate finibus nulla et tincidunt.\r\n', '2015-09-02', NULL, NULL, '30', '2015-09-04 02:08:56', '0000-00-00 00:00:00'),
(13, 1, 'Announcement for table normal', 'Announcement for table normal', '2015-09-01', 1, NULL, NULL, '2015-09-17 04:51:47', '0000-00-00 00:00:00'),
(14, 1, 'Announcement for shift 2', 'Announcement for shift 2', '2015-09-25', NULL, 2, NULL, '2015-09-17 04:53:18', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Khai vị', 'Món khai vị', '2015-08-30 06:22:44', '2015-08-30 06:22:44'),
(2, 'Chính', 'Món chính', '2015-08-30 06:22:53', '2015-08-30 06:22:53'),
(3, 'Tráng miệng', 'Món tráng miệng', '2015-08-30 06:22:28', '2015-08-30 06:22:28');

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `dish_id` int(11) DEFAULT NULL,
  `content` text NOT NULL,
  `title` varchar(255) NOT NULL,
  `meal_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `dish_id`, `content`, `title`, `meal_date`, `created_at`, `updated_at`) VALUES
(2, 1, 2, 'I love it. I want to eat it again.', 'Quite good 2', '2015-08-12', '2015-08-14 08:09:56', '2015-08-14 09:39:23'),
(4, 100, 2, 'I love it. I w22ant to eat it again.', 'Quite good 2', '2015-08-12', '2015-08-19 11:17:01', NULL),
(5, 1, 2, 'I love it. I want to eat it again.', 'Quite good', '2015-08-12', '2015-08-20 02:25:13', NULL),
(6, 1, 2, 'I love it. I want to eat it again.', 'Quite good', '2015-08-12', '2015-08-20 02:27:19', NULL),
(7, 1, 2, 'I love it. I want to eat it again.', 'Quite good', '2015-08-12', '2015-08-20 02:27:43', NULL),
(8, 1, NULL, 'I love it. I want to eat it again.', 'Quite good', '2015-08-13', '2015-08-20 02:28:47', NULL),
(9, 1, NULL, 'I love it. I want to eat it again.', 'Quite good', '2015-08-13', '2015-08-20 02:37:13', NULL),
(10, 1, NULL, 'I love it. I want to eat it again.', 'Quite good', '2015-08-13', '2015-08-20 02:43:39', NULL),
(11, 1, 2, 'I love it. I want to eat it again.', 'Quite good', '2015-08-13', '2015-08-20 02:44:15', NULL),
(12, 1, 2, 'I love it. I want to eat it again.', 'Quite good', '2015-08-12', '2015-08-20 03:33:40', NULL),
(13, 1, NULL, 'I love it. I want to eat it again.', 'Quite good', '2015-08-12', '2015-08-20 03:34:17', NULL),
(14, 1, NULL, 'I love it. I want to eat it again.', 'Quite good', '2015-08-12', '2015-08-20 03:36:09', NULL),
(15, 1, 2, 'I love it. I want to eat it again.', 'Quite good', '2015-08-12', '2015-08-20 06:53:36', NULL),
(16, 15, 1, 'Fast food is very good', 'Fast food good', '2015-08-17', '2015-08-21 05:31:05', NULL),
(17, 29, 6, 'The name of this dish is very bad.', 'Bad name', '2015-08-19', '2015-08-21 09:40:02', NULL),
(18, 29, 6, 'dasd', 'ada', '2015-08-19', '2015-08-21 09:41:56', NULL),
(19, 15, 6, 'good food', 'Comment for food', '2015-08-15', '2015-08-24 03:30:31', NULL),
(28, 15, NULL, 'Test food', 'Food', '2015-08-15', '2015-08-31 06:55:20', NULL),
(29, 29, 3, 'do', 'mon', '2015-08-27', '2015-08-31 07:19:49', NULL),
(30, 15, 2, 'xyhdj', 'ckytdkxtgkx', '2015-08-31', '2015-09-01 02:05:28', NULL),
(34, 15, 7, 'test', 'test', '2015-09-16', '2015-09-16 10:32:18', NULL),
(35, 15, 6, 'test', 'good', '2015-09-10', '2015-09-17 01:27:20', NULL),
(36, 15, 10, 'dasdasda', '123adasddad', '2015-09-18', '2015-09-17 01:46:13', NULL),
(37, 29, 2, '1234213421342134\n123421\n3421\n34\n213\n421\n4', '4124214', '2015-09-15', '2015-09-17 02:48:59', NULL),
(38, 30, 7, 'Point :Average. \nLittle food for one person.\n', 'Survey for lunch ', '2015-09-16', '2015-09-17 03:29:37', NULL),
(39, 30, NULL, 'Good point for this meal.\n\n', 'Survey for lunch ', '2015-09-10', '2015-09-17 03:30:21', NULL),
(40, 29, 3, 'it ''s a gôd dish', 'test abcd', '2015-09-16', '2015-09-17 06:06:40', NULL),
(41, 15, 7, 'test', 'abc', '2015-09-18', '2015-09-17 06:09:29', NULL),
(42, 15, 7, 'number 1	', 'number 1', '2015-09-18', '2015-09-17 08:50:26', NULL),
(43, 48, 3, 'Good services', 'Good', '2015-09-16', '2015-09-17 10:22:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dishes`
--

CREATE TABLE IF NOT EXISTS `dishes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8,
  `category_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=57 ;

--
-- Dumping data for table `dishes`
--

INSERT INTO `dishes` (`id`, `name`, `description`, `category_id`, `created_at`, `updated_at`) VALUES
(2, 'Canh rau muống 10', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam dignissim nulla at arcu dignissim placerat. Morbi maximus purus a semper posuere. Pellentesque varius lacinia nibh, a interdum purus dictum ut. Praesent hendrerit, est eu cursus dignissim, purus est feugiat velit, a convallis dui augue non enim. Nullam efficitur quam a ligula pretium sagittis. Vivamus accumsan viverra risus eu scelerisque. Mauris consequat accumsan diam, id efficitur nisi consequat non. Aliquam vulputate finibus nulla et tincidunt.\r\n\r\nCurabitur pulvinar pulvinar ex quis semper. Duis nec lorem eu felis vehicula accumsan. Sed non lectus pellentesque, gravida ante a, cursus est. Pellentesque viverra dolor sit amet dolor elementum lobortis. Suspendisse volutpat justo non arcu ullamcorper fringilla. Cras in ullamcorper ante. Donec eget vehicula elit. Donec dictum enim id orci sodales finibus. Etiam vitae nisl et elit egestas molestie. Pellentesque posuere laoreet elit sit amet suscipit. Mauris ut quam rhoncus, pharetra lectus at, cursus orci. Phasellus efficitur tempor sapien ac accumsan. Quisque eros libero, bibendum sit amet nibh vel, porttitor venenatis dolor. Donec dui velit, tincidunt et felis sed, mollis tempus nisl. Fusce vitae turpis id risus placerat lacinia eget sit amet turpis. Pellentesque vehicula quam quis ante porta, eget aliquam tellus blandit.', 1, '2015-09-04 10:42:37', '0000-00-00 00:00:00'),
(3, 'Phở 2', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam dignissim nulla at arcu dignissim placerat. Morbi maximus purus a semper posuere. Pellentesque varius lacinia nibh, a interdum purus dictum ut. Praesent hendrerit, est eu cursus dignissim, purus est feugiat velit, a convallis dui augue non enim. Nullam efficitur quam a ligula pretium sagittis. Vivamus accumsan viverra risus eu scelerisque. Mauris consequat accumsan diam, id efficitur nisi consequat non. Aliquam vulputate finibus nulla et tincidunt.\r\n\r\nCurabitur pulvinar pulvinar ex quis semper. Duis nec lorem eu felis vehicula accumsan. Sed non lectus pellentesque, gravida ante a, cursus est. Pellentesque viverra dolor sit amet dolor elementum lobortis. Suspendisse volutpat justo non arcu ullamcorper fringilla. Cras in ullamcorper ante. Donec eget vehicula elit. Donec dictum enim id orci sodales finibus. Etiam vitae nisl et elit egestas molestie. Pellentesque posuere laoreet elit sit amet suscipit. Mauris ut quam rhoncus, pharetra lectus at, cursus orci. Phasellus efficitur tempor sapien ac accumsan. Quisque eros libero, bibendum sit amet nibh vel, porttitor venenatis dolor. Donec dui velit, tincidunt et felis sed, mollis tempus nisl. Fusce vitae turpis id risus placerat lacinia eget sit amet turpis. Pellentesque vehicula quam quis ante porta, eget aliquam tellus blandit.', 3, '2015-09-01 06:18:30', '0000-00-00 00:00:00'),
(4, 'Canh rau muống 1', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam dignissim nulla at arcu dignissim placerat. Morbi maximus purus a semper posuere. Pellentesque varius lacinia nibh, a interdum purus dictum ut. Praesent hendrerit, est eu cursus dignissim, purus est feugiat velit, a convallis dui augue non enim. Nullam efficitur quam a ligula pretium sagittis. Vivamus accumsan viverra risus eu scelerisque. Mauris consequat accumsan diam, id efficitur nisi consequat non. Aliquam vulputate finibus nulla et tincidunt.\r\n\r\nCurabitur pulvinar pulvinar ex quis semper. Duis nec lorem eu felis vehicula accumsan. Sed non lectus pellentesque, gravida ante a, cursus est. Pellentesque viverra dolor sit amet dolor elementum lobortis. Suspendisse volutpat justo non arcu ullamcorper fringilla. Cras in ullamcorper ante. Donec eget vehicula elit. Donec dictum enim id orci sodales finibus. Etiam vitae nisl et elit egestas molestie. Pellentesque posuere laoreet elit sit amet suscipit. Mauris ut quam rhoncus, pharetra lectus at, cursus orci. Phasellus efficitur tempor sapien ac accumsan. Quisque eros libero, bibendum sit amet nibh vel, porttitor venenatis dolor. Donec dui velit, tincidunt et felis sed, mollis tempus nisl. Fusce vitae turpis id risus placerat lacinia eget sit amet turpis. Pellentesque vehicula quam quis ante porta, eget aliquam tellus blandit.', 1, '2015-09-04 10:41:58', '0000-00-00 00:00:00'),
(5, 'Thịt', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam dignissim nulla at arcu dignissim placerat. Morbi maximus purus a semper posuere. Pellentesque varius lacinia nibh, a interdum purus dictum ut. Praesent hendrerit, est eu cursus dignissim, purus est feugiat velit, a convallis dui augue non enim. Nullam efficitur quam a ligula pretium sagittis. Vivamus accumsan viverra risus eu scelerisque. Mauris consequat accumsan diam, id efficitur nisi consequat non. Aliquam vulputate finibus nulla et tincidunt.\r\n\r\nCurabitur pulvinar pulvinar ex quis semper. Duis nec lorem eu felis vehicula accumsan. Sed non lectus pellentesque, gravida ante a, cursus est. Pellentesque viverra dolor sit amet dolor elementum lobortis. Suspendisse volutpat justo non arcu ullamcorper fringilla. Cras in ullamcorper ante. Donec eget vehicula elit. Donec dictum enim id orci sodales finibus. Etiam vitae nisl et elit egestas molestie. Pellentesque posuere laoreet elit sit amet suscipit. Mauris ut quam rhoncus, pharetra lectus at, cursus orci. Phasellus efficitur tempor sapien ac accumsan. Quisque eros libero, bibendum sit amet nibh vel, porttitor venenatis dolor. Donec dui velit, tincidunt et felis sed, mollis tempus nisl. Fusce vitae turpis id risus placerat lacinia eget sit amet turpis. Pellentesque vehicula quam quis ante porta, eget aliquam tellus blandit.', 3, '2015-09-01 06:18:38', '0000-00-00 00:00:00'),
(6, 'Rau muống', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam dignissim nulla at arcu dignissim placerat. Morbi maximus purus a semper posuere. Pellentesque varius lacinia nibh, a interdum purus dictum ut. Praesent hendrerit, est eu cursus dignissim, purus est feugiat velit, a convallis dui augue non enim. Nullam efficitur quam a ligula pretium sagittis. Vivamus accumsan viverra risus eu scelerisque. Mauris consequat accumsan diam, id efficitur nisi consequat non. Aliquam vulputate finibus nulla et tincidunt.\r\n\r\nCurabitur pulvinar pulvinar ex quis semper. Duis nec lorem eu felis vehicula accumsan. Sed non lectus pellentesque, gravida ante a, cursus est. Pellentesque viverra dolor sit amet dolor elementum lobortis. Suspendisse volutpat justo non arcu ullamcorper fringilla. Cras in ullamcorper ante. Donec eget vehicula elit. Donec dictum enim id orci sodales finibus. Etiam vitae nisl et elit egestas molestie. Pellentesque posuere laoreet elit sit amet suscipit. Mauris ut quam rhoncus, pharetra lectus at, cursus orci. Phasellus efficitur tempor sapien ac accumsan. Quisque eros libero, bibendum sit amet nibh vel, porttitor venenatis dolor. Donec dui velit, tincidunt et felis sed, mollis tempus nisl. Fusce vitae turpis id risus placerat lacinia eget sit amet turpis. Pellentesque vehicula quam quis ante porta, eget aliquam tellus blandit.', 1, '2015-09-04 10:42:05', '0000-00-00 00:00:00'),
(7, 'Phở bò 3', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam dignissim nulla at arcu dignissim placerat. Morbi maximus purus a semper posuere. Pellentesque varius lacinia nibh, a interdum purus dictum ut. Praesent hendrerit, est eu cursus dignissim, purus est feugiat velit, a convallis dui augue non enim. Nullam efficitur quam a ligula pretium sagittis. Vivamus accumsan viverra risus eu scelerisque. Mauris consequat accumsan diam, id efficitur nisi consequat non. Aliquam vulputate finibus nulla et tincidunt.\r\n\r\nCurabitur pulvinar pulvinar ex quis semper. Duis nec lorem eu felis vehicula accumsan. Sed non lectus pellentesque, gravida ante a, cursus est. Pellentesque viverra dolor sit amet dolor elementum lobortis. Suspendisse volutpat justo non arcu ullamcorper fringilla. Cras in ullamcorper ante. Donec eget vehicula elit. Donec dictum enim id orci sodales finibus. Etiam vitae nisl et elit egestas molestie. Pellentesque posuere laoreet elit sit amet suscipit. Mauris ut quam rhoncus, pharetra lectus at, cursus orci. Phasellus efficitur tempor sapien ac accumsan. Quisque eros libero, bibendum sit amet nibh vel, porttitor venenatis dolor. Donec dui velit, tincidunt et felis sed, mollis tempus nisl. Fusce vitae turpis id risus placerat lacinia eget sit amet turpis. Pellentesque vehicula quam quis ante porta, eget aliquam tellus blandit.', 1, '2015-09-04 10:42:17', '0000-00-00 00:00:00'),
(8, 'Cháo cá', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam dignissim nulla at arcu dignissim placerat. Morbi maximus purus a semper posuere. Pellentesque varius lacinia nibh, a interdum purus dictum ut. Praesent hendrerit, est eu cursus dignissim, purus est feugiat velit, a convallis dui augue non enim. Nullam efficitur quam a ligula pretium sagittis. Vivamus accumsan viverra risus eu scelerisque. Mauris consequat accumsan diam, id efficitur nisi consequat non. Aliquam vulputate finibus nulla et tincidunt.\r\n\r\nCurabitur pulvinar pulvinar ex quis semper. Duis nec lorem eu felis vehicula accumsan. Sed non lectus pellentesque, gravida ante a, cursus est. Pellentesque viverra dolor sit amet dolor elementum lobortis. Suspendisse volutpat justo non arcu ullamcorper fringilla. Cras in ullamcorper ante. Donec eget vehicula elit. Donec dictum enim id orci sodales finibus. Etiam vitae nisl et elit egestas molestie. Pellentesque posuere laoreet elit sit amet suscipit. Mauris ut quam rhoncus, pharetra lectus at, cursus orci. Phasellus efficitur tempor sapien ac accumsan. Quisque eros libero, bibendum sit amet nibh vel, porttitor venenatis dolor. Donec dui velit, tincidunt et felis sed, mollis tempus nisl. Fusce vitae turpis id risus placerat lacinia eget sit amet turpis. Pellentesque vehicula quam quis ante porta, eget aliquam tellus blandit.', 1, '2015-08-27 10:45:53', '0000-00-00 00:00:00'),
(10, 'Thịt kho tàu', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam dignissim nulla at arcu dignissim placerat. Morbi maximus purus a semper posuere. Pellentesque varius lacinia nibh, a interdum purus dictum ut. Praesent hendrerit, est eu cursus dignissim, purus est feugiat velit, a convallis dui augue non enim. Nullam efficitur quam a ligula pretium sagittis. Vivamus accumsan viverra risus eu scelerisque. Mauris consequat accumsan diam, id efficitur nisi consequat non. Aliquam vulputate finibus nulla et tincidunt.\r\n\r\nCurabitur pulvinar pulvinar ex quis semper. Duis nec lorem eu felis vehicula accumsan. Sed non lectus pellentesque, gravida ante a, cursus est. Pellentesque viverra dolor sit amet dolor elementum lobortis. Suspendisse volutpat justo non arcu ullamcorper fringilla. Cras in ullamcorper ante. Donec eget vehicula elit. Donec dictum enim id orci sodales finibus. Etiam vitae nisl et elit egestas molestie. Pellentesque posuere laoreet elit sit amet suscipit. Mauris ut quam rhoncus, pharetra lectus at, cursus orci. Phasellus efficitur tempor sapien ac accumsan. Quisque eros libero, bibendum sit amet nibh vel, porttitor venenatis dolor. Donec dui velit, tincidunt et felis sed, mollis tempus nisl. Fusce vitae turpis id risus placerat lacinia eget sit amet turpis. Pellentesque vehicula quam quis ante porta, eget aliquam tellus blandit.', 1, '2015-08-28 04:22:52', '0000-00-00 00:00:00'),
(46, 'Ram cuốn cải', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam dignissim nulla at arcu dignissim placerat. Morbi maximus purus a semper posuere. Pellentesque varius lacinia nibh, a interdum purus dictum ut. Praesent hendrerit, est eu cursus dignissim, purus est feugiat velit, a convallis dui augue non enim. Nullam efficitur quam a ligula pretium sagittis. Vivamus accumsan viverra risus eu scelerisque. Mauris consequat accumsan diam, id efficitur nisi consequat non. Aliquam vulputate finibus nulla et tincidunt.\r\n\r\nCurabitur pulvinar pulvinar ex quis semper. Duis nec lorem eu felis vehicula accumsan. Sed non lectus pellentesque, gravida ante a, cursus est. Pellentesque viverra dolor sit amet dolor elementum lobortis. Suspendisse volutpat justo non arcu ullamcorper fringilla. Cras in ullamcorper ante. Donec eget vehicula elit. Donec dictum enim id orci sodales finibus. Etiam vitae nisl et elit egestas molestie. Pellentesque posuere laoreet elit sit amet suscipit. Mauris ut quam rhoncus, pharetra lectus at, cursus orci. Phasellus efficitur tempor sapien ac accumsan. Quisque eros libero, bibendum sit amet nibh vel, porttitor venenatis dolor. Donec dui velit, tincidunt et felis sed, mollis tempus nisl. Fusce vitae turpis id risus placerat lacinia eget sit amet turpis. Pellentesque vehicula quam quis ante porta, eget aliquam tellus blandit.', 1, '2015-08-28 06:11:05', '0000-00-00 00:00:00'),
(47, 'Canh rau muống 79878', 'fdgdfgd', 1, '2015-09-04 10:44:16', '0000-00-00 00:00:00'),
(56, 'Dâu tươi', 'Dâu tươi', 3, '2015-09-04 07:06:22', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `dishes_menus`
--

CREATE TABLE IF NOT EXISTS `dishes_menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dish_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=127 ;

--
-- Dumping data for table `dishes_menus`
--

INSERT INTO `dishes_menus` (`id`, `dish_id`, `menu_id`) VALUES
(46, 3, 11),
(73, 8, 10),
(74, 10, 10),
(75, 3, 10),
(76, 5, 10),
(77, 2, 10),
(78, 6, 10),
(84, 7, 3),
(85, 3, 3),
(86, 6, 2),
(87, 7, 2),
(88, 10, 2),
(89, 2, 1),
(90, 2, 1),
(91, 6, 1),
(92, 8, 7),
(93, 10, 7),
(94, 46, 7),
(95, 3, 7),
(96, 5, 7),
(122, 6, 14),
(123, 47, 14),
(125, 8, 12),
(126, 2, 12);

-- --------------------------------------------------------

--
-- Table structure for table `floors`
--

CREATE TABLE IF NOT EXISTS `floors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `description` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `floors`
--

INSERT INTO `floors` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Floor 1', 'Floor 1', '2015-08-20 10:12:16', '0000-00-00 00:00:00'),
(2, 'Floor 2', 'Floor 2', '2015-08-25 03:10:51', '0000-00-00 00:00:00'),
(3, 'Floor 3', 'Floor 3', '2015-08-25 03:10:51', '0000-00-00 00:00:00'),
(4, 'Floor 4', 'Floor 4', '2015-08-25 03:10:51', '0000-00-00 00:00:00'),
(5, 'Floor 5', 'Floor 5', '2015-08-25 03:10:51', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `keys`
--

CREATE TABLE IF NOT EXISTS `keys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(40) NOT NULL,
  `level` int(2) NOT NULL,
  `ignore_limits` tinyint(1) NOT NULL DEFAULT '0',
  `date_created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `meals`
--

CREATE TABLE IF NOT EXISTS `meals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `meal_date` date NOT NULL,
  `preordered_meals` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `meals`
--

INSERT INTO `meals` (`id`, `meal_date`, `preordered_meals`, `menu_id`, `created_at`, `updated_at`) VALUES
(1, '2015-08-17', 2, 1, '2015-08-19 08:21:09', '0000-00-00 00:00:00'),
(2, '2015-08-15', 4, 2, '2015-08-15 08:25:33', '0000-00-00 00:00:00'),
(3, '2015-08-12', 3, 1, '2015-08-11 01:13:01', '0000-00-00 00:00:00'),
(4, '2015-08-14', 3, 2, '2015-08-11 01:13:01', '0000-00-00 00:00:00'),
(6, '2015-08-25', 0, 1, '2015-08-28 03:33:53', '0000-00-00 00:00:00'),
(8, '2015-08-19', 2, 2, '2015-08-19 08:21:28', '0000-00-00 00:00:00'),
(12, '2015-08-26', 2, 2, '2015-08-28 03:20:51', '0000-00-00 00:00:00'),
(13, '2015-08-27', 2, 3, '2015-08-28 03:20:59', '0000-00-00 00:00:00'),
(14, '2015-08-31', 2, 1, '2015-08-19 08:21:09', '0000-00-00 00:00:00'),
(15, '2015-09-02', 2, 1, '2015-08-19 08:21:09', '0000-00-00 00:00:00'),
(16, '2015-09-03', 4, 2, '2015-08-15 08:25:33', '0000-00-00 00:00:00'),
(17, '2015-09-05', 2, 2, '2015-08-19 08:21:28', '0000-00-00 00:00:00'),
(18, '2015-09-17', 20, 10, '2015-09-15 06:08:28', '0000-00-00 00:00:00'),
(20, '2015-09-16', 5, 3, '2015-09-15 06:08:42', '0000-00-00 00:00:00'),
(21, '2015-09-18', 5, 2, '2015-09-15 06:08:56', '0000-00-00 00:00:00'),
(22, '2015-09-07', 5, 1, '2015-09-16 04:50:50', '0000-00-00 00:00:00'),
(23, '2015-09-08', 30, 7, '2015-09-16 04:50:58', '0000-00-00 00:00:00'),
(24, '2015-08-11', 0, 4, '2015-08-28 03:42:56', '0000-00-00 00:00:00'),
(25, '2015-09-29', 20, 2, '2015-09-08 04:49:45', '0000-00-00 00:00:00'),
(26, '2015-09-10', 20, 1, '2015-09-08 04:50:30', '0000-00-00 00:00:00'),
(31, '2015-10-08', 20, 1, '2015-09-08 04:56:52', '0000-00-00 00:00:00'),
(32, '2015-09-15', 20, 1, '2015-09-15 06:06:35', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE IF NOT EXISTS `menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `description` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Menu 1', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam dignissim nulla at arcu dignissim placerat. Morbi maximus purus a semper posuere. Pellentesque varius lacinia nibh, a interdum purus dictum ut. Praesent hendrerit, est eu cursus dignissim, purus est feugiat velit, a convallis dui augue non enim. Nullam efficitur quam a ligula pretium sagittis. Vivamus accumsan viverra risus eu scelerisque. Mauris consequat accumsan diam, id efficitur nisi consequat non. Aliquam vulputate finibus nulla et tincidunt.\r\n\r\nCurabitur pulvinar pulvinar ex quis semper. Duis nec lorem eu felis vehicula accumsan. Sed non lectus pellentesque, gravida ante a, cursus est. Pellentesque viverra dolor sit amet dolor elementum lobortis. Suspendisse volutpat justo non arcu ullamcorper fringilla. Cras in ullamcorper ante. Donec eget vehicula elit. Donec dictum enim id orci sodales finibus. Etiam vitae nisl et elit egestas molestie. Pellentesque posuere laoreet elit sit amet suscipit. Mauris ut quam rhoncus, pharetra lectus at, cursus orci. Phasellus efficitur tempor sapien ac accumsan. Quisque eros libero, bibendum sit amet nibh vel, porttitor venenatis dolor. Donec dui velit, tincidunt et felis sed, mollis tempus nisl. Fusce vitae turpis id risus placerat lacinia eget sit amet turpis. Pellentesque vehicula quam quis ante porta, eget aliquam tellus blandit.', '2015-09-03 10:45:30', '0000-00-00 00:00:00'),
(2, 'Menu 2', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam dignissim nulla at arcu dignissim placerat. Morbi maximus purus a semper posuere. Pellentesque varius lacinia nibh, a interdum purus dictum ut. Praesent hendrerit, est eu cursus dignissim, purus est feugiat velit, a convallis dui augue non enim. Nullam efficitur quam a ligula pretium sagittis. Vivamus accumsan viverra risus eu scelerisque. Mauris consequat accumsan diam, id efficitur nisi consequat non. Aliquam vulputate finibus nulla et tincidunt.\r\n\r\nCurabitur pulvinar pulvinar ex quis semper. Duis nec lorem eu felis vehicula accumsan. Sed non lectus pellentesque, gravida ante a, cursus est. Pellentesque viverra dolor sit amet dolor elementum lobortis. Suspendisse volutpat justo non arcu ullamcorper fringilla. Cras in ullamcorper ante. Donec eget vehicula elit. Donec dictum enim id orci sodales finibus. Etiam vitae nisl et elit egestas molestie. Pellentesque posuere laoreet elit sit amet suscipit. Mauris ut quam rhoncus, pharetra lectus at, cursus orci. Phasellus efficitur tempor sapien ac accumsan. Quisque eros libero, bibendum sit amet nibh vel, porttitor venenatis dolor. Donec dui velit, tincidunt et felis sed, mollis tempus nisl. Fusce vitae turpis id risus placerat lacinia eget sit amet turpis. Pellentesque vehicula quam quis ante porta, eget aliquam tellus blandit.', '2015-09-03 10:45:27', '0000-00-00 00:00:00'),
(3, 'Menu 3', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam dignissim nulla at arcu dignissim placerat. Morbi maximus purus a semper posuere. Pellentesque varius lacinia nibh, a interdum purus dictum ut. Praesent hendrerit, est eu cursus dignissim, purus est feugiat velit, a convallis dui augue non enim. Nullam efficitur quam a ligula pretium sagittis. Vivamus accumsan viverra risus eu scelerisque. Mauris consequat accumsan diam, id efficitur nisi consequat non. Aliquam vulputate finibus nulla et tincidunt.\r\n\r\nCurabitur pulvinar pulvinar ex quis semper. Duis nec lorem eu felis vehicula accumsan. Sed non lectus pellentesque, gravida ante a, cursus est. Pellentesque viverra dolor sit amet dolor elementum lobortis. Suspendisse volutpat justo non arcu ullamcorper fringilla. Cras in ullamcorper ante. Donec eget vehicula elit. Donec dictum enim id orci sodales finibus. Etiam vitae nisl et elit egestas molestie. Pellentesque posuere laoreet elit sit amet suscipit. Mauris ut quam rhoncus, pharetra lectus at, cursus orci. Phasellus efficitur tempor sapien ac accumsan. Quisque eros libero, bibendum sit amet nibh vel, porttitor venenatis dolor. Donec dui velit, tincidunt et felis sed, mollis tempus nisl. Fusce vitae turpis id risus placerat lacinia eget sit amet turpis. Pellentesque vehicula quam quis ante porta, eget aliquam tellus blandit.', '2015-09-03 10:45:18', '0000-00-00 00:00:00'),
(4, 'Menu 4', 'Menu 4', '2015-08-10 08:26:09', '0000-00-00 00:00:00'),
(5, 'Menu 5', 'Menu 5', '2015-08-10 08:26:09', '0000-00-00 00:00:00'),
(7, 'Menu', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam dignissim nulla at arcu dignissim placerat. Morbi maximus purus a semper posuere. Pellentesque varius lacinia nibh, a interdum purus dictum ut. Praesent hendrerit, est eu cursus dignissim, purus est feugiat velit, a convallis dui augue non enim. Nullam efficitur quam a ligula pretium sagittis. Vivamus accumsan viverra risus eu scelerisque. Mauris consequat accumsan diam, id efficitur nisi consequat non. Aliquam vulputate finibus nulla et tincidunt.\r\n\r\nCurabitur pulvinar pulvinar ex quis semper. Duis nec lorem eu felis vehicula accumsan. Sed non lectus pellentesque, gravida ante a, cursus est. Pellentesque viverra dolor sit amet dolor elementum lobortis. Suspendisse volutpat justo non arcu ullamcorper fringilla. Cras in ullamcorper ante. Donec eget vehicula elit. Donec dictum enim id orci sodales finibus. Etiam vitae nisl et elit egestas molestie. Pellentesque posuere laoreet elit sit amet suscipit. Mauris ut quam rhoncus, pharetra lectus at, cursus orci. Phasellus efficitur tempor sapien ac accumsan. Quisque eros libero, bibendum sit amet nibh vel, porttitor venenatis dolor. Donec dui velit, tincidunt et felis sed, mollis tempus nisl. Fusce vitae turpis id risus placerat lacinia eget sit amet turpis. Pellentesque vehicula quam quis ante porta, eget aliquam tellus blandit.', '2015-09-03 10:45:13', '0000-00-00 00:00:00'),
(10, 'Menu normal 2', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam dignissim nulla at arcu dignissim placerat. Morbi maximus purus a semper posuere. Pellentesque varius lacinia nibh, a interdum purus dictum ut. Praesent hendrerit, est eu cursus dignissim, purus est feugiat velit, a convallis dui augue non enim. Nullam efficitur quam a ligula pretium sagittis. Vivamus accumsan viverra risus eu scelerisque. Mauris consequat accumsan diam, id efficitur nisi consequat non. Aliquam vulputate finibus nulla et tincidunt.\r\n\r\nCurabitur pulvinar pulvinar ex quis semper. Duis nec lorem eu felis vehicula accumsan. Sed non lectus pellentesque, gravida ante a, cursus est. Pellentesque viverra dolor sit amet dolor elementum lobortis. Suspendisse volutpat justo non arcu ullamcorper fringilla. Cras in ullamcorper ante. Donec eget vehicula elit. Donec dictum enim id orci sodales finibus. Etiam vitae nisl et elit egestas molestie. Pellentesque posuere laoreet elit sit amet suscipit. Mauris ut quam rhoncus, pharetra lectus at, cursus orci. Phasellus efficitur tempor sapien ac accumsan. Quisque eros libero, bibendum sit amet nibh vel, porttitor venenatis dolor. Donec dui velit, tincidunt et felis sed, mollis tempus nisl. Fusce vitae turpis id risus placerat lacinia eget sit amet turpis. Pellentesque vehicula quam quis ante porta, eget aliquam tellus blandit.', '2015-09-03 10:45:05', '0000-00-00 00:00:00'),
(12, 'Menu normal 4', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam dignissim nulla at arcu dignissim placerat. Morbi maximus purus a semper posuere. Pellentesque varius lacinia nibh, a interdum purus dictum ut. Praesent hendrerit, est eu cursus dignissim, purus est feugiat velit, a convallis dui augue non enim. Nullam efficitur quam a ligula pretium sagittis. Vivamus accumsan viverra risus eu scelerisque. Mauris consequat accumsan diam, id efficitur nisi consequat non. Aliquam vulputate finibus nulla et tincidunt.\r\n\r\nCurabitur pulvinar pulvinar ex quis semper. Duis nec lorem eu felis vehicula accumsan. Sed non lectus pellentesque, gravida ante a, cursus est. Pellentesque viverra dolor sit amet dolor elementum lobortis. Suspendisse volutpat justo non arcu ullamcorper fringilla. Cras in ullamcorper ante. Donec eget vehicula elit. Donec dictum enim id orci sodales finibus. Etiam vitae nisl et elit egestas molestie. Pellentesque posuere laoreet elit sit amet suscipit. Mauris ut quam rhoncus, pharetra lectus at, cursus orci. Phasellus efficitur tempor sapien ac accumsan. Quisque eros libero, bibendum sit amet nibh vel, porttitor venenatis dolor. Donec dui velit, tincidunt et felis sed, mollis tempus nisl. Fusce vitae turpis id risus placerat lacinia eget sit amet turpis. Pellentesque vehicula quam quis ante porta, eget aliquam tellus blandit.', '2015-09-03 10:45:00', '0000-00-00 00:00:00'),
(14, 'Menu 9', 'Test', '2015-09-04 03:58:57', '0000-00-00 00:00:00'),
(15, 'Menu test', 'asd', '2015-09-07 02:37:41', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `pictures`
--

CREATE TABLE IF NOT EXISTS `pictures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` text NOT NULL,
  `description` text,
  `dish_id` int(11) DEFAULT NULL,
  `image_file_name` text NOT NULL,
  `image_content_type` text NOT NULL,
  `image_file_size` int(11) NOT NULL,
  `image_updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=72 ;

--
-- Dumping data for table `pictures`
--

INSERT INTO `pictures` (`id`, `image`, `description`, `dish_id`, `image_file_name`, `image_content_type`, `image_file_size`, `image_updated_at`, `created_at`, `updated_at`) VALUES
(43, 'http://113.160.225.87:8484/assets/images/dishes/1-8210-1406277579.jpg', '1-8210-1406277579.jpg', 2, '1-8210-1406277579.jpg', '', 0, '2015-09-15 05:02:08', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(44, 'http://113.160.225.87:8484/assets/images/dishes/1338367774-com-ngon21.jpg', '1338367774-com-ngon21.jpg', 3, '1338367774-com-ngon21.jpg', '', 0, '2015-09-15 05:05:10', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(47, 'http://113.160.225.87:8484/assets/images/dishes/88e9ad6comtam1.jpg', '88e9ad6comtam1.jpg', 4, '88e9ad6comtam1.jpg', '', 0, '2015-09-15 05:02:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(48, 'http://113.160.225.87:8484/assets/images/dishes/download.jpg', 'download.jpg', 5, 'download.jpg', '', 0, '2015-09-15 05:05:23', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(49, 'http://113.160.225.87:8484/assets/images/dishes/1338367774-com-ngon2.jpg', '1338367774-com-ngon2.jpg', 6, '1338367774-com-ngon2.jpg', '', 0, '2015-09-15 05:02:31', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(50, 'http://113.160.225.87:8484/assets/images/dishes/alotin_vn_1404142160_trangbh2012121110533646_0.jpg', 'alotin_vn_1404142160_trangbh2012121110533646_0.jpg', 7, 'alotin_vn_1404142160_trangbh2012121110533646_0.jpg', '', 0, '2015-09-15 05:03:16', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(51, 'http://113.160.225.87:8484/assets/images/dishes/download_(2).jpg', 'download_(2).jpg', 8, 'download_(2).jpg', '', 0, '2015-09-15 05:03:59', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(56, 'http://113.160.225.87:8484/assets/images/dishes/download_(1).jpg', 'download_(1).jpg', 10, 'download_(1).jpg', '', 0, '2015-09-15 05:04:13', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(58, 'http://113.160.225.87:8484/assets/images/dishes/1-8210-14062775791.jpg', '1-8210-14062775791.jpg', 46, '1-8210-14062775791.jpg', '', 0, '2015-09-15 05:04:36', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(59, 'http://113.160.225.87:8484/assets/images/dishes/1-8210-14062775792.jpg', '1-8210-14062775792.jpg', 47, '1-8210-14062775792.jpg', '', 0, '2015-09-15 05:04:55', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(69, 'http://113.160.225.87:8484/assets/images/dishes/download1.jpg', 'download1.jpg', 56, 'download1.jpg', '', 0, '2015-09-15 05:05:36', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(71, 'http://113.160.225.87:8484/assets/images/dishes/maxresdefault1.jpg', 'maxresdefault1.jpg', 57, 'maxresdefault1.jpg', '', 0, '2015-09-07 02:48:08', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `reply_messages`
--

CREATE TABLE IF NOT EXISTS `reply_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `message_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `type_messages` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=78 ;

--
-- Dumping data for table `reply_messages`
--

INSERT INTO `reply_messages` (`id`, `user_id`, `content`, `message_id`, `created_at`, `updated_at`, `type_messages`) VALUES
(8, 30, 'Hi, Admin. \nThank for you annoucement.', 4, '2015-09-15 06:24:27', '0000-00-00 00:00:00', 'admin_messages'),
(9, 30, 'Good afternoon, Admin.\nThank for your annoucement.', 5, '2015-09-15 06:34:24', '0000-00-00 00:00:00', 'admin_messages'),
(10, 15, 'test', 16, '2015-09-15 07:26:56', '0000-00-00 00:00:00', 'comments'),
(14, 1, 'Reply comment', 16, '2015-09-15 07:26:56', '0000-00-00 00:00:00', 'comments'),
(15, 15, 'thanks', 16, '2015-09-15 08:17:50', '0000-00-00 00:00:00', 'comments'),
(16, 1, 'Reply comment 2', 16, '2015-09-15 07:26:56', '0000-00-00 00:00:00', 'comments'),
(17, 1, 'Reply comment 3', 16, '2015-09-15 07:26:56', '0000-00-00 00:00:00', 'comments'),
(18, 1, 'test', 1, '2015-09-16 04:35:35', '0000-00-00 00:00:00', 'admin_messages'),
(19, 29, 'Hello', 17, '2015-09-16 07:57:27', '0000-00-00 00:00:00', 'comments'),
(20, 29, '"Test send message."', 4, '2015-09-16 08:00:30', '0000-00-00 00:00:00', 'comments'),
(21, 30, 'sdfsdf', 3, '2015-09-16 08:21:53', '0000-00-00 00:00:00', 'admin_messages'),
(22, 29, '"I got it."', 4, '2015-09-16 08:39:06', '0000-00-00 00:00:00', 'admin_messages'),
(23, 29, '1234', 17, '2015-09-16 08:39:34', '0000-00-00 00:00:00', 'comments'),
(24, 29, 'test', 1, '2015-09-16 08:39:44', '0000-00-00 00:00:00', 'admin_messages'),
(25, 29, '23423424234234234', 1, '2015-09-16 09:06:48', '0000-00-00 00:00:00', 'admin_messages'),
(26, 29, '123213', 1, '2015-09-16 09:06:52', '0000-00-00 00:00:00', 'admin_messages'),
(27, 29, '2353', 18, '2015-09-16 10:17:04', '0000-00-00 00:00:00', 'comments'),
(28, 30, 'Hi, Admin. Have a nice day. ', 3, '2015-09-16 10:45:44', '0000-00-00 00:00:00', 'admin_messages'),
(29, 1, 'OK. I got it', 1, '2015-09-16 11:06:22', '0000-00-00 00:00:00', 'admin_messages'),
(49, 15, 'test with long text "asdfghjjkllasdasbfbdfhabkfbhsbafbfdbbadhfbakbfhbakfdhkafhdbsahfhdsbfbsbafbasbf"', 16, '2015-09-17 01:25:40', '0000-00-00 00:00:00', 'comments'),
(50, 29, '4214123421342134\n1234\n12\n34\n2134\n21\n34', 18, '2015-09-17 02:44:33', '0000-00-00 00:00:00', 'comments'),
(51, 29, '4213421342134\n2\n134\n124213421342\n1\n23\n4', 18, '2015-09-17 02:47:52', '0000-00-00 00:00:00', 'comments'),
(52, 29, '123123', 3, '2015-09-17 02:48:24', '0000-00-00 00:00:00', 'admin_messages'),
(54, 1, 'Thanks for comment.', 38, '2015-09-15 07:26:56', '0000-00-00 00:00:00', 'comments'),
(55, 1, 'Thanks for comment.', 39, '2015-09-15 07:26:56', '0000-00-00 00:00:00', 'comments'),
(56, 1, 'Hello.', 14, '2015-09-17 04:53:40', '0000-00-00 00:00:00', 'admin_messages'),
(57, 1, 'I got it', 13, '2015-09-17 05:40:21', '0000-00-00 00:00:00', 'admin_messages'),
(58, 29, '231235\n412\n3412\n34\n213\n42', 18, '2015-09-17 06:01:00', '0000-00-00 00:00:00', 'comments'),
(59, 29, '12431234bb\n\n2134234', 18, '2015-09-17 06:01:07', '0000-00-00 00:00:00', 'comments'),
(60, 29, '41234', 18, '2015-09-17 06:02:02', '0000-00-00 00:00:00', 'comments'),
(61, 29, '1234234', 18, '2015-09-17 06:02:05', '0000-00-00 00:00:00', 'comments'),
(62, 29, '34123412\n2134234\n1234', 18, '2015-09-17 06:02:12', '0000-00-00 00:00:00', 'comments'),
(63, 29, '214214', 18, '2015-09-17 06:02:21', '0000-00-00 00:00:00', 'comments'),
(64, 29, '2134', 18, '2015-09-17 06:02:22', '0000-00-00 00:00:00', 'comments'),
(65, 29, '21', 18, '2015-09-17 06:02:23', '0000-00-00 00:00:00', 'comments'),
(66, 29, 'ggsd', 37, '2015-09-17 06:05:52', '0000-00-00 00:00:00', 'comments'),
(67, 29, 'sđ', 29, '2015-09-17 06:09:36', '0000-00-00 00:00:00', 'comments'),
(68, 1, 'Test reply', 14, '2015-09-17 06:42:06', '0000-00-00 00:00:00', 'admin_messages'),
(69, 29, 'hhgf', 29, '2015-09-17 07:16:38', '0000-00-00 00:00:00', 'comments'),
(70, 1, 'OK', 14, '2015-09-17 08:37:05', '0000-00-00 00:00:00', 'admin_messages'),
(71, 29, 'adasda', 17, '2015-09-17 09:47:29', '0000-00-00 00:00:00', 'comments'),
(72, 29, 'hkgkjgkjgkj', 17, '2015-09-17 09:47:58', '0000-00-00 00:00:00', 'comments'),
(73, 29, 'asdasdasasdasdad', 37, '2015-09-17 10:06:26', '0000-00-00 00:00:00', 'comments'),
(74, 48, 'Test', 43, '2015-09-17 10:23:16', '0000-00-00 00:00:00', 'comments'),
(75, 29, '21312312', 17, '2015-09-17 10:34:58', '0000-00-00 00:00:00', 'comments'),
(76, 29, '"Test send message."', 4, '2015-09-16 08:00:30', '0000-00-00 00:00:00', 'comments');

-- --------------------------------------------------------

--
-- Table structure for table `shifts`
--

CREATE TABLE IF NOT EXISTS `shifts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `description` text,
  `start_time` time NOT NULL DEFAULT '00:00:00',
  `end_time` time NOT NULL DEFAULT '00:00:00',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `shifts`
--

INSERT INTO `shifts` (`id`, `name`, `description`, `start_time`, `end_time`, `created_at`, `updated_at`) VALUES
(1, 'Suat 1', 'Suat 1', '11:00:00', '11:30:00', '2015-09-14 17:00:00', '0000-00-00 00:00:00'),
(2, 'Suat 2', 'Suat 2', '11:30:00', '12:00:00', '2015-09-15 17:00:00', '2015-09-15 08:35:36'),
(3, 'Suat 3', 'Suat 3', '00:00:00', '13:31:00', '2015-09-15 09:45:09', '2015-09-15 09:45:09');

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE IF NOT EXISTS `tables` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `description` text,
  `for_vegans` tinyint(1) NOT NULL DEFAULT '0',
  `seats` int(11) NOT NULL,
  `available_seats` int(11) NOT NULL,
  `shift_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`id`, `name`, `description`, `for_vegans`, `seats`, `available_seats`, `shift_id`, `created_at`, `updated_at`) VALUES
(1, 'Table normal', 'Table normal', 0, 7, 7, 1, '2015-09-18 02:40:47', '0000-00-00 00:00:00'),
(2, 'Table normal 2', 'Table normal 2', 0, 7, 7, 1, '2015-09-04 02:13:02', '0000-00-00 00:00:00'),
(3, 'Table normal 3', 'Table normal 3', 0, 7, 7, 1, '2015-09-04 02:12:59', '0000-00-00 00:00:00'),
(4, 'Table normal 4', 'Table normal 4', 0, 7, 7, 2, '2015-09-18 02:40:53', '0000-00-00 00:00:00'),
(5, 'Table normal 5', 'Table normal 5', 0, 7, 7, 2, '2015-08-21 02:20:48', '0000-00-00 00:00:00'),
(6, 'Table normal 6', 'Table normal 6', 0, 7, 7, 2, '2015-08-27 07:26:37', '0000-00-00 00:00:00'),
(7, 'Table normal 7', 'Table normal 7', 0, 7, 7, 3, '2015-09-01 01:34:21', '0000-00-00 00:00:00'),
(8, 'Table normal 8', 'Table normal 8', 0, 7, 7, 3, '2015-09-01 09:05:02', '0000-00-00 00:00:00'),
(9, 'Table mormal 9', 'Table mormal 9', 0, 7, 7, 3, '2015-09-18 02:40:35', '0000-00-00 00:00:00'),
(10, 'Table vegan 1', 'Table vegan 1', 1, 7, 7, 3, '2015-09-16 04:50:28', '0000-00-00 00:00:00'),
(11, 'Table vegan', 'Table vegan', 1, 7, 7, 1, '2015-09-04 02:12:59', '0000-00-00 00:00:00'),
(12, 'Table vegan', 'Table vegan', 1, 7, 7, 2, '2015-08-27 07:26:37', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tables_users`
--

CREATE TABLE IF NOT EXISTS `tables_users` (
  `table_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'user id',
  `email` text CHARACTER SET latin1 NOT NULL,
  `encrypted_password` text CHARACTER SET latin1 NOT NULL,
  `reset_password_token` text CHARACTER SET latin1,
  `reset_password_sent_at` timestamp NULL DEFAULT NULL,
  `remember_created_at` timestamp NULL DEFAULT NULL,
  `sign_in_count` int(11) NOT NULL DEFAULT '0',
  `current_sign_in_at` timestamp NULL DEFAULT NULL,
  `last_sign_in_at` timestamp NULL DEFAULT NULL,
  `confirmation_token` text CHARACTER SET latin1,
  `confirmation_sent_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `avatar_file_name` text CHARACTER SET latin1,
  `avatar_content_file` text CHARACTER SET latin1,
  `avatar_file_size` int(11) DEFAULT NULL,
  `avatar_updated_at` timestamp NULL DEFAULT NULL,
  `first_name` text CHARACTER SET latin1 NOT NULL,
  `last_name` text CHARACTER SET latin1 NOT NULL,
  `floor_id` int(11) DEFAULT NULL,
  `shift_id` tinyint(4) NOT NULL,
  `what_taste` text CHARACTER SET latin1,
  `want_vegan_meal` tinyint(1) NOT NULL DEFAULT '0',
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `authentication_token` text CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=49 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `encrypted_password`, `reset_password_token`, `reset_password_sent_at`, `remember_created_at`, `sign_in_count`, `current_sign_in_at`, `last_sign_in_at`, `confirmation_token`, `confirmation_sent_at`, `created_at`, `updated_at`, `avatar_file_name`, `avatar_content_file`, `avatar_file_size`, `avatar_updated_at`, `first_name`, `last_name`, `floor_id`, `shift_id`, `what_taste`, `want_vegan_meal`, `admin`, `authentication_token`) VALUES
(1, 'cody@enclave.vn', '$2a$08$3rD9IKTDUY44KT6LgZRefu60aO681FZCUeHu4eJN5U8UWRc7/waJe', NULL, '2015-08-26 14:19:34', NULL, 0, NULL, NULL, NULL, NULL, NULL, '2015-09-16 11:16:28', '10906251_728963490533567_6473881943192600836_n.jpg', 'http://113.160.225.87:8484/assets/images/users/10906251_728963490533567_6473881943192600836_n.jpg', NULL, NULL, 'Cuong', 'Cody', 5, 1, 'Salty', 1, 1, 'ed44d0ff5ff2e9de393fa22b99dd041213f2b38bec86c4795939f8b603f1610f898889bb9826af5bcd331d21390973c12bd2a9754384113ab51da1a808fb60c43UAHYIqlvnfPgUBjbaP2e7GwqQdkqJQGUz85Zay+kSc='),
(3, 'cody@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, '2015-08-08 09:35:15', NULL, 0, NULL, NULL, NULL, NULL, '2015-08-08 09:33:00', '2015-09-04 07:45:03', '10906251_728963490533567_6473881943192600836_n2.jpg', 'http://113.160.225.87:8484/assets/images/users/10906251_728963490533567_6473881943192600836_n2.jpg', NULL, NULL, 'Akos', 'Nguyen', 1, 1, 'Normal', 0, 0, 'ed44d0ff5ff2e9de393fa22b99dd041213f2b38bec86c4795939f8b603f1610f898889bb9826af5bcd331d21390973c12bd2a9754384113ab51da1a808fb60c43UAHYIqlvnfPgUBjbaP2e7GwqQdkqJQGUz85Zay+kSc='),
(10, 'asd@enclace.vn', '$2a$08$WjWxjNRtNiYqBZ1uyIfl/OCdJGpmafY6K3X1HirbC3g4p/7TyYoUS', NULL, '2015-08-08 09:26:28', '2015-08-08 09:26:28', 0, '2015-08-08 09:26:28', '2015-08-08 09:26:28', NULL, '2015-08-08 09:26:28', '2015-08-08 09:26:28', '2015-09-15 03:55:53', 'huyc.png', 'http://113.160.225.87:8484/assets/images/users/huyc.png', NULL, '2015-08-08 09:26:28', 'Terry', 'Thanh', 1, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam dignissim nulla at arcu dignissim placerat. Morbi maximus purus a semper posuere. Pellentesque varius lacinia nibh, a interdum purus dictum ut. Praesent hendrerit, est eu cursus dignissim, purus est feugiat velit, a convallis dui augue non enim. Nullam efficitur quam a ligula pretium sagittis. Vivamus accumsan viverra risus eu scelerisque. Mauris consequat accumsan diam, id efficitur nisi consequat non. Aliquam vulputate finibus nulla et tincidunt.\r\n\r\nCurabitur pulvinar pulvinar ex quis semper. Duis nec lorem eu felis vehicula accumsan. Sed non lectus pellentesque, gravida ante a, cursus est. Pellentesque viverra dolor sit amet dolor elementum lobortis. Suspendisse volutpat justo non arcu ullamcorper fringilla. Cras in ullamcorper ante. Donec eget vehicula elit. Donec dictum enim id orci sodales finibus. Etiam vitae nisl et elit egestas molestie. Pellentesque posuere laoreet elit sit amet suscipit. Mauris ut quam rhoncus, pharetra lectus at, cursus orci. Phasellus efficitur tempor sapien ac accumsan. Quisque eros libero, bibendum sit amet nibh vel, porttitor venenatis dolor. Donec dui velit, tincidunt et felis sed, mollis tempus nisl. Fusce vitae turpis id risus placerat lacinia eget sit amet turpis. Pellentesque vehicula quam quis ante porta, eget aliquam tellus blandit.', 1, 0, 'ed44d0ff5ff2e9de393fa22b99dd041213f2b38bec86c4795939f8b603f1610f898889bb9826af5bcd331d21390973c12bd2a9754384113ab51da1a808fb60c43UAHYIqlvnfPgUBjbaP2e7GwqQdkqJQGUz85Zay+kSc='),
(15, 'test@enclave.vn', '$2a$08$laMBAOYdnxDU1PXjRMZifOjrM2IrJLW0k..nOgZcS2uBe3Shg7IFu', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'http://113.160.225.87:8484/assets/images/users/default-avatar3.png', NULL, NULL, 'Test', 'Test', NULL, 2, 'milk', 0, 0, 'ed44d0ff5ff2e9de393fa22b99dd041213f2b38bec86c4795939f8b603f1610f898889bb9826af5bcd331d21390973c12bd2a9754384113ab51da1a808fb60c43UAHYIqlvnfPgUBjbaP2e7GwqQdkqJQGUz85Zay+kSc='),
(16, 'test_vegan@enclave.vn', '$2a$08$t12Yes2j6QpSZeHqSOWMkuKhw5z0obnSN4GTV9qFYZ7I70rx/imDS', NULL, '2015-08-26 09:25:35', NULL, 0, NULL, NULL, NULL, NULL, NULL, '2015-09-15 06:25:25', 'thanhc.png', 'http://113.160.225.87:8484/assets/images/users/thanhc.png', NULL, NULL, 'Test Vegan', 'Test Vegan', 1, 2, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam dignissim nulla at arcu dignissim placerat. Morbi maximus purus a semper posuere. Pellentesque varius lacinia nibh, a interdum purus dictum ut. Praesent hendrerit, est eu cursus dignissim, purus est feugiat velit, a convallis dui augue non enim. Nullam efficitur quam a ligula pretium sagittis. Vivamus accumsan viverra risus eu scelerisque. Mauris consequat accumsan diam, id efficitur nisi consequat non. Aliquam vulputate finibus nulla et tincidunt.\r\n\r\nCurabitur pulvinar pulvinar ex quis semper. Duis nec lorem eu felis vehicula accumsan. Sed non lectus pellentesque, gravida ante a, cursus est. Pellentesque viverra dolor sit amet dolor elementum lobortis. Suspendisse volutpat justo non arcu ullamcorper fringilla. Cras in ullamcorper ante. Donec eget vehicula elit. Donec dictum enim id orci sodales finibus. Etiam vitae nisl et elit egestas molestie. Pellentesque posuere laoreet elit sit amet suscipit. Mauris ut quam rhoncus, pharetra lectus at, cursus orci. Phasellus efficitur tempor sapien ac accumsan. Quisque eros libero, bibendum sit amet nibh vel, porttitor venenatis dolor. Donec dui velit, tincidunt et felis sed, mollis tempus nisl. Fusce vitae turpis id risus placerat lacinia eget sit amet turpis. Pellentesque vehicula quam quis ante porta, eget aliquam tellus blandit.', 1, 0, 'ed44d0ff5ff2e9de393fa22b99dd041213f2b38bec86c4795939f8b603f1610f898889bb9826af5bcd331d21390973c12bd2a9754384113ab51da1a808fb60c43UAHYIqlvnfPgUBjbaP2e7GwqQdkqJQGUz85Zay+kSc='),
(29, 'pax@enclave.vn', '$2a$08$Bu4reoOVdr3bGjORmn5Hb.1kXYzc5zVFoKwvosnbFdcqBLhkfYQvS', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'http://113.160.225.87:8484/assets/images/users/default-avatar4.png', NULL, NULL, 'Pax', 'Pax', NULL, 2, 'little bit salty 123\r\n\r\naasdas 234', 0, 0, 'ed44d0ff5ff2e9de393fa22b99dd041213f2b38bec86c4795939f8b603f1610f898889bb9826af5bcd331d21390973c12bd2a9754384113ab51da1a808fb60c43UAHYIqlvnfPgUBjbaP2e7GwqQdkqJQGUz85Zay+kSc='),
(30, 'brian@enclave.vn', '$2a$08$no2ijm6x8983PQ51dlQYHOiBcIu6EpojQt1oKUOPm4fqcLKrjOgxm', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'http://113.160.225.87:8484/assets/images/users/imgo2.jpg', NULL, NULL, 'Brian', 'Brian', NULL, 1, 'milks', 1, 0, 'ed44d0ff5ff2e9de393fa22b99dd041213f2b38bec86c4795939f8b603f1610f898889bb9826af5bcd331d21390973c12bd2a9754384113ab51da1a808fb60c43UAHYIqlvnfPgUBjbaP2e7GwqQdkqJQGUz85Zay+kSc='),
(40, 'talon@enclave.vn', '$2a$08$W2lMruTDdNxMaeEJRBq8Qez/jX7ep7EYB8Fee3qJiyF5sAkuYw0ji', NULL, '2015-08-25 03:57:38', '2015-08-25 03:57:38', 0, '2015-08-25 03:57:38', '2015-08-25 03:57:38', NULL, '2015-08-25 03:57:38', '2015-08-25 03:57:38', '2015-09-03 10:49:49', 'download_(1).jpg', 'http://113.160.225.87:8484/assets/images/users/download_(1).jpg', NULL, NULL, 'Carrick', 'Thanh', 1, 3, 'Salty', 0, 0, 'ed44d0ff5ff2e9de393fa22b99dd041213f2b38bec86c4795939f8b603f1610f898889bb9826af5bcd331d21390973c12bd2a9754384113ab51da1a808fb60c43UAHYIqlvnfPgUBjbaP2e7GwqQdkqJQGUz85Zay+kSc='),
(46, 'nguyennhatcuong.it@gmail.com', '$2a$08$baXKdxdQ2zvQdqebsL0/ne1QhRxarruaDuXvM9eM9VCgnJG5X8fDm', NULL, '2015-08-25 07:16:53', '2015-08-25 07:16:53', 0, '2015-08-25 07:16:53', '2015-08-25 07:16:53', NULL, '2015-08-25 07:16:53', '2015-08-25 07:16:53', '2015-09-15 09:46:08', '10906251_728963490533567_6473881943192600836_n7.jpg', 'http://113.160.225.87:8484/assets/images/users/10906251_728963490533567_6473881943192600836_n7.jpg', NULL, NULL, 'Rooney', 'Wayne', 2, 3, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam dignissim nulla at arcu dignissim placerat. Morbi maximus purus a semper posuere. Pellentesque varius lacinia nibh, a interdum purus dictum ut. Praesent hendrerit, est eu cursus dignissim, purus est feugiat velit, a convallis dui augue non enim. Nullam efficitur quam a ligula pretium sagittis. Vivamus accumsan viverra risus eu scelerisque. Mauris consequat accumsan diam, id efficitur nisi consequat non. Aliquam vulputate finibus nulla et tincidunt.\r\n\r\nCurabitur pulvinar pulvinar ex quis semper. Duis nec lorem eu felis vehicula accumsan. Sed non lectus pellentesque, gravida ante a, cursus est. Pellentesque viverra dolor sit amet dolor elementum lobortis. Suspendisse volutpat justo non arcu ullamcorper fringilla. Cras in ullamcorper ante. Donec eget vehicula elit. Donec dictum enim id orci sodales finibus. Etiam vitae nisl et elit egestas molestie. Pellentesque posuere laoreet elit sit amet suscipit. Mauris ut quam rhoncus, pharetra lectus at, cursus orci. Phasellus efficitur tempor sapien ac accumsan. Quisque eros libero, bibendum sit amet nibh vel, porttitor venenatis dolor. Donec dui velit, tincidunt et felis sed, mollis tempus nisl. Fusce vitae turpis id risus placerat lacinia eget sit amet turpis. Pellentesque vehicula quam quis ante porta, eget aliquam tellus blandit.', 1, 0, 'ed44d0ff5ff2e9de393fa22b99dd041213f2b38bec86c4795939f8b603f1610f898889bb9826af5bcd331d21390973c12bd2a9754384113ab51da1a808fb60c43UAHYIqlvnfPgUBjbaP2e7GwqQdkqJQGUz85Zay+kSc='),
(47, 'test_cody@gmail.com', '$2a$08$PU1snZehPQBw/ymzb.S/muFYMKUNIS07.JoXyWOEgmEZ3692Fv5VW', NULL, '2015-09-15 04:18:41', '2015-09-15 04:18:41', 0, '2015-09-15 04:18:41', '2015-09-15 04:18:41', NULL, '2015-09-15 04:18:41', '2015-09-15 04:18:41', '2015-09-15 04:21:09', 'cuongc.png', 'http://113.160.225.87:8484/assets/images/users/cuongc.png', NULL, NULL, 'test_cody', 'Test', 1, 0, 'Normal', 1, 1, 'ed44d0ff5ff2e9de393fa22b99dd041213f2b38bec86c4795939f8b603f1610f898889bb9826af5bcd331d21390973c12bd2a9754384113ab51da1a808fb60c43UAHYIqlvnfPgUBjbaP2e7GwqQdkqJQGUz85Zay+kSc='),
(48, 'nick@enclave.vn', '$2a$08$vBoflNm6WCiIKMEeHfdhIeSqCHBtRh1ry3C43my4m4FNDjc9kxbsC', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'http://113.160.225.87:8484/assets/images/users/imgo_(2).jpg', NULL, NULL, 'Nick', 'Nam', 1, 2, 'Normal', 1, 0, 'ed44d0ff5ff2e9de393fa22b99dd041213f2b38bec86c4795939f8b603f1610f898889bb9826af5bcd331d21390973c12bd2a9754384113ab51da1a808fb60c43UAHYIqlvnfPgUBjbaP2e7GwqQdkqJQGUz85Zay+kSc=');

-- --------------------------------------------------------

--
-- Table structure for table `vote_logs`
--

CREATE TABLE IF NOT EXISTS `vote_logs` (
  `user_id` int(11) NOT NULL,
  `first_day_of_week` date NOT NULL,
  `votes` varchar(100) CHARACTER SET latin1 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vote_logs`
--

INSERT INTO `vote_logs` (`user_id`, `first_day_of_week`, `votes`) VALUES
(1, '2015-08-17', '3;3;4;2;'),
(3, '2015-08-17', '2;2;7;'),
(15, '2015-08-17', '6;1;'),
(10, '2015-08-17', '7;'),
(1, '2015-08-10', '1;2;3;4'),
(1, '2015-08-24', '1;2;3;1;1;'),
(3, '2015-08-24', '1;2;3;'),
(5, '2015-08-24', '1;2;3;4;5;'),
(7, '2015-08-24', '1;2;2;2;2;'),
(15, '2015-08-24', '2;1;2;3;'),
(16, '2015-08-24', '1;2;3;1;2;'),
(29, '2015-08-24', '2;3;4;'),
(30, '2015-08-31', '2;3;2;2;3;'),
(15, '2015-08-31', '2;3;3;10;'),
(29, '2015-08-31', '3;5;3;5;6;'),
(1, '2015-09-07', '3;4;5;'),
(3, '2015-09-07', '4;5;'),
(29, '2015-09-07', '3;'),
(30, '2015-09-07', '2;3;2;4;'),
(29, '2015-09-14', '3;3;2;2;3;'),
(15, '2015-09-14', '2;3;4;2;3;'),
(30, '2015-09-14', '3;');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
