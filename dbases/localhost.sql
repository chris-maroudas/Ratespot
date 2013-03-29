-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 22, 2013 at 02:24 AM
-- Server version: 5.5.24-log
-- PHP Version: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dipl`
--
CREATE DATABASE `dipl` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `dipl`;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` varchar(60) NOT NULL,
  `content` text NOT NULL,
  `imageName` varchar(255) NOT NULL,
  `rating` int(5) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `title` varchar(80) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `author`, `content`, `imageName`, `rating`, `date`, `title`) VALUES
(1, 'Christos Maroudas', 'Completely fashion integrated mindshare through equity invested technology. Dramatically embrace orthogonal imperatives for integrated e-markets. Progressively reconceptualize granular internal or "organic" sources before robust mindshare. Competently cultivate seamless methodologies via goal-oriented human capital. Quickly cultivate best-of-breed testing procedures for premium testing procedures.\r\n\r\nIntrinsicly e-enable covalent collaboration and idea-sharing via distinctive.', 'www.google.com/koko.jpg', 5, '2013-02-22 02:04:51', 'another'),
(3, 'Christos Maroudas', 'Completely fashion integrated mindshare through equity invested technology. Dramatically embrace orthogonal imperatives for integrated e-markets. Progressively reconceptualize granular internal or "organic" sources before robust mindshare. Competently cultivate seamless methodologies via goal-oriented human capital. Quickly cultivate best-of-breed testing procedures for premium testing procedures.\r\n\r\nIntrinsicly e-enable covalent collaboration and idea-sharing via distinctive.', 'www.google.com/koko.jpg', 5, '2013-02-21 23:41:09', 'Heres to a new day!'),
(4, 'Christos Maroudas', 'Completely fashion integrated mindshare through equity invested technology. Dramatically embrace orthogonal imperatives for integrated e-markets. Progressively reconceptualize granular internal or "organic" sources before robust mindshare. Competently cultivate seamless methodologies via goal-oriented human capital. Quickly cultivate best-of-breed testing procedures for premium testing procedures.\r\n\r\nIntrinsicly e-enable covalent collaboration and idea-sharing via distinctive.', 'www.google.com/koko.jpg', 5, '2013-02-22 01:43:10', 'gay message'),
(5, 'Molivenios', 'HELLO AND YES WE''RE LIVE', 'sadasdasdasd', 2, '2013-02-22 02:08:14', 'here we go');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
