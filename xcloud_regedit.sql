-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 01, 2017 at 03:32 PM
-- Server version: 5.5.53-0+deb8u1
-- PHP Version: 5.6.29-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `xcloud_regedit`
--

-- --------------------------------------------------------

--
-- Table structure for table `apps`
--

CREATE TABLE IF NOT EXISTS `apps` (
`id` int(11) NOT NULL,
  `dir` text NOT NULL,
  `rules` text NOT NULL,
  `alias` text NOT NULL,
  `version` int(11) NOT NULL,
  `type` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `apps`
--

INSERT INTO `apps` (`id`, `dir`, `rules`, `alias`, `version`, `type`) VALUES
(16, 'apps/2e5d8aa3dfa8ef34ca5131d20f9dad51', '', 'settings', 0, 0),
(17, 'apps/3722cffd53dd74a2537b336bbd5720fd', '', 'file_manager', 0, 0),
(18, 'apps/0cfd653d5d3e1e9fdbb644523d77971d', '', '', 0, 0),
(19, 'apps/e9a847ba61b7bab6d65f7bb83e2d947b', '', 'apps_market', 0, 0),
(20, 'apps/a0e7b2a565119c0a7ec3126a16016113', '', '', 0, 0),
(22, 'apps/4136a932eb7724a00cb87c3fb9e1ea1d', '', '', 0, 0),
(24, 'apps/3e82f1a69ee07c70f9dff8cda15cf357', '', 'workcast', 0, 0),
(25, 'apps/05b47614107eb2dd346f747a48936456', '', '', 0, 1),
(26, 'apps/bd1a5d7f1baf4a7c78dce7fb26e094d7', '', '', 0, 1),
(27, 'apps/a0b63292bf6b619396f71a4dd96b8ed2', '', 'user_editor', 1, 1),
(28, 'apps/fc7afaaaf50a046f73b1000de5f0f6b8', '', '', 0, 2),
(29, 'apps/d4721a6bab8c7dee78cc25f7fa154bfc', '', '', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `association`
--

CREATE TABLE IF NOT EXISTS `association` (
`id` int(11) NOT NULL,
  `type` text NOT NULL,
  `app_id` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `association`
--

INSERT INTO `association` (`id`, `type`, `app_id`) VALUES
(1, 'txt', 25),
(2, 'jpg', 26),
(3, 'png', 26),
(4, 'gif', 26),
(5, 'mp3', 28),
(6, 'jpeg', 26);

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

CREATE TABLE IF NOT EXISTS `notices` (
  `title` text NOT NULL,
  `content` text NOT NULL,
  `rules` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `json_config` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`json_config`) VALUES
('{"account":"test@quareal.ru","home_path":"/home/home"}');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(2) NOT NULL,
  `login` text NOT NULL,
  `password` text NOT NULL,
  `root` int(1) NOT NULL,
  `avatar` text NOT NULL,
  `rules` text NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `root`, `avatar`, `rules`) VALUES
(7, 'test', '6216e45324b366f466da22424486d8a1', 1, '/resources/assets/img/noavatar.png', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `apps`
--
ALTER TABLE `apps`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `association`
--
ALTER TABLE `association`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `apps`
--
ALTER TABLE `apps`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `association`
--
ALTER TABLE `association`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(2) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
