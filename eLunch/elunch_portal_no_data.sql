-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 09, 2015 at 01:53 PM
-- Server version: 5.5.46-0ubuntu0.14.04.2
-- PHP Version: 5.5.9-1ubuntu4.14

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
-- Table structure for table `access_point`
--

CREATE TABLE IF NOT EXISTS `access_point` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ssid` varchar(255) NOT NULL,
  `bssid` varchar(255) NOT NULL,
  `floor_id` int(11) DEFAULT NULL,
  `selected` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `access_point`
--

INSERT INTO `access_point` (`id`, `ssid`, `bssid`, `floor_id`, `selected`, `created_at`, `updated_at`) VALUES
(1, 'EnclaveODC1', 'B8:A3:86:62:CF:7C', 1, 0, '0000-00-00 00:00:00', '2015-10-13 03:30:01'),
(2, 'EnclaveODC2', 'C8:D3:A3:5D:A9:83', 2, 1, '0000-00-00 00:00:00', '2015-11-06 08:42:03'),
(3, 'EnclaveODC3', 'C8:D3:A3:5D:A9:83', 3, 1, '0000-00-00 00:00:00', '2015-11-06 08:42:15'),
(4, 'EnclaveODC4', 'C8:D3:A3:5D:A9:83', 4, 1, '0000-00-00 00:00:00', '2015-11-06 08:42:30'),
(5, 'EnclaveODC5', 'E8:CC:18:41:38:BB', 5, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=634 ;

--
-- Dumping data for table `admin_messages`
--

INSERT INTO `admin_messages` (`id`, `user_id`, `title`, `content`, `meal_date`, `table`, `shift`, `user`, `created_at`, `updated_at`) VALUES
(588, 1, 'Announcement for all users', 'Announcement for all users', '2015-10-22', NULL, NULL, 'all', '2015-10-22 10:07:53', '0000-00-00 00:00:00'),
(589, 1, 'Nick', '123', '2015-10-08', NULL, NULL, '48', '2015-10-22 10:54:22', '0000-00-00 00:00:00'),
(590, 1, 'Nick', '123', '2015-10-23', NULL, NULL, '48', '2015-10-23 01:43:44', '0000-00-00 00:00:00'),
(591, 1, 'Nick', 'asdsadsadsadsad', '2015-10-23', NULL, NULL, '48', '2015-10-23 01:45:02', '0000-00-00 00:00:00'),
(592, 1, 'Nick', 'ertert', '2015-10-23', NULL, NULL, '48', '2015-10-23 01:47:07', '0000-00-00 00:00:00'),
(593, 1, 'Nick', '123', '2015-10-23', NULL, NULL, '48', '2015-10-23 02:13:22', '0000-00-00 00:00:00'),
(594, 1, 'Nick', '12341234', '2015-10-23', NULL, NULL, '48', '2015-10-23 02:48:03', '0000-00-00 00:00:00'),
(595, 1, 'Nick', 'trereeererer', '2015-10-23', NULL, NULL, '48', '2015-10-23 02:51:24', '0000-00-00 00:00:00'),
(596, 1, 'Nick all users', 'test', '2015-10-23', NULL, NULL, 'all', '2015-10-23 04:12:48', '0000-00-00 00:00:00'),
(597, 1, 'Nick', '123123', '2015-10-23', NULL, NULL, '48', '2015-10-23 04:45:13', '0000-00-00 00:00:00'),
(598, 1, 'Test push', 'OK', '2015-10-23', NULL, NULL, '55', '2015-10-23 06:08:55', '0000-00-00 00:00:00'),
(599, 1, 'Pax test Friday 213', 'AASCEECE', '2015-10-07', NULL, NULL, '29', '2015-10-23 06:10:08', '0000-00-00 00:00:00'),
(600, 1, 'All user', 'ádsad', '2015-10-23', NULL, NULL, 'all', '2015-10-23 06:12:28', '0000-00-00 00:00:00'),
(601, 1, 'Pax test with cody', '2321512512 begrfsdfdf', '2015-10-23', NULL, NULL, '55', '2015-10-23 07:10:28', '0000-00-00 00:00:00'),
(602, 1, 'Tétdsf', 'sdkio', '2015-10-23', NULL, NULL, '55', '2015-10-23 07:46:09', '0000-00-00 00:00:00'),
(603, 1, 'Pax Test', 'ádasd', '2015-10-23', NULL, NULL, '29', '2015-10-23 08:07:41', '0000-00-00 00:00:00'),
(604, 1, 'oko', 'asd', '2015-10-23', NULL, NULL, '55', '2015-10-23 08:35:13', '0000-00-00 00:00:00'),
(605, 1, 'ju8j', 'gbuhu', '2015-10-23', NULL, NULL, '55', '2015-10-23 08:37:06', '0000-00-00 00:00:00'),
(606, 1, 'ịi9j', 'jmiji', '2015-10-27', NULL, NULL, '55', '2015-10-23 08:38:38', '0000-00-00 00:00:00'),
(607, 1, 'mômi', 'hgbihbi', '2015-10-23', NULL, NULL, '55', '2015-10-23 08:39:36', '0000-00-00 00:00:00'),
(608, 1, 'u809098', 'ụhouijhnio', '2015-10-23', NULL, NULL, '55', '2015-10-23 08:40:42', '0000-00-00 00:00:00'),
(609, 1, 'joiio', 'uhuoh', '2015-10-23', NULL, NULL, '55', '2015-10-23 08:52:48', '0000-00-00 00:00:00'),
(610, 1, 'Nick', '123123', '2015-10-26', NULL, NULL, '48', '2015-10-26 07:06:30', '0000-00-00 00:00:00'),
(611, 1, 'Nick', '10101010101010101010', '2015-10-26', NULL, NULL, '48', '2015-10-26 07:10:32', '0000-00-00 00:00:00'),
(612, 1, 'Nick', '12312312', '2015-11-03', NULL, NULL, '48', '2015-11-02 08:16:52', '0000-00-00 00:00:00'),
(613, 1, 'Test annoucement', 'Hello, Brian.', '2015-11-03', NULL, NULL, '30', '2015-11-02 08:18:21', '0000-00-00 00:00:00'),
(614, 1, 'Nick', '123123', '2015-11-03', NULL, NULL, '48', '2015-11-02 08:20:32', '0000-00-00 00:00:00'),
(615, 1, 'Nick', '123123123', '2015-11-03', NULL, NULL, '48', '2015-11-02 08:21:45', '0000-00-00 00:00:00'),
(616, 1, 'nick', '123123123123', '2015-11-04', NULL, NULL, '48', '2015-11-02 08:36:34', '0000-00-00 00:00:00'),
(617, 1, 'Pax test 123', 'Test acd', '2015-11-02', NULL, NULL, '29', '2015-11-02 10:32:00', '0000-00-00 00:00:00'),
(618, 1, 'Pax11', 'Pax tes', '2015-11-02', NULL, NULL, '29', '2015-11-02 10:34:31', '0000-00-00 00:00:00'),
(620, 1, 'Nick', '123123123', '2015-11-03', NULL, NULL, '48', '2015-11-03 03:17:56', '0000-00-00 00:00:00'),
(621, 1, 'Shift', 'Test PN', '2015-11-04', NULL, 2, NULL, '2015-11-05 03:53:03', '0000-00-00 00:00:00'),
(622, 1, 'Dash', 'ádád', '2015-11-05', NULL, NULL, '50', '2015-11-05 04:01:38', '0000-00-00 00:00:00'),
(623, 1, 'Test 1', '1', '2015-11-05', NULL, NULL, '50', '2015-11-05 04:16:46', '0000-00-00 00:00:00'),
(624, 1, 'Test 2', '1', '2015-11-05', NULL, NULL, '50', '2015-11-05 05:45:03', '0000-00-00 00:00:00'),
(625, 1, 'Test announcement', 'asdadasd asdadasd asdadasd asdadasd asdadasd asdadasd asdadasd asdadasd asdadasd asdadasd asdadasd asdadasd asdadasd asdadasd asdadasd asdadasd asdadasd asdadasd asdadasd asdadasd', '2015-11-05', NULL, NULL, 'all', '2015-11-06 07:23:10', '0000-00-00 00:00:00'),
(626, 1, 'fasf', 'sdfsdff sdffsd', '2015-12-01', NULL, NULL, 'all', '2015-11-06 07:23:58', '0000-00-00 00:00:00'),
(627, 1, 'Nick', '123123', '2015-11-13', NULL, NULL, 'all', '2015-11-06 08:10:45', '0000-00-00 00:00:00'),
(628, 1, 'nick', '123123123', '2015-11-11', NULL, NULL, '48', '2015-11-06 08:12:15', '0000-00-00 00:00:00'),
(629, 1, 'Nick', '123123', '2015-11-06', NULL, NULL, 'all', '2015-11-06 11:02:07', '0000-00-00 00:00:00'),
(630, 1, 'Nick', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#039;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2015-11-09', NULL, NULL, 'all', '2015-11-09 01:47:49', '0000-00-00 00:00:00'),
(631, 1, 'Nick', 'abcdadasdasdasdasdasd abcdadasdasdasdasdasd abcdadasdasdasdasdasd abcdadasdasdasdasdasd abcdadasdasdasdasdasd abcdadasdasdasdasdasd abcdadasdasdasdasdasd abcdadasdasdasdasdasd abcdadasdasdasdasdasd abcdadasdasdasdasdasd abcdadasdasdasdasdasd abcdadasdasdasdasdasd abcdadasdasdasdasdasd abcdadasdasdasdasdasd abcdadasdasdasdasdasd abcdadasdasdasdasdasd abcdadasdasdasdasdasd vabcdadasdasdasdasdasd abcdadasdasdasdasdasd abcdadasdasdasdasdasd', '2015-11-09', NULL, NULL, '48', '2015-11-09 01:49:15', '0000-00-00 00:00:00'),
(632, 1, 'Nick', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged', '2015-11-09', NULL, NULL, '48', '2015-11-09 02:00:34', '0000-00-00 00:00:00'),
(633, 1, 'Nick', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2015-11-09', NULL, NULL, '48', '2015-11-09 02:01:12', '0000-00-00 00:00:00');

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
(1, 'Aperitif', 'Aperitif dishes', '2015-11-06 03:43:52', '2015-11-06 03:43:52'),
(2, 'Main', 'Main dishes', '2015-11-06 03:43:46', '2015-11-06 03:43:46'),
(3, 'Dessert', 'Dessert', '2015-11-06 03:43:39', '2015-11-06 03:43:39');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `dish_id` int(11) DEFAULT NULL,
  `content` text CHARACTER SET utf8 NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `meal_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=172 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `dish_id`, `content`, `title`, `meal_date`, `created_at`, `updated_at`) VALUES
(130, 29, 2, '63464', '346346456', '2015-10-21', '2015-10-23 01:15:29', NULL),
(131, 29, 2, '3456464', '34356', '2015-10-21', '2015-10-23 01:15:36', NULL),
(135, 55, 3, 'hello', 'comment for meal day', '2015-10-15', '2015-10-23 04:09:45', NULL),
(136, 55, NULL, 'hjcj', 'hello', '2015-10-20', '2015-10-23 08:54:36', NULL),
(137, 29, 2, '123213', '123123', '2015-10-21', '2015-10-23 10:17:44', NULL),
(138, 29, 2, '123123', '123', '2015-10-21', '2015-10-23 10:54:41', NULL),
(139, 29, 2, '12312312', '12321', '2015-10-21', '2015-10-23 11:27:06', NULL),
(141, 48, 10, 'Test', 'test', '2015-10-23', '2015-10-26 03:53:26', NULL),
(142, 48, NULL, 'Test1', 'Test1', '2015-10-23', '2015-10-26 03:53:57', NULL),
(143, 48, 6, 'Test2', 'Test2', '2015-10-23', '2015-10-26 03:54:27', NULL),
(144, 48, 7, 'Test3', 'Test3', '2015-10-23', '2015-10-26 03:55:01', NULL),
(145, 48, 10, 'Test', 'Test', '2015-10-23', '2015-10-26 06:32:54', NULL),
(147, 48, 3, 'Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...', 'Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...', '2015-10-23', '2015-10-27 11:29:33', NULL),
(150, 48, NULL, 'Test', 'Hi', '2015-10-23', '2015-10-28 01:43:41', NULL),
(152, 29, 2, 'vsxvzx agqetg23643452354 2354 23 trhdfshbdsfgasg asg asgasgasdgasdgasdgasdg asgds', 'Pax test abcd2342344145785696789067987957', '2015-10-26', '2015-10-28 01:47:37', NULL),
(154, 50, 2, 'test', 'test', '2015-10-27', '2015-10-28 06:01:02', NULL),
(155, 15, 7, 'xbxn', 'hêhn', '2015-10-20', '2015-10-30 07:35:32', NULL),
(156, 15, 7, 'xbxn', 'hêhn', '2015-10-20', '2015-10-30 07:35:33', NULL),
(157, 15, 7, 'xbxn', 'hêhn', '2015-10-20', '2015-10-30 07:35:34', NULL),
(158, 15, 2, 'ndnxn\n\n\n', 'nznx', '2015-10-21', '2015-10-30 07:36:43', NULL),
(159, 29, 47, '236423642346234', '631462362364236236423', '2015-11-04', '2015-11-06 03:02:39', NULL),
(160, 29, 6, 'ghgg', 'ggg', '2015-11-04', '2015-11-06 03:18:38', NULL),
(161, 29, 6, 'ghgg', 'ggg', '2015-11-04', '2015-11-06 03:18:39', NULL),
(162, 48, 7, 'Hhh', 'Hhh', '0000-00-00', '2015-11-06 07:04:26', NULL),
(163, 1, NULL, 'test', 'test', '2015-11-11', '2015-11-09 03:26:42', NULL),
(164, 48, NULL, 'Hhh', 'Hhh', '0000-00-00', '2015-11-09 03:27:11', NULL),
(165, 1, NULL, 'test', 'test', '2015-11-11', '2015-11-09 03:29:18', NULL),
(166, 1, NULL, 'test', 'test', '2015-11-11', '2015-11-09 03:32:04', NULL),
(167, 1, 2, 'test', 'test', '2015-11-11', '2015-11-09 03:33:33', NULL),
(168, 1, NULL, 'test', 'test', '2015-11-11', '2015-11-09 03:33:48', NULL),
(169, 15, 3, 'Gghh', 'Hhb', '0000-00-00', '2015-11-09 03:34:43', NULL),
(170, 48, 6, 'Hvhnn', 'Hhbh', '0000-00-00', '2015-11-09 04:32:14', NULL),
(171, 29, 7, 'asdasd', 'Create for cody', '2015-11-05', '2015-11-09 06:36:16', NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=59 ;

--
-- Dumping data for table `dishes`
--

INSERT INTO `dishes` (`id`, `name`, `description`, `category_id`, `created_at`, `updated_at`) VALUES
(2, 'Water morning-glory soup', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam dignissim nulla at arcu dignissim placerat. Morbi maximus purus a semper posuere. Pellentesque varius lacinia nibh, a interdum purus dictum ut. Praesent hendrerit, est eu cursus dignissim, purus est feugiat velit, a convallis dui augue non enim. Nullam efficitur quam a ligula pretium sagittis. Vivamus accumsan viverra risus eu scelerisque. Mauris consequat accumsan diam, id efficitur nisi consequat non. Aliquam vulputate finibus nulla et tincidunt.\r\n\r\nCurabitur pulvinar pulvinar ex quis semper. Duis nec lorem eu felis vehicula accumsan. Sed non lectus pellentesque, gravida ante a, cursus est. Pellentesque viverra dolor sit amet dolor elementum lobortis. Suspendisse volutpat justo non arcu ullamcorper fringilla. Cras in ullamcorper ante. Donec eget vehicula elit. Donec dictum enim id orci sodales finibus. Etiam vitae nisl et elit egestas molestie. Pellentesque posuere laoreet elit sit amet suscipit. Mauris ut quam rhoncus, pharetra lectus at, cursus orci. Phasellus efficitur tempor sapien ac accumsan. Quisque eros libero, bibendum sit amet nibh vel, porttitor venenatis dolor. Donec dui velit, tincidunt et felis sed, mollis tempus nisl. Fusce vitae turpis id risus placerat lacinia eget sit amet turpis. Pellentesque vehicula quam quis ante porta, eget aliquam tellus blandit.', 1, '2015-11-06 03:45:22', '0000-00-00 00:00:00'),
(3, 'Sticky rice', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam dignissim nulla at arcu dignissim placerat. Morbi maximus purus a semper posuere. Pellentesque varius lacinia nibh, a interdum purus dictum ut. Praesent hendrerit, est eu cursus dignissim, purus est feugiat velit, a convallis dui augue non enim. Nullam efficitur quam a ligula pretium sagittis. Vivamus accumsan viverra risus eu scelerisque. Mauris consequat accumsan diam, id efficitur nisi consequat non. Aliquam vulputate finibus nulla et tincidunt.\r\n\r\nCurabitur pulvinar pulvinar ex quis semper. Duis nec lorem eu felis vehicula accumsan. Sed non lectus pellentesque, gravida ante a, cursus est. Pellentesque viverra dolor sit amet dolor elementum lobortis. Suspendisse volutpat justo non arcu ullamcorper fringilla. Cras in ullamcorper ante. Donec eget vehicula elit. Donec dictum enim id orci sodales finibus. Etiam vitae nisl et elit egestas molestie. Pellentesque posuere laoreet elit sit amet suscipit. Mauris ut quam rhoncus, pharetra lectus at, cursus orci. Phasellus efficitur tempor sapien ac accumsan. Quisque eros libero, bibendum sit amet nibh vel, porttitor venenatis dolor. Donec dui velit, tincidunt et felis sed, mollis tempus nisl. Fusce vitae turpis id risus placerat lacinia eget sit amet turpis. Pellentesque vehicula quam quis ante porta, eget aliquam tellus blandit.', 2, '2015-11-06 04:06:32', '0000-00-00 00:00:00'),
(4, 'Gourd soup', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam dignissim nulla at arcu dignissim placerat. Morbi maximus purus a semper posuere. Pellentesque varius lacinia nibh, a interdum purus dictum ut. Praesent hendrerit, est eu cursus dignissim, purus est feugiat velit, a convallis dui augue non enim. Nullam efficitur quam a ligula pretium sagittis. Vivamus accumsan viverra risus eu scelerisque. Mauris consequat accumsan diam, id efficitur nisi consequat non. Aliquam vulputate finibus nulla et tincidunt.\r\n\r\nCurabitur pulvinar pulvinar ex quis semper. Duis nec lorem eu felis vehicula accumsan. Sed non lectus pellentesque, gravida ante a, cursus est. Pellentesque viverra dolor sit amet dolor elementum lobortis. Suspendisse volutpat justo non arcu ullamcorper fringilla. Cras in ullamcorper ante. Donec eget vehicula elit. Donec dictum enim id orci sodales finibus. Etiam vitae nisl et elit egestas molestie. Pellentesque posuere laoreet elit sit amet suscipit. Mauris ut quam rhoncus, pharetra lectus at, cursus orci. Phasellus efficitur tempor sapien ac accumsan. Quisque eros libero, bibendum sit amet nibh vel, porttitor venenatis dolor. Donec dui velit, tincidunt et felis sed, mollis tempus nisl. Fusce vitae turpis id risus placerat lacinia eget sit amet turpis. Pellentesque vehicula quam quis ante porta, eget aliquam tellus blandit.', 3, '2015-11-06 04:03:04', '0000-00-00 00:00:00'),
(5, 'Steamed fish', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam dignissim nulla at arcu dignissim placerat. Morbi maximus purus a semper posuere. Pellentesque varius lacinia nibh, a interdum purus dictum ut. Praesent hendrerit, est eu cursus dignissim, purus est feugiat velit, a convallis dui augue non enim. Nullam efficitur quam a ligula pretium sagittis. Vivamus accumsan viverra risus eu scelerisque. Mauris consequat accumsan diam, id efficitur nisi consequat non. Aliquam vulputate finibus nulla et tincidunt.\r\n\r\nCurabitur pulvinar pulvinar ex quis semper. Duis nec lorem eu felis vehicula accumsan. Sed non lectus pellentesque, gravida ante a, cursus est. Pellentesque viverra dolor sit amet dolor elementum lobortis. Suspendisse volutpat justo non arcu ullamcorper fringilla. Cras in ullamcorper ante. Donec eget vehicula elit. Donec dictum enim id orci sodales finibus. Etiam vitae nisl et elit egestas molestie. Pellentesque posuere laoreet elit sit amet suscipit. Mauris ut quam rhoncus, pharetra lectus at, cursus orci. Phasellus efficitur tempor sapien ac accumsan. Quisque eros libero, bibendum sit amet nibh vel, porttitor venenatis dolor. Donec dui velit, tincidunt et felis sed, mollis tempus nisl. Fusce vitae turpis id risus placerat lacinia eget sit amet turpis. Pellentesque vehicula quam quis ante porta, eget aliquam tellus blandit.', 3, '2015-11-06 04:04:16', '0000-00-00 00:00:00'),
(6, 'Fried fish', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam dignissim nulla at arcu dignissim placerat. Morbi maximus purus a semper posuere. Pellentesque varius lacinia nibh, a interdum purus dictum ut. Praesent hendrerit, est eu cursus dignissim, purus est feugiat velit, a convallis dui augue non enim. Nullam efficitur quam a ligula pretium sagittis. Vivamus accumsan viverra risus eu scelerisque. Mauris consequat accumsan diam, id efficitur nisi consequat non. Aliquam vulputate finibus nulla et tincidunt.\r\n\r\nCurabitur pulvinar pulvinar ex quis semper. Duis nec lorem eu felis vehicula accumsan. Sed non lectus pellentesque, gravida ante a, cursus est. Pellentesque viverra dolor sit amet dolor elementum lobortis. Suspendisse volutpat justo non arcu ullamcorper fringilla. Cras in ullamcorper ante. Donec eget vehicula elit. Donec dictum enim id orci sodales finibus. Etiam vitae nisl et elit egestas molestie. Pellentesque posuere laoreet elit sit amet suscipit. Mauris ut quam rhoncus, pharetra lectus at, cursus orci. Phasellus efficitur tempor sapien ac accumsan. Quisque eros libero, bibendum sit amet nibh vel, porttitor venenatis dolor. Donec dui velit, tincidunt et felis sed, mollis tempus nisl. Fusce vitae turpis id risus placerat lacinia eget sit amet turpis. Pellentesque vehicula quam quis ante porta, eget aliquam tellus blandit.', 2, '2015-11-06 04:08:01', '0000-00-00 00:00:00'),
(7, 'Rice', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam dignissim nulla at arcu dignissim placerat. Morbi maximus purus a semper posuere. Pellentesque varius lacinia nibh, a interdum purus dictum ut. Praesent hendrerit, est eu cursus dignissim, purus est feugiat velit, a convallis dui augue non enim. Nullam efficitur quam a ligula pretium sagittis. Vivamus accumsan viverra risus eu scelerisque. Mauris consequat accumsan diam, id efficitur nisi consequat non. Aliquam vulputate finibus nulla et tincidunt.\r\n\r\nCurabitur pulvinar pulvinar ex quis semper. Duis nec lorem eu felis vehicula accumsan. Sed non lectus pellentesque, gravida ante a, cursus est. Pellentesque viverra dolor sit amet dolor elementum lobortis. Suspendisse volutpat justo non arcu ullamcorper fringilla. Cras in ullamcorper ante. Donec eget vehicula elit. Donec dictum enim id orci sodales finibus. Etiam vitae nisl et elit egestas molestie. Pellentesque posuere laoreet elit sit amet suscipit. Mauris ut quam rhoncus, pharetra lectus at, cursus orci. Phasellus efficitur tempor sapien ac accumsan. Quisque eros libero, bibendum sit amet nibh vel, porttitor venenatis dolor. Donec dui velit, tincidunt et felis sed, mollis tempus nisl. Fusce vitae turpis id risus placerat lacinia eget sit amet turpis. Pellentesque vehicula quam quis ante porta, eget aliquam tellus blandit.', 1, '2015-11-06 03:45:44', '0000-00-00 00:00:00'),
(8, 'Fish and rice gruel', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam dignissim nulla at arcu dignissim placerat. Morbi maximus purus a semper posuere. Pellentesque varius lacinia nibh, a interdum purus dictum ut. Praesent hendrerit, est eu cursus dignissim, purus est feugiat velit, a convallis dui augue non enim. Nullam efficitur quam a ligula pretium sagittis. Vivamus accumsan viverra risus eu scelerisque. Mauris consequat accumsan diam, id efficitur nisi consequat non. Aliquam vulputate finibus nulla et tincidunt.\r\n\r\nCurabitur pulvinar pulvinar ex quis semper. Duis nec lorem eu felis vehicula accumsan. Sed non lectus pellentesque, gravida ante a, cursus est. Pellentesque viverra dolor sit amet dolor elementum lobortis. Suspendisse volutpat justo non arcu ullamcorper fringilla. Cras in ullamcorper ante. Donec eget vehicula elit. Donec dictum enim id orci sodales finibus. Etiam vitae nisl et elit egestas molestie. Pellentesque posuere laoreet elit sit amet suscipit. Mauris ut quam rhoncus, pharetra lectus at, cursus orci. Phasellus efficitur tempor sapien ac accumsan. Quisque eros libero, bibendum sit amet nibh vel, porttitor venenatis dolor. Donec dui velit, tincidunt et felis sed, mollis tempus nisl. Fusce vitae turpis id risus placerat lacinia eget sit amet turpis. Pellentesque vehicula quam quis ante porta, eget aliquam tellus blandit.', 1, '2015-11-06 03:46:49', '0000-00-00 00:00:00'),
(10, 'Braised pork in coconut', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam dignissim nulla at arcu dignissim placerat. Morbi maximus purus a semper posuere. Pellentesque varius lacinia nibh, a interdum purus dictum ut. Praesent hendrerit, est eu cursus dignissim, purus est feugiat velit, a convallis dui augue non enim. Nullam efficitur quam a ligula pretium sagittis. Vivamus accumsan viverra risus eu scelerisque. Mauris consequat accumsan diam, id efficitur nisi consequat non. Aliquam vulputate finibus nulla et tincidunt.\r\n\r\nCurabitur pulvinar pulvinar ex quis semper. Duis nec lorem eu felis vehicula accumsan. Sed non lectus pellentesque, gravida ante a, cursus est. Pellentesque viverra dolor sit amet dolor elementum lobortis. Suspendisse volutpat justo non arcu ullamcorper fringilla. Cras in ullamcorper ante. Donec eget vehicula elit. Donec dictum enim id orci sodales finibus. Etiam vitae nisl et elit egestas molestie. Pellentesque posuere laoreet elit sit amet suscipit. Mauris ut quam rhoncus, pharetra lectus at, cursus orci. Phasellus efficitur tempor sapien ac accumsan. Quisque eros libero, bibendum sit amet nibh vel, porttitor venenatis dolor. Donec dui velit, tincidunt et felis sed, mollis tempus nisl. Fusce vitae turpis id risus placerat lacinia eget sit amet turpis. Pellentesque vehicula quam quis ante porta, eget aliquam tellus blandit.', 1, '2015-11-06 03:47:26', '0000-00-00 00:00:00'),
(46, 'Stuffed pancake', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam dignissim nulla at arcu dignissim placerat. Morbi maximus purus a semper posuere. Pellentesque varius lacinia nibh, a interdum purus dictum ut. Praesent hendrerit, est eu cursus dignissim, purus est feugiat velit, a convallis dui augue non enim. Nullam efficitur quam a ligula pretium sagittis. Vivamus accumsan viverra risus eu scelerisque. Mauris consequat accumsan diam, id efficitur nisi consequat non. Aliquam vulputate finibus nulla et tincidunt.\r\n\r\nCurabitur pulvinar pulvinar ex quis semper. Duis nec lorem eu felis vehicula accumsan. Sed non lectus pellentesque, gravida ante a, cursus est. Pellentesque viverra dolor sit amet dolor elementum lobortis. Suspendisse volutpat justo non arcu ullamcorper fringilla. Cras in ullamcorper ante. Donec eget vehicula elit. Donec dictum enim id orci sodales finibus. Etiam vitae nisl et elit egestas molestie. Pellentesque posuere laoreet elit sit amet suscipit. Mauris ut quam rhoncus, pharetra lectus at, cursus orci. Phasellus efficitur tempor sapien ac accumsan. Quisque eros libero, bibendum sit amet nibh vel, porttitor venenatis dolor. Donec dui velit, tincidunt et felis sed, mollis tempus nisl. Fusce vitae turpis id risus placerat lacinia eget sit amet turpis. Pellentesque vehicula quam quis ante porta, eget aliquam tellus blandit.', 1, '2015-11-06 03:48:30', '0000-00-00 00:00:00'),
(47, 'Fried meat', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam dignissim nulla at arcu dignissim placerat', 1, '2015-11-06 03:49:10', '0000-00-00 00:00:00'),
(56, 'Strawberry', 'Strawberry', 3, '2015-11-06 04:05:37', '0000-00-00 00:00:00'),
(57, 'Chicken', 'Chicken', 2, '2015-11-06 04:09:00', '0000-00-00 00:00:00'),
(58, 'Pan cake', 'Pan cake', 2, '2015-11-06 04:09:34', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `dishes_menus`
--

CREATE TABLE IF NOT EXISTS `dishes_menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dish_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=160 ;

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
(122, 6, 14),
(123, 47, 14),
(125, 8, 12),
(126, 2, 12),
(139, 2, 18),
(140, 6, 18),
(141, 3, 18),
(142, 56, 18),
(143, 2, 1),
(145, 6, 1),
(146, 7, 1),
(147, 8, 1),
(148, 8, 7),
(149, 10, 7),
(150, 46, 7),
(151, 3, 7),
(152, 5, 7),
(153, 57, 7),
(154, 6, 19),
(155, 8, 19),
(156, 2, 19),
(157, 4, 19),
(158, 3, 19),
(159, 57, 19);

-- --------------------------------------------------------

--
-- Table structure for table `floors`
--

CREATE TABLE IF NOT EXISTS `floors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8,
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
(5, 'Floor 5', 'Floor 5', '2015-10-22 08:40:28', '2015-10-22 08:40:28');

-- --------------------------------------------------------

--
-- Table structure for table `meals`
--

CREATE TABLE IF NOT EXISTS `meals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `meal_date` date NOT NULL,
  `for_vegans` tinyint(4) NOT NULL,
  `preordered_meals` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=52 ;

--
-- Dumping data for table `meals`
--

INSERT INTO `meals` (`id`, `meal_date`, `for_vegans`, `preordered_meals`, `menu_id`, `created_at`, `updated_at`) VALUES
(1, '2015-08-17', 0, 2, 1, '2015-08-19 08:21:09', '0000-00-00 00:00:00'),
(2, '2015-08-15', 0, 4, 2, '2015-08-15 08:25:33', '0000-00-00 00:00:00'),
(3, '2015-08-12', 0, 3, 1, '2015-08-11 01:13:01', '0000-00-00 00:00:00'),
(4, '2015-08-14', 0, 3, 2, '2015-08-11 01:13:01', '0000-00-00 00:00:00'),
(6, '2015-08-25', 0, 0, 1, '2015-08-28 03:33:53', '0000-00-00 00:00:00'),
(8, '2015-08-19', 0, 2, 2, '2015-08-19 08:21:28', '0000-00-00 00:00:00'),
(12, '2015-09-22', 0, 2, 2, '2015-09-22 07:52:00', '0000-00-00 00:00:00'),
(13, '2015-08-21', 0, 2, 3, '2015-09-22 07:51:44', '0000-00-00 00:00:00'),
(14, '2015-08-31', 0, 2, 1, '2015-08-19 08:21:09', '0000-00-00 00:00:00'),
(15, '2015-09-02', 0, 2, 1, '2015-08-19 08:21:09', '0000-00-00 00:00:00'),
(16, '2015-09-03', 0, 4, 2, '2015-08-15 08:25:33', '0000-00-00 00:00:00'),
(17, '2015-09-05', 0, 2, 2, '2015-08-19 08:21:28', '0000-00-00 00:00:00'),
(20, '2015-09-16', 0, 5, 3, '2015-09-15 06:08:42', '0000-00-00 00:00:00'),
(22, '2015-09-07', 0, 5, 1, '2015-09-16 04:50:50', '0000-00-00 00:00:00'),
(23, '2015-09-08', 0, 30, 7, '2015-09-16 04:50:58', '0000-00-00 00:00:00'),
(24, '2015-08-11', 0, 0, 4, '2015-08-28 03:42:56', '0000-00-00 00:00:00'),
(25, '2015-09-29', 0, 20, 2, '2015-09-08 04:49:45', '0000-00-00 00:00:00'),
(26, '2015-09-10', 0, 20, 1, '2015-09-08 04:50:30', '0000-00-00 00:00:00'),
(31, '2015-10-07', 0, 20, 1, '2015-09-18 11:58:22', '0000-00-00 00:00:00'),
(32, '2015-09-15', 0, 20, 1, '2015-09-15 06:06:35', '0000-00-00 00:00:00'),
(33, '2015-09-22', 0, 20, 1, '2015-09-15 06:06:35', '0000-00-00 00:00:00'),
(34, '2015-09-24', 0, 0, 3, '2015-09-22 09:08:20', '0000-00-00 00:00:00'),
(35, '2015-10-12', 0, 20, 1, '2015-10-12 08:18:33', '0000-00-00 00:00:00'),
(36, '2015-10-13', 0, 23, 2, '2015-10-12 08:18:46', '0000-00-00 00:00:00'),
(37, '2015-10-14', 0, 30, 3, '2015-10-12 08:18:59', '0000-00-00 00:00:00'),
(38, '2015-10-15', 0, 20, 7, '2015-10-12 08:19:20', '0000-00-00 00:00:00'),
(39, '2015-10-20', 0, 20, 1, '2015-10-20 01:28:23', '0000-00-00 00:00:00'),
(40, '2015-10-21', 0, 30, 1, '2015-10-21 06:05:17', '0000-00-00 00:00:00'),
(41, '2015-10-13', 0, 20, 12, '2015-10-21 11:32:30', '0000-00-00 00:00:00'),
(42, '2015-10-23', 0, 30, 3, '2015-10-26 13:23:12', '0000-00-00 00:00:00'),
(43, '2015-10-26', 0, 20, 18, '2015-10-26 02:07:46', '0000-00-00 00:00:00'),
(44, '2015-10-27', 0, 20, 1, '2015-10-26 02:08:20', '0000-00-00 00:00:00'),
(45, '2015-10-28', 0, 20, 3, '2015-10-26 02:09:26', '0000-00-00 00:00:00'),
(46, '2015-10-29', 0, 20, 1, '2015-10-26 02:11:39', '0000-00-00 00:00:00'),
(47, '2015-11-02', 0, 5, 1, '2015-11-01 06:25:56', '0000-00-00 00:00:00'),
(48, '2015-11-03', 0, 5, 2, '2015-11-01 06:26:15', '0000-00-00 00:00:00'),
(49, '2015-11-04', 0, 5, 14, '2015-11-01 06:26:31', '0000-00-00 00:00:00'),
(50, '2015-11-05', 0, 10, 3, '2015-11-01 06:26:49', '0000-00-00 00:00:00'),
(51, '2015-11-09', 0, 150, 7, '2015-11-09 04:25:09', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `meals_log`
--

CREATE TABLE IF NOT EXISTS `meals_log` (
  `meal_date` date NOT NULL,
  `tracking_log` text NOT NULL,
  `actual_meals` int(11) NOT NULL,
  `note` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `meals_log`
--

INSERT INTO `meals_log` (`meal_date`, `tracking_log`, `actual_meals`, `note`, `created_at`, `updated_at`) VALUES
('2015-11-05', '[{"shift":{"id":"2","name":"Suat 2","start_time":"11:30:00","end_time":"12:00:00"},"tables":[{"id":"4","name":"Table normal 4","users":[{"email":"test@enclave.vn","avatar_content_file":"http:\\/\\/113.160.225.87:8484\\/assets\\/images\\/users\\/default-avatar411.png","first_name":"Test 0","last_name":"Enclave","status_user":"2"},{"email":"dash@enclave.vn","avatar_content_file":"http:\\/\\/113.160.225.87:8484\\/assets\\/images\\/users\\/default-avatar5.png","first_name":"Dash","last_name":"Duc","status_user":"3"},{"email":"phuong@enclave.vn","avatar_content_file":"http:\\/\\/113.160.225.87:8484\\/assets\\/images\\/users\\/default-avatar50.png","first_name":"Phuong","last_name":"Nguyen","status_user":"1"}]},{"id":"5","name":"Table normal 5","users":[{"email":"test2@enclave.vn","avatar_content_file":"http:\\/\\/113.160.225.87:8484\\/assets\\/images\\/users\\/default-avatar411.png","first_name":"Test 2","last_name":"Enclave","status_user":"1"},{"email":"test3@enclave.vn","avatar_content_file":"http:\\/\\/113.160.225.87:8484\\/assets\\/images\\/users\\/default-avatar411.png","first_name":"Test 3","last_name":"Enclave","status_user":"1"},{"email":"test4@enclave.vn","avatar_content_file":"http:\\/\\/113.160.225.87:8484\\/assets\\/images\\/users\\/default-avatar411.png","first_name":"Test 4","last_name":"Enclave","status_user":"2"}]},{"id":"6","name":"Table normal 6","users":[{"email":"pax@enclave.vn","avatar_content_file":"http:\\/\\/113.160.225.87:8484\\/assets\\/images\\/users\\/default-avatar41.png","first_name":"Pax","last_name":"Pax","status_user":"2"},{"email":"nick@enclave.vn","avatar_content_file":"http:\\/\\/113.160.225.87:8484\\/assets\\/images\\/users\\/imgo_(1).jpg","first_name":"Nick","last_name":"Nam","status_user":"2"}]}]},{"shift":{"id":"3","name":"Suat 3","start_time":"00:00:00","end_time":"13:31:00"},"tables":[{"id":"7","name":"Table normal 7","users":[{"email":"test1@enclave.vn","avatar_content_file":"http:\\/\\/113.160.225.87:8484\\/assets\\/images\\/users\\/BuiQuangHuy.JPG","first_name":"Harold","last_name":"Enclave","status_user":"2"}]},{"id":"8","name":"Table normal 8"},{"id":"9","name":"Table mormal 9"}]},{"shift":{"id":"1","name":"Shift 1","start_time":"11:00:00","end_time":"11:30:00"},"tables":[{"id":"4","name":"Table normal 4","users":[{"email":"dash@enclave.vn","avatar_content_file":"http:\\/\\/113.160.225.87:8484\\/assets\\/images\\/users\\/default-avatar5.png","first_name":"Dash","last_name":"Duc","status_user":"2"},{"email":"phuong@enclave.vn","avatar_content_file":"http:\\/\\/113.160.225.87:8484\\/assets\\/images\\/users\\/default-avatar50.png","first_name":"Phuong","last_name":"Nguyen","status_user":"2"}]},{"id":"5","name":"Table normal 5","users":[{"email":"test2@enclave.vn","avatar_content_file":"http:\\/\\/113.160.225.87:8484\\/assets\\/images\\/users\\/default-avatar411.png","first_name":"Test 2","last_name":"Enclave","status_user":"2"},{"email":"test3@enclave.vn","avatar_content_file":"http:\\/\\/113.160.225.87:8484\\/assets\\/images\\/users\\/default-avatar411.png","first_name":"Test 3","last_name":"Enclave","status_user":"2"},{"email":"test4@enclave.vn","avatar_content_file":"http:\\/\\/113.160.225.87:8484\\/assets\\/images\\/users\\/default-avatar411.png","first_name":"Test 4","last_name":"Enclave","status_user":"2"}]},{"id":"6","name":"Table normal 6","users":[{"email":"pax@enclave.vn","avatar_content_file":"http:\\/\\/113.160.225.87:8484\\/assets\\/images\\/users\\/rsz_1skypeimage.jpg","first_name":"Pax","last_name":"Pax","status_user":"2"},{"email":"nick@enclave.vn","avatar_content_file":"http:\\/\\/113.160.225.87:8484\\/assets\\/images\\/users\\/imgo_(1).jpg","first_name":"Nick","last_name":"Nam","status_user":"1"}]}]}]', 120, '<br>Done shift 1.<br>Done with shift 2<br>Done with shift 4<br>Nopte<br>Test', '2015-11-06 03:32:31', '2015-11-09 03:49:58'),
('2015-11-04', '', 0, '', '2015-11-06 03:32:33', '0000-00-00 00:00:00'),
('2015-11-03', '', 0, '', '2015-11-06 03:32:35', '0000-00-00 00:00:00'),
('2015-11-02', '', 0, '', '2015-11-06 03:32:38', '0000-00-00 00:00:00'),
('2015-11-09', '[{"shift":{"id":"2","name":"Shift 2","start_time":"11:23:00","end_time":"17:00:00"},"tables":[{"id":"4","name":"Table normal 4","users":[{"email":"dash@enclave.vn","avatar_content_file":"http:\\/\\/113.160.225.87:8484\\/assets\\/images\\/users\\/default-avatar5.png","first_name":"Dash","last_name":"Duc","status_user":"2"}]},{"id":"5","name":"Table normal 5","users":[{"email":"test2@enclave.vn","avatar_content_file":"http:\\/\\/113.160.225.87:8484\\/assets\\/images\\/users\\/default-avatar411.png","first_name":"Test 2","last_name":"Enclave","status_user":"2"},{"email":"test3@enclave.vn","avatar_content_file":"http:\\/\\/113.160.225.87:8484\\/assets\\/images\\/users\\/default-avatar411.png","first_name":"Test 3","last_name":"Enclave","status_user":"2"},{"email":"test4@enclave.vn","avatar_content_file":"http:\\/\\/113.160.225.87:8484\\/assets\\/images\\/users\\/default-avatar411.png","first_name":"Test 4","last_name":"Enclave","status_user":"2"}]},{"id":"6","name":"Table normal 6"},{"id":"12","name":"Table vegan 1 shift 2","users":[{"email":"cody@gmail.com","avatar_content_file":"http:\\/\\/113.160.225.87:8484\\/assets\\/images\\/users\\/12046680_10153249354692746_468853144829428122_n.jpg","first_name":"Akos","last_name":"Nguyen","status_user":"2"},{"email":"test5@enclave.vn","avatar_content_file":"http:\\/\\/113.160.225.87:8484\\/assets\\/images\\/users\\/default-avatar411.png","first_name":"Test 5","last_name":"Enclave","status_user":"2"},{"email":"test6@enclave.vn","avatar_content_file":"http:\\/\\/113.160.225.87:8484\\/assets\\/images\\/users\\/default-avatar411.png","first_name":"Test 6","last_name":"Enclave","status_user":"2"},{"email":"test7@enclave.vn","avatar_content_file":"http:\\/\\/113.160.225.87:8484\\/assets\\/images\\/users\\/default-avatar411.png","first_name":"Test 7","last_name":"Enclave","status_user":"2"},{"email":"test8@enclave.vn","avatar_content_file":"http:\\/\\/113.160.225.87:8484\\/assets\\/images\\/users\\/default-avatar411.png","first_name":"Test 8","last_name":"Enclave","status_user":"2"},{"email":"test9@enclave.vn","avatar_content_file":"http:\\/\\/113.160.225.87:8484\\/assets\\/images\\/users\\/default-avatar411.png","first_name":"Test 9","last_name":"Enclave","status_user":"2"},{"email":"nick@enclave.vn","avatar_content_file":"http:\\/\\/113.160.225.87:8484\\/assets\\/images\\/users\\/imgo_(1).jpg","first_name":"Nick","last_name":"Nam","status_user":"2"}]},{"id":"14","name":"Table vegan 2 shift 2","users":[{"email":"brian@enclave.vn","avatar_content_file":"http:\\/\\/113.160.225.87:8484\\/assets\\/images\\/users\\/imgo4.jpg","first_name":"Brian","last_name":"Brian","status_user":"2"}]},{"id":"15","name":"Table vegan 3 shift 2"},{"id":"16","name":"Table vegan 4 shift 2"}]},{"shift":{"id":"3","name":"Shift 3","start_time":"12:00:00","end_time":"12:30:00"},"tables":[{"id":"7","name":"Table normal 7"},{"id":"8","name":"Table normal 8"},{"id":"9","name":"Table mormal 9"},{"id":"10","name":"Table vegan 1 shift 3","users":[{"email":"test1@enclave.vn","avatar_content_file":"http:\\/\\/113.160.225.87:8484\\/assets\\/images\\/users\\/BuiQuangHuy.JPG","first_name":"Harold","last_name":"Enclave","status_user":"1"}]},{"id":"17","name":"Table vegan 2 shift 3"}]},{"shift":{"id":"1","name":"Shift 1","start_time":"11:00:00","end_time":"11:30:00"},"tables":[{"id":"1","name":"Table normal"},{"id":"2","name":"Table normal 2"},{"id":"3","name":"Table normal 3","users":[{"email":"asd@enclace.vn","avatar_content_file":"http:\\/\\/113.160.225.87:8484\\/assets\\/images\\/users\\/huyc.png","first_name":"Terry","last_name":"Thanh","status_user":"2"}]},{"id":"11","name":"Table vegan 1 shift 1","users":[{"email":"test11@enclave.vn","avatar_content_file":"http:\\/\\/113.160.225.87:8484\\/assets\\/images\\/users\\/default-avatar411.png","first_name":"Test 11","last_name":"Enclave","status_user":"1"},{"email":"test12@enclave.vn","avatar_content_file":"http:\\/\\/113.160.225.87:8484\\/assets\\/images\\/users\\/default-avatar411.png","first_name":"Test 12","last_name":"Enclave","status_user":"1"},{"email":"test13@enclave.vn","avatar_content_file":"http:\\/\\/113.160.225.87:8484\\/assets\\/images\\/users\\/default-avatar411.png","first_name":"Test 13","last_name":"Enclave","status_user":"3"},{"email":"test14@enclave.vn","avatar_content_file":"http:\\/\\/113.160.225.87:8484\\/assets\\/images\\/users\\/default-avatar411.png","first_name":"Test 14","last_name":"Enclave","status_user":"1"},{"email":"test15@enclave.vn","avatar_content_file":"http:\\/\\/113.160.225.87:8484\\/assets\\/images\\/users\\/default-avatar411.png","first_name":"Test 15","last_name":"Enclave","status_user":"2"},{"email":"test16@enclave.vn","avatar_content_file":"http:\\/\\/113.160.225.87:8484\\/assets\\/images\\/users\\/default-avatar411.png","first_name":"Test 16","last_name":"Enclave","status_user":"1"}]},{"id":"13","name":"Table vegan 2 shift 1","users":[{"email":"huck@enclave.vn","avatar_content_file":"http:\\/\\/113.160.225.87:8484\\/assets\\/images\\/users\\/thanhc1.png","first_name":"Huck","last_name":"Enclave","status_user":"2"}]}]}]', 150, '<br>Test 1<br>Test 2<br>Test 3<br>Test 1', '2015-11-09 04:25:13', '2015-11-09 04:29:44');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE IF NOT EXISTS `menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

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
(15, 'Menu test', 'asd', '2015-09-07 02:37:41', '0000-00-00 00:00:00'),
(18, 'Menu 26/10', 'Menu 26/10', '2015-10-26 02:06:28', '0000-00-00 00:00:00'),
(19, 'Menu 27 10', 'Test menu', '2015-10-27 10:15:41', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `pictures`
--

CREATE TABLE IF NOT EXISTS `pictures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` text CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8,
  `dish_id` int(11) DEFAULT NULL,
  `image_file_name` text CHARACTER SET utf8 NOT NULL,
  `image_content_type` text CHARACTER SET utf8 NOT NULL,
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
(43, 'http://113.160.225.87:8484/assets/images/dishes/1-8210-1406277579.jpg', '1-8210-1406277579.jpg', 2, '1-8210-1406277579.jpg', '', 0, '2015-11-06 03:52:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(44, 'http://113.160.225.87:8484/assets/images/dishes/1338367774-com-ngon21.jpg', '1338367774-com-ngon21.jpg', 3, '1338367774-com-ngon21.jpg', '', 0, '2015-09-15 05:05:10', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(47, 'http://113.160.225.87:8484/assets/images/dishes/1-tom-201-1394441942183.jpg', '1-tom-201-1394441942183.jpg', 4, '1-tom-201-1394441942183.jpg', '', 0, '2015-10-28 02:31:41', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(48, 'http://113.160.225.87:8484/assets/images/dishes/ca-hap1.jpg', 'ca-hap1.jpg', 5, 'ca-hap1.jpg', '', 0, '2015-10-28 02:34:25', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(49, 'http://113.160.225.87:8484/assets/images/dishes/Cha-Ca.jpg', 'Cha-Ca.jpg', 6, 'Cha-Ca.jpg', '', 0, '2015-10-28 02:30:48', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(50, 'http://113.160.225.87:8484/assets/images/dishes/alotin_vn_1404142160_trangbh2012121110533646_0.jpg', 'alotin_vn_1404142160_trangbh2012121110533646_0.jpg', 7, 'alotin_vn_1404142160_trangbh2012121110533646_0.jpg', '', 0, '2015-09-15 05:03:16', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(51, 'http://113.160.225.87:8484/assets/images/dishes/download_(2).jpg', 'download_(2).jpg', 8, 'download_(2).jpg', '', 0, '2015-09-15 05:03:59', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(56, 'http://113.160.225.87:8484/assets/images/dishes/cach-nau-thit-kho-tau-1.jpg', 'cach-nau-thit-kho-tau-1.jpg', 10, 'cach-nau-thit-kho-tau-1.jpg', '', 0, '2015-10-28 02:29:12', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(58, 'http://113.160.225.87:8484/assets/images/dishes/682_nha-hang-co-do-3.jpg', '682_nha-hang-co-do-3.jpg', 46, '682_nha-hang-co-do-3.jpg', '', 0, '2015-10-28 02:29:57', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(59, 'http://113.160.225.87:8484/assets/images/dishes/121110la-mieng-voi-mang-xao-thit-heo-kieu-moi1.JPG', '121110la-mieng-voi-mang-xao-thit-heo-kieu-moi1.JPG', 47, '121110la-mieng-voi-mang-xao-thit-heo-kieu-moi1.JPG', '', 0, '2015-11-06 03:50:28', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(69, 'http://113.160.225.87:8484/assets/images/dishes/dau_tay.jpg', 'dau_tay.jpg', 56, 'dau_tay.jpg', '', 0, '2015-10-28 02:25:06', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(70, 'http://113.160.225.87:8484/assets/images/dishes/Hinh_1-Com_luon_la_nguon_thuc_pham_on_dinh.jpg', 'Hinh_1-Com_luon_la_nguon_thuc_pham_on_dinh.jpg', 57, 'Hinh_1-Com_luon_la_nguon_thuc_pham_on_dinh.jpg', '', 0, '2015-10-27 02:59:16', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(71, 'http://113.160.225.87:8484/assets/images/dishes/20141114103606-31.jpg', '20141114103606-31.jpg', 58, '20141114103606-31.jpg', '', 0, '2015-10-27 02:39:36', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2576 ;

--
-- Dumping data for table `reply_messages`
--

INSERT INTO `reply_messages` (`id`, `user_id`, `content`, `message_id`, `created_at`, `updated_at`, `type_messages`) VALUES
(1759, 1, 'Got it', 588, '2015-10-22 10:08:23', '0000-00-00 00:00:00', 'admin_messages'),
(1760, 48, 'Test', 588, '2015-10-22 10:52:29', '0000-00-00 00:00:00', 'admin_messages'),
(1761, 48, 'Ok', 588, '2015-10-22 10:52:34', '0000-00-00 00:00:00', 'admin_messages'),
(1762, 1, '123', 588, '2015-10-22 10:52:50', '0000-00-00 00:00:00', 'admin_messages'),
(1763, 1, '123', 588, '2015-10-22 10:53:14', '0000-00-00 00:00:00', 'admin_messages'),
(1764, 1, '123', 588, '2015-10-22 10:53:42', '0000-00-00 00:00:00', 'admin_messages'),
(1765, 48, 'Ok', 589, '2015-10-22 10:54:40', '0000-00-00 00:00:00', 'admin_messages'),
(1766, 1, '123', 589, '2015-10-22 10:54:50', '0000-00-00 00:00:00', 'admin_messages'),
(1767, 1, '123', 589, '2015-10-22 10:54:56', '0000-00-00 00:00:00', 'admin_messages'),
(1768, 1, '123', 589, '2015-10-22 10:55:04', '0000-00-00 00:00:00', 'admin_messages'),
(1769, 48, 'Ok', 589, '2015-10-22 10:55:15', '0000-00-00 00:00:00', 'admin_messages'),
(1770, 1, '123', 589, '2015-10-22 10:55:19', '0000-00-00 00:00:00', 'admin_messages'),
(1771, 48, 'Got', 589, '2015-10-22 10:55:23', '0000-00-00 00:00:00', 'admin_messages'),
(1772, 1, '3232', 588, '2015-10-22 10:55:39', '0000-00-00 00:00:00', 'admin_messages'),
(1773, 1, '123213123123', 588, '2015-10-22 10:56:00', '0000-00-00 00:00:00', 'admin_messages'),
(1774, 1, '123123123', 589, '2015-10-22 10:56:12', '0000-00-00 00:00:00', 'admin_messages'),
(1775, 1, '12312312', 589, '2015-10-22 10:56:20', '0000-00-00 00:00:00', 'admin_messages'),
(1798, 48, 'Test', 588, '2015-10-23 01:32:44', '0000-00-00 00:00:00', 'admin_messages'),
(1799, 48, 'Ok', 588, '2015-10-23 01:33:17', '0000-00-00 00:00:00', 'admin_messages'),
(1800, 48, 'Ok', 588, '2015-10-23 01:33:30', '0000-00-00 00:00:00', 'admin_messages'),
(1811, 48, 'Ok', 592, '2015-10-23 01:52:33', '0000-00-00 00:00:00', 'admin_messages'),
(1812, 48, 'Test', 592, '2015-10-23 01:52:45', '0000-00-00 00:00:00', 'admin_messages'),
(1813, 1, 'qwer', 592, '2015-10-23 01:53:20', '0000-00-00 00:00:00', 'admin_messages'),
(1814, 1, 'qwer', 592, '2015-10-23 01:53:59', '0000-00-00 00:00:00', 'admin_messages'),
(1815, 1, 'qwer', 592, '2015-10-23 01:54:17', '0000-00-00 00:00:00', 'admin_messages'),
(1816, 1, 'qwer', 592, '2015-10-23 01:54:25', '0000-00-00 00:00:00', 'admin_messages'),
(1817, 1, 'qwer', 592, '2015-10-23 01:54:40', '0000-00-00 00:00:00', 'admin_messages'),
(1818, 1, 'qwer', 592, '2015-10-23 01:54:47', '0000-00-00 00:00:00', 'admin_messages'),
(1819, 1, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 591, '2015-10-23 01:56:46', '0000-00-00 00:00:00', 'admin_messages'),
(1820, 1, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 590, '2015-10-23 02:03:58', '0000-00-00 00:00:00', 'admin_messages'),
(1821, 50, 'Confirmed.', 588, '2015-10-23 02:13:23', '0000-00-00 00:00:00', 'admin_messages'),
(1822, 1, '123', 593, '2015-10-23 02:13:38', '0000-00-00 00:00:00', 'admin_messages'),
(1823, 1, '123', 593, '2015-10-23 02:13:56', '0000-00-00 00:00:00', 'admin_messages'),
(1824, 1, 'Thanks', 588, '2015-10-23 02:18:54', '0000-00-00 00:00:00', 'admin_messages'),
(1825, 1, '123', 593, '2015-10-23 02:19:02', '0000-00-00 00:00:00', 'admin_messages'),
(1826, 1, '123', 593, '2015-10-23 02:19:07', '0000-00-00 00:00:00', 'admin_messages'),
(1827, 1, 'Thanks', 131, '2015-10-23 02:19:58', '0000-00-00 00:00:00', 'comments'),
(1828, 1, 'I got it', 130, '2015-10-23 02:20:04', '0000-00-00 00:00:00', 'comments'),
(1829, 1, '123', 593, '2015-10-23 02:20:18', '0000-00-00 00:00:00', 'admin_messages'),
(1830, 1, '123', 593, '2015-10-23 02:20:24', '0000-00-00 00:00:00', 'admin_messages'),
(1831, 48, 'Ok', 593, '2015-10-23 02:33:49', '0000-00-00 00:00:00', 'admin_messages'),
(1832, 1, '123', 593, '2015-10-23 02:33:56', '0000-00-00 00:00:00', 'admin_messages'),
(1834, 1, '00000', 593, '2015-10-23 02:37:23', '0000-00-00 00:00:00', 'admin_messages'),
(1835, 1, '1111', 593, '2015-10-23 02:38:58', '0000-00-00 00:00:00', 'admin_messages'),
(1836, 1, 'iiiiiiiii', 593, '2015-10-23 02:39:43', '0000-00-00 00:00:00', 'admin_messages'),
(1837, 1, 'iiiii', 593, '2015-10-23 02:47:06', '0000-00-00 00:00:00', 'admin_messages'),
(1838, 1, '123123', 593, '2015-10-23 02:47:28', '0000-00-00 00:00:00', 'admin_messages'),
(1839, 1, '1234', 594, '2015-10-23 02:48:17', '0000-00-00 00:00:00', 'admin_messages'),
(1840, 48, 'Yes', 594, '2015-10-23 02:48:34', '0000-00-00 00:00:00', 'admin_messages'),
(1841, 1, '3456', 594, '2015-10-23 02:48:49', '0000-00-00 00:00:00', 'admin_messages'),
(1842, 48, 'Ok', 594, '2015-10-23 02:49:05', '0000-00-00 00:00:00', 'admin_messages'),
(1843, 48, 'Ok', 594, '2015-10-23 02:49:13', '0000-00-00 00:00:00', 'admin_messages'),
(1844, 48, 'Ok', 594, '2015-10-23 02:49:40', '0000-00-00 00:00:00', 'admin_messages'),
(1845, 48, 'Ok', 594, '2015-10-23 02:49:56', '0000-00-00 00:00:00', 'admin_messages'),
(1846, 48, 'Test', 594, '2015-10-23 02:50:13', '0000-00-00 00:00:00', 'admin_messages'),
(1847, 1, '756756', 594, '2015-10-23 02:50:19', '0000-00-00 00:00:00', 'admin_messages'),
(1848, 1, '23423423', 594, '2015-10-23 02:50:26', '0000-00-00 00:00:00', 'admin_messages'),
(1849, 48, 'Ok pool', 594, '2015-10-23 02:50:48', '0000-00-00 00:00:00', 'admin_messages'),
(1850, 48, 'Ok', 595, '2015-10-23 02:52:00', '0000-00-00 00:00:00', 'admin_messages'),
(1851, 1, '123', 595, '2015-10-23 02:52:17', '0000-00-00 00:00:00', 'admin_messages'),
(1852, 48, 'Ok', 595, '2015-10-23 02:52:26', '0000-00-00 00:00:00', 'admin_messages'),
(1853, 48, 'Ok', 595, '2015-10-23 02:52:34', '0000-00-00 00:00:00', 'admin_messages'),
(1854, 1, '333', 595, '2015-10-23 02:52:42', '0000-00-00 00:00:00', 'admin_messages'),
(1855, 48, 'Test', 588, '2015-10-23 02:54:28', '0000-00-00 00:00:00', 'admin_messages'),
(1856, 48, 'Ok', 588, '2015-10-23 02:54:51', '0000-00-00 00:00:00', 'admin_messages'),
(1869, 48, 'Ok', 588, '2015-10-23 03:14:43', '0000-00-00 00:00:00', 'admin_messages'),
(1870, 48, 'Uk', 595, '2015-10-23 03:15:28', '0000-00-00 00:00:00', 'admin_messages'),
(1892, 48, 'Ok', 595, '2015-10-23 03:49:10', '0000-00-00 00:00:00', 'admin_messages'),
(1893, 48, 'Test', 594, '2015-10-23 03:49:19', '0000-00-00 00:00:00', 'admin_messages'),
(1894, 48, 'Ok', 594, '2015-10-23 03:49:55', '0000-00-00 00:00:00', 'admin_messages'),
(1896, 48, 'Ok', 595, '2015-10-23 03:54:48', '0000-00-00 00:00:00', 'admin_messages'),
(1897, 55, 'i got it. thanks admin', 588, '2015-10-23 04:08:10', '0000-00-00 00:00:00', 'admin_messages'),
(1898, 1, 'done', 135, '2015-10-23 04:10:10', '0000-00-00 00:00:00', 'comments'),
(1899, 1, 'ola', 135, '2015-10-23 04:10:28', '0000-00-00 00:00:00', 'comments'),
(1903, 55, 'oa', 135, '2015-10-23 04:12:11', '0000-00-00 00:00:00', 'comments'),
(1904, 48, 'Test', 595, '2015-10-23 04:12:12', '0000-00-00 00:00:00', 'admin_messages'),
(1905, 1, 'hello', 135, '2015-10-23 04:12:23', '0000-00-00 00:00:00', 'comments'),
(1906, 1, '123', 596, '2015-10-23 04:13:10', '0000-00-00 00:00:00', 'admin_messages'),
(1907, 1, 'Ok', 596, '2015-10-23 04:13:37', '0000-00-00 00:00:00', 'admin_messages'),
(1908, 48, 'Ok', 596, '2015-10-23 04:13:44', '0000-00-00 00:00:00', 'admin_messages'),
(1909, 55, 'test', 596, '2015-10-23 04:15:49', '0000-00-00 00:00:00', 'admin_messages'),
(1910, 1, 'Dash Test', 588, '2015-10-23 04:18:25', '0000-00-00 00:00:00', 'admin_messages'),
(1911, 50, 'hvgj', 588, '2015-10-23 04:18:59', '0000-00-00 00:00:00', 'admin_messages'),
(1912, 1, 'Dash 2', 588, '2015-10-23 04:19:06', '0000-00-00 00:00:00', 'admin_messages'),
(1913, 50, 'jjjk', 588, '2015-10-23 04:19:28', '0000-00-00 00:00:00', 'admin_messages'),
(1914, 1, '5455445', 588, '2015-10-23 04:19:41', '0000-00-00 00:00:00', 'admin_messages'),
(1915, 50, 'jkjj', 588, '2015-10-23 04:20:02', '0000-00-00 00:00:00', 'admin_messages'),
(1916, 1, 'khgbkjbkj', 588, '2015-10-23 04:20:19', '0000-00-00 00:00:00', 'admin_messages'),
(1917, 1, '6565565656', 588, '2015-10-23 04:21:06', '0000-00-00 00:00:00', 'admin_messages'),
(1918, 1, 'kljlk', 588, '2015-10-23 04:21:50', '0000-00-00 00:00:00', 'admin_messages'),
(1919, 55, 'ola', 588, '2015-10-23 04:22:05', '0000-00-00 00:00:00', 'admin_messages'),
(1920, 50, 'hj', 588, '2015-10-23 04:22:42', '0000-00-00 00:00:00', 'admin_messages'),
(1921, 1, '45498489846541', 588, '2015-10-23 04:22:46', '0000-00-00 00:00:00', 'admin_messages'),
(1922, 1, '54+62\n32', 588, '2015-10-23 04:26:10', '0000-00-00 00:00:00', 'admin_messages'),
(1923, 1, '4513lkkk', 588, '2015-10-23 04:27:20', '0000-00-00 00:00:00', 'admin_messages'),
(1924, 1, '21641651;ll', 588, '2015-10-23 04:28:02', '0000-00-00 00:00:00', 'admin_messages'),
(1925, 1, '164165kkk', 588, '2015-10-23 04:29:08', '0000-00-00 00:00:00', 'admin_messages'),
(1926, 50, 'ghjgjvbbbh', 588, '2015-10-23 04:30:25', '0000-00-00 00:00:00', 'admin_messages'),
(1927, 50, 'gbuhih', 588, '2015-10-23 04:31:44', '0000-00-00 00:00:00', 'admin_messages'),
(1928, 55, 'jjuik', 588, '2015-10-23 04:32:19', '0000-00-00 00:00:00', 'admin_messages'),
(1929, 55, 'ji', 588, '2015-10-23 04:33:21', '0000-00-00 00:00:00', 'admin_messages'),
(1930, 1, '65656526', 588, '2015-10-23 04:34:44', '0000-00-00 00:00:00', 'admin_messages'),
(1931, 1, '65469', 588, '2015-10-23 04:35:24', '0000-00-00 00:00:00', 'admin_messages'),
(1932, 1, 'no9mnomnkonko', 588, '2015-10-23 04:36:22', '0000-00-00 00:00:00', 'admin_messages'),
(1933, 1, 'hu9hu8ihb8hb', 588, '2015-10-23 04:36:40', '0000-00-00 00:00:00', 'admin_messages'),
(1934, 1, '123', 588, '2015-10-23 04:37:04', '0000-00-00 00:00:00', 'admin_messages'),
(1935, 1, '+*+-/*-/', 588, '2015-10-23 04:38:25', '0000-00-00 00:00:00', 'admin_messages'),
(1936, 1, '123', 135, '2015-10-23 04:43:54', '0000-00-00 00:00:00', 'comments'),
(1938, 1, '12312312', 591, '2015-10-23 04:45:29', '0000-00-00 00:00:00', 'admin_messages'),
(1939, 1, 'adasdas', 588, '2015-10-23 04:45:49', '0000-00-00 00:00:00', 'admin_messages'),
(1940, 48, 'Test', 597, '2015-10-23 04:49:25', '0000-00-00 00:00:00', 'admin_messages'),
(1941, 1, '=-=-=-=', 597, '2015-10-23 04:50:40', '0000-00-00 00:00:00', 'admin_messages'),
(1942, 1, '123456', 588, '2015-10-23 04:51:59', '0000-00-00 00:00:00', 'admin_messages'),
(1943, 29, '123123', 588, '2015-10-23 06:00:02', '0000-00-00 00:00:00', 'admin_messages'),
(1944, 1, 'Pax resr', 588, '2015-10-23 06:00:14', '0000-00-00 00:00:00', 'admin_messages'),
(1945, 1, '123', 588, '2015-10-23 06:02:37', '0000-00-00 00:00:00', 'admin_messages'),
(1946, 1, '1234512345', 588, '2015-10-23 06:03:32', '0000-00-00 00:00:00', 'admin_messages'),
(1947, 29, '1542134', 588, '2015-10-23 06:04:32', '0000-00-00 00:00:00', 'admin_messages'),
(1948, 1, 'ddee3 pax test', 588, '2015-10-23 06:04:50', '0000-00-00 00:00:00', 'admin_messages'),
(1949, 1, '41234124', 588, '2015-10-23 06:06:59', '0000-00-00 00:00:00', 'admin_messages'),
(1950, 1, '21342134', 588, '2015-10-23 06:07:11', '0000-00-00 00:00:00', 'admin_messages'),
(1951, 1, 'Done', 598, '2015-10-23 06:10:10', '0000-00-00 00:00:00', 'admin_messages'),
(1952, 1, '4123412342134', 599, '2015-10-23 06:11:32', '0000-00-00 00:00:00', 'admin_messages'),
(1953, 1, 'asdasd', 588, '2015-10-23 06:11:44', '0000-00-00 00:00:00', 'admin_messages'),
(1954, 29, '2523542354', 599, '2015-10-23 06:11:52', '0000-00-00 00:00:00', 'admin_messages'),
(1955, 1, 'Tets admin reply', 599, '2015-10-23 06:12:11', '0000-00-00 00:00:00', 'admin_messages'),
(1956, 29, '4123421342134234', 599, '2015-10-23 06:12:25', '0000-00-00 00:00:00', 'admin_messages'),
(1957, 29, '12341234', 599, '2015-10-23 06:12:26', '0000-00-00 00:00:00', 'admin_messages'),
(1958, 29, '213421', 599, '2015-10-23 06:12:27', '0000-00-00 00:00:00', 'admin_messages'),
(1959, 29, '3421', 599, '2015-10-23 06:12:28', '0000-00-00 00:00:00', 'admin_messages'),
(1960, 29, '34', 599, '2015-10-23 06:12:29', '0000-00-00 00:00:00', 'admin_messages'),
(1961, 29, '234', 599, '2015-10-23 06:12:30', '0000-00-00 00:00:00', 'admin_messages'),
(1962, 1, 'test admin reply', 599, '2015-10-23 06:12:45', '0000-00-00 00:00:00', 'admin_messages'),
(1963, 1, 'OK', 600, '2015-10-23 06:12:57', '0000-00-00 00:00:00', 'admin_messages'),
(1964, 1, '214314cfcc', 599, '2015-10-23 06:13:49', '0000-00-00 00:00:00', 'admin_messages'),
(1965, 1, '1234213412vffv', 599, '2015-10-23 06:14:24', '0000-00-00 00:00:00', 'admin_messages'),
(1966, 1, '12342134fvfvfv', 599, '2015-10-23 06:14:30', '0000-00-00 00:00:00', 'admin_messages'),
(1967, 55, 'ola', 598, '2015-10-23 06:15:02', '0000-00-00 00:00:00', 'admin_messages'),
(1968, 1, 'OK', 598, '2015-10-23 06:15:28', '0000-00-00 00:00:00', 'admin_messages'),
(1969, 1, 'Done', 598, '2015-10-23 06:15:38', '0000-00-00 00:00:00', 'admin_messages'),
(1970, 55, 'hi', 598, '2015-10-23 06:15:43', '0000-00-00 00:00:00', 'admin_messages'),
(1971, 1, 'Done', 598, '2015-10-23 06:15:58', '0000-00-00 00:00:00', 'admin_messages'),
(1973, 1, 'OK', 598, '2015-10-23 06:16:14', '0000-00-00 00:00:00', 'admin_messages'),
(1974, 1, 'Pax 111', 599, '2015-10-23 06:18:01', '0000-00-00 00:00:00', 'admin_messages'),
(1975, 1, 'pax1124', 599, '2015-10-23 06:20:18', '0000-00-00 00:00:00', 'admin_messages'),
(1976, 1, 'AAVVD11', 599, '2015-10-23 06:22:18', '0000-00-00 00:00:00', 'admin_messages'),
(1977, 1, 'ABVEE222', 599, '2015-10-23 06:22:35', '0000-00-00 00:00:00', 'admin_messages'),
(1978, 48, 'Ok', 600, '2015-10-23 06:26:20', '0000-00-00 00:00:00', 'admin_messages'),
(1979, 1, 'vee332', 599, '2015-10-23 06:26:42', '0000-00-00 00:00:00', 'admin_messages'),
(1980, 1, '12341fffff44', 599, '2015-10-23 06:26:50', '0000-00-00 00:00:00', 'admin_messages'),
(1981, 48, 'Ko', 600, '2015-10-23 06:27:04', '0000-00-00 00:00:00', 'admin_messages'),
(1982, 48, 'Ok', 600, '2015-10-23 06:28:54', '0000-00-00 00:00:00', 'admin_messages'),
(1983, 1, '324242bbb', 599, '2015-10-23 06:29:01', '0000-00-00 00:00:00', 'admin_messages'),
(1984, 48, 'Test', 600, '2015-10-23 06:29:06', '0000-00-00 00:00:00', 'admin_messages'),
(1985, 1, '1234123423', 599, '2015-10-23 06:29:13', '0000-00-00 00:00:00', 'admin_messages'),
(1986, 48, 'Ok ok', 600, '2015-10-23 06:29:19', '0000-00-00 00:00:00', 'admin_messages'),
(1987, 1, 'AAAAS', 599, '2015-10-23 06:29:32', '0000-00-00 00:00:00', 'admin_messages'),
(1988, 1, '21412432134vggff', 599, '2015-10-23 06:30:01', '0000-00-00 00:00:00', 'admin_messages'),
(1989, 1, '21412432134vggff', 599, '2015-10-23 06:30:10', '0000-00-00 00:00:00', 'admin_messages'),
(1990, 1, 'mLivMessage.smoothScrollToPosition(mAdapter.getCount());', 599, '2015-10-23 06:30:34', '0000-00-00 00:00:00', 'admin_messages'),
(1991, 1, 'bbbb', 599, '2015-10-23 06:31:23', '0000-00-00 00:00:00', 'admin_messages'),
(1992, 48, 'Test', 600, '2015-10-23 06:33:27', '0000-00-00 00:00:00', 'admin_messages'),
(1993, 1, 'cccc', 599, '2015-10-23 06:33:36', '0000-00-00 00:00:00', 'admin_messages'),
(1994, 48, 'Ok', 597, '2015-10-23 06:33:38', '0000-00-00 00:00:00', 'admin_messages'),
(1995, 1, 'DDDD', 599, '2015-10-23 06:34:45', '0000-00-00 00:00:00', 'admin_messages'),
(1996, 1, 'EEEEEE', 599, '2015-10-23 06:35:33', '0000-00-00 00:00:00', 'admin_messages'),
(1998, 1, 'FFFF', 599, '2015-10-23 06:37:22', '0000-00-00 00:00:00', 'admin_messages'),
(1999, 1, 'GGGGG', 599, '2015-10-23 06:38:18', '0000-00-00 00:00:00', 'admin_messages'),
(2001, 1, 'HHHHH', 599, '2015-10-23 06:40:16', '0000-00-00 00:00:00', 'admin_messages'),
(2002, 1, 'JJJJJ', 599, '2015-10-23 06:40:30', '0000-00-00 00:00:00', 'admin_messages'),
(2003, 29, 'count', 599, '2015-10-23 06:40:56', '0000-00-00 00:00:00', 'admin_messages'),
(2004, 1, 'Asdasdasd', 599, '2015-10-23 06:41:02', '0000-00-00 00:00:00', 'admin_messages'),
(2005, 29, '234h12h34123421', 599, '2015-10-23 06:41:18', '0000-00-00 00:00:00', 'admin_messages'),
(2006, 29, '21341', 599, '2015-10-23 06:41:18', '0000-00-00 00:00:00', 'admin_messages'),
(2007, 29, '234', 599, '2015-10-23 06:41:19', '0000-00-00 00:00:00', 'admin_messages'),
(2008, 29, '21', 599, '2015-10-23 06:41:20', '0000-00-00 00:00:00', 'admin_messages'),
(2009, 29, '34', 599, '2015-10-23 06:41:21', '0000-00-00 00:00:00', 'admin_messages'),
(2010, 29, '2134', 599, '2015-10-23 06:41:22', '0000-00-00 00:00:00', 'admin_messages'),
(2011, 1, 'ASDADS232134n bb', 599, '2015-10-23 06:41:28', '0000-00-00 00:00:00', 'admin_messages'),
(2013, 1, '152dfgdfg3453', 599, '2015-10-23 06:47:19', '0000-00-00 00:00:00', 'admin_messages'),
(2015, 1, 'Always specify both the height and width attributes for images. If height and width are set, the space required for the image is reserved when the page is loaded. However, without these attributes, the browser does not know the size of the image, and cannot reserve the appropriate space to it. The effect will be that the page layout will change during loading (while the images load).', 600, '2015-10-23 06:47:32', '0000-00-00 00:00:00', 'admin_messages'),
(2016, 29, '125542354', 599, '2015-10-23 06:47:33', '0000-00-00 00:00:00', 'admin_messages'),
(2017, 29, '3253245', 599, '2015-10-23 06:47:36', '0000-00-00 00:00:00', 'admin_messages'),
(2018, 1, 'test 1', 599, '2015-10-23 06:49:25', '0000-00-00 00:00:00', 'admin_messages'),
(2019, 1, 'test 2', 599, '2015-10-23 06:49:34', '0000-00-00 00:00:00', 'admin_messages'),
(2020, 1, 'art42q52', 599, '2015-10-23 06:49:40', '0000-00-00 00:00:00', 'admin_messages'),
(2022, 1, '@12312321', 599, '2015-10-23 06:53:23', '0000-00-00 00:00:00', 'admin_messages'),
(2023, 1, '431234123421', 599, '2015-10-23 06:53:35', '0000-00-00 00:00:00', 'admin_messages'),
(2024, 1, '431234SDDRF', 599, '2015-10-23 06:53:48', '0000-00-00 00:00:00', 'admin_messages'),
(2025, 1, '3Q5423543253254', 599, '2015-10-23 06:54:25', '0000-00-00 00:00:00', 'admin_messages'),
(2026, 1, 'fffff', 599, '2015-10-23 06:54:45', '0000-00-00 00:00:00', 'admin_messages'),
(2028, 1, 'asdád', 600, '2015-10-23 06:58:40', '0000-00-00 00:00:00', 'admin_messages'),
(2029, 1, 'qqqq', 599, '2015-10-23 06:59:56', '0000-00-00 00:00:00', 'admin_messages'),
(2030, 1, 'wwwww', 599, '2015-10-23 07:00:33', '0000-00-00 00:00:00', 'admin_messages'),
(2031, 1, 'Asd23425253vvv', 599, '2015-10-23 07:01:45', '0000-00-00 00:00:00', 'admin_messages'),
(2032, 1, 'eeeeee', 599, '2015-10-23 07:02:37', '0000-00-00 00:00:00', 'admin_messages'),
(2034, 1, 'TTTTTT', 599, '2015-10-23 07:07:04', '0000-00-00 00:00:00', 'admin_messages'),
(2035, 1, 'AASDASDASD457636363', 599, '2015-10-23 07:07:50', '0000-00-00 00:00:00', 'admin_messages'),
(2037, 1, 'wrq3542354', 599, '2015-10-23 07:09:37', '0000-00-00 00:00:00', 'admin_messages'),
(2038, 1, 'AASASDADASDsad', 601, '2015-10-23 07:10:49', '0000-00-00 00:00:00', 'admin_messages'),
(2039, 1, 'Asdasda41251234', 601, '2015-10-23 07:11:08', '0000-00-00 00:00:00', 'admin_messages'),
(2040, 1, 'AD124131231bvb b ty5656546346', 599, '2015-10-23 07:11:38', '0000-00-00 00:00:00', 'admin_messages'),
(2042, 1, '421asdfsadf3453252', 601, '2015-10-23 07:14:47', '0000-00-00 00:00:00', 'admin_messages'),
(2043, 1, '457547645765467', 601, '2015-10-23 07:15:13', '0000-00-00 00:00:00', 'admin_messages'),
(2045, 1, '23452346vcccc', 601, '2015-10-23 07:16:03', '0000-00-00 00:00:00', 'admin_messages'),
(2047, 1, 'MMMIAISDIASD', 601, '2015-10-23 07:18:51', '0000-00-00 00:00:00', 'admin_messages'),
(2049, 1, 'tets 12312', 601, '2015-10-23 07:21:41', '0000-00-00 00:00:00', 'admin_messages'),
(2050, 55, 'hfjjcj', 601, '2015-10-23 07:22:58', '0000-00-00 00:00:00', 'admin_messages'),
(2053, 1, 'Done', 602, '2015-10-23 07:49:45', '0000-00-00 00:00:00', 'admin_messages'),
(2054, 1, 'Done', 602, '2015-10-23 07:53:10', '0000-00-00 00:00:00', 'admin_messages'),
(2055, 1, 'Hi', 602, '2015-10-23 07:53:35', '0000-00-00 00:00:00', 'admin_messages'),
(2056, 1, 'ok', 602, '2015-10-23 07:54:29', '0000-00-00 00:00:00', 'admin_messages'),
(2057, 1, 'lol', 602, '2015-10-23 07:54:45', '0000-00-00 00:00:00', 'admin_messages'),
(2058, 55, 'got it', 602, '2015-10-23 07:55:47', '0000-00-00 00:00:00', 'admin_messages'),
(2059, 1, '12312', 588, '2015-10-23 08:06:30', '0000-00-00 00:00:00', 'admin_messages'),
(2060, 1, '123123', 592, '2015-10-23 08:06:48', '0000-00-00 00:00:00', 'admin_messages'),
(2061, 29, '12342134324', 603, '2015-10-23 08:07:54', '0000-00-00 00:00:00', 'admin_messages'),
(2062, 1, 'OK', 603, '2015-10-23 08:09:05', '0000-00-00 00:00:00', 'admin_messages'),
(2063, 29, '42134213421', 603, '2015-10-23 08:09:23', '0000-00-00 00:00:00', 'admin_messages'),
(2064, 29, '1221342134', 603, '2015-10-23 08:09:25', '0000-00-00 00:00:00', 'admin_messages'),
(2066, 1, 'ịi', 604, '2015-10-23 08:36:01', '0000-00-00 00:00:00', 'admin_messages'),
(2067, 1, 'ịi', 605, '2015-10-23 08:37:45', '0000-00-00 00:00:00', 'admin_messages'),
(2069, 48, 'Hehe', 600, '2015-10-23 08:44:43', '0000-00-00 00:00:00', 'admin_messages'),
(2070, 1, 'hu9h', 609, '2015-10-23 08:53:07', '0000-00-00 00:00:00', 'admin_messages'),
(2071, 1, 'Done', 135, '2015-10-23 09:01:38', '0000-00-00 00:00:00', 'comments'),
(2072, 1, 'HBaha', 136, '2015-10-23 09:01:56', '0000-00-00 00:00:00', 'comments'),
(2073, 1, 'hy9', 609, '2015-10-23 09:28:34', '0000-00-00 00:00:00', 'admin_messages'),
(2074, 1, 'l0', 609, '2015-10-23 09:28:56', '0000-00-00 00:00:00', 'admin_messages'),
(2075, 55, 'n', 609, '2015-10-23 09:29:14', '0000-00-00 00:00:00', 'admin_messages'),
(2076, 29, '123123', 131, '2015-10-23 10:54:30', '0000-00-00 00:00:00', 'comments'),
(2083, 1, '123123', 600, '2015-10-26 01:54:20', '0000-00-00 00:00:00', 'admin_messages'),
(2084, 55, 'done', 609, '2015-10-26 02:00:27', '0000-00-00 00:00:00', 'admin_messages'),
(2085, 48, 'Test', 144, '2015-10-26 04:06:16', '0000-00-00 00:00:00', 'comments'),
(2086, 48, 'Ok', 144, '2015-10-26 04:06:51', '0000-00-00 00:00:00', 'comments'),
(2087, 48, 'Test', 144, '2015-10-26 06:11:48', '0000-00-00 00:00:00', 'comments'),
(2088, 48, 'Ok', 144, '2015-10-26 06:14:39', '0000-00-00 00:00:00', 'comments'),
(2089, 1, '123123', 145, '2015-10-26 06:53:34', '0000-00-00 00:00:00', 'comments'),
(2090, 1, '123123', 145, '2015-10-26 06:53:48', '0000-00-00 00:00:00', 'comments'),
(2091, 48, 'Ok', 145, '2015-10-26 06:54:31', '0000-00-00 00:00:00', 'comments'),
(2092, 1, '01230123', 145, '2015-10-26 06:54:44', '0000-00-00 00:00:00', 'comments'),
(2093, 48, 'Ok', 145, '2015-10-26 06:55:18', '0000-00-00 00:00:00', 'comments'),
(2094, 1, '023023', 145, '2015-10-26 06:55:26', '0000-00-00 00:00:00', 'comments'),
(2095, 48, 'Oke', 145, '2015-10-26 06:56:03', '0000-00-00 00:00:00', 'comments'),
(2096, 1, '123456789', 145, '2015-10-26 06:56:18', '0000-00-00 00:00:00', 'comments'),
(2097, 1, '0000', 145, '2015-10-26 06:56:48', '0000-00-00 00:00:00', 'comments'),
(2098, 48, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 145, '2015-10-26 06:58:48', '0000-00-00 00:00:00', 'comments'),
(2099, 1, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 145, '2015-10-26 06:59:21', '0000-00-00 00:00:00', 'comments'),
(2100, 48, 'Test test test', 145, '2015-10-26 07:01:04', '0000-00-00 00:00:00', 'comments'),
(2101, 48, 'Test test test', 145, '2015-10-26 07:01:15', '0000-00-00 00:00:00', 'comments'),
(2102, 1, '0147852369', 145, '2015-10-26 07:01:24', '0000-00-00 00:00:00', 'comments'),
(2103, 1, '121212', 145, '2015-10-26 07:01:46', '0000-00-00 00:00:00', 'comments'),
(2104, 48, 'Ok', 145, '2015-10-26 07:02:25', '0000-00-00 00:00:00', 'comments'),
(2105, 48, 'Abc ', 145, '2015-10-26 07:03:18', '0000-00-00 00:00:00', 'comments'),
(2106, 1, '0147852369', 145, '2015-10-26 07:03:32', '0000-00-00 00:00:00', 'comments'),
(2107, 48, 'Test', 610, '2015-10-26 07:06:49', '0000-00-00 00:00:00', 'admin_messages'),
(2108, 1, '090909', 610, '2015-10-26 07:06:56', '0000-00-00 00:00:00', 'admin_messages'),
(2109, 48, 'Test', 610, '2015-10-26 07:07:07', '0000-00-00 00:00:00', 'admin_messages'),
(2110, 1, '898989', 610, '2015-10-26 07:07:17', '0000-00-00 00:00:00', 'admin_messages'),
(2111, 48, 'Test', 610, '2015-10-26 07:08:19', '0000-00-00 00:00:00', 'admin_messages'),
(2112, 1, '010101', 610, '2015-10-26 07:08:39', '0000-00-00 00:00:00', 'admin_messages'),
(2113, 1, '10101010', 610, '2015-10-26 07:08:53', '0000-00-00 00:00:00', 'admin_messages'),
(2114, 1, '10101010', 610, '2015-10-26 07:09:12', '0000-00-00 00:00:00', 'admin_messages'),
(2115, 1, '101010101010', 610, '2015-10-26 07:09:26', '0000-00-00 00:00:00', 'admin_messages'),
(2116, 1, '1010101010', 610, '2015-10-26 07:09:36', '0000-00-00 00:00:00', 'admin_messages'),
(2117, 1, '101010101010', 610, '2015-10-26 07:09:47', '0000-00-00 00:00:00', 'admin_messages'),
(2118, 48, 'Test', 610, '2015-10-26 07:09:59', '0000-00-00 00:00:00', 'admin_messages'),
(2119, 48, 'Test', 610, '2015-10-26 07:10:05', '0000-00-00 00:00:00', 'admin_messages'),
(2120, 48, 'Ok', 610, '2015-10-26 07:10:10', '0000-00-00 00:00:00', 'admin_messages'),
(2121, 48, 'Ok', 611, '2015-10-26 07:10:47', '0000-00-00 00:00:00', 'admin_messages'),
(2122, 1, '10101010', 611, '2015-10-26 07:10:52', '0000-00-00 00:00:00', 'admin_messages'),
(2123, 48, 'Ok', 611, '2015-10-26 07:10:59', '0000-00-00 00:00:00', 'admin_messages'),
(2124, 1, '10101010101010', 611, '2015-10-26 07:11:06', '0000-00-00 00:00:00', 'admin_messages'),
(2125, 1, '101010101010', 611, '2015-10-26 07:11:27', '0000-00-00 00:00:00', 'admin_messages'),
(2126, 1, '10101010', 611, '2015-10-26 07:11:35', '0000-00-00 00:00:00', 'admin_messages'),
(2127, 48, 'Ok', 611, '2015-10-26 07:21:53', '0000-00-00 00:00:00', 'admin_messages'),
(2128, 48, 'Test', 610, '2015-10-26 07:21:59', '0000-00-00 00:00:00', 'admin_messages'),
(2129, 1, '123123', 143, '2015-10-26 07:22:41', '0000-00-00 00:00:00', 'comments'),
(2130, 48, 'Ok', 143, '2015-10-26 07:22:48', '0000-00-00 00:00:00', 'comments'),
(2131, 1, '123123123123', 143, '2015-10-26 07:22:54', '0000-00-00 00:00:00', 'comments'),
(2132, 1, '123123', 143, '2015-10-26 07:23:26', '0000-00-00 00:00:00', 'comments'),
(2133, 1, '123123', 142, '2015-10-26 07:26:32', '0000-00-00 00:00:00', 'comments'),
(2134, 48, 'Ok', 142, '2015-10-26 07:26:41', '0000-00-00 00:00:00', 'comments'),
(2135, 1, '123', 142, '2015-10-26 07:26:46', '0000-00-00 00:00:00', 'comments'),
(2136, 1, '123', 142, '2015-10-26 07:26:56', '0000-00-00 00:00:00', 'comments'),
(2137, 1, '123', 142, '2015-10-26 07:27:03', '0000-00-00 00:00:00', 'comments'),
(2138, 1, '123', 142, '2015-10-26 07:27:13', '0000-00-00 00:00:00', 'comments'),
(2139, 48, 'Ok', 142, '2015-10-26 07:27:24', '0000-00-00 00:00:00', 'comments'),
(2140, 48, 'Ok', 611, '2015-10-26 07:29:31', '0000-00-00 00:00:00', 'admin_messages'),
(2141, 1, '123', 145, '2015-10-26 07:29:48', '0000-00-00 00:00:00', 'comments'),
(2142, 1, '123', 145, '2015-10-26 07:30:01', '0000-00-00 00:00:00', 'comments'),
(2143, 1, '123', 145, '2015-10-26 07:30:10', '0000-00-00 00:00:00', 'comments'),
(2144, 48, 'Ok', 145, '2015-10-26 07:30:17', '0000-00-00 00:00:00', 'comments'),
(2145, 48, 'Ok', 145, '2015-10-26 07:30:23', '0000-00-00 00:00:00', 'comments'),
(2146, 48, 'Ok', 145, '2015-10-26 07:30:27', '0000-00-00 00:00:00', 'comments'),
(2147, 1, '123123', 145, '2015-10-26 07:51:29', '0000-00-00 00:00:00', 'comments'),
(2148, 1, '123123', 600, '2015-10-26 07:51:52', '0000-00-00 00:00:00', 'admin_messages'),
(2149, 48, 'Ok', 145, '2015-10-26 11:03:46', '0000-00-00 00:00:00', 'comments'),
(2150, 48, 'Test', 145, '2015-10-26 11:05:45', '0000-00-00 00:00:00', 'comments'),
(2151, 48, 'Ok', 145, '2015-10-26 11:05:54', '0000-00-00 00:00:00', 'comments'),
(2152, 48, 'Test', 145, '2015-10-26 11:06:00', '0000-00-00 00:00:00', 'comments'),
(2153, 48, 'Ok', 590, '2015-10-26 11:08:47', '0000-00-00 00:00:00', 'admin_messages'),
(2154, 48, 'Test', 590, '2015-10-26 11:08:51', '0000-00-00 00:00:00', 'admin_messages'),
(2155, 1, '123', 145, '2015-10-27 06:11:13', '0000-00-00 00:00:00', 'comments'),
(2156, 48, 'Test', 145, '2015-10-27 06:15:51', '0000-00-00 00:00:00', 'comments'),
(2157, 48, 'Test', 145, '2015-10-27 06:15:59', '0000-00-00 00:00:00', 'comments'),
(2158, 48, 'Test', 145, '2015-10-27 06:16:08', '0000-00-00 00:00:00', 'comments'),
(2160, 1, '123123', 147, '2015-10-27 11:29:51', '0000-00-00 00:00:00', 'comments'),
(2161, 48, 'Test', 147, '2015-10-28 01:15:19', '0000-00-00 00:00:00', 'comments'),
(2164, 48, 'Test', 141, '2015-10-28 01:30:10', '0000-00-00 00:00:00', 'comments'),
(2165, 48, 'Test', 141, '2015-10-28 01:30:50', '0000-00-00 00:00:00', 'comments'),
(2167, 48, 'Test', 150, '2015-10-28 01:43:49', '0000-00-00 00:00:00', 'comments'),
(2169, 48, 'Test', 150, '2015-10-28 01:47:18', '0000-00-00 00:00:00', 'comments'),
(2174, 48, 'Tét', 611, '2015-10-28 07:44:51', '0000-00-00 00:00:00', 'admin_messages'),
(2175, 48, 'Ok', 611, '2015-10-28 07:44:58', '0000-00-00 00:00:00', 'admin_messages'),
(2176, 48, 'Ok', 588, '2015-10-28 07:45:18', '0000-00-00 00:00:00', 'admin_messages'),
(2177, 48, 'test', 150, '2015-10-29 06:04:54', '0000-00-00 00:00:00', 'comments'),
(2178, 48, '123', 150, '2015-10-29 06:29:57', '0000-00-00 00:00:00', 'comments'),
(2181, 48, '123', 150, '2015-10-29 06:38:10', '0000-00-00 00:00:00', 'comments'),
(2183, 48, '123', 150, '2015-10-29 06:55:02', '0000-00-00 00:00:00', 'comments'),
(2190, 48, '123', 150, '2015-10-29 07:00:36', '0000-00-00 00:00:00', 'comments'),
(2192, 48, 'Ok', 150, '2015-10-29 07:06:30', '0000-00-00 00:00:00', 'comments'),
(2193, 48, '123', 145, '2015-10-29 08:44:17', '0000-00-00 00:00:00', 'comments'),
(2194, 15, 'abd', 596, '2015-10-30 07:38:02', '0000-00-00 00:00:00', 'admin_messages'),
(2195, 15, 'bxnxnzhxhxnxhdj', 596, '2015-10-30 07:38:10', '0000-00-00 00:00:00', 'admin_messages'),
(2196, 15, 'gshsjdhej', 600, '2015-10-30 07:43:58', '0000-00-00 00:00:00', 'admin_messages'),
(2197, 15, 'hello', 156, '2015-10-30 08:10:28', '0000-00-00 00:00:00', 'comments'),
(2198, 15, '@', 588, '2015-10-30 08:27:34', '0000-00-00 00:00:00', 'admin_messages'),
(2199, 15, 'b', 588, '2015-10-30 08:27:41', '0000-00-00 00:00:00', 'admin_messages'),
(2200, 15, 'hello.', 588, '2015-10-30 08:27:52', '0000-00-00 00:00:00', 'admin_messages'),
(2201, 15, 'n', 588, '2015-10-30 08:28:07', '0000-00-00 00:00:00', 'admin_messages'),
(2202, 50, 'test', 600, '2015-11-02 01:48:22', '0000-00-00 00:00:00', 'admin_messages'),
(2203, 50, 'this is a long message', 154, '2015-11-02 01:53:37', '0000-00-00 00:00:00', 'comments'),
(2204, 15, 'ccvvv', 596, '2015-11-02 02:11:35', '0000-00-00 00:00:00', 'admin_messages'),
(2205, 15, 'bbb', 596, '2015-11-02 02:11:43', '0000-00-00 00:00:00', 'admin_messages'),
(2206, 15, ' nnnn', 596, '2015-11-02 02:11:49', '0000-00-00 00:00:00', 'admin_messages'),
(2207, 30, 'Ghhh', 596, '2015-11-02 02:12:08', '0000-00-00 00:00:00', 'admin_messages'),
(2208, 30, 'Hhhhhhhhff', 596, '2015-11-02 02:12:31', '0000-00-00 00:00:00', 'admin_messages'),
(2209, 15, 'ccv', 596, '2015-11-02 02:12:33', '0000-00-00 00:00:00', 'admin_messages'),
(2211, 30, 'bzhxbdhdh', 600, '2015-11-02 03:28:42', '0000-00-00 00:00:00', 'admin_messages'),
(2212, 30, 'bzbznzbzbzbzbzbzbzbzbzbbbnn', 600, '2015-11-02 03:28:49', '0000-00-00 00:00:00', 'admin_messages'),
(2213, 50, 'all users', 600, '2015-11-02 03:38:45', '0000-00-00 00:00:00', 'admin_messages'),
(2214, 50, 'all\nuser', 600, '2015-11-02 03:38:52', '0000-00-00 00:00:00', 'admin_messages'),
(2215, 30, 'Fgccghhhhh', 588, '2015-11-02 04:52:08', '0000-00-00 00:00:00', 'admin_messages'),
(2218, 1, 'OK', 588, '2015-11-02 08:12:21', '0000-00-00 00:00:00', 'admin_messages'),
(2219, 1, 'Test OK.', 588, '2015-11-02 08:13:20', '0000-00-00 00:00:00', 'admin_messages'),
(2220, 1, '123123', 615, '2015-11-02 08:24:43', '0000-00-00 00:00:00', 'admin_messages'),
(2221, 1, '123123123', 615, '2015-11-02 08:28:08', '0000-00-00 00:00:00', 'admin_messages'),
(2222, 1, '123123', 615, '2015-11-02 08:28:35', '0000-00-00 00:00:00', 'admin_messages'),
(2225, 1, '12312312', 615, '2015-11-02 08:29:13', '0000-00-00 00:00:00', 'admin_messages'),
(2228, 1, '123123123', 615, '2015-11-02 08:29:45', '0000-00-00 00:00:00', 'admin_messages'),
(2229, 1, '123123123', 615, '2015-11-02 08:29:50', '0000-00-00 00:00:00', 'admin_messages'),
(2234, 1, '123123', 615, '2015-11-02 08:30:21', '0000-00-00 00:00:00', 'admin_messages'),
(2235, 1, '123123123', 616, '2015-11-02 08:37:00', '0000-00-00 00:00:00', 'admin_messages'),
(2236, 48, 'Ok', 616, '2015-11-02 08:37:15', '0000-00-00 00:00:00', 'admin_messages'),
(2237, 1, '123123', 616, '2015-11-02 08:37:40', '0000-00-00 00:00:00', 'admin_messages'),
(2238, 1, '123123', 616, '2015-11-02 08:38:14', '0000-00-00 00:00:00', 'admin_messages'),
(2239, 1, '123123', 616, '2015-11-02 08:38:57', '0000-00-00 00:00:00', 'admin_messages'),
(2240, 1, '123123123', 614, '2015-11-02 08:39:31', '0000-00-00 00:00:00', 'admin_messages'),
(2242, 30, 'Gggg', 613, '2015-11-02 08:49:58', '0000-00-00 00:00:00', 'admin_messages'),
(2243, 30, 'Gggggg', 613, '2015-11-02 08:50:00', '0000-00-00 00:00:00', 'admin_messages'),
(2244, 30, 'Yyy', 613, '2015-11-02 08:50:03', '0000-00-00 00:00:00', 'admin_messages'),
(2245, 30, 'Yuyyyy', 613, '2015-11-02 08:50:07', '0000-00-00 00:00:00', 'admin_messages'),
(2246, 30, 'Ghhbhxdbdbxbxjxjxncncncncnc', 588, '2015-11-02 09:00:09', '0000-00-00 00:00:00', 'admin_messages'),
(2247, 30, 'Fffffxgzmgzmhhhxmhzjdjfkfkfmfmfkfjfjfjfkfjdjxhxhxkhxlhdlhdluhhjjjhhhjjjdlhx', 588, '2015-11-02 09:00:22', '0000-00-00 00:00:00', 'admin_messages'),
(2248, 1, '12313123', 614, '2015-11-02 09:03:39', '0000-00-00 00:00:00', 'admin_messages'),
(2249, 1, '123123', 614, '2015-11-02 09:05:21', '0000-00-00 00:00:00', 'admin_messages'),
(2250, 1, '12312312', 614, '2015-11-02 09:05:39', '0000-00-00 00:00:00', 'admin_messages'),
(2255, 50, 'Hhh', 600, '2015-11-02 09:25:02', '0000-00-00 00:00:00', 'admin_messages'),
(2256, 50, 'Hfh', 600, '2015-11-02 09:25:04', '0000-00-00 00:00:00', 'admin_messages'),
(2257, 50, 'Gdh', 600, '2015-11-02 09:25:10', '0000-00-00 00:00:00', 'admin_messages'),
(2258, 50, 'Hdb', 596, '2015-11-02 09:25:25', '0000-00-00 00:00:00', 'admin_messages'),
(2259, 50, 'Hcg', 596, '2015-11-02 09:25:27', '0000-00-00 00:00:00', 'admin_messages'),
(2260, 50, 'New', 600, '2015-11-02 09:25:38', '0000-00-00 00:00:00', 'admin_messages'),
(2264, 50, 'Yggg\n\n\n\n\n\n\n\n\n\n\n\n\nFghvdhsdghdid', 600, '2015-11-02 09:43:25', '0000-00-00 00:00:00', 'admin_messages'),
(2266, 50, 'Hhh', 600, '2015-11-02 09:55:34', '0000-00-00 00:00:00', 'admin_messages'),
(2271, 50, 'Gfhf\nVchgh\n\n\nGfg', 600, '2015-11-02 10:10:46', '0000-00-00 00:00:00', 'admin_messages'),
(2272, 50, 'Hcgg\nHcg\nGxhgh', 600, '2015-11-02 10:21:06', '0000-00-00 00:00:00', 'admin_messages'),
(2282, 50, 'Hfh', 596, '2015-11-03 01:09:45', '0000-00-00 00:00:00', 'admin_messages'),
(2284, 50, 'google.com', 600, '2015-11-03 01:13:28', '0000-00-00 00:00:00', 'admin_messages'),
(2285, 50, 'Hhh', 600, '2015-11-03 01:13:49', '0000-00-00 00:00:00', 'admin_messages'),
(2314, 50, 'Go to google.com for more details.', 600, '2015-11-03 01:48:27', '0000-00-00 00:00:00', 'admin_messages'),
(2315, 50, 'Google.canh', 600, '2015-11-03 01:48:46', '0000-00-00 00:00:00', 'admin_messages'),
(2333, 30, 'hhhhj', 596, '2015-11-03 02:14:37', '0000-00-00 00:00:00', 'admin_messages'),
(2343, 1, 'dfhfhdfhg', 152, '2015-11-03 02:37:16', '0000-00-00 00:00:00', 'comments'),
(2344, 1, '2345235443', 152, '2015-11-03 02:37:59', '0000-00-00 00:00:00', 'comments'),
(2345, 1, '21341234', 152, '2015-11-03 02:39:02', '0000-00-00 00:00:00', 'comments'),
(2348, 1, 'sdf3344', 152, '2015-11-03 02:43:04', '0000-00-00 00:00:00', 'comments'),
(2349, 48, 'test', 143, '2015-11-03 02:48:48', '0000-00-00 00:00:00', 'comments'),
(2350, 48, 'rest', 141, '2015-11-03 02:50:23', '0000-00-00 00:00:00', 'comments'),
(2351, 48, 'test', 141, '2015-11-03 02:50:36', '0000-00-00 00:00:00', 'comments'),
(2353, 48, 'test', 592, '2015-11-03 03:10:01', '0000-00-00 00:00:00', 'admin_messages'),
(2355, 1, '12312asdasd212', 152, '2015-11-03 03:13:37', '0000-00-00 00:00:00', 'comments'),
(2356, 48, 'test', 612, '2015-11-03 03:16:20', '0000-00-00 00:00:00', 'admin_messages'),
(2357, 1, '12312ad', 152, '2015-11-03 03:19:31', '0000-00-00 00:00:00', 'comments'),
(2360, 1, '12312321312', 152, '2015-11-03 03:20:03', '0000-00-00 00:00:00', 'comments'),
(2361, 1, '12312321ss', 152, '2015-11-03 03:20:43', '0000-00-00 00:00:00', 'comments'),
(2364, 1, '251332347567', 152, '2015-11-03 03:23:07', '0000-00-00 00:00:00', 'comments'),
(2365, 48, 'test', 620, '2015-11-03 03:26:50', '0000-00-00 00:00:00', 'admin_messages'),
(2366, 48, 'test', 612, '2015-11-03 03:27:07', '0000-00-00 00:00:00', 'admin_messages'),
(2367, 1, '231412sddd', 152, '2015-11-03 03:27:24', '0000-00-00 00:00:00', 'comments'),
(2369, 48, 'test', 610, '2015-11-03 03:27:51', '0000-00-00 00:00:00', 'admin_messages'),
(2370, 48, 'test', 610, '2015-11-03 03:28:06', '0000-00-00 00:00:00', 'admin_messages'),
(2371, 48, 'test', 600, '2015-11-03 03:28:57', '0000-00-00 00:00:00', 'admin_messages'),
(2376, 48, 'test', 615, '2015-11-03 03:33:37', '0000-00-00 00:00:00', 'admin_messages'),
(2377, 48, 'test', 615, '2015-11-03 03:33:42', '0000-00-00 00:00:00', 'admin_messages'),
(2378, 1, '123', 615, '2015-11-03 03:34:36', '0000-00-00 00:00:00', 'admin_messages'),
(2379, 48, 'test', 615, '2015-11-03 03:35:36', '0000-00-00 00:00:00', 'admin_messages'),
(2381, 50, '0935 678 867', 600, '2015-11-03 03:46:41', '0000-00-00 00:00:00', 'admin_messages'),
(2383, 48, '111', 615, '2015-11-03 03:48:06', '0000-00-00 00:00:00', 'admin_messages'),
(2384, 48, '111', 615, '2015-11-03 03:48:15', '0000-00-00 00:00:00', 'admin_messages'),
(2385, 48, '113', 615, '2015-11-03 03:51:00', '0000-00-00 00:00:00', 'admin_messages'),
(2386, 50, 'google.com 0987987787', 600, '2015-11-03 04:01:02', '0000-00-00 00:00:00', 'admin_messages'),
(2388, 50, '456776543246', 596, '2015-11-03 04:31:23', '0000-00-00 00:00:00', 'admin_messages'),
(2389, 48, 'ok', 614, '2015-11-03 05:47:16', '0000-00-00 00:00:00', 'admin_messages'),
(2391, 48, 'ok', 614, '2015-11-03 08:38:49', '0000-00-00 00:00:00', 'admin_messages'),
(2392, 30, 'vhhjnbhbbbbbsbsbsbsnnsnssbbssbsbnsnsbsndb', 596, '2015-11-03 10:01:35', '0000-00-00 00:00:00', 'admin_messages'),
(2393, 30, 'bsbdjdhdj', 596, '2015-11-03 10:01:41', '0000-00-00 00:00:00', 'admin_messages'),
(2394, 30, 'nznxnxnxnxnxnxnxnxnxndndjdndnndndndndjdjdjdjdjdjdjdjdjdjdjdjejejejejejejejejejehejejejejejei', 596, '2015-11-03 10:17:07', '0000-00-00 00:00:00', 'admin_messages'),
(2395, 29, '1232131', 599, '2015-11-05 01:44:40', '0000-00-00 00:00:00', 'admin_messages'),
(2396, 29, '1231231', 599, '2015-11-05 01:44:48', '0000-00-00 00:00:00', 'admin_messages'),
(2397, 48, ' R ', 150, '2015-11-05 01:47:56', '0000-00-00 00:00:00', 'comments'),
(2398, 29, '3421341234', 588, '2015-11-05 02:17:47', '0000-00-00 00:00:00', 'admin_messages'),
(2399, 29, '21342134', 588, '2015-11-05 02:17:51', '0000-00-00 00:00:00', 'admin_messages'),
(2400, 29, '214234', 588, '2015-11-05 02:17:59', '0000-00-00 00:00:00', 'admin_messages'),
(2401, 29, '42342', 588, '2015-11-05 02:18:48', '0000-00-00 00:00:00', 'admin_messages'),
(2402, 29, '2134214', 599, '2015-11-05 02:18:52', '0000-00-00 00:00:00', 'admin_messages'),
(2403, 29, '123421342342', 596, '2015-11-05 02:18:57', '0000-00-00 00:00:00', 'admin_messages'),
(2404, 29, '3142134', 596, '2015-11-05 02:19:00', '0000-00-00 00:00:00', 'admin_messages'),
(2405, 29, '21342134', 596, '2015-11-05 02:19:02', '0000-00-00 00:00:00', 'admin_messages'),
(2406, 29, '2341234', 596, '2015-11-05 02:19:03', '0000-00-00 00:00:00', 'admin_messages'),
(2407, 29, '12342134', 596, '2015-11-05 02:19:05', '0000-00-00 00:00:00', 'admin_messages'),
(2408, 29, '1234234', 588, '2015-11-05 02:19:12', '0000-00-00 00:00:00', 'admin_messages'),
(2409, 29, '342134234', 588, '2015-11-05 02:19:14', '0000-00-00 00:00:00', 'admin_messages'),
(2410, 29, '2342134', 588, '2015-11-05 02:19:16', '0000-00-00 00:00:00', 'admin_messages'),
(2411, 29, 'asdasd', 588, '2015-11-05 02:19:27', '0000-00-00 00:00:00', 'admin_messages'),
(2412, 29, 'Ffdvvx', 588, '2015-11-05 02:32:16', '0000-00-00 00:00:00', 'admin_messages'),
(2413, 29, 'Fgdgr', 588, '2015-11-05 02:32:19', '0000-00-00 00:00:00', 'admin_messages'),
(2414, 29, 'Gfedd', 588, '2015-11-05 02:32:22', '0000-00-00 00:00:00', 'admin_messages'),
(2415, 29, 'Fdd', 588, '2015-11-05 02:32:24', '0000-00-00 00:00:00', 'admin_messages'),
(2416, 29, 'Ìidi', 588, '2015-11-05 02:32:30', '0000-00-00 00:00:00', 'admin_messages'),
(2417, 29, 'Xhdjdjd', 588, '2015-11-05 02:32:32', '0000-00-00 00:00:00', 'admin_messages'),
(2418, 29, 'Djdididi', 588, '2015-11-05 02:32:35', '0000-00-00 00:00:00', 'admin_messages'),
(2419, 48, '123', 145, '2015-11-05 02:34:32', '0000-00-00 00:00:00', 'comments'),
(2420, 48, '123', 145, '2015-11-05 02:34:42', '0000-00-00 00:00:00', 'comments'),
(2421, 48, '123', 145, '2015-11-05 02:34:52', '0000-00-00 00:00:00', 'comments'),
(2422, 29, 'Hjhgj', 599, '2015-11-05 02:36:05', '0000-00-00 00:00:00', 'admin_messages'),
(2423, 29, 'Hjjhggu', 599, '2015-11-05 02:36:08', '0000-00-00 00:00:00', 'admin_messages'),
(2424, 29, 'Gvcgjj', 599, '2015-11-05 02:36:10', '0000-00-00 00:00:00', 'admin_messages'),
(2425, 29, 'Eywgwgqcavavavsvs', 599, '2015-11-05 02:36:19', '0000-00-00 00:00:00', 'admin_messages'),
(2426, 29, 'Jbhb\nVb', 617, '2015-11-05 02:52:43', '0000-00-00 00:00:00', 'admin_messages'),
(2427, 29, 'Uhjjj\n\n\n\nJ', 617, '2015-11-05 02:52:47', '0000-00-00 00:00:00', 'admin_messages'),
(2428, 48, 'test', 147, '2015-11-05 02:57:50', '0000-00-00 00:00:00', 'comments'),
(2429, 48, 'test', 147, '2015-11-05 02:57:54', '0000-00-00 00:00:00', 'comments'),
(2430, 1, '123123', 150, '2015-11-05 03:11:08', '0000-00-00 00:00:00', 'comments'),
(2431, 48, '123', 150, '2015-11-05 03:11:17', '0000-00-00 00:00:00', 'comments'),
(2432, 1, '123', 150, '2015-11-05 03:11:28', '0000-00-00 00:00:00', 'comments'),
(2433, 48, '123', 150, '2015-11-05 03:12:31', '0000-00-00 00:00:00', 'comments'),
(2434, 1, '123', 150, '2015-11-05 03:12:39', '0000-00-00 00:00:00', 'comments'),
(2435, 48, 'asdasasdasdasdasdgasdgdsfgdsafasdfsdfsdafasdfsdafsadfsadfasdfasdfsadfasdfsadfsadfsadfsadfsadfsdafsdafasdfasdfsadfasdfsadf', 147, '2015-11-05 03:42:03', '0000-00-00 00:00:00', 'comments'),
(2436, 29, 'Ttff', 131, '2015-11-05 03:42:09', '0000-00-00 00:00:00', 'comments'),
(2437, 29, 'Jdjdkkf', 137, '2015-11-05 03:42:30', '0000-00-00 00:00:00', 'comments'),
(2438, 48, 'asdasd', 147, '2015-11-05 04:11:16', '0000-00-00 00:00:00', 'comments'),
(2439, 48, 'asdasdasd', 147, '2015-11-05 04:11:29', '0000-00-00 00:00:00', 'comments'),
(2440, 1, '1', 622, '2015-11-05 04:13:35', '0000-00-00 00:00:00', 'admin_messages'),
(2441, 1, '2', 622, '2015-11-05 04:14:03', '0000-00-00 00:00:00', 'admin_messages'),
(2442, 1, '3', 622, '2015-11-05 04:14:48', '0000-00-00 00:00:00', 'admin_messages'),
(2443, 1, '4', 622, '2015-11-05 04:15:19', '0000-00-00 00:00:00', 'admin_messages'),
(2444, 1, '5', 622, '2015-11-05 04:15:32', '0000-00-00 00:00:00', 'admin_messages'),
(2445, 30, 'ghhgbbbhbbbvbbbbbbbbbbbbbbbbbbbbbbbbbbn', 588, '2015-11-05 04:19:22', '0000-00-00 00:00:00', 'admin_messages'),
(2446, 1, '2', 623, '2015-11-05 04:24:52', '0000-00-00 00:00:00', 'admin_messages'),
(2447, 1, '3', 623, '2015-11-05 04:25:08', '0000-00-00 00:00:00', 'admin_messages'),
(2448, 1, '4', 623, '2015-11-05 04:25:22', '0000-00-00 00:00:00', 'admin_messages'),
(2449, 1, '5', 623, '2015-11-05 04:26:49', '0000-00-00 00:00:00', 'admin_messages'),
(2450, 1, '6', 623, '2015-11-05 04:27:27', '0000-00-00 00:00:00', 'admin_messages'),
(2451, 1, '7', 623, '2015-11-05 04:34:42', '0000-00-00 00:00:00', 'admin_messages'),
(2452, 1, '8', 623, '2015-11-05 04:43:09', '0000-00-00 00:00:00', 'admin_messages'),
(2453, 1, '9', 623, '2015-11-05 04:43:21', '0000-00-00 00:00:00', 'admin_messages'),
(2454, 1, '10', 623, '2015-11-05 04:43:30', '0000-00-00 00:00:00', 'admin_messages'),
(2455, 1, '11', 623, '2015-11-05 04:45:53', '0000-00-00 00:00:00', 'admin_messages'),
(2456, 1, '12', 623, '2015-11-05 04:46:12', '0000-00-00 00:00:00', 'admin_messages'),
(2457, 1, '13', 623, '2015-11-05 04:49:51', '0000-00-00 00:00:00', 'admin_messages'),
(2458, 1, '14', 623, '2015-11-05 04:50:13', '0000-00-00 00:00:00', 'admin_messages'),
(2459, 1, '15', 623, '2015-11-05 04:50:23', '0000-00-00 00:00:00', 'admin_messages'),
(2460, 1, '16', 623, '2015-11-05 05:36:06', '0000-00-00 00:00:00', 'admin_messages'),
(2461, 1, '17', 623, '2015-11-05 05:36:20', '0000-00-00 00:00:00', 'admin_messages'),
(2462, 1, '18', 623, '2015-11-05 05:36:34', '0000-00-00 00:00:00', 'admin_messages'),
(2463, 1, '19', 623, '2015-11-05 05:36:53', '0000-00-00 00:00:00', 'admin_messages'),
(2464, 1, '20', 623, '2015-11-05 05:37:02', '0000-00-00 00:00:00', 'admin_messages'),
(2465, 1, '21', 623, '2015-11-05 05:37:08', '0000-00-00 00:00:00', 'admin_messages'),
(2466, 1, '23', 623, '2015-11-05 05:37:16', '0000-00-00 00:00:00', 'admin_messages'),
(2467, 1, '22', 623, '2015-11-05 05:38:19', '0000-00-00 00:00:00', 'admin_messages'),
(2468, 1, '22', 623, '2015-11-05 05:38:24', '0000-00-00 00:00:00', 'admin_messages'),
(2469, 1, '21', 623, '2015-11-05 05:38:29', '0000-00-00 00:00:00', 'admin_messages'),
(2470, 1, '22', 623, '2015-11-05 05:38:33', '0000-00-00 00:00:00', 'admin_messages'),
(2471, 1, '24', 623, '2015-11-05 05:38:53', '0000-00-00 00:00:00', 'admin_messages'),
(2472, 1, '25', 623, '2015-11-05 05:39:01', '0000-00-00 00:00:00', 'admin_messages'),
(2473, 1, '26', 623, '2015-11-05 05:39:10', '0000-00-00 00:00:00', 'admin_messages'),
(2474, 1, '27', 623, '2015-11-05 05:39:18', '0000-00-00 00:00:00', 'admin_messages'),
(2475, 1, '28', 623, '2015-11-05 05:39:28', '0000-00-00 00:00:00', 'admin_messages'),
(2476, 1, '29', 623, '2015-11-05 05:39:40', '0000-00-00 00:00:00', 'admin_messages'),
(2477, 1, '30', 623, '2015-11-05 05:39:50', '0000-00-00 00:00:00', 'admin_messages'),
(2478, 1, '31', 623, '2015-11-05 05:40:02', '0000-00-00 00:00:00', 'admin_messages'),
(2479, 1, '2', 624, '2015-11-05 05:45:52', '0000-00-00 00:00:00', 'admin_messages'),
(2480, 1, '3', 624, '2015-11-05 05:46:32', '0000-00-00 00:00:00', 'admin_messages'),
(2481, 1, '4', 624, '2015-11-05 05:47:28', '0000-00-00 00:00:00', 'admin_messages'),
(2482, 1, '5', 624, '2015-11-05 05:47:57', '0000-00-00 00:00:00', 'admin_messages'),
(2483, 1, '6', 624, '2015-11-05 05:48:11', '0000-00-00 00:00:00', 'admin_messages'),
(2484, 1, '7', 624, '2015-11-05 05:50:37', '0000-00-00 00:00:00', 'admin_messages'),
(2485, 1, '8', 624, '2015-11-05 05:50:58', '0000-00-00 00:00:00', 'admin_messages'),
(2486, 50, 'Hhhhh', 624, '2015-11-05 05:53:39', '0000-00-00 00:00:00', 'admin_messages'),
(2487, 50, 'Jj', 624, '2015-11-05 05:54:12', '0000-00-00 00:00:00', 'admin_messages'),
(2488, 48, 'ok', 621, '2015-11-05 06:00:27', '0000-00-00 00:00:00', 'admin_messages'),
(2489, 48, 'Yes', 147, '2015-11-05 06:29:58', '0000-00-00 00:00:00', 'comments'),
(2490, 48, 'Nick', 147, '2015-11-05 06:39:59', '0000-00-00 00:00:00', 'comments'),
(2491, 1, '123123', 150, '2015-11-05 06:40:43', '0000-00-00 00:00:00', 'comments'),
(2492, 1, '123123', 150, '2015-11-05 06:41:27', '0000-00-00 00:00:00', 'comments'),
(2493, 1, 'eeyeery', 150, '2015-11-05 06:42:00', '0000-00-00 00:00:00', 'comments'),
(2494, 1, '123123', 150, '2015-11-05 06:42:26', '0000-00-00 00:00:00', 'comments'),
(2495, 1, '12312312', 150, '2015-11-05 06:47:56', '0000-00-00 00:00:00', 'comments'),
(2496, 1, '123123', 150, '2015-11-05 06:51:17', '0000-00-00 00:00:00', 'comments'),
(2497, 1, '123123', 150, '2015-11-05 06:56:33', '0000-00-00 00:00:00', 'comments'),
(2498, 1, 'qweqweqwe', 150, '2015-11-05 06:58:23', '0000-00-00 00:00:00', 'comments'),
(2499, 1, '123123', 150, '2015-11-05 06:58:59', '0000-00-00 00:00:00', 'comments'),
(2500, 1, '123123123', 150, '2015-11-05 06:59:10', '0000-00-00 00:00:00', 'comments'),
(2501, 50, 'Always specify both the height and width attributes for images. If height and width are set, the space required for the image is reserved when the page is loaded. However, without these attributes, the browser does not know the size of the image, and cannot reserve the appropriate space to it. The effect will be that the page layout will change during loading (while the images load).', 600, '2015-11-05 07:08:23', '0000-00-00 00:00:00', 'admin_messages'),
(2502, 48, 'Hi', 621, '2015-11-05 07:26:05', '0000-00-00 00:00:00', 'admin_messages'),
(2503, 1, 'Beep *beep* *beep* *beep* *beep* *beep*', 621, '2015-11-05 07:32:37', '0000-00-00 00:00:00', 'admin_messages'),
(2504, 48, 'What is beep?', 621, '2015-11-05 07:58:39', '0000-00-00 00:00:00', 'admin_messages'),
(2505, 50, 'Hello', 623, '2015-11-05 08:55:43', '0000-00-00 00:00:00', 'admin_messages'),
(2506, 1, '123', 143, '2015-11-05 11:13:46', '0000-00-00 00:00:00', 'comments'),
(2507, 15, 'cfffffffffffffffgggggfggggfgggggfgggggggggggggggggggggggggggggg', 158, '2015-11-05 23:45:16', '0000-00-00 00:00:00', 'comments'),
(2508, 29, '2', 137, '2015-11-06 01:09:49', '0000-00-00 00:00:00', 'comments'),
(2509, 29, '22', 137, '2015-11-06 01:09:51', '0000-00-00 00:00:00', 'comments');
INSERT INTO `reply_messages` (`id`, `user_id`, `content`, `message_id`, `created_at`, `updated_at`, `type_messages`) VALUES
(2510, 29, 'Vbjj', 138, '2015-11-06 03:18:47', '0000-00-00 00:00:00', 'comments'),
(2511, 29, 'Hhj', 621, '2015-11-06 03:22:28', '0000-00-00 00:00:00', 'admin_messages'),
(2512, 48, 'Shhdghj\nGhjbg\n\n\n\n\n\nGhnnnkkb\n\n\n\n\nGhkkn', 596, '2015-11-06 06:45:31', '0000-00-00 00:00:00', 'admin_messages'),
(2513, 48, 'Test', 596, '2015-11-06 06:45:38', '0000-00-00 00:00:00', 'admin_messages'),
(2514, 48, 'Rtes\nHgn', 588, '2015-11-06 06:48:01', '0000-00-00 00:00:00', 'admin_messages'),
(2515, 48, 'Ghh\n\nHhn', 588, '2015-11-06 06:48:07', '0000-00-00 00:00:00', 'admin_messages'),
(2516, 48, 'Fhhg\n\n\nGhhjn\n\n\n', 588, '2015-11-06 06:48:15', '0000-00-00 00:00:00', 'admin_messages'),
(2517, 48, 'Ghbbvb\n\n\n\n\n\nGhhhh\n\n\n\n\n\nBhbbj', 588, '2015-11-06 06:48:26', '0000-00-00 00:00:00', 'admin_messages'),
(2518, 48, 'Bbhhbbbbnnnnnnngngybnnnnnbnbnbnbbnbnn', 589, '2015-11-06 06:50:15', '0000-00-00 00:00:00', 'admin_messages'),
(2519, 48, 'Gooo.bbb\n468457', 600, '2015-11-06 06:59:08', '0000-00-00 00:00:00', 'admin_messages'),
(2520, 29, 'Ddc', 600, '2015-11-06 07:03:19', '0000-00-00 00:00:00', 'admin_messages'),
(2521, 29, 'Dccd', 600, '2015-11-06 07:03:20', '0000-00-00 00:00:00', 'admin_messages'),
(2522, 48, 'Ol', 162, '2015-11-06 07:04:35', '0000-00-00 00:00:00', 'comments'),
(2523, 29, 'Hxudhsdbbd', 159, '2015-11-06 07:17:58', '0000-00-00 00:00:00', 'comments'),
(2524, 29, 'Gxhh', 159, '2015-11-06 07:18:01', '0000-00-00 00:00:00', 'comments'),
(2525, 29, 'Hxhdjd', 139, '2015-11-06 07:18:21', '0000-00-00 00:00:00', 'comments'),
(2526, 30, 'dddxx', 600, '2015-11-06 07:19:17', '0000-00-00 00:00:00', 'admin_messages'),
(2527, 29, 'Test by Ted bnnmmmjnn\nGhgfdj\nJjvb\nIiyy', 161, '2015-11-06 07:25:19', '0000-00-00 00:00:00', 'comments'),
(2528, 15, 'dxxbb', 155, '2015-11-06 07:26:32', '0000-00-00 00:00:00', 'comments'),
(2529, 15, 'gsgshshsj', 155, '2015-11-06 07:26:51', '0000-00-00 00:00:00', 'comments'),
(2530, 15, 'fsgsgsshss', 155, '2015-11-06 07:49:19', '0000-00-00 00:00:00', 'comments'),
(2531, 15, 'heheheehse', 156, '2015-11-06 08:28:04', '0000-00-00 00:00:00', 'comments'),
(2532, 15, 'babababsn', 156, '2015-11-06 08:28:09', '0000-00-00 00:00:00', 'comments'),
(2533, 15, 'bababan', 156, '2015-11-06 08:28:17', '0000-00-00 00:00:00', 'comments'),
(2534, 15, 'bsbsbsb', 626, '2015-11-06 08:28:32', '0000-00-00 00:00:00', 'admin_messages'),
(2535, 15, 'bsbsbsh', 621, '2015-11-06 08:29:10', '0000-00-00 00:00:00', 'admin_messages'),
(2536, 15, 'bababsb', 621, '2015-11-06 08:29:19', '0000-00-00 00:00:00', 'admin_messages'),
(2537, 15, 'jjfjffjjffjfjfjfkfk', 621, '2015-11-06 08:29:26', '0000-00-00 00:00:00', 'admin_messages'),
(2538, 15, 'bzbzbzb', 621, '2015-11-06 08:29:40', '0000-00-00 00:00:00', 'admin_messages'),
(2539, 15, 'vzbzbzhsjk', 621, '2015-11-06 08:29:47', '0000-00-00 00:00:00', 'admin_messages'),
(2540, 15, 'bzbzjshshsjdj', 621, '2015-11-06 08:29:57', '0000-00-00 00:00:00', 'admin_messages'),
(2541, 15, 'nnnnnnnnnnbbbbbbbbbnnbbbbbbbbbbhghh', 621, '2015-11-06 08:30:07', '0000-00-00 00:00:00', 'admin_messages'),
(2542, 15, 'bbvbbbbvvvhhhhhhhhhbbbhhhbbbbbbhb', 621, '2015-11-06 08:30:16', '0000-00-00 00:00:00', 'admin_messages'),
(2543, 15, 'zhxjzjxjxjxjcjxjfkdkxjdkdididjdjdkdjzkzjzjxjxkxjxjxmxmxvcgghgcjdkdk', 621, '2015-11-06 08:30:30', '0000-00-00 00:00:00', 'admin_messages'),
(2544, 15, 'ffcccccfddddcccccvvvvvbhhgvvcccxccffggg', 158, '2015-11-06 08:49:15', '0000-00-00 00:00:00', 'comments'),
(2545, 48, 'Ok', 162, '2015-11-06 10:01:58', '0000-00-00 00:00:00', 'comments'),
(2546, 48, 'Tứt', 628, '2015-11-06 10:59:31', '0000-00-00 00:00:00', 'admin_messages'),
(2547, 1, '12312313', 162, '2015-11-06 11:01:13', '0000-00-00 00:00:00', 'comments'),
(2548, 1, '123123123', 162, '2015-11-06 11:01:27', '0000-00-00 00:00:00', 'comments'),
(2549, 1, '12312312', 162, '2015-11-06 11:01:48', '0000-00-00 00:00:00', 'comments'),
(2550, 1, '12312321', 629, '2015-11-06 11:02:52', '0000-00-00 00:00:00', 'admin_messages'),
(2551, 1, '123123', 628, '2015-11-06 11:03:05', '0000-00-00 00:00:00', 'admin_messages'),
(2552, 1, '12312312', 162, '2015-11-06 11:03:26', '0000-00-00 00:00:00', 'comments'),
(2553, 1, '12312312', 162, '2015-11-06 11:03:32', '0000-00-00 00:00:00', 'comments'),
(2554, 1, '12312312', 162, '2015-11-06 11:03:35', '0000-00-00 00:00:00', 'comments'),
(2555, 48, 'Test', 631, '2015-11-09 01:53:41', '0000-00-00 00:00:00', 'admin_messages'),
(2556, 1, '123', 633, '2015-11-09 02:02:49', '0000-00-00 00:00:00', 'admin_messages'),
(2557, 48, 'Ok', 633, '2015-11-09 02:03:09', '0000-00-00 00:00:00', 'admin_messages'),
(2558, 1, '12222', 633, '2015-11-09 02:03:18', '0000-00-00 00:00:00', 'admin_messages'),
(2559, 48, 'Tvycyxyxyxyxyxyxyxycyxccycyccyxycuuucucucucuxuxyxyxtxtcttxyxyyxtxtxtxttctxytcycyxyxyytxtctxtxtxtxttxtxtxtxtxtxtxttxtjxxyuhfhfhfnfnfjdhfbfbfdfjfncnfbfhfbfbffnfncncncncnccncncncncnccncncncncncncbcbcbfhfd đnfhd h djd h dj dj di zh dhf he náu dúndj đựnenux đu ứu đu h đubjd d hdndnf.', 600, '2015-11-09 02:25:45', '0000-00-00 00:00:00', 'admin_messages'),
(2560, 48, 'Ok', 633, '2015-11-09 02:38:10', '0000-00-00 00:00:00', 'admin_messages'),
(2561, 48, 'Tét', 633, '2015-11-09 02:38:15', '0000-00-00 00:00:00', 'admin_messages'),
(2562, 48, 'Tét', 620, '2015-11-09 02:38:29', '0000-00-00 00:00:00', 'admin_messages'),
(2563, 48, 'Tét', 147, '2015-11-09 02:43:42', '0000-00-00 00:00:00', 'comments'),
(2564, 48, 'Hi', 162, '2015-11-09 03:21:21', '0000-00-00 00:00:00', 'comments'),
(2565, 48, 'Tét', 162, '2015-11-09 03:21:30', '0000-00-00 00:00:00', 'comments'),
(2566, 48, 'Tét', 164, '2015-11-09 04:31:02', '0000-00-00 00:00:00', 'comments'),
(2567, 48, 'Ok', 147, '2015-11-09 04:32:31', '0000-00-00 00:00:00', 'comments'),
(2568, 48, 'Hello', 633, '2015-11-09 05:30:16', '0000-00-00 00:00:00', 'admin_messages'),
(2569, 29, 'Gxhh', 159, '2015-11-09 06:40:23', '0000-00-00 00:00:00', 'comments'),
(2570, 29, 'Gxhh', 159, '2015-11-09 06:40:26', '0000-00-00 00:00:00', 'comments'),
(2571, 30, 'jkjhkjhkjsdfsdf', 630, '2015-11-09 06:45:22', '0000-00-00 00:00:00', 'admin_messages'),
(2572, 30, 'sdfsdf', 629, '2015-11-09 06:45:37', '0000-00-00 00:00:00', 'admin_messages'),
(2573, 30, 'jjjjj', 629, '2015-11-09 06:46:06', '0000-00-00 00:00:00', 'admin_messages'),
(2574, 30, 'sdcsdfc', 629, '2015-11-09 06:46:12', '0000-00-00 00:00:00', 'admin_messages'),
(2575, 29, 'ghgg', 160, '2015-11-09 06:50:40', '0000-00-00 00:00:00', 'comments');

-- --------------------------------------------------------

--
-- Table structure for table `shifts`
--

CREATE TABLE IF NOT EXISTS `shifts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8,
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
(1, 'Shift 1', 'Shift 1', '11:00:00', '11:30:00', '2015-11-06 03:39:33', '2015-11-06 03:39:33'),
(2, 'Shift 2', 'Shift 2', '11:23:00', '17:00:00', '2015-11-06 06:22:20', '2015-11-06 06:22:20'),
(3, 'Shift 3', 'Shift 3', '12:00:00', '12:30:00', '2015-11-06 03:40:16', '2015-11-06 03:40:16');

-- --------------------------------------------------------

--
-- Table structure for table `status_user`
--

CREATE TABLE IF NOT EXISTS `status_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `status_user`
--

INSERT INTO `status_user` (`id`, `status`) VALUES
(1, 'attend'),
(2, 'absent'),
(3, 'late');

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE IF NOT EXISTS `tables` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8,
  `for_vegans` tinyint(1) NOT NULL DEFAULT '0',
  `seats` int(11) NOT NULL,
  `available_seats` int(11) NOT NULL,
  `shift_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`id`, `name`, `description`, `for_vegans`, `seats`, `available_seats`, `shift_id`, `created_at`, `updated_at`) VALUES
(1, 'Table normal', 'Table normal', 0, 7, 7, 1, '2015-09-21 01:45:07', '0000-00-00 00:00:00'),
(2, 'Table normal 2', 'Table normal 2', 0, 7, 7, 1, '2015-09-21 09:31:29', '0000-00-00 00:00:00'),
(3, 'Table normal 3', 'Table normal 3', 0, 7, 7, 1, '2015-09-18 09:43:11', '0000-00-00 00:00:00'),
(4, 'Table normal 4', 'Table normal 4', 0, 7, 6, 2, '2015-09-22 12:10:40', '0000-00-00 00:00:00'),
(5, 'Table normal 5', 'Table normal 5', 0, 7, 5, 2, '2015-09-22 09:07:51', '0000-00-00 00:00:00'),
(6, 'Table normal 6', 'Table normal 6', 0, 7, 6, 2, '2015-09-23 09:20:39', '0000-00-00 00:00:00'),
(7, 'Table normal 7', 'Table normal 7', 0, 7, 7, 3, '2015-09-01 01:34:21', '0000-00-00 00:00:00'),
(8, 'Table normal 8', 'Table normal 8', 0, 7, 7, 3, '2015-09-01 09:05:02', '0000-00-00 00:00:00'),
(9, 'Table mormal 9', 'Table mormal 9', 0, 7, 7, 3, '2015-09-18 02:40:35', '0000-00-00 00:00:00'),
(10, 'Table vegan 1 shift 3', 'Table vegan 1 shift 3', 1, 7, 7, 3, '2015-11-06 03:58:35', '0000-00-00 00:00:00'),
(11, 'Table vegan 1 shift 1', 'Table vegan shift 1', 1, 7, 7, 1, '2015-11-06 03:57:23', '0000-00-00 00:00:00'),
(12, 'Table vegan 1 shift 2', 'Table vegan 1 shift 2', 1, 7, 9, 2, '2015-11-06 03:56:04', '0000-00-00 00:00:00'),
(13, 'Table vegan 2 shift 1', 'Table vegan 2 shift 1', 1, 7, 0, 1, '2015-11-05 08:29:29', '0000-00-00 00:00:00'),
(14, 'Table vegan 2 shift 2', 'Table vegan 2 shift 2', 1, 7, 0, 2, '2015-11-06 03:53:12', '0000-00-00 00:00:00'),
(15, 'Table vegan 3 shift 2', 'Table vegan 3 shift 2', 1, 7, 0, 2, '2015-11-06 03:54:05', '0000-00-00 00:00:00'),
(16, 'Table vegan 4 shift 2', 'Table vegan 4 shift 2', 1, 7, 0, 2, '2015-11-06 03:55:10', '0000-00-00 00:00:00'),
(17, 'Table vegan 2 shift 3', 'Table vegan 2 shift 3', 1, 7, 0, 3, '2015-11-06 03:59:20', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tables_users`
--

CREATE TABLE IF NOT EXISTS `tables_users` (
  `table_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `vegan_day` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tables_users`
--

INSERT INTO `tables_users` (`table_id`, `user_id`, `vegan_day`) VALUES
(12, 3, 1),
(5, 56, 0),
(5, 56, 1),
(5, 57, 0),
(5, 57, 1),
(5, 58, 0),
(5, 58, 1),
(12, 59, 1),
(12, 60, 1),
(12, 61, 1),
(12, 62, 1),
(12, 63, 1),
(1, 64, 0),
(2, 66, 0),
(2, 67, 0),
(1, 68, 0),
(1, 69, 0),
(1, 71, 0),
(1, 72, 0),
(1, 73, 0),
(2, 74, 0),
(3, 75, 0),
(11, 65, 1),
(11, 66, 1),
(11, 67, 1),
(11, 68, 1),
(11, 69, 1),
(11, 71, 1),
(6, 29, 0),
(10, 55, 1),
(7, 55, 0),
(4, 50, 0),
(4, 50, 1),
(2, 80, 0),
(2, 80, 1),
(3, 65, 0),
(3, 10, 0),
(3, 10, 1),
(4, 51, 0),
(2, 76, 0),
(13, 76, 1),
(14, 30, 1),
(12, 48, 1),
(6, 48, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tracking_users`
--

CREATE TABLE IF NOT EXISTS `tracking_users` (
  `user_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `manually_set` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tracking_users`
--

INSERT INTO `tracking_users` (`user_id`, `status_id`, `manually_set`, `created_at`, `updated_at`) VALUES
(3, 2, 0, '2015-10-13 07:59:14', '2015-11-09 04:30:34'),
(29, 2, 0, '2015-10-13 09:28:40', '2015-11-09 06:11:17'),
(48, 2, 0, '2015-10-14 06:47:16', '2015-11-09 06:10:26'),
(1, 1, 1, '2015-10-16 02:20:14', '2015-10-23 02:04:31'),
(54, 1, 0, '2015-10-16 04:03:16', '2015-10-16 04:03:16'),
(50, 2, 0, '2015-10-16 04:07:28', '2015-11-09 06:10:57'),
(51, 2, 0, '2015-10-16 04:07:28', '2015-11-09 06:10:57'),
(55, 1, 1, '2015-10-16 04:59:40', '2015-11-09 04:28:30'),
(56, 2, 0, '2015-10-16 05:00:09', '2015-11-09 06:10:26'),
(57, 2, 0, '2015-10-16 05:00:09', '2015-11-09 06:10:26'),
(58, 1, 1, '2015-10-16 07:17:46', '2015-11-09 06:09:35'),
(59, 2, 0, '2015-10-16 07:17:46', '2015-11-09 04:30:34'),
(60, 2, 0, '2015-10-16 07:17:46', '2015-11-09 04:30:34'),
(61, 2, 0, '2015-10-16 07:17:46', '2015-11-09 04:30:34'),
(63, 2, 0, '2015-10-16 07:17:46', '2015-11-09 04:30:34'),
(64, 2, 0, '2015-10-16 07:17:46', '2015-11-09 06:53:47'),
(65, 1, 1, '2015-10-16 07:17:46', '2015-11-09 04:29:33'),
(66, 1, 1, '2015-10-16 07:17:46', '2015-11-09 04:29:27'),
(68, 1, 1, '2015-10-16 07:19:11', '2015-11-09 04:29:35'),
(69, 2, 0, '2015-10-16 07:19:11', '2015-11-09 06:53:38'),
(71, 1, 1, '2015-10-16 07:19:11', '2015-11-09 04:29:31'),
(72, 2, 0, '2015-10-16 07:19:11', '2015-11-09 06:53:47'),
(73, 2, 0, '2015-10-16 07:19:50', '2015-11-09 06:53:47'),
(74, 2, 0, '2015-10-16 07:19:50', '2015-11-09 06:53:47'),
(75, 2, 0, '2015-10-16 07:19:50', '2015-11-09 06:53:47'),
(62, 2, 0, '2015-10-16 07:21:33', '2015-11-09 04:30:34'),
(67, 3, 1, '2015-10-16 07:21:33', '2015-11-09 04:29:29'),
(47, 2, 0, '2015-10-19 06:23:05', '2015-10-28 02:57:28'),
(76, 2, 0, '2015-10-22 08:12:57', '2015-11-09 06:53:38'),
(77, 1, 0, '2015-10-27 01:43:22', '2015-10-27 01:43:22'),
(78, 1, 0, '2015-10-27 01:44:05', '2015-10-27 01:44:05'),
(79, 1, 0, '2015-10-27 01:48:46', '2015-10-27 01:48:46'),
(81, 1, 0, '2015-11-03 07:21:23', '2015-11-03 07:21:23'),
(82, 1, 0, '2015-11-03 07:38:06', '2015-11-03 07:38:06'),
(10, 2, 0, '2015-11-05 08:20:55', '2015-11-09 06:53:38');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'user id',
  `email` varchar(255) NOT NULL,
  `encrypted_password` text NOT NULL,
  `reset_password_token` text,
  `reset_password_sent_at` timestamp NULL DEFAULT NULL,
  `remember_created_at` timestamp NULL DEFAULT NULL,
  `sign_in_count` int(11) NOT NULL DEFAULT '0',
  `current_sign_in_at` timestamp NULL DEFAULT NULL,
  `last_sign_in_at` timestamp NULL DEFAULT NULL,
  `confirmation_token` text,
  `confirmation_sent_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `avatar_file_name` text,
  `avatar_content_file` text,
  `avatar_file_size` int(11) DEFAULT NULL,
  `avatar_updated_at` timestamp NULL DEFAULT NULL,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `floor_id` int(11) DEFAULT NULL,
  `shift_id` tinyint(4) NOT NULL,
  `what_taste` text,
  `want_vegan_meal` tinyint(1) NOT NULL DEFAULT '0',
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `authentication_token` text NOT NULL,
  `read_announcements` text NOT NULL,
  `read_comments` text NOT NULL,
  `read_replies_announcements` text NOT NULL,
  `read_replies_comments` text NOT NULL,
  `gcm_regid` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=80 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `encrypted_password`, `reset_password_token`, `reset_password_sent_at`, `remember_created_at`, `sign_in_count`, `current_sign_in_at`, `last_sign_in_at`, `confirmation_token`, `confirmation_sent_at`, `created_at`, `updated_at`, `avatar_file_name`, `avatar_content_file`, `avatar_file_size`, `avatar_updated_at`, `first_name`, `last_name`, `floor_id`, `shift_id`, `what_taste`, `want_vegan_meal`, `admin`, `authentication_token`, `read_announcements`, `read_comments`, `read_replies_announcements`, `read_replies_comments`, `gcm_regid`) VALUES
(1, 'cody@enclave.vn', '$2a$08$GJg2CqggwuVyHxZqRXw.0.W2TM/g0KZCRnImMy2s.V3rZ65R4EgrW', NULL, '2015-08-26 14:19:34', NULL, 0, NULL, NULL, NULL, NULL, NULL, '2015-10-27 03:05:23', 'NguyenNhatCuong6.JPG', 'http://113.160.225.87:8484/assets/images/users/NguyenNhatCuong6.JPG', NULL, NULL, 'Cuong', 'Cody', 5, 2, 'Salty', 1, 1, 'e8b5618a02ac4e617b9efe665cf50f893d8f4c8e76a02c632eab9be0e79e82021d196e6269ddcf00b0ceeca89dc8808b3c381dc62e3604907f8f599e1caac7a5yR9NsGrNKPT1aTDK89Goi+EaenfEPMhYkA12+hMlGU0=', '3;42;2;14;15;64;63', '1;2;3;4;76;79;81;94;95;163;165;166;167;168', '[{"announcement":"335","replies":776},{"announcement":"336","replies":779},{"announcement":"336","replies":780},{"announcement":"336","replies":781},{"announcement":"336","replies":782},{"announcement":"336","replies":783},{"announcement":"336","replies":784},{"announcement":"336","replies":785},{"announcement":"336","replies":786},{"announcement":"336","replies":787},{"announcement":"336","replies":788},{"announcement":"336","replies":789},{"announcement":"336","replies":790},{"announcement":"336","replies":791},{"announcement":"336","replies":792},{"announcement":"336","replies":793},{"announcement":"336","replies":794},{"announcement":"335","replies":795},{"announcement":"335","replies":796},{"announcement":"335","replies":797},{"announcement":"338","replies":798},{"announcement":"337","replies":799},{"announcement":"337","replies":800},{"announcement":"337","replies":801},{"announcement":"337","replies":802},{"announcement":"337","replies":803},{"announcement":"337","replies":804},{"announcement":"337","replies":805},{"announcement":"337","replies":806},{"announcement":"337","replies":807},{"announcement":"337","replies":808},{"announcement":"337","replies":809},{"announcement":"337","replies":810},{"announcement":"337","replies":811},{"announcement":"337","replies":812},{"announcement":"338","replies":813},{"announcement":"344","replies":814},{"announcement":"344","replies":815},{"announcement":"344","replies":816},{"announcement":"344","replies":817},{"announcement":"344","replies":818},{"announcement":"344","replies":819},{"announcement":"344","replies":820},{"announcement":"344","replies":821},{"announcement":"344","replies":822},{"announcement":"344","replies":823},{"announcement":"344","replies":824},{"announcement":"344","replies":825},{"announcement":"344","replies":826},{"announcement":"344","replies":827},{"announcement":"344","replies":828},{"announcement":"344","replies":829},{"announcement":"344","replies":830},{"announcement":"344","replies":831},{"announcement":"344","replies":832},{"announcement":"344","replies":833},{"announcement":"344","replies":834},{"announcement":"344","replies":835},{"announcement":"344","replies":836},{"announcement":"344","replies":837},{"announcement":"344","replies":838},{"announcement":"344","replies":839},{"announcement":"344","replies":840},{"announcement":"344","replies":841},{"announcement":"345","replies":842},{"announcement":"345","replies":843},{"announcement":"345","replies":844},{"announcement":"345","replies":845},{"announcement":"345","replies":846},{"announcement":"345","replies":847},{"announcement":"345","replies":848},{"announcement":"345","replies":849},{"announcement":"345","replies":850},{"announcement":"345","replies":851},{"announcement":"345","replies":852},{"announcement":"345","replies":853},{"announcement":"351","replies":869},{"announcement":"351","replies":870},{"announcement":"356","replies":871},{"announcement":"356","replies":872},{"announcement":"360","replies":874},{"announcement":"360","replies":875},{"announcement":"360","replies":876},{"announcement":"360","replies":877},{"announcement":"360","replies":878},{"announcement":"360","replies":879},{"announcement":"360","replies":880},{"announcement":"360","replies":881},{"announcement":"360","replies":882},{"announcement":"367","replies":884},{"announcement":"367","replies":886},{"announcement":"367","replies":887},{"announcement":"367","replies":889},{"announcement":"367","replies":891},{"announcement":"367","replies":892},{"announcement":"367","replies":893},{"announcement":"370","replies":894},{"announcement":"370","replies":895},{"announcement":"370","replies":896},{"announcement":"370","replies":897},{"announcement":"370","replies":898},{"announcement":"370","replies":899},{"announcement":"370","replies":902},{"announcement":"370","replies":904},{"announcement":"370","replies":906},{"announcement":"370","replies":908},{"announcement":"370","replies":910},{"announcement":"370","replies":911},{"announcement":"376","replies":914},{"announcement":"402","replies":934},{"announcement":"402","replies":935},{"announcement":"436","replies":959},{"announcement":"504","replies":964},{"announcement":"504","replies":966},{"announcement":"504","replies":967},{"announcement":"504","replies":968},{"announcement":"504","replies":969},{"announcement":"504","replies":973},{"announcement":"504","replies":975},{"announcement":"504","replies":976},{"announcement":"504","replies":978},{"announcement":"504","replies":982},{"announcement":"504","replies":986},{"announcement":"504","replies":988},{"announcement":"504","replies":990},{"announcement":"504","replies":991},{"announcement":"504","replies":992},{"announcement":"504","replies":993},{"announcement":"534","replies":997},{"announcement":"534","replies":999},{"announcement":"534","replies":1001},{"announcement":"534","replies":1002},{"announcement":"534","replies":1008},{"announcement":"537","replies":1021},{"announcement":"537","replies":1022},{"announcement":"537","replies":1023},{"announcement":"534","replies":1027},{"announcement":"534","replies":1029},{"announcement":"534","replies":1030},{"announcement":"534","replies":1031},{"announcement":"534","replies":1032},{"announcement":"534","replies":1033},{"announcement":"534","replies":1034},{"announcement":"537","replies":1036},{"announcement":"537","replies":1037},{"announcement":"537","replies":1038},{"announcement":"537","replies":1039},{"announcement":"541","replies":1042},{"announcement":"547","replies":1044},{"announcement":"547","replies":1045},{"announcement":"547","replies":1046},{"announcement":"547","replies":1047},{"announcement":"547","replies":1048},{"announcement":"547","replies":1049},{"announcement":"547","replies":1050},{"announcement":"547","replies":1051},{"announcement":"547","replies":1052},{"announcement":"547","replies":1053},{"announcement":"548","replies":1054},{"announcement":"548","replies":1064},{"announcement":"548","replies":1065},{"announcement":"548","replies":1066},{"announcement":"548","replies":1067},{"announcement":"548","replies":1068},{"announcement":"548","replies":1069},{"announcement":"548","replies":1071},{"announcement":"548","replies":1072},{"announcement":"548","replies":1074},{"announcement":"548","replies":1075},{"announcement":"548","replies":1077},{"announcement":"548","replies":1078},{"announcement":"548","replies":1079},{"announcement":"548","replies":1080},{"announcement":"548","replies":1081},{"announcement":"548","replies":1082},{"announcement":"548","replies":1083},{"announcement":"548","replies":1084},{"announcement":"548","replies":1085},{"announcement":"548","replies":1086},{"announcement":"548","replies":1087},{"announcement":"548","replies":1088},{"announcement":"548","replies":1089},{"announcement":"548","replies":1090},{"announcement":"548","replies":1092},{"announcement":"548","replies":1093},{"announcement":"548","replies":1094},{"announcement":"548","replies":1097},{"announcement":"548","replies":1098},{"announcement":"548","replies":1099},{"announcement":"548","replies":1101},{"announcement":"548","replies":1104},{"announcement":"574","replies":1106},{"announcement":"574","replies":1108},{"announcement":"574","replies":1110},{"announcement":"574","replies":1112},{"announcement":"574","replies":1113},{"announcement":"574","replies":1114},{"announcement":"574","replies":1115},{"announcement":"574","replies":1116},{"announcement":"574","replies":1118},{"announcement":"574","replies":1120},{"announcement":"574","replies":1121},{"announcement":"574","replies":1122},{"announcement":"574","replies":1123},{"announcement":"574","replies":1124},{"announcement":"574","replies":1126},{"announcement":"574","replies":1127},{"announcement":"582","replies":1128},{"announcement":"582","replies":1130},{"announcement":"587","replies":1131},{"announcement":"587","replies":1133},{"announcement":"587","replies":1135},{"announcement":"587","replies":1137},{"announcement":"587","replies":1139},{"announcement":"587","replies":1140},{"announcement":"587","replies":1141},{"announcement":"587","replies":1142},{"announcement":"587","replies":1143},{"announcement":"587","replies":1144},{"announcement":"587","replies":1145},{"announcement":"587","replies":1147},{"announcement":"587","replies":1148},{"announcement":"587","replies":1149},{"announcement":"587","replies":1150},{"announcement":"587","replies":1151},{"announcement":"587","replies":1152},{"announcement":"587","replies":1153},{"announcement":"587","replies":1154},{"announcement":"587","replies":1155},{"announcement":"587","replies":1156},{"announcement":"587","replies":1157},{"announcement":"587","replies":1158},{"announcement":"587","replies":1159},{"announcement":"587","replies":1161},{"announcement":"587","replies":1162},{"announcement":"587","replies":1163},{"announcement":"587","replies":1164},{"announcement":"587","replies":1165},{"announcement":"587","replies":1166},{"announcement":"587","replies":1167},{"announcement":"587","replies":1168},{"announcement":"587","replies":1171},{"announcement":"587","replies":1172},{"announcement":"587","replies":1173},{"announcement":"594","replies":1197},{"announcement":"594","replies":1199},{"announcement":"594","replies":1231},{"announcement":"594","replies":1235},{"announcement":"594","replies":1236},{"announcement":"594","replies":1237},{"announcement":"594","replies":1239},{"announcement":"594","replies":1240},{"announcement":"594","replies":1247},{"announcement":"594","replies":1250},{"announcement":"594","replies":1252},{"announcement":"594","replies":1253},{"announcement":"594","replies":1254},{"announcement":"594","replies":1255},{"announcement":"594","replies":1256},{"announcement":"594","replies":1257},{"announcement":"594","replies":1258},{"announcement":"594","replies":1259},{"announcement":"594","replies":1260},{"announcement":"594","replies":1262},{"announcement":"594","replies":1264},{"announcement":"594","replies":1265},{"announcement":"594","replies":1266},{"announcement":"605","replies":1276},{"announcement":"605","replies":1278},{"announcement":"605","replies":1280},{"announcement":"605","replies":1281},{"announcement":"605","replies":1282},{"announcement":"605","replies":1284},{"announcement":"605","replies":1296},{"announcement":"626","replies":1314},{"announcement":"626","replies":1324},{"announcement":"626","replies":1328},{"announcement":"626","replies":1329},{"announcement":"626","replies":1330},{"announcement":"626","replies":1332},{"announcement":"626","replies":1335},{"announcement":"626","replies":1341},{"announcement":"626","replies":1344},{"announcement":"626","replies":1359},{"announcement":"626","replies":1361},{"announcement":"626","replies":1362},{"announcement":"626","replies":1366},{"announcement":"629","replies":1382},{"announcement":"629","replies":1384},{"announcement":"629","replies":1385},{"announcement":"629","replies":1386},{"announcement":"629","replies":1391},{"announcement":"629","replies":1392},{"announcement":"647","replies":1393},{"announcement":"647","replies":1395},{"announcement":"647","replies":1397},{"announcement":"647","replies":1398},{"announcement":"647","replies":1399},{"announcement":"649","replies":1400},{"announcement":"649","replies":1401},{"announcement":"649","replies":1402},{"announcement":"649","replies":1406},{"announcement":"649","replies":1408},{"announcement":"649","replies":1409},{"announcement":"649","replies":1410},{"announcement":"649","replies":1411},{"announcement":"649","replies":1412},{"announcement":"649","replies":1413},{"announcement":"649","replies":1414},{"announcement":"649","replies":1415},{"announcement":"649","replies":1416},{"announcement":"649","replies":1417},{"announcement":"649","replies":1418},{"announcement":"649","replies":1419},{"announcement":"649","replies":1420},{"announcement":"649","replies":1421},{"announcement":"649","replies":1422},{"announcement":"649","replies":1423},{"announcement":"649","replies":1424},{"announcement":"649","replies":1425},{"announcement":"649","replies":1426},{"announcement":"649","replies":1427},{"announcement":"649","replies":1428},{"announcement":"649","replies":1430},{"announcement":"649","replies":1431},{"announcement":"649","replies":1432},{"announcement":"649","replies":1433},{"announcement":"649","replies":1434},{"announcement":"649","replies":1435},{"announcement":"649","replies":1436},{"announcement":"649","replies":1437},{"announcement":"649","replies":1438},{"announcement":"649","replies":1439},{"announcement":"649","replies":1440},{"announcement":"649","replies":1441},{"announcement":"649","replies":1442},{"announcement":"677","replies":1450},{"announcement":"677","replies":1451},{"announcement":"677","replies":1452},{"announcement":"677","replies":1454},{"announcement":"677","replies":1455},{"announcement":"677","replies":1457},{"announcement":"677","replies":1458},{"announcement":"677","replies":1459},{"announcement":"677","replies":1460},{"announcement":"677","replies":1461},{"announcement":"677","replies":1462},{"announcement":"677","replies":1463},{"announcement":"677","replies":1464},{"announcement":"677","replies":1465},{"announcement":"677","replies":1466},{"announcement":"677","replies":1467},{"announcement":"677","replies":1468},{"announcement":"677","replies":1469},{"announcement":"677","replies":1470},{"announcement":"677","replies":1471},{"announcement":"677","replies":1472},{"announcement":"677","replies":1473},{"announcement":"677","replies":1474},{"announcement":"677","replies":1475},{"announcement":"677","replies":1476},{"announcement":"677","replies":1477},{"announcement":"677","replies":1478},{"announcement":"677","replies":1479},{"announcement":"677","replies":1480},{"announcement":"677","replies":1481},{"announcement":"677","replies":1482},{"announcement":"677","replies":1483},{"announcement":"677","replies":1484},{"announcement":"677","replies":1485},{"announcement":"677","replies":1486},{"announcement":"677","replies":1488},{"announcement":"677","replies":1489},{"announcement":"677","replies":1490},{"announcement":"677","replies":1491},{"announcement":"677","replies":1492},{"announcement":"677","replies":1493},{"announcement":"677","replies":1494},{"announcement":"677","replies":1496},{"announcement":"677","replies":1498},{"announcement":"677","replies":1500},{"announcement":"677","replies":1502},{"announcement":"677","replies":1503},{"announcement":"677","replies":1504},{"announcement":"677","replies":1505},{"announcement":"677","replies":1510},{"announcement":"677","replies":1513},{"announcement":"677","replies":1522},{"announcement":"677","replies":1523},{"announcement":"677","replies":1525},{"announcement":"677","replies":1526},{"announcement":"677","replies":1527},{"announcement":"679","replies":1597},{"announcement":"679","replies":1598},{"announcement":"679","replies":1599},{"announcement":"679","replies":1600},{"announcement":"679","replies":1602},{"announcement":"679","replies":1603},{"announcement":"586","replies":1636},{"announcement":"588","replies":1759},{"announcement":"588","replies":1762},{"announcement":"588","replies":1763},{"announcement":"588","replies":1764},{"announcement":"589","replies":1766},{"announcement":"589","replies":1767},{"announcement":"589","replies":1768},{"announcement":"589","replies":1770},{"announcement":"588","replies":1772},{"announcement":"588","replies":1773},{"announcement":"589","replies":1774},{"announcement":"589","replies":1775},{"announcement":"592","replies":1813},{"announcement":"592","replies":1814},{"announcement":"592","replies":1815},{"announcement":"592","replies":1816},{"announcement":"592","replies":1817},{"announcement":"592","replies":1818},{"announcement":"591","replies":1819},{"announcement":"590","replies":1820},{"announcement":"593","replies":1822},{"announcement":"593","replies":1823},{"announcement":"588","replies":1824},{"announcement":"593","replies":1825},{"announcement":"593","replies":1826},{"announcement":"593","replies":1829},{"announcement":"593","replies":1830},{"announcement":"593","replies":1832},{"announcement":"593","replies":1834},{"announcement":"593","replies":1835},{"announcement":"593","replies":1836},{"announcement":"593","replies":1837},{"announcement":"593","replies":1838},{"announcement":"594","replies":1839},{"announcement":"594","replies":1841},{"announcement":"594","replies":1847},{"announcement":"594","replies":1848},{"announcement":"595","replies":1851},{"announcement":"595","replies":1854},{"announcement":"596","replies":1906},{"announcement":"596","replies":1907},{"announcement":"596","replies":"596"},{"announcement":"596","replies":"1908"},{"announcement":"588","replies":1910},{"announcement":"588","replies":1912},{"announcement":"588","replies":1914},{"announcement":"588","replies":1916},{"announcement":"588","replies":1917},{"announcement":"588","replies":1918},{"announcement":"588","replies":1921},{"announcement":"588","replies":1922},{"announcement":"588","replies":1923},{"announcement":"588","replies":1924},{"announcement":"588","replies":1925},{"announcement":"588","replies":1930},{"announcement":"588","replies":1931},{"announcement":"588","replies":1932},{"announcement":"588","replies":1933},{"announcement":"588","replies":1934},{"announcement":"588","replies":1935},{"announcement":"591","replies":1938},{"announcement":"588","replies":1939},{"announcement":"597","replies":1941},{"announcement":"588","replies":1942},{"announcement":"588","replies":1944},{"announcement":"588","replies":1945},{"announcement":"588","replies":1946},{"announcement":"588","replies":1948},{"announcement":"588","replies":1949},{"announcement":"588","replies":1950},{"announcement":"598","replies":1951},{"announcement":"599","replies":1952},{"announcement":"588","replies":1953},{"announcement":"599","replies":1955},{"announcement":"599","replies":1962},{"announcement":"600","replies":1963},{"announcement":"599","replies":1964},{"announcement":"599","replies":1965},{"announcement":"599","replies":1966},{"announcement":"598","replies":1968},{"announcement":"598","replies":1969},{"announcement":"598","replies":1971},{"announcement":"598","replies":1973},{"announcement":"599","replies":1974},{"announcement":"599","replies":1975},{"announcement":"599","replies":1976},{"announcement":"599","replies":1977},{"announcement":"599","replies":1979},{"announcement":"599","replies":1980},{"announcement":"599","replies":1983},{"announcement":"599","replies":1985},{"announcement":"599","replies":1987},{"announcement":"599","replies":1988},{"announcement":"599","replies":1989},{"announcement":"599","replies":1990},{"announcement":"599","replies":1991},{"announcement":"599","replies":1993},{"announcement":"599","replies":1995},{"announcement":"599","replies":1996},{"announcement":"599","replies":1998},{"announcement":"599","replies":1999},{"announcement":"599","replies":2001},{"announcement":"599","replies":2002},{"announcement":"599","replies":2004},{"announcement":"599","replies":2011},{"announcement":"599","replies":2013},{"announcement":"600","replies":2015},{"announcement":"599","replies":2018},{"announcement":"599","replies":2019},{"announcement":"599","replies":2020},{"announcement":"599","replies":2022},{"announcement":"599","replies":2023},{"announcement":"599","replies":2024},{"announcement":"599","replies":2025},{"announcement":"599","replies":2026},{"announcement":"600","replies":2028},{"announcement":"599","replies":2029},{"announcement":"599","replies":2030},{"announcement":"599","replies":2031},{"announcement":"599","replies":2032},{"announcement":"599","replies":2034},{"announcement":"599","replies":2035},{"announcement":"599","replies":2037},{"announcement":"601","replies":2038},{"announcement":"601","replies":2039},{"announcement":"599","replies":2040},{"announcement":"601","replies":2042},{"announcement":"601","replies":2043},{"announcement":"601","replies":2045},{"announcement":"601","replies":2047},{"announcement":"601","replies":2049},{"announcement":"602","replies":2053},{"announcement":"602","replies":2054},{"announcement":"602","replies":2055},{"announcement":"602","replies":2056},{"announcement":"602","replies":2057},{"announcement":"588","replies":2059},{"announcement":"592","replies":2060},{"announcement":"603","replies":2062},{"announcement":"604","replies":2066},{"announcement":"605","replies":2067},{"announcement":"609","replies":2070},{"announcement":"609","replies":2073},{"announcement":"609","replies":2074},{"announcement":"600","replies":2083},{"announcement":"610","replies":2108},{"announcement":"610","replies":2110},{"announcement":"610","replies":2112},{"announcement":"610","replies":2113},{"announcement":"610","replies":2114},{"announcement":"610","replies":2115},{"announcement":"610","replies":2116},{"announcement":"610","replies":2117},{"announcement":"611","replies":2122},{"announcement":"611","replies":2124},{"announcement":"611","replies":2125},{"announcement":"611","replies":2126},{"announcement":"600","replies":2148},{"announcement":"588","replies":2218},{"announcement":"588","replies":2219},{"announcement":"615","replies":2220},{"announcement":"615","replies":2221},{"announcement":"615","replies":2222},{"announcement":"615","replies":2225},{"announcement":"615","replies":2228},{"announcement":"615","replies":2229},{"announcement":"615","replies":2234},{"announcement":"616","replies":2235},{"announcement":"616","replies":2237},{"announcement":"616","replies":2238},{"announcement":"616","replies":2239},{"announcement":"614","replies":2240},{"announcement":"614","replies":2248},{"announcement":"614","replies":2249},{"announcement":"614","replies":2250},{"announcement":"619","replies":2273},{"announcement":"619","replies":2274},{"announcement":"619","replies":2275},{"announcement":"619","replies":2276},{"announcement":"619","replies":2277},{"announcement":"619","replies":2278},{"announcement":"619","replies":2279},{"announcement":"619","replies":2280},{"announcement":"619","replies":2283},{"announcement":"619","replies":2286},{"announcement":"619","replies":2287},{"announcement":"619","replies":2288},{"announcement":"619","replies":2289},{"announcement":"619","replies":2290},{"announcement":"619","replies":2291},{"announcement":"619","replies":2294},{"announcement":"615","replies":2378},{"announcement":"622","replies":2440},{"announcement":"622","replies":2441},{"announcement":"622","replies":2442},{"announcement":"622","replies":2443},{"announcement":"622","replies":2444},{"announcement":"623","replies":2446},{"announcement":"623","replies":2447},{"announcement":"623","replies":2448},{"announcement":"623","replies":2449},{"announcement":"623","replies":2450},{"announcement":"623","replies":2451},{"announcement":"623","replies":2452},{"announcement":"623","replies":2453},{"announcement":"623","replies":2454},{"announcement":"623","replies":2455},{"announcement":"623","replies":2456},{"announcement":"623","replies":2457},{"announcement":"623","replies":2458},{"announcement":"623","replies":2459},{"announcement":"623","replies":2460},{"announcement":"623","replies":2461},{"announcement":"623","replies":2462},{"announcement":"623","replies":2463},{"announcement":"623","replies":2464},{"announcement":"623","replies":2465},{"announcement":"623","replies":2466},{"announcement":"623","replies":2467},{"announcement":"623","replies":2468},{"announcement":"623","replies":2469},{"announcement":"623","replies":2470},{"announcement":"623","replies":2471},{"announcement":"623","replies":2472},{"announcement":"623","replies":2473},{"announcement":"623","replies":2474},{"announcement":"623","replies":2475},{"announcement":"623","replies":2476},{"announcement":"623","replies":2477},{"announcement":"623","replies":2478},{"announcement":"624","replies":2479},{"announcement":"624","replies":2480},{"announcement":"624","replies":2481},{"announcement":"624","replies":2482},{"announcement":"624","replies":2483},{"announcement":"624","replies":2484},{"announcement":"624","replies":2485},{"announcement":"621","replies":2503},{"announcement":"629","replies":2550},{"announcement":"628","replies":2551},{"announcement":"633","replies":2556},{"announcement":"633","replies":2558}]', '[{"comment":"107","replies":774},{"comment":"108","replies":854},{"comment":"108","replies":855},{"comment":"108","replies":856},{"comment":"108","replies":857},{"comment":"108","replies":858},{"comment":"108","replies":859},{"comment":"108","replies":860},{"comment":"108","replies":861},{"comment":"108","replies":862},{"comment":"108","replies":863},{"comment":"108","replies":864},{"comment":"108","replies":865},{"comment":"108","replies":866},{"comment":"108","replies":867},{"comment":"108","replies":868},{"comment":"109","replies":915},{"comment":"109","replies":916},{"comment":"109","replies":917},{"comment":"109","replies":919},{"comment":"109","replies":920},{"comment":"109","replies":921},{"comment":"109","replies":922},{"comment":"110","replies":923},{"comment":"110","replies":926},{"comment":"110","replies":927},{"comment":"110","replies":929},{"comment":"110","replies":930},{"comment":"110","replies":931},{"comment":"110","replies":932},{"comment":"110","replies":938},{"comment":"110","replies":940},{"comment":"110","replies":941},{"comment":"110","replies":943},{"comment":"108","replies":955},{"comment":"108","replies":956},{"comment":"108","replies":957},{"comment":"108","replies":958},{"comment":"108","replies":960},{"comment":"108","replies":961},{"comment":"108","replies":1012},{"comment":"108","replies":1013},{"comment":"108","replies":1014},{"comment":"104","replies":1015},{"comment":"104","replies":1016},{"comment":"81","replies":1019},{"comment":"81","replies":1020},{"comment":"108","replies":1056},{"comment":"108","replies":1057},{"comment":"108","replies":1058},{"comment":"108","replies":1061},{"comment":"108","replies":1062},{"comment":"108","replies":1063},{"comment":"108","replies":1174},{"comment":"108","replies":1175},{"comment":"108","replies":1176},{"comment":"108","replies":1177},{"comment":"108","replies":1180},{"comment":"108","replies":1181},{"comment":"108","replies":1182},{"comment":"108","replies":1183},{"comment":"108","replies":1184},{"comment":"108","replies":1185},{"comment":"108","replies":1186},{"comment":"108","replies":1187},{"comment":"108","replies":1188},{"comment":"108","replies":1189},{"comment":"108","replies":1190},{"comment":"108","replies":1191},{"comment":"108","replies":1192},{"comment":"108","replies":1193},{"comment":"108","replies":1194},{"comment":"108","replies":1195},{"comment":"114","replies":1200},{"comment":"114","replies":1201},{"comment":"114","replies":1202},{"comment":"114","replies":1203},{"comment":"114","replies":1204},{"comment":"114","replies":1205},{"comment":"114","replies":1206},{"comment":"114","replies":1207},{"comment":"114","replies":1208},{"comment":"114","replies":1209},{"comment":"114","replies":1210},{"comment":"108","replies":1226},{"comment":"108","replies":1227},{"comment":"108","replies":1228},{"comment":"108","replies":1229},{"comment":"108","replies":1230},{"comment":"108","replies":1232},{"comment":"108","replies":1233},{"comment":"108","replies":1234},{"comment":"108","replies":1238},{"comment":"108","replies":1241},{"comment":"108","replies":1242},{"comment":"108","replies":1243},{"comment":"108","replies":1251},{"comment":"108","replies":1267},{"comment":"108","replies":1268},{"comment":"108","replies":1269},{"comment":"108","replies":1270},{"comment":"108","replies":1271},{"comment":"108","replies":1272},{"comment":"108","replies":1285},{"comment":"108","replies":1286},{"comment":"108","replies":1287},{"comment":"108","replies":1288},{"comment":"108","replies":1289},{"comment":"108","replies":1290},{"comment":"108","replies":1291},{"comment":"108","replies":1292},{"comment":"108","replies":1293},{"comment":"108","replies":1294},{"comment":"108","replies":1295},{"comment":"108","replies":1313},{"comment":"108","replies":1326},{"comment":"108","replies":1327},{"comment":"108","replies":1331},{"comment":"108","replies":1333},{"comment":"108","replies":1334},{"comment":"108","replies":1336},{"comment":"108","replies":1339},{"comment":"108","replies":1345},{"comment":"108","replies":1346},{"comment":"108","replies":1347},{"comment":"108","replies":1348},{"comment":"108","replies":1350},{"comment":"108","replies":1351},{"comment":"108","replies":1352},{"comment":"108","replies":1353},{"comment":"108","replies":1354},{"comment":"108","replies":1355},{"comment":"108","replies":1356},{"comment":"108","replies":1357},{"comment":"108","replies":1358},{"comment":"108","replies":1363},{"comment":"108","replies":1365},{"comment":"108","replies":1367},{"comment":"108","replies":1369},{"comment":"108","replies":1370},{"comment":"108","replies":1371},{"comment":"108","replies":1372},{"comment":"108","replies":1373},{"comment":"108","replies":1374},{"comment":"108","replies":1375},{"comment":"108","replies":1376},{"comment":"108","replies":1377},{"comment":"108","replies":1378},{"comment":"108","replies":1379},{"comment":"108","replies":1380},{"comment":"108","replies":1381},{"comment":"108","replies":1387},{"comment":"108","replies":1388},{"comment":"108","replies":1389},{"comment":"108","replies":1390},{"comment":"108","replies":1444},{"comment":"108","replies":1445},{"comment":"108","replies":1446},{"comment":"108","replies":1447},{"comment":"113","replies":1448},{"comment":"113","replies":1449},{"comment":"108","replies":1529},{"comment":"108","replies":1530},{"comment":"108","replies":1531},{"comment":"108","replies":1532},{"comment":"108","replies":1616},{"comment":"123","replies":1641},{"comment":"123","replies":1647},{"comment":"123","replies":1648},{"comment":"123","replies":1649},{"comment":"124","replies":1650},{"comment":"124","replies":1651},{"comment":"124","replies":1653},{"comment":"124","replies":1654},{"comment":"124","replies":1655},{"comment":"124","replies":1656},{"comment":"124","replies":1657},{"comment":"124","replies":1658},{"comment":"124","replies":1659},{"comment":"124","replies":1660},{"comment":"124","replies":1661},{"comment":"124","replies":1662},{"comment":"124","replies":1663},{"comment":"124","replies":1664},{"comment":"124","replies":1665},{"comment":"124","replies":1666},{"comment":"124","replies":1667},{"comment":"124","replies":1668},{"comment":"124","replies":1669},{"comment":"124","replies":1670},{"comment":"124","replies":1679},{"comment":"124","replies":1680},{"comment":"124","replies":1681},{"comment":"124","replies":1682},{"comment":"124","replies":1683},{"comment":"124","replies":1684},{"comment":"124","replies":1685},{"comment":"123","replies":1686},{"comment":"123","replies":1688},{"comment":"124","replies":1690},{"comment":"124","replies":1691},{"comment":"124","replies":1692},{"comment":"124","replies":1693},{"comment":"124","replies":1694},{"comment":"124","replies":1695},{"comment":"123","replies":1696},{"comment":"123","replies":1697},{"comment":"124","replies":1699},{"comment":"124","replies":1700},{"comment":"124","replies":1701},{"comment":"124","replies":1702},{"comment":"124","replies":1703},{"comment":"124","replies":1704},{"comment":"124","replies":1705},{"comment":"124","replies":1706},{"comment":"124","replies":1707},{"comment":"124","replies":1708},{"comment":"124","replies":1709},{"comment":"124","replies":1710},{"comment":"124","replies":1711},{"comment":"124","replies":1712},{"comment":"124","replies":1713},{"comment":"124","replies":1714},{"comment":"124","replies":1715},{"comment":"124","replies":1716},{"comment":"124","replies":1717},{"comment":"124","replies":1720},{"comment":"124","replies":1721},{"comment":"124","replies":1725},{"comment":"124","replies":1726},{"comment":"124","replies":1727},{"comment":"124","replies":1728},{"comment":"124","replies":1729},{"comment":"124","replies":1730},{"comment":"124","replies":1731},{"comment":"124","replies":1732},{"comment":"124","replies":1733},{"comment":"124","replies":1734},{"comment":"124","replies":1735},{"comment":"124","replies":1736},{"comment":"124","replies":1738},{"comment":"124","replies":1739},{"comment":"124","replies":1740},{"comment":"124","replies":1741},{"comment":"124","replies":1742},{"comment":"124","replies":1743},{"comment":"124","replies":1744},{"comment":"124","replies":1745},{"comment":"124","replies":1746},{"comment":"124","replies":1747},{"comment":"124","replies":1748},{"comment":"124","replies":1749},{"comment":"124","replies":1750},{"comment":"124","replies":1751},{"comment":"124","replies":1752},{"comment":"124","replies":1758},{"comment":"129","replies":1776},{"comment":"129","replies":1779},{"comment":"129","replies":1780},{"comment":"129","replies":1782},{"comment":"129","replies":1783},{"comment":"129","replies":1784},{"comment":"129","replies":1785},{"comment":"129","replies":1786},{"comment":"129","replies":1790},{"comment":"129","replies":1793},{"comment":"129","replies":1794},{"comment":"129","replies":1795},{"comment":"129","replies":1801},{"comment":"129","replies":1802},{"comment":"129","replies":1803},{"comment":"129","replies":1804},{"comment":"129","replies":1805},{"comment":"127","replies":1806},{"comment":"127","replies":1807},{"comment":"127","replies":1808},{"comment":"127","replies":1810},{"comment":"131","replies":1827},{"comment":"130","replies":1828},{"comment":"132","replies":1857},{"comment":"132","replies":1858},{"comment":"132","replies":1859},{"comment":"132","replies":1864},{"comment":"132","replies":1865},{"comment":"132","replies":1866},{"comment":"133","replies":1874},{"comment":"133","replies":1875},{"comment":"133","replies":1876},{"comment":"133","replies":1877},{"comment":"133","replies":1879},{"comment":"133","replies":1881},{"comment":"133","replies":1882},{"comment":"134","replies":1884},{"comment":"134","replies":1885},{"comment":"134","replies":1886},{"comment":"134","replies":1887},{"comment":"134","replies":1889},{"comment":"134","replies":1890},{"comment":"135","replies":1898},{"comment":"135","replies":1899},{"comment":"135","replies":1905},{"comment":"135","replies":1936},{"comment":"134","replies":1937},{"comment":"134","replies":1997},{"comment":"134","replies":2000},{"comment":"134","replies":2012},{"comment":"134","replies":2014},{"comment":"134","replies":2021},{"comment":"134","replies":2027},{"comment":"134","replies":2033},{"comment":"134","replies":2036},{"comment":"134","replies":2041},{"comment":"134","replies":2044},{"comment":"134","replies":2046},{"comment":"134","replies":2048},{"comment":"134","replies":2051},{"comment":"135","replies":2071},{"comment":"136","replies":2072},{"comment":"140","replies":2078},{"comment":"140","replies":2079},{"comment":"140","replies":2080},{"comment":"140","replies":2081},{"comment":"140","replies":2082},{"comment":"145","replies":2089},{"comment":"145","replies":2090},{"comment":"145","replies":2092},{"comment":"145","replies":2094},{"comment":"145","replies":2096},{"comment":"145","replies":2097},{"comment":"145","replies":2099},{"comment":"145","replies":2102},{"comment":"145","replies":2103},{"comment":"145","replies":2106},{"comment":"143","replies":2129},{"comment":"143","replies":2131},{"comment":"143","replies":2132},{"comment":"142","replies":2133},{"comment":"142","replies":2135},{"comment":"142","replies":2136},{"comment":"142","replies":2137},{"comment":"142","replies":2138},{"comment":"145","replies":2141},{"comment":"145","replies":2142},{"comment":"145","replies":2143},{"comment":"145","replies":2147},{"comment":"145","replies":2155},{"comment":"146","replies":2159},{"comment":"147","replies":2160},{"comment":"151","replies":2261},{"comment":"151","replies":2262},{"comment":"151","replies":2263},{"comment":"151","replies":2265},{"comment":"153","replies":2316},{"comment":"153","replies":2317},{"comment":"153","replies":2318},{"comment":"153","replies":2319},{"comment":"153","replies":2320},{"comment":"153","replies":2321},{"comment":"153","replies":2322},{"comment":"153","replies":2324},{"comment":"153","replies":2325},{"comment":"153","replies":2326},{"comment":"153","replies":2327},{"comment":"153","replies":2328},{"comment":"153","replies":2329},{"comment":"153","replies":2330},{"comment":"153","replies":2331},{"comment":"153","replies":2332},{"comment":"153","replies":2334},{"comment":"153","replies":2335},{"comment":"153","replies":2340},{"comment":"153","replies":2341},{"comment":"153","replies":2342},{"comment":"152","replies":2343},{"comment":"152","replies":2344},{"comment":"152","replies":2345},{"comment":"153","replies":2346},{"comment":"153","replies":2347},{"comment":"152","replies":2348},{"comment":"153","replies":2354},{"comment":"152","replies":2355},{"comment":"152","replies":2357},{"comment":"153","replies":2358},{"comment":"153","replies":2359},{"comment":"152","replies":2360},{"comment":"152","replies":2361},{"comment":"153","replies":2362},{"comment":"153","replies":2363},{"comment":"152","replies":2364},{"comment":"152","replies":2367},{"comment":"153","replies":2368},{"comment":"153","replies":2372},{"comment":"153","replies":2375},{"comment":"164","replies":2411},{"comment":"146","replies":2412},{"comment":"146","replies":2413},{"comment":"164","replies":2414},{"comment":"150","replies":2430},{"comment":"150","replies":2432},{"comment":"150","replies":2434},{"comment":"150","replies":2491},{"comment":"150","replies":2492},{"comment":"150","replies":2493},{"comment":"150","replies":2494},{"comment":"150","replies":2495},{"comment":"150","replies":2496},{"comment":"150","replies":2497},{"comment":"150","replies":2498},{"comment":"150","replies":2499},{"comment":"150","replies":2500},{"comment":"143","replies":2506},{"comment":"162","replies":2547},{"comment":"162","replies":2548},{"comment":"162","replies":2549},{"comment":"162","replies":2552},{"comment":"162","replies":2553},{"comment":"162","replies":2554}]', ''),
(3, 'cody@gmail.com', '$2a$08$3rD9IKTDUY44KT6LgZRefu60aO681FZCUeHu4eJN5U8UWRc7/waJe', NULL, '2015-08-08 09:35:15', NULL, 0, NULL, NULL, NULL, NULL, '2015-08-08 09:33:00', '2015-09-21 09:42:29', '12046680_10153249354692746_468853144829428122_n.jpg', 'http://113.160.225.87:8484/assets/images/users/12046680_10153249354692746_468853144829428122_n.jpg', NULL, NULL, 'Akos', 'Nguyen', 1, 2, 'Normal', 1, 0, '', '1;3', '4;1', '', '', ''),
(10, 'asd@enclace.vn', '$2a$08$OYGqA68pd.D2hFKQCakDUe.nd.t0HrpgizSVPKQQPl4IT0GuRnwca', NULL, '2015-08-08 09:26:28', '2015-08-08 09:26:28', 0, '2015-08-08 09:26:28', '2015-08-08 09:26:28', NULL, '2015-08-08 09:26:28', '2015-08-08 09:26:28', '2015-09-15 03:55:53', 'huyc.png', 'http://113.160.225.87:8484/assets/images/users/huyc.png', NULL, '2015-08-08 09:26:28', 'Terry', 'Thanh', 1, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam dignissim nulla at arcu dignissim placerat. Morbi maximus purus a semper posuere. Pellentesque varius lacinia nibh, a interdum purus dictum ut. Praesent hendrerit, est eu cursus dignissim, purus est feugiat velit, a convallis dui augue non enim. Nullam efficitur quam a ligula pretium sagittis. Vivamus accumsan viverra risus eu scelerisque. Mauris consequat accumsan diam, id efficitur nisi consequat non. Aliquam vulputate finibus nulla et tincidunt.\r\n\r\nCurabitur pulvinar pulvinar ex quis semper. Duis nec lorem eu felis vehicula accumsan. Sed non lectus pellentesque, gravida ante a, cursus est. Pellentesque viverra dolor sit amet dolor elementum lobortis. Suspendisse volutpat justo non arcu ullamcorper fringilla. Cras in ullamcorper ante. Donec eget vehicula elit. Donec dictum enim id orci sodales finibus. Etiam vitae nisl et elit egestas molestie. Pellentesque posuere laoreet elit sit amet suscipit. Mauris ut quam rhoncus, pharetra lectus at, cursus orci. Phasellus efficitur tempor sapien ac accumsan. Quisque eros libero, bibendum sit amet nibh vel, porttitor venenatis dolor. Donec dui velit, tincidunt et felis sed, mollis tempus nisl. Fusce vitae turpis id risus placerat lacinia eget sit amet turpis. Pellentesque vehicula quam quis ante porta, eget aliquam tellus blandit.', 0, 0, '5aee8f2a879d58be6d063caf5ca68016caa8e51be6ee687a411fa034103e2e4618e8b2a8e8ebb5e0726e20225e2afbbf6bf77ab4265c995f3b8ea6a2f1c808d5nlJX6QBDYK3IJtzvBLmHdNfgZKJeHinuwC7YMdr1ELk=', '', '', '', '', ''),
(15, 'test@enclave.vn', '$2a$08$laMBAOYdnxDU1PXjRMZifOjrM2IrJLW0k..nOgZcS2uBe3Shg7IFu', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '2015-10-16 04:23:49', 'default-avatar411.png', 'http://113.160.225.87:8484/assets/images/users/default-avatar411.png', NULL, NULL, 'Test 0', 'Enclave', 5, 2, '', 1, 0, '3aabbc4a1051cb48a264a228b85d353be5cfd928195d3fd24705541696662ee404aa671faff779e743b546d290badc16cae77a0ecbba114c31d9e31696e69d1cSHBQX3y/LuuIH2pelcMUyV7fAAvQyW9tw2ER3TWDA60=', '596;600;621;625;0;626;627', '155;156;157;158;159;169', '[{"announcement":"600","replies":"600;1963;1978;1981;1982;1984;1986"},{"announcement":"588","replies":"588;1759;1760;1761;1762;1763"},{"announcement":"588","replies":"1764;1799;1800;1821;1824;1855;1856;1869;1925;1926;1927;1928;1929;1930;1931;1946;1947;1948;1949;1950;1953;2059;2176"},{"announcement":"596","replies":"596;1906;1907;1908;1909"},{"announcement":"596","replies":2194},{"announcement":"596","replies":2195},{"announcement":"600","replies":2196},{"announcement":"600","replies":"1992;2015;2028;2069;2083;2148"},{"announcement":"588","replies":"1772;1773;1798;1897;1910;1911;1912;1913;1914;1915;1916;1917;1918;1919;1920;1921;1922;1923;1924;1932;1933;1934;1935;1939;1942;1943;1944;1945"},{"announcement":"588","replies":2198},{"announcement":"588","replies":2199},{"announcement":"588","replies":2200},{"announcement":"588","replies":2201},{"announcement":"596","replies":2204},{"announcement":"596","replies":2205},{"announcement":"596","replies":2206},{"announcement":"596","replies":2209},{"announcement":"596","replies":"2207"},{"announcement":"600","replies":"2202"},{"announcement":"588","replies":"2215;2218;2219;2246;2247;2398;2399;2400;2401;2408;2409;2410;2411;2412;2413;2414;2415;2416;2417;2418;2445"},{"announcement":"621","replies":"2488;2502;2503;2504"},{"announcement":"626","replies":2534},{"announcement":"621","replies":2535},{"announcement":"621","replies":2536},{"announcement":"621","replies":2537},{"announcement":"621","replies":2538},{"announcement":"621","replies":2539},{"announcement":"621","replies":2540},{"announcement":"621","replies":2541},{"announcement":"621","replies":2542},{"announcement":"621","replies":2543},{"announcement":"621","replies":"2511"},{"announcement":"600","replies":"2211"}]', '[{"comment":"159","replies":"159"},{"comment":"157","replies":"157"},{"comment":"156","replies":2197},{"comment":"158","replies":2507},{"comment":"155","replies":2528},{"comment":"155","replies":2529},{"comment":"155","replies":2530},{"comment":"156","replies":2531},{"comment":"156","replies":2532},{"comment":"156","replies":2533},{"comment":"158","replies":2544}]', 'lFrf1DMPm1o:APA91bHPzNpFOSJ9zzy6cCrLFqjsZvTP802sUcZoY2KrXhreKNvPaavmWj9XhuU1tLFzvVOYVo8KNBgGBN-myM_l44WY_mtLVTu4v7-ZdMFWlrKrhgwE-_96JxJTkOl0gdZR2sJKwWD1'),
(16, 'test_vegan@enclave.vn', '$2a$08$t12Yes2j6QpSZeHqSOWMkuKhw5z0obnSN4GTV9qFYZ7I70rx/imDS', NULL, '2015-08-26 09:25:35', NULL, 0, NULL, NULL, NULL, NULL, NULL, '2015-09-15 06:25:25', 'thanhc.png', 'http://113.160.225.87:8484/assets/images/users/thanhc.png', NULL, NULL, 'Test Vegan', 'Test Vegan', 1, 2, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam dignissim nulla at arcu dignissim placerat. Morbi maximus purus a semper posuere. Pellentesque varius lacinia nibh, a interdum purus dictum ut. Praesent hendrerit, est eu cursus dignissim, purus est feugiat velit, a convallis dui augue non enim. Nullam efficitur quam a ligula pretium sagittis. Vivamus accumsan viverra risus eu scelerisque. Mauris consequat accumsan diam, id efficitur nisi consequat non. Aliquam vulputate finibus nulla et tincidunt.\r\n\r\nCurabitur pulvinar pulvinar ex quis semper. Duis nec lorem eu felis vehicula accumsan. Sed non lectus pellentesque, gravida ante a, cursus est. Pellentesque viverra dolor sit amet dolor elementum lobortis. Suspendisse volutpat justo non arcu ullamcorper fringilla. Cras in ullamcorper ante. Donec eget vehicula elit. Donec dictum enim id orci sodales finibus. Etiam vitae nisl et elit egestas molestie. Pellentesque posuere laoreet elit sit amet suscipit. Mauris ut quam rhoncus, pharetra lectus at, cursus orci. Phasellus efficitur tempor sapien ac accumsan. Quisque eros libero, bibendum sit amet nibh vel, porttitor venenatis dolor. Donec dui velit, tincidunt et felis sed, mollis tempus nisl. Fusce vitae turpis id risus placerat lacinia eget sit amet turpis. Pellentesque vehicula quam quis ante porta, eget aliquam tellus blandit.', 1, 0, 'bbd837ea3a3fba59bc29fda960c12cb19b70c4baa77496b6a11c1824ed8c6484d20e889466d57c7137826aed8a4269d07a79d8f86df736133f2587170f9f981d1hd6sFw1ANFJhA0HlmwIfOnFIsRVQ6tgnkQh9KuNB1g=', '', '', '', '', '');
INSERT INTO `users` (`id`, `email`, `encrypted_password`, `reset_password_token`, `reset_password_sent_at`, `remember_created_at`, `sign_in_count`, `current_sign_in_at`, `last_sign_in_at`, `confirmation_token`, `confirmation_sent_at`, `created_at`, `updated_at`, `avatar_file_name`, `avatar_content_file`, `avatar_file_size`, `avatar_updated_at`, `first_name`, `last_name`, `floor_id`, `shift_id`, `what_taste`, `want_vegan_meal`, `admin`, `authentication_token`, `read_announcements`, `read_comments`, `read_replies_announcements`, `read_replies_comments`, `gcm_regid`) VALUES
(29, 'pax@enclave.vn', '$2a$08$3Vk5O0Jhlufw8W.Rk/VxvOUURmann0YRHbeQrZpuO8WJEyEl8QR8q', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '2015-11-06 04:01:03', 'rsz_1skypeimage.jpg', 'http://113.160.225.87:8484/assets/images/users/rsz_1skypeimage.jpg', NULL, NULL, 'Pax', 'Pax', 1, 2, 'litle fhhvghjnnmkhhgghdhjdjff.  kkk', 1, 0, '3bb65e8d5bee95121b65efc9b6b744d0ea0708068cd5658d30e9a16b027caa6162fef6d3408153ffeb8eb5d3f69d2f2e6c8da579884525df7029465c122fc59fdhBrQxJiBrsk1MrKcE0FrEGUuGe1CG5KJfY6P5UMCEo=', '619;617;600;279;603;596;618;599;588;621;625;626;630', '153;152;138;151;139;137;131;130;159;160;161;171', '[{"announcement":"619","replies":"2280;2279;2278;2277;2276;2275;2274;2273"},{"announcement":"619","replies":2352},{"announcement":"600","replies":"2202;2271;2264;2069;2371;2266;2314;2260;2315;1981;1982;2381;2256;2196;2257;1978;2255;2386;2028;1963;2015;2083;1986;2285;2148;2284;1984;2211;1992;2214;2213;2272;2212"},{"announcement":"619","replies":"2289;2288;2290;2287;2291;2294;2286;2283"},{"announcement":"603","replies":"2064;2061;2062;2063"},{"announcement":"596","replies":"2204;2205;2206;2207;2194;1907;2195;1906;1909;1908;2258;2259;2388;2282;2209;2208;2394;2393;2333;2392"},{"announcement":"599","replies":2395},{"announcement":"599","replies":2396},{"announcement":"599","replies":"2032;2034;2035;2037;2040;2017;2016;2019;2018;2020;2023;2022;2025;2024;2026;2029;2031;2030;2002;2003;2001;2006;2007;2004;2005;2010;2011;2008;2009;2013;1987;1985;1991;1990;1989;1988;1995;1993;1999;1998;1996;1974;1975;1980;1983;1976;1977;1979;1957;1956;1959;1958;1952;1955;1954;1965;1964;1966;1961;1960;1962"},{"announcement":"588","replies":2398},{"announcement":"588","replies":2399},{"announcement":"588","replies":2400},{"announcement":"588","replies":"2200;1913;1763;2201;1912;1762;1915;1761;1914;1760;1917;1916;1919;1918;1764;2198;1911;1773;2199;1910;1772;1897;2176;2059;2219;2218;1869;1856;2215;1759;1855;1953;2247;2246;1824;1942;1943;1821;1939;1950;1948;1949;1946;1947;1944;1945;1927;1926;1925;1924;1923;1922;1921;1800;1920;1935;1798;1934;1799;1933;1932;1931;1930;1929;1928"},{"announcement":"588","replies":2401},{"announcement":"599","replies":2402},{"announcement":"596","replies":2403},{"announcement":"596","replies":2404},{"announcement":"596","replies":2405},{"announcement":"596","replies":2406},{"announcement":"596","replies":2407},{"announcement":"588","replies":2408},{"announcement":"588","replies":2409},{"announcement":"588","replies":2410},{"announcement":"588","replies":2411},{"announcement":"588","replies":2412},{"announcement":"588","replies":2413},{"announcement":"588","replies":2414},{"announcement":"588","replies":2415},{"announcement":"588","replies":2416},{"announcement":"588","replies":2417},{"announcement":"588","replies":2418},{"announcement":"599","replies":2422},{"announcement":"599","replies":2423},{"announcement":"599","replies":2424},{"announcement":"599","replies":2425},{"announcement":"617","replies":2426},{"announcement":"617","replies":2427},{"announcement":"621","replies":"2503;2488;2502;2504"},{"announcement":"600","replies":"2501"},{"announcement":"621","replies":2511},{"announcement":"600","replies":2520},{"announcement":"600","replies":2521},{"announcement":"600","replies":"2519"},{"announcement":"596","replies":"2513;2512"},{"announcement":"588","replies":"2515;2514;2516;2517;2445"},{"announcement":"600","replies":"2526"},{"announcement":"626","replies":"2534"},{"announcement":"621","replies":"2541;2535;2537;2542;2539;2536;2543;2540;2538"}]', '[{"comment":"153","replies":"2318;2319;2316;2317;2253;2322;2252;2321;2320;2254;2327;2326;2325;2251;2324;2331;2330;2329;2328;2332"},{"comment":"153","replies":"2334"},{"comment":"153","replies":2336},{"comment":"153","replies":2337},{"comment":"153","replies":2338},{"comment":"153","replies":2339},{"comment":"153","replies":"2335"},{"comment":"153","replies":"2340"},{"comment":"153","replies":"2341"},{"comment":"153","replies":"2342"},{"comment":"152","replies":"2343"},{"comment":"152","replies":"2344"},{"comment":"152","replies":"2345"},{"comment":"153","replies":"2346"},{"comment":"152","replies":"2348"},{"comment":"153","replies":"2347"},{"comment":"152","replies":"2355"},{"comment":"153","replies":"2354"},{"comment":"153","replies":"2358"},{"comment":"153","replies":"2359"},{"comment":"152","replies":"2360;2357"},{"comment":"152","replies":"2361"},{"comment":"153","replies":"2362"},{"comment":"152","replies":"2364"},{"comment":"153","replies":"2363"},{"comment":"153","replies":"2368"},{"comment":"152","replies":"2367"},{"comment":"151","replies":"2265;2261;2262;2263"},{"comment":"153","replies":"2375;2372"},{"comment":"153","replies":2387},{"comment":"153","replies":2395},{"comment":"153","replies":2396},{"comment":"153","replies":2397},{"comment":"153","replies":2398},{"comment":"153","replies":2399},{"comment":"153","replies":2400},{"comment":"153","replies":2401},{"comment":"153","replies":2403},{"comment":"153","replies":2404},{"comment":"153","replies":2405},{"comment":"153","replies":2406},{"comment":"131","replies":"2076;1827"},{"comment":"130","replies":"1828"},{"comment":"153","replies":2407},{"comment":"153","replies":2408},{"comment":"153","replies":2409},{"comment":"153","replies":2410},{"comment":"131","replies":2436},{"comment":"137","replies":2437},{"comment":"137","replies":2508},{"comment":"137","replies":2509},{"comment":"138","replies":2510},{"comment":"159","replies":2523},{"comment":"159","replies":2524},{"comment":"139","replies":2525},{"comment":"161","replies":2527},{"comment":"159","replies":2569},{"comment":"159","replies":2570},{"comment":"160","replies":2575}]', ''),
(30, 'brian@enclave.vn', '$2a$08$no2ijm6x8983PQ51dlQYHOiBcIu6EpojQt1oKUOPm4fqcLKrjOgxm', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '2015-11-02 01:40:15', 'imgo4.jpg', 'http://113.160.225.87:8484/assets/images/users/imgo4.jpg', NULL, NULL, 'Brian', 'Brian', 2, 2, '', 1, 0, 'a72813b354a891e7cfa36c288e8daaa44262a477a50f495870cedb8091fba6ce5e6d0b3d57234d2cdb25c0fecbc45003f55159c58c6dd3f158d157280e6b15a4Avl3TE/p6XHXsnHMQujEyyveI9c8u3yeJ6y70Zh7d3Q=', '64;63;613;588;600;596;630', '39;38;160;162', '[{"announcement":"64","replies":"588;587;590;586;589"},{"announcement":"600","replies":"600;1963;1978;1981;1982;1984;1986"},{"announcement":"588","replies":"588;1759;1760;1761;1762;1763;1764"},{"announcement":"600","replies":"1992"},{"announcement":"600","replies":"2015"},{"announcement":"600","replies":"2028"},{"announcement":"596","replies":"596;1906;1907;1908;1909"},{"announcement":"588","replies":"1772"},{"announcement":"600","replies":"2069;2083"},{"announcement":"600","replies":"2148"},{"announcement":"596","replies":2207},{"announcement":"596","replies":2208},{"announcement":"596","replies":"2194;2195;2204;2205;2206"},{"announcement":"600","replies":2211},{"announcement":"600","replies":2212},{"announcement":"600","replies":"2196;2202"},{"announcement":"596","replies":"2209"},{"announcement":"588","replies":"1773;1798;1799;1800;1821;1824;1855;1856;1869;1897;1910;1911;1912;1913;1914;1915;1916;1917;1918;1919;1920;1921;1922;1923;1924;1925;1926;1927;1928;1929;1930;1931;1932;1933;1934;1935;1939;1942;1943;1944;1945;1946;1947;1948;1949;1950;1953;2059;2176;2198;2199;2200;2201"},{"announcement":"600","replies":"2213;2214"},{"announcement":"588","replies":2215},{"announcement":"613","replies":"613"},{"announcement":"613","replies":2242},{"announcement":"613","replies":2243},{"announcement":"613","replies":2244},{"announcement":"613","replies":2245},{"announcement":"588","replies":2246},{"announcement":"588","replies":2247},{"announcement":"588","replies":"2218;2219"},{"announcement":"600","replies":"2255;2256;2257;2260;2264;2266;2271;2272"},{"announcement":"596","replies":"2258;2259"},{"announcement":"596","replies":2333},{"announcement":"600","replies":"2284;2285;2314;2315;2371;2381"},{"announcement":"596","replies":"2282"},{"announcement":"600","replies":"2386"},{"announcement":"596","replies":"2388"},{"announcement":"596","replies":2392},{"announcement":"596","replies":2393},{"announcement":"596","replies":2394},{"announcement":"588","replies":"2398;2399;2400;2401;2408;2409;2410;2411;2412;2413;2414;2415;2416;2417;2418"},{"announcement":"596","replies":"2403;2404;2405;2406;2407"},{"announcement":"588","replies":2445},{"announcement":"600","replies":2526},{"announcement":"630","replies":2571},{"announcement":"629","replies":2572},{"announcement":"629","replies":2573},{"announcement":"629","replies":2574},{"announcement":"629","replies":"2550"},{"announcement":"596","replies":"2512;2513"}]', '[{"comment":"39","replies":"55"},{"comment":"38","replies":"54"},{"comment":"160","replies":2210},{"comment":"160","replies":"160"},{"comment":"162","replies":"162"}]', ''),
(40, 'talon@enclave.vn', '$2a$08$W2lMruTDdNxMaeEJRBq8Qez/jX7ep7EYB8Fee3qJiyF5sAkuYw0ji', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'http://113.160.225.87:8484/assets/images/users/download_(1).jpg', NULL, NULL, 'Carrick', 'Thanh', 1, 2, 'Salty', 0, 0, '1c96679fc6c03b2ba4006780cbc3f0ee84df0eb1265c6388df768c3e0271bcb48adc5f8e9814ac4341e08a001f7d211a9e6b388927839807e324860773144ebeZRHbhYU6Ijq7X2l516pEariB3hK24Gwon9y6bHwGbr0=', '', '', '', '', ''),
(46, 'nguyennhatcuong.it@gmail.com', '$2a$08$baXKdxdQ2zvQdqebsL0/ne1QhRxarruaDuXvM9eM9VCgnJG5X8fDm', NULL, '2015-08-25 07:16:53', '2015-08-25 07:16:53', 0, '2015-08-25 07:16:53', '2015-08-25 07:16:53', NULL, '2015-08-25 07:16:53', '2015-08-25 07:16:53', '2015-09-15 09:46:08', '10906251_728963490533567_6473881943192600836_n7.jpg', 'http://113.160.225.87:8484/assets/images/users/10906251_728963490533567_6473881943192600836_n7.jpg', NULL, NULL, 'Rooney', 'Wayne', 2, 3, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam dignissim nulla at arcu dignissim placerat. Morbi maximus purus a semper posuere. Pellentesque varius lacinia nibh, a interdum purus dictum ut. Praesent hendrerit, est eu cursus dignissim, purus est feugiat velit, a convallis dui augue non enim. Nullam efficitur quam a ligula pretium sagittis. Vivamus accumsan viverra risus eu scelerisque. Mauris consequat accumsan diam, id efficitur nisi consequat non. Aliquam vulputate finibus nulla et tincidunt.\r\n\r\nCurabitur pulvinar pulvinar ex quis semper. Duis nec lorem eu felis vehicula accumsan. Sed non lectus pellentesque, gravida ante a, cursus est. Pellentesque viverra dolor sit amet dolor elementum lobortis. Suspendisse volutpat justo non arcu ullamcorper fringilla. Cras in ullamcorper ante. Donec eget vehicula elit. Donec dictum enim id orci sodales finibus. Etiam vitae nisl et elit egestas molestie. Pellentesque posuere laoreet elit sit amet suscipit. Mauris ut quam rhoncus, pharetra lectus at, cursus orci. Phasellus efficitur tempor sapien ac accumsan. Quisque eros libero, bibendum sit amet nibh vel, porttitor venenatis dolor. Donec dui velit, tincidunt et felis sed, mollis tempus nisl. Fusce vitae turpis id risus placerat lacinia eget sit amet turpis. Pellentesque vehicula quam quis ante porta, eget aliquam tellus blandit.', 1, 0, 'bbd837ea3a3fba59bc29fda960c12cb19b70c4baa77496b6a11c1824ed8c6484d20e889466d57c7137826aed8a4269d07a79d8f86df736133f2587170f9f981d1hd6sFw1ANFJhA0HlmwIfOnFIsRVQ6tgnkQh9KuNB1g=', '', '', '', '', ''),
(47, 'test_cody@gmail.com', '$2a$08$PU1snZehPQBw/ymzb.S/muFYMKUNIS07.JoXyWOEgmEZ3692Fv5VW', NULL, '2015-09-15 04:18:41', '2015-09-15 04:18:41', 0, '2015-09-15 04:18:41', '2015-09-15 04:18:41', NULL, '2015-09-15 04:18:41', '2015-09-15 04:18:41', '2015-10-15 06:29:35', 'cuongc.png', 'http://113.160.225.87:8484/assets/images/users/cuongc.png', NULL, NULL, 'test_cody', 'Test', 2, 3, 'Normal', 1, 1, '', '', '', '', '', ''),
(48, 'nick@enclave.vn', '$2a$08$QMJzNK4BXMAsu4rxB0zlBenPXJJ1VnHeGSMxPsCyyX9N0sr3RbUTS', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '2015-10-28 02:53:22', 'imgo_(1).jpg', 'http://113.160.225.87:8484/assets/images/users/imgo_(1).jpg', NULL, NULL, 'Nick', 'Nam', 1, 2, 'I''m ITesting hehey M', 1, 0, 'd4584a12ec07125219bdfc33a9f781eeec50a6bc99f5b1c1778a9a8dbe02f751fd6c0d3952bf0f7ac9ef67b1c6b0867d79e1c5df9a2adfb3cc082e7db1f38416EWLjlZgc1OUtleELI4aGtXvA0qkAQfw348ekUS36Olk=', '621;627;630;631;615;629;610;632;633;628;616;626;625;611;620;614;612;600;597;588;589;590;591;592;593;594;596;595', '162;150;147;145;144;143;142;141;164;170', '[{"announcement":"621","replies":"2488;2502;2503;2504;2511;2535;2536;2537;2538;2539;2540;2541;2542;2543"},{"announcement":"615","replies":"2220;2221;2222;2225;2228;2229;2234;2376;2377;2378;2379;2383;2384;2385"},{"announcement":"631","replies":2555},{"announcement":"629","replies":"2550"},{"announcement":"610","replies":"2107;2108;2109;2110;2111;2112;2113;2114;2115;2116;2117;2118;2119;2120;2128;2369;2370"},{"announcement":"633","replies":2557},{"announcement":"633","replies":"2556;2558"},{"announcement":"628","replies":"2546;2551"},{"announcement":"616","replies":"2235;2236;2237;2238;2239"},{"announcement":"626","replies":"2534"},{"announcement":"600","replies":2559},{"announcement":"600","replies":"1963;1978;1981;1982;1984;1986;1992;2015;2028;2069;2083;2148;2196;2202;2211;2212;2213;2214;2255;2256;2257;2260;2264;2266;2271;2272;2284;2285;2314;2315;2371;2381;2386;2501;2519;2520;2521;2526"},{"announcement":"611","replies":"2121;2122;2123;2124;2125;2126;2127;2140;2174;2175"},{"announcement":"633","replies":2560},{"announcement":"633","replies":2561},{"announcement":"620","replies":2562},{"announcement":"620","replies":"2365"},{"announcement":"614","replies":"2240;2248;2249;2250;2389;2391"},{"announcement":"612","replies":"2356;2366"},{"announcement":"597","replies":"1940;1941;1994"},{"announcement":"588","replies":"1759;1760;1761;1762"},{"announcement":"588","replies":"1763;1764;1772;1773;1798;1799;1800;1821;1824;1855;1856;1869;1897;1910;1911;1912;1913;1914;1915;1916;1917;1918;1919;1920;1921;1922;1923;1924;1925;1926;1927;1928;1929;1930;1931;1932;1933;1934;1935;1939;1942;1943;1944;1945;1946;1947;1948;1949;1950;1953;2059;2176;2198;2199;2200;2201;2215;2218;2219;2246;2247;2398;2399;2400;2401;2408;2409;2410;2411;2412;2413;2414;2415;2416;2417;2418;2445;2514;2515;2516;2517"},{"announcement":"589","replies":"1765;1766;1767;1768"},{"announcement":"589","replies":"1769;1770;1771;1774;1775;2518"},{"announcement":"590","replies":"1820;2153;2154"},{"announcement":"591","replies":"1819;1938"},{"announcement":"592","replies":"1811;1812;1813;1814;1815;1816;1817;1818;2060;2353"},{"announcement":"593","replies":"1822;1823;1825;1826;1829;1830;1831;1832;1834;1835;1836;1837;1838"},{"announcement":"594","replies":"1839;1840;1841;1842;1843;1844;1845;1846;1847;1848;1849;1893;1894"},{"announcement":"596","replies":"1906;1907;1908;1909;2194;2195;2204;2205;2206;2207;2208;2209;2258;2259;2282;2333;2388;2392;2393;2394;2403;2404;2405;2406;2407;2512;2513"},{"announcement":"595","replies":"1850;1851;1852;1853;1854;1870;1892;1896;1904"},{"announcement":"633","replies":2568}]', '[{"comment":"162","replies":"2522;2545;2547;2548"},{"comment":"162","replies":"2549;2552;2553;2554"},{"comment":"150","replies":"2167;2169;2177;2178;2181;2183;2190"},{"comment":"150","replies":"2192;2397;2430;2431;2432;2433;2434;2491;2492;2493;2494;2495;2496;2497;2498;2499;2500"},{"comment":"147","replies":2563},{"comment":"147","replies":"2160;2161;2428;2429;2435;2438;2439;2489;2490"},{"comment":"145","replies":"2089;2090;2091;2092;2093;2094;2095;2096;2097;2098;2099;2100;2101;2102;2103;2104;2105;2106;2141;2142;2143;2144;2145;2146;2147;2149;2150;2151;2152;2155;2156;2157;2158;2193;2419;2420;2421"},{"comment":"144","replies":"2085;2086;2087;2088"},{"comment":"143","replies":"2129;2130;2131;2132;2349;2506"},{"comment":"142","replies":"2133;2134;2135;2136;2137;2138;2139"},{"comment":"141","replies":"2164;2165;2350;2351"},{"comment":"162","replies":2564},{"comment":"162","replies":2565},{"comment":"164","replies":2566},{"comment":"147","replies":2567}]', 'lPijcqhh480:APA91bF7Me1fvQ8E1jafjxOODHDeASdJqOaZG0R-8xG3c_5OhShnNphoXjjTKyWjhmiKUfkC6BB40NAHKLCnn-BGcrmVV0jCnoMo6vEYCq82Hj6i6QgRSz0W9DVOzAZu0Hql-JcOu5WK'),
(49, 'test_cody2@gmail.com', '$2a$08$PU1snZehPQBw/ymzb.S/muFYMKUNIS07.JoXyWOEgmEZ3692Fv5VW', NULL, '2015-09-15 04:18:41', '2015-09-15 04:18:41', 0, '2015-09-15 04:18:41', '2015-09-15 04:18:41', NULL, '2015-09-15 04:18:41', '2015-09-15 04:18:41', '2015-11-04 01:44:33', 'cuongc.png', 'http://113.160.225.87:8484/assets/images/users/cuongc.png', NULL, NULL, 'test_cody2', 'Test', 1, 1, 'Normal 2', 1, 1, '', '', '', '', '', ''),
(50, 'dash@enclave.vn', '$2a$08$Mj0DVrAvLL7Ly9gnErWAYeOtWbO4NCA3SoIApaOW96.h0LxgFkmGO', NULL, '2015-10-05 07:51:31', '2015-10-05 07:51:31', 0, '2015-10-05 07:51:31', '2015-10-05 07:51:31', NULL, '2015-10-05 07:51:31', '2015-10-05 07:51:31', '2015-10-14 10:29:44', 'default-avatar5.png', 'http://113.160.225.87:8484/assets/images/users/default-avatar5.png', NULL, NULL, 'Dash', 'Duc', 2, 2, '', 0, 0, '8558d53ac3b0a7d8ff43bf83f8db61edf25200aad072b56ce84f5ee6130c00034d018ee965191b83ee6737cf7b3355e9d47df6e3ba842be040a3d2d680da2278921CWFhOOUjvWu0tBu0Foa8MT6nZWV5me0geWDFedj4=', '0;279;290;301;2799;364;352;349;303;338;335;487;489;586;42;488;486;330;223;2;588;596;600;27991;278;2781;621;622;623;624', '84;114;117;118;119;120;154;161', '[{"announcement":"364","replies":"947"},{"announcement":"338","replies":962},{"announcement":"338","replies":"813;798"},{"announcement":"335","replies":"795;797;776;775;796"},{"announcement":"42","replies":"478;479;476;477;474;475;472;473;500;501;496;497;498;499;493;492;495;494;489;488;491;490;485;1211;484;487;486;481;480;483;482"},{"announcement":"486","replies":"963"},{"announcement":"586","replies":"1538"},{"announcement":"586","replies":1540},{"announcement":"586","replies":"1565;1566"},{"announcement":"488","replies":"1570;1568;1578;1569;1577"},{"announcement":"586","replies":"1595;1614;1613;1615"},{"announcement":"486","replies":"1593;1592;1591"},{"announcement":"338","replies":1630},{"announcement":"338","replies":"1589;1011"},{"announcement":"330","replies":"1575;1573;1574"},{"announcement":"364","replies":"1617"},{"announcement":"223","replies":"699;692"},{"announcement":"2","replies":1631},{"announcement":"2","replies":"169;1583;1586;564;1585;1584;100;565;83;170;186;178"},{"announcement":"588","replies":1821},{"announcement":"588","replies":"1763;1773;1798;1759;1764;1761;1760;1762;1799;1800;1772"},{"announcement":"596","replies":"1908;1909;1907;1906"},{"announcement":"588","replies":"1855;1856;1824;1897;1869"},{"announcement":"588","replies":1911},{"announcement":"588","replies":1913},{"announcement":"588","replies":1915},{"announcement":"588","replies":1920},{"announcement":"588","replies":"1921;1912;1918;1910;1916;1917;1914;1919"},{"announcement":"588","replies":"1922"},{"announcement":"588","replies":"1923"},{"announcement":"588","replies":"1924"},{"announcement":"588","replies":"1925"},{"announcement":"588","replies":1926},{"announcement":"588","replies":1927},{"announcement":"588","replies":"1928"},{"announcement":"588","replies":"1930;1929"},{"announcement":"600","replies":"1992;1986;1984;2069;2015;1982;1963;2028;1978;2083;1981"},{"announcement":"600","replies":"2148"},{"announcement":"588","replies":"1943;1933;1934;1932;1939;1942;1935;1931"},{"announcement":"588","replies":"1946;1950;2059;2176;1948;1945;1953;1944;1947;1949"},{"announcement":"600","replies":"2196"},{"announcement":"600","replies":2202},{"announcement":"600","replies":2213},{"announcement":"600","replies":2214},{"announcement":"600","replies":"2212;2211"},{"announcement":"596","replies":"2208;2205;2194;2195;2204;2209;2207;2206"},{"announcement":"588","replies":"2199;2215;2201;2198;2200"},{"announcement":"600","replies":2255},{"announcement":"600","replies":2256},{"announcement":"600","replies":2257},{"announcement":"596","replies":2258},{"announcement":"596","replies":2259},{"announcement":"600","replies":2260},{"announcement":"600","replies":2264},{"announcement":"600","replies":2266},{"announcement":"600","replies":2271},{"announcement":"600","replies":2272},{"announcement":"596","replies":2282},{"announcement":"600","replies":2284},{"announcement":"600","replies":2285},{"announcement":"600","replies":2314},{"announcement":"600","replies":2315},{"announcement":"596","replies":"2333"},{"announcement":"600","replies":2381},{"announcement":"600","replies":"2371"},{"announcement":"600","replies":2386},{"announcement":"596","replies":2388},{"announcement":"588","replies":"2246;2218;2219;2247"},{"announcement":"588","replies":"2409;2412;2418;2416;2401;2413;2399;2398;2408;2415;2410;2414;2411;2417;2400"},{"announcement":"622","replies":"2440"},{"announcement":"622","replies":"2441"},{"announcement":"622","replies":"2442;2443"},{"announcement":"622","replies":"2444"},{"announcement":"623","replies":"2447;2446"},{"announcement":"623","replies":"2448"},{"announcement":"623","replies":"2449"},{"announcement":"623","replies":"2450"},{"announcement":"623","replies":"2451"},{"announcement":"623","replies":"2453;2452"},{"announcement":"623","replies":"2454;2455"},{"announcement":"623","replies":"2456"},{"announcement":"623","replies":"2457;2458"},{"announcement":"623","replies":"2459"},{"announcement":"596","replies":"2405;2406;2407;2393;2404;2403;2394;2392"},{"announcement":"623","replies":"2467;2460;2463;2466;2465;2464;2462;2461"},{"announcement":"623","replies":"2478;2475;2470;2473;2477;2472;2469;2471;2476;2468;2474"},{"announcement":"624","replies":"2480;2481;2479"},{"announcement":"624","replies":"2482;2483"},{"announcement":"624","replies":"2484;2485"},{"announcement":"624","replies":2486},{"announcement":"624","replies":2487},{"announcement":"621","replies":"2488"},{"announcement":"600","replies":2501},{"announcement":"621","replies":"2502"},{"announcement":"623","replies":2505}]', '[{"comment":"84","replies":777},{"comment":"84","replies":778},{"comment":"84","replies":954},{"comment":"84","replies":994},{"comment":"114","replies":1576},{"comment":"120","replies":1632},{"comment":"120","replies":1633},{"comment":"154","replies":2203},{"comment":"161","replies":2216},{"comment":"161","replies":2223},{"comment":"161","replies":2224},{"comment":"161","replies":2226},{"comment":"161","replies":2227},{"comment":"161","replies":2230},{"comment":"161","replies":2231},{"comment":"161","replies":2232},{"comment":"161","replies":2233},{"comment":"161","replies":2241},{"comment":"161","replies":2267},{"comment":"161","replies":2268},{"comment":"161","replies":2269},{"comment":"161","replies":2270},{"comment":"161","replies":2292},{"comment":"161","replies":2293},{"comment":"161","replies":2295},{"comment":"161","replies":2296},{"comment":"161","replies":2297},{"comment":"161","replies":2298},{"comment":"161","replies":2299},{"comment":"161","replies":2300},{"comment":"161","replies":2301},{"comment":"161","replies":2302},{"comment":"161","replies":2303},{"comment":"161","replies":2304},{"comment":"161","replies":2305},{"comment":"161","replies":2306},{"comment":"161","replies":2307},{"comment":"161","replies":2308},{"comment":"161","replies":2309},{"comment":"161","replies":2310},{"comment":"161","replies":2311},{"comment":"161","replies":2312},{"comment":"161","replies":2313},{"comment":"161","replies":2323},{"comment":"153","replies":"2318;2319;2316;2317;2253;2322;2252;2321;2320;2254;2327;2326;2325;2251;2324;2331;2330;2329;2328;2335;2334;2332;2336;2337;2338;2339;2340;2341;2342;2346;2347;2354;2359;2358"},{"comment":"161","replies":2402}]', ''),
(51, 'phuong@enclave.vn', '$2a$08$bHc2uYkzlpH9Lbhi5Hj8k.SCHXxFy5.k8zJNtphpqpVQSFf5Ygh0m', NULL, '2015-10-09 07:53:44', '2015-10-09 07:53:44', 0, '2015-10-09 07:53:44', '2015-10-09 07:53:44', NULL, '2015-10-09 07:53:44', '2015-10-09 07:53:44', NULL, 'default-avatar50.png', 'http://113.160.225.87:8484/assets/images/users/default-avatar50.png', NULL, NULL, 'Phuong', 'Nguyen', 1, 2, 'ABCD', 1, 0, 'd1cb411226032c8601dd5e5250c07b2831c9181164d16a87bb2c52100f5dd011bd99937429ab9d96f6f6a2e10941aef75c33f3887685b96259b39414271bec9a4T42566qD72dpoyx7e4YE7fEN7hF/1a9/trdr9Xj14w=', '600;596;627', '', '[{"announcement":"600","replies":"1992;1986;1984;2069;2015;1982;2148;1963;2028;1978;2083;1981"},{"announcement":"596","replies":"1908;1909;1907;1906"},{"announcement":"600","replies":"2196"}]', '', 'cj-XSLXEIVQ:APA91bG2-INwpu57QrYZhhud6QWig95ou5GMc95YGbjcPACjExb1p0cG39jMTPGWPYQmJih9WGQsCFgol1b_JejFHs9K-xmKfjbYZP6ltloVnzJ1N-78AZaA1nNBNw0PRfrUU6OvKMH8'),
(52, 'asdasd@emailc.com', '$2a$08$WI2MDp0jFpRc4QFmmvDIVu2xfTJP5.y1T6N6HlgXeOpRYd.LJd4Ii', NULL, '2015-10-15 06:23:09', '2015-10-15 06:23:09', 0, '2015-10-15 06:23:09', '2015-10-15 06:23:09', NULL, '2015-10-15 06:23:09', '2015-10-15 06:23:09', NULL, 'Anthony-Martial-signs-for-Manchester-United111.jpg', 'http://113.160.225.87:8484/assets/images/users/Anthony-Martial-signs-for-Manchester-United111.jpg', NULL, NULL, 'ffes', 'sdfsdf', 1, 3, 'sadasdasd', 1, 0, '14cc4c9f89b8a536a0d5450e8aade0709f1f44a497a206d86db1f265715056672fb2191a3fd2feff57e8455460c8e95dcafbdfde864ef4e5b9ae1f2e35355631xuWKwM55nFX58zUkkTzuQMtcPYMvF3IPBsuhv7g9l1I=', '', '', '', '', ''),
(55, 'test1@enclave.vn', '$2a$08$eWB7Y/Vtb0jmo5EoaLBAGOKVsSC8nTNFnD1D20WkovDZhFEFB44QG', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '2015-10-23 11:07:16', 'BuiQuangHuy.JPG', 'http://113.160.225.87:8484/assets/images/users/BuiQuangHuy.JPG', NULL, NULL, 'Harold', 'Enclave', 5, 3, 'milk. banana', 1, 0, '88e898bb3ea17715d1d8151bde09a6203ad2254825051955695188ce71a56ba81b8c6356e61b4f7c3bc742795302b23bf5cd0586b79d4507de3d7f97684fc56b/MgTvUxrLgfMJEfBNG5dJjKqhm//oDfClxfwTzEpnBA=', '602;601;600;598;588;604;605;606;607;608;609;596', '136;135', '[{"announcement":"602","replies":"2057;2054;2058;2055;2056;2053"},{"announcement":"601","replies":"2045;2043;2047;2039;2049;2042;2038;2050"},{"announcement":"600","replies":"1992;1986;1984;2015;1982;1963;2028;1978;1981"},{"announcement":"598","replies":"1969;1951;1971;1968;1973;1970;1967"},{"announcement":"588","replies":"1912;1759;1918;1855;1911;1763;1910;1916;1917;1897;1762;1869;1800;1772;1773;1764;1915;1761;1760;1821;1913;1914;1856;1798;1824;1799"},{"announcement":"588","replies":"1926;1921;1943;1946;1923;1927;1922;1925;1953;1933;1944;1950;1929;1931;2059;1947;1932;1924;1939;1942;1935;1920;1948;1934;1949;1930;1945;1928;1919"},{"announcement":"604","replies":"2066"},{"announcement":"605","replies":"2067"},{"announcement":"609","replies":"2070"},{"announcement":"596","replies":"1908;1909;1907;1906"},{"announcement":"600","replies":"2069"},{"announcement":"609","replies":"2073"},{"announcement":"609","replies":2075},{"announcement":"609","replies":"2074"},{"announcement":"600","replies":"2083"},{"announcement":"609","replies":2084}]', '[{"comment":"135","replies":"1899;2071;1905;1898;1936;1903"},{"comment":"136","replies":"2072"}]', 'cJaC5noUrDo:APA91bEOvNLDKPHvZW1mlz8bYaGORmdblk3pRIjKKrQ3JrO-HtKW37BR5juGklH5XPaZFuMjkb4VEoABzRLHT8MMocRfXQh35ktDPCUdcNYe2KTIYSaIBZb24ueFSEV4B0lVu8jKNtEw'),
(56, 'test2@enclave.vn', '$2a$08$laMBAOYdnxDU1PXjRMZifOjrM2IrJLW0k..nOgZcS2uBe3Shg7IFu', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '2015-10-16 04:23:49', 'default-avatar411.png', 'http://113.160.225.87:8484/assets/images/users/default-avatar411.png', NULL, NULL, 'Test 2', 'Enclave', 4, 2, 'milk', 0, 0, 'c69f96954bc9fff0d4c8b6b5bee3d4f83a6fb3c7f43a341b8d99b7bfd49e98ed417e7bcc214eef4f5506756957e6d0fe5a8834b9f926bedd93d0f4e8c5da8a59oJ/9QaYoc4awr9z20IH/BSMihUIpIYFt8GH0D2VYoHY=', '', '', '', '', ''),
(57, 'test3@enclave.vn', '$2a$08$laMBAOYdnxDU1PXjRMZifOjrM2IrJLW0k..nOgZcS2uBe3Shg7IFu', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '2015-10-16 04:23:49', 'default-avatar411.png', 'http://113.160.225.87:8484/assets/images/users/default-avatar411.png', NULL, NULL, 'Test 3', 'Enclave', 4, 2, 'milk', 0, 0, 'c69f96954bc9fff0d4c8b6b5bee3d4f83a6fb3c7f43a341b8d99b7bfd49e98ed417e7bcc214eef4f5506756957e6d0fe5a8834b9f926bedd93d0f4e8c5da8a59oJ/9QaYoc4awr9z20IH/BSMihUIpIYFt8GH0D2VYoHY=', '', '', '', '', ''),
(58, 'test4@enclave.vn', '$2a$08$laMBAOYdnxDU1PXjRMZifOjrM2IrJLW0k..nOgZcS2uBe3Shg7IFu', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '2015-10-16 04:23:49', 'default-avatar411.png', 'http://113.160.225.87:8484/assets/images/users/default-avatar411.png', NULL, NULL, 'Test 4', 'Enclave', 4, 2, 'milk', 0, 0, 'c69f96954bc9fff0d4c8b6b5bee3d4f83a6fb3c7f43a341b8d99b7bfd49e98ed417e7bcc214eef4f5506756957e6d0fe5a8834b9f926bedd93d0f4e8c5da8a59oJ/9QaYoc4awr9z20IH/BSMihUIpIYFt8GH0D2VYoHY=', '', '', '', '', ''),
(59, 'test5@enclave.vn', '$2a$08$laMBAOYdnxDU1PXjRMZifOjrM2IrJLW0k..nOgZcS2uBe3Shg7IFu', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '2015-10-16 04:23:49', 'default-avatar411.png', 'http://113.160.225.87:8484/assets/images/users/default-avatar411.png', NULL, NULL, 'Test 5', 'Enclave', 3, 2, 'milk', 1, 0, 'c69f96954bc9fff0d4c8b6b5bee3d4f83a6fb3c7f43a341b8d99b7bfd49e98ed417e7bcc214eef4f5506756957e6d0fe5a8834b9f926bedd93d0f4e8c5da8a59oJ/9QaYoc4awr9z20IH/BSMihUIpIYFt8GH0D2VYoHY=', '', '', '', '', ''),
(60, 'test6@enclave.vn', '$2a$08$laMBAOYdnxDU1PXjRMZifOjrM2IrJLW0k..nOgZcS2uBe3Shg7IFu', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '2015-10-16 04:23:49', 'default-avatar411.png', 'http://113.160.225.87:8484/assets/images/users/default-avatar411.png', NULL, NULL, 'Test 6', 'Enclave', 3, 2, 'milk', 1, 0, 'c69f96954bc9fff0d4c8b6b5bee3d4f83a6fb3c7f43a341b8d99b7bfd49e98ed417e7bcc214eef4f5506756957e6d0fe5a8834b9f926bedd93d0f4e8c5da8a59oJ/9QaYoc4awr9z20IH/BSMihUIpIYFt8GH0D2VYoHY=', '', '', '', '', ''),
(61, 'test7@enclave.vn', '$2a$08$laMBAOYdnxDU1PXjRMZifOjrM2IrJLW0k..nOgZcS2uBe3Shg7IFu', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '2015-10-16 04:23:49', 'default-avatar411.png', 'http://113.160.225.87:8484/assets/images/users/default-avatar411.png', NULL, NULL, 'Test 7', 'Enclave', 2, 2, 'milk', 1, 0, 'c69f96954bc9fff0d4c8b6b5bee3d4f83a6fb3c7f43a341b8d99b7bfd49e98ed417e7bcc214eef4f5506756957e6d0fe5a8834b9f926bedd93d0f4e8c5da8a59oJ/9QaYoc4awr9z20IH/BSMihUIpIYFt8GH0D2VYoHY=', '', '', '', '', ''),
(62, 'test8@enclave.vn', '$2a$08$laMBAOYdnxDU1PXjRMZifOjrM2IrJLW0k..nOgZcS2uBe3Shg7IFu', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '2015-10-16 04:23:49', 'default-avatar411.png', 'http://113.160.225.87:8484/assets/images/users/default-avatar411.png', NULL, NULL, 'Test 8', 'Enclave', 1, 2, 'milk', 1, 0, 'c69f96954bc9fff0d4c8b6b5bee3d4f83a6fb3c7f43a341b8d99b7bfd49e98ed417e7bcc214eef4f5506756957e6d0fe5a8834b9f926bedd93d0f4e8c5da8a59oJ/9QaYoc4awr9z20IH/BSMihUIpIYFt8GH0D2VYoHY=', '', '', '', '', ''),
(63, 'test9@enclave.vn', '$2a$08$laMBAOYdnxDU1PXjRMZifOjrM2IrJLW0k..nOgZcS2uBe3Shg7IFu', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '2015-10-16 04:23:49', 'default-avatar411.png', 'http://113.160.225.87:8484/assets/images/users/default-avatar411.png', NULL, NULL, 'Test 9', 'Enclave', 1, 2, 'milk', 1, 0, 'c69f96954bc9fff0d4c8b6b5bee3d4f83a6fb3c7f43a341b8d99b7bfd49e98ed417e7bcc214eef4f5506756957e6d0fe5a8834b9f926bedd93d0f4e8c5da8a59oJ/9QaYoc4awr9z20IH/BSMihUIpIYFt8GH0D2VYoHY=', '', '', '', '', ''),
(64, 'test10@enclave.vn', '$2a$08$laMBAOYdnxDU1PXjRMZifOjrM2IrJLW0k..nOgZcS2uBe3Shg7IFu', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '2015-10-16 04:23:49', 'default-avatar411.png', 'http://113.160.225.87:8484/assets/images/users/default-avatar411.png', NULL, NULL, 'Test 10 ', 'Enclave', 5, 1, 'milk', 1, 0, 'c69f96954bc9fff0d4c8b6b5bee3d4f83a6fb3c7f43a341b8d99b7bfd49e98ed417e7bcc214eef4f5506756957e6d0fe5a8834b9f926bedd93d0f4e8c5da8a59oJ/9QaYoc4awr9z20IH/BSMihUIpIYFt8GH0D2VYoHY=', '', '', '', '', ''),
(65, 'test11@enclave.vn', '$2a$08$laMBAOYdnxDU1PXjRMZifOjrM2IrJLW0k..nOgZcS2uBe3Shg7IFu', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '2015-10-16 04:23:49', 'default-avatar411.png', 'http://113.160.225.87:8484/assets/images/users/default-avatar411.png', NULL, NULL, 'Test 11', 'Enclave', 5, 1, 'milk', 1, 0, 'c69f96954bc9fff0d4c8b6b5bee3d4f83a6fb3c7f43a341b8d99b7bfd49e98ed417e7bcc214eef4f5506756957e6d0fe5a8834b9f926bedd93d0f4e8c5da8a59oJ/9QaYoc4awr9z20IH/BSMihUIpIYFt8GH0D2VYoHY=', '', '', '', '', ''),
(66, 'test12@enclave.vn', '$2a$08$laMBAOYdnxDU1PXjRMZifOjrM2IrJLW0k..nOgZcS2uBe3Shg7IFu', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '2015-10-16 04:23:49', 'default-avatar411.png', 'http://113.160.225.87:8484/assets/images/users/default-avatar411.png', NULL, NULL, 'Test 12', 'Enclave', 4, 1, 'milk', 1, 0, 'c69f96954bc9fff0d4c8b6b5bee3d4f83a6fb3c7f43a341b8d99b7bfd49e98ed417e7bcc214eef4f5506756957e6d0fe5a8834b9f926bedd93d0f4e8c5da8a59oJ/9QaYoc4awr9z20IH/BSMihUIpIYFt8GH0D2VYoHY=', '', '', '', '', ''),
(67, 'test13@enclave.vn', '$2a$08$laMBAOYdnxDU1PXjRMZifOjrM2IrJLW0k..nOgZcS2uBe3Shg7IFu', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '2015-10-16 04:23:49', 'default-avatar411.png', 'http://113.160.225.87:8484/assets/images/users/default-avatar411.png', NULL, NULL, 'Test 13', 'Enclave', 4, 1, 'milk', 1, 0, 'c69f96954bc9fff0d4c8b6b5bee3d4f83a6fb3c7f43a341b8d99b7bfd49e98ed417e7bcc214eef4f5506756957e6d0fe5a8834b9f926bedd93d0f4e8c5da8a59oJ/9QaYoc4awr9z20IH/BSMihUIpIYFt8GH0D2VYoHY=', '', '', '', '', ''),
(68, 'test14@enclave.vn', '$2a$08$laMBAOYdnxDU1PXjRMZifOjrM2IrJLW0k..nOgZcS2uBe3Shg7IFu', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '2015-10-16 04:23:49', 'default-avatar411.png', 'http://113.160.225.87:8484/assets/images/users/default-avatar411.png', NULL, NULL, 'Test 14', 'Enclave', 3, 1, 'milk', 1, 0, 'c69f96954bc9fff0d4c8b6b5bee3d4f83a6fb3c7f43a341b8d99b7bfd49e98ed417e7bcc214eef4f5506756957e6d0fe5a8834b9f926bedd93d0f4e8c5da8a59oJ/9QaYoc4awr9z20IH/BSMihUIpIYFt8GH0D2VYoHY=', '', '', '', '', ''),
(69, 'test15@enclave.vn', '$2a$08$laMBAOYdnxDU1PXjRMZifOjrM2IrJLW0k..nOgZcS2uBe3Shg7IFu', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '2015-10-16 04:23:49', 'default-avatar411.png', 'http://113.160.225.87:8484/assets/images/users/default-avatar411.png', NULL, NULL, 'Test 15', 'Enclave', 3, 1, 'milk', 1, 0, 'c69f96954bc9fff0d4c8b6b5bee3d4f83a6fb3c7f43a341b8d99b7bfd49e98ed417e7bcc214eef4f5506756957e6d0fe5a8834b9f926bedd93d0f4e8c5da8a59oJ/9QaYoc4awr9z20IH/BSMihUIpIYFt8GH0D2VYoHY=', '', '', '', '', ''),
(71, 'test16@enclave.vn', '$2a$08$laMBAOYdnxDU1PXjRMZifOjrM2IrJLW0k..nOgZcS2uBe3Shg7IFu', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '2015-10-16 04:23:49', 'default-avatar411.png', 'http://113.160.225.87:8484/assets/images/users/default-avatar411.png', NULL, NULL, 'Test 16', 'Enclave', 2, 1, 'milk', 1, 0, 'c69f96954bc9fff0d4c8b6b5bee3d4f83a6fb3c7f43a341b8d99b7bfd49e98ed417e7bcc214eef4f5506756957e6d0fe5a8834b9f926bedd93d0f4e8c5da8a59oJ/9QaYoc4awr9z20IH/BSMihUIpIYFt8GH0D2VYoHY=', '', '', '', '', ''),
(72, 'test17@enclave.vn', '$2a$08$laMBAOYdnxDU1PXjRMZifOjrM2IrJLW0k..nOgZcS2uBe3Shg7IFu', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '2015-10-16 04:23:49', 'default-avatar411.png', 'http://113.160.225.87:8484/assets/images/users/default-avatar411.png', NULL, NULL, 'Test 17', 'Enclave', 2, 1, 'milk', 1, 0, 'c69f96954bc9fff0d4c8b6b5bee3d4f83a6fb3c7f43a341b8d99b7bfd49e98ed417e7bcc214eef4f5506756957e6d0fe5a8834b9f926bedd93d0f4e8c5da8a59oJ/9QaYoc4awr9z20IH/BSMihUIpIYFt8GH0D2VYoHY=', '', '', '', '', ''),
(73, 'test18@enclave.vn', '$2a$08$laMBAOYdnxDU1PXjRMZifOjrM2IrJLW0k..nOgZcS2uBe3Shg7IFu', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '2015-10-16 04:23:49', 'default-avatar411.png', 'http://113.160.225.87:8484/assets/images/users/default-avatar411.png', NULL, NULL, 'Test 18', 'Enclave', 1, 1, 'milk', 1, 0, 'c69f96954bc9fff0d4c8b6b5bee3d4f83a6fb3c7f43a341b8d99b7bfd49e98ed417e7bcc214eef4f5506756957e6d0fe5a8834b9f926bedd93d0f4e8c5da8a59oJ/9QaYoc4awr9z20IH/BSMihUIpIYFt8GH0D2VYoHY=', '', '', '', '', ''),
(74, 'test19@enclave.vn', '$2a$08$laMBAOYdnxDU1PXjRMZifOjrM2IrJLW0k..nOgZcS2uBe3Shg7IFu', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '2015-10-16 04:23:49', 'default-avatar411.png', 'http://113.160.225.87:8484/assets/images/users/default-avatar411.png', NULL, NULL, 'Test 19', 'Enclave', 1, 1, 'milk', 1, 0, 'c69f96954bc9fff0d4c8b6b5bee3d4f83a6fb3c7f43a341b8d99b7bfd49e98ed417e7bcc214eef4f5506756957e6d0fe5a8834b9f926bedd93d0f4e8c5da8a59oJ/9QaYoc4awr9z20IH/BSMihUIpIYFt8GH0D2VYoHY=', '', '', '', '', ''),
(75, 'test20@enclave.vn', '$2a$08$laMBAOYdnxDU1PXjRMZifOjrM2IrJLW0k..nOgZcS2uBe3Shg7IFu', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '2015-10-16 04:23:49', 'default-avatar411.png', 'http://113.160.225.87:8484/assets/images/users/default-avatar411.png', NULL, NULL, 'Test 20', 'Enclave', 2, 1, 'milk', 1, 0, 'c69f96954bc9fff0d4c8b6b5bee3d4f83a6fb3c7f43a341b8d99b7bfd49e98ed417e7bcc214eef4f5506756957e6d0fe5a8834b9f926bedd93d0f4e8c5da8a59oJ/9QaYoc4awr9z20IH/BSMihUIpIYFt8GH0D2VYoHY=', '', '', '', '', ''),
(76, 'huck@enclave.vn', '$2a$08$CyHqSd53PDOTPBlseV0.VuH2.Xz.qzDtjK6ON8VJob7UklVU33xAW', NULL, '2015-10-22 08:12:56', '2015-10-22 08:12:56', 0, '2015-10-22 08:12:56', '2015-10-22 08:12:56', NULL, '2015-10-22 08:12:56', '2015-10-22 08:12:56', '2015-11-05 08:30:31', 'thanhc1.png', 'http://113.160.225.87:8484/assets/images/users/thanhc1.png', NULL, NULL, 'Huck', 'Enclave', 1, 1, 'Normal', 1, 0, '3f380bbff6f1f36418427c10363555d7ac6dfc4356a479052369cc8461249e50f4458e2b3bbcd8824ea0f364bf525661a6e8eb3cff441dd242e5f4f4f7cd411aabK159N6/iB58bKdv3XxBjOiw+RhVgmDcoKa0TydT5s=', '', '', '', '', ''),
(77, 'email@enclave.vn', '$2a$08$l1pWPks37WhU4eNTu9.ZgODyyAtRglLt6mnuvTdKzJHtUnjInXB46', NULL, '2015-10-27 01:43:22', '2015-10-27 01:43:22', 0, '2015-10-27 01:43:22', '2015-10-27 01:43:22', NULL, '2015-10-27 01:43:22', '2015-10-27 01:43:22', NULL, 'IMG_0667.JPG', 'http://113.160.225.87:8484/assets/images/users/IMG_0667.JPG', NULL, NULL, 'Test', 'Test', 1, 1, 'asdsad', 1, 0, '0fe6111010e9a701ec1fae201bcc8bd02f467caab9d6f83c3fce867328e785285a594b046aff3ec033c88441bff70f9d48ae3c568c29c25c5c2aad941e5a6cdbImI2hD1lUAU/oivMFV+dMjLAsAMk/5O9QdgCfyGHgvA=', '', '', '', '', ''),
(78, 'asd@encalve.vn', '$2a$08$l6iee0i/0M1lqEAvUyVZIOwr87c089F1z7ItCvoyXXGQFC.rGbdnW', NULL, '2015-10-27 01:44:05', '2015-10-27 01:44:05', 0, '2015-10-27 01:44:05', '2015-10-27 01:44:05', NULL, '2015-10-27 01:44:05', '2015-10-27 01:44:05', NULL, 'IMG_06671.JPG', 'http://113.160.225.87:8484/assets/images/users/IMG_06671.JPG', NULL, NULL, 'asd', 'asd', 1, 1, 'aweawe', 1, 0, '8df2d96ec3e92516e99a402a8d4dfcf491d0c34c550a00b016d8128750f020b5f8e6060bcbe07e49147b395f70606b7ef678d7d5f9f278a959f7dd6e6ebebf52ovsS0UnzrhPczqv8yj9nNoiw3U5Nh+xRKf/cQJwf0XU=', '', '', '', '', ''),
(79, 'adsd@encalve.vn', '$2a$08$iu7TRgpNsKD7OSatjeOUP.SP.Kfpzq9S74eN0OUAtLQNVRtEkI9Iy', NULL, '2015-10-27 01:48:46', '2015-10-27 01:48:46', 0, '2015-10-27 01:48:46', '2015-10-27 01:48:46', NULL, '2015-10-27 01:48:46', '2015-10-27 01:48:46', NULL, 'NguyenNhatCuong5.JPG', 'http://113.160.225.87:8484/assets/images/users/NguyenNhatCuong5.JPG', NULL, NULL, 'asd', 'asd123', 1, 1, 'aweawe', 1, 0, '20043d1a318099168f49c79ee23955e336ca0b220db4a34191deff031278637c16988214dba785ac163460b0d273e060b1761199b37f858b046f26949f3a90b3/1e9jnFdTXiOK6hu7wkqgHSpF+dCYiNzubQgvrEOtGI=', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `vote_logs`
--

CREATE TABLE IF NOT EXISTS `vote_logs` (
  `user_id` int(11) NOT NULL,
  `first_day_of_week` date NOT NULL,
  `votes` varchar(100) DEFAULT NULL
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
(29, '2015-09-14', '2;3;4;5;7;'),
(15, '2015-09-14', '2;3;4;2;3;'),
(30, '2015-09-14', '2;3;4;6;7;'),
(48, '2015-09-14', '2;'),
(30, '2015-09-21', '2;5;6;'),
(29, '2015-09-21', '4;'),
(48, '2015-09-21', '4;5;6;56;'),
(1, '2015-09-21', '2;3;4;5;6;'),
(48, '2015-09-28', '2;3;4;5;6;'),
(29, '2015-10-05', '3;4;5;6;'),
(30, '2015-10-05', '3;'),
(50, '2015-10-05', '2;'),
(29, '2015-10-12', '5;8;46;56;'),
(50, '2015-10-12', '2;3;'),
(48, '2015-10-12', '2;3;4;5;6;'),
(1, '2015-10-19', '2;'),
(29, '2015-10-19', '2;3;'),
(50, '2015-10-19', '2;'),
(48, '2015-10-19', '2;3;4;5;6;'),
(55, '2015-10-26', '10;46;47;56;'),
(29, '2015-10-26', '5;6;56;'),
(50, '2015-10-26', '2;'),
(48, '2015-10-26', '2;7;'),
(30, '2015-10-26', '3;'),
(51, '2015-10-26', '3;'),
(15, '2015-10-26', '2;'),
(30, '2015-11-02', '2;3;4;'),
(48, '2015-11-02', '2;3;'),
(50, '2015-11-02', '2;'),
(29, '2015-11-02', '5;6;7;8;10;'),
(51, '2015-11-02', '3;4;5;'),
(48, '2015-11-09', '2;3;4;6;7;'),
(15, '2015-11-09', '2;3;4;');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
