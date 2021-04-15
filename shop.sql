-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 02, 2020 at 07:05 AM
-- Server version: 5.5.24-log
-- PHP Version: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `ID` int(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `parent` int(11) NOT NULL DEFAULT '0',
  `ordering` int(11) DEFAULT NULL,
  `visibility` tinyint(4) NOT NULL DEFAULT '0',
  `allow_coment` tinyint(4) NOT NULL DEFAULT '0',
  `allow_ads` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `name`, `description`, `parent`, `ordering`, `visibility`, `allow_coment`, `allow_ads`) VALUES
(5, 'Mobils', 'Very good qualite', 0, 1, 1, 1, 1),
(6, 'books', 'literal and scientific', 0, 1, 0, 0, 0),
(8, 'Computer', 'HP and toshiba', 0, 3, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `c_id` int(11) NOT NULL AUTO_INCREMENT,
  `comment` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `comment_date` date NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`c_id`),
  KEY `items_comment` (`item_id`),
  KEY `users_comment` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`c_id`, `comment`, `status`, `comment_date`, `item_id`, `user_id`) VALUES
(1, 'very gd quality', 0, '2020-06-02', 32, 54);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `item_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` varchar(255) NOT NULL,
  `date_ad` date NOT NULL,
  `country_made` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `rating` smallint(6) NOT NULL,
  `approve` tinyint(4) NOT NULL DEFAULT '0',
  `tags` varchar(255) NOT NULL,
  `Cat_ID` int(11) NOT NULL,
  `Member_ID` int(11) NOT NULL,
  PRIMARY KEY (`item_ID`),
  KEY `user_1` (`Member_ID`),
  KEY `Cat_1` (`Cat_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_ID`, `Name`, `description`, `price`, `date_ad`, `country_made`, `image`, `status`, `rating`, `approve`, `tags`, `Cat_ID`, `Member_ID`) VALUES
(28, 'PHP 5', 'Learn easy php', '50', '2020-06-02', 'lebanon', '5646362_PHP6andMySQL5forDynamicWebSitesVisualQuickProGuide.jpg', '1', 0, 1, 'discount', 6, 54),
(29, 'HP', 'Laptop', '250', '2020-06-02', 'lebanon', '6429749_OIP224J01C1.jpg', '3', 0, 1, '', 8, 54),
(30, 'Hp Laptop', 'laptop', '250', '2020-06-02', 'lebanon', '3828735_OIP224J01C1.jpg', '3', 0, 0, '', 8, 54),
(31, 'Sumsung', 'verry good quality', '250', '2020-06-02', 'lebanon', '4439087_mobil_poppox_p1_lliure.jpg', '1', 0, 1, '', 5, 54),
(32, 'Nokia', 'verry good quality', '300', '2020-06-02', 'lebanon', '7315369_688915-mobisl.jpg', '1', 0, 1, '', 5, 54);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'To identify User',
  `Username` varchar(255) NOT NULL COMMENT 'Username To Login',
  `Password` varchar(255) NOT NULL COMMENT 'Password To Login',
  `Email` varchar(255) NOT NULL,
  `FullName` varchar(255) NOT NULL,
  `GroupID` int(1) NOT NULL DEFAULT '0' COMMENT 'Identify User Group',
  `TrustStatus` int(1) NOT NULL DEFAULT '0' COMMENT ' seller rank',
  `RegStatus` int(1) NOT NULL DEFAULT '0' COMMENT 'User Approval',
  `Date` date NOT NULL,
  `avatar` varchar(255) NOT NULL,
  PRIMARY KEY (`UserID`),
  UNIQUE KEY `Username` (`Username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=55 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `Email`, `FullName`, `GroupID`, `TrustStatus`, `RegStatus`, `Date`, `avatar`) VALUES
(4, 'Naji', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'nfd@gmail.com', 'nashed fakher', 1, 0, 0, '0000-00-00', ''),
(17, 'Nado', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'nad@gmail.com', 'Nadine', 0, 0, 1, '2020-05-26', ''),
(50, 'Nardinef', '8cb2237d0679ca88db6464eac60da96345513964', 'nad@gmail.com', 'Nardinefakher', 0, 0, 0, '2020-06-02', '9594117_IMG-20181229-WA0013.jpg'),
(52, 'Nardinefd', '8cb2237d0679ca88db6464eac60da96345513964', 'nad@gmail.com', 'Nardinefakher', 0, 0, 0, '2020-06-02', '6166992_Souzan 20181205_205433.jpg'),
(53, 'Nardinefdfdfd', '8cb2237d0679ca88db6464eac60da96345513964', 'nad@gmail.com', 'Nardinefakher', 0, 0, 0, '2020-06-02', '8469544_Souzan 20181205_205433.jpg'),
(54, 'Nadinefd', '8cb2237d0679ca88db6464eac60da96345513964', 'nad@gmail.com', 'Nadine', 0, 0, 0, '2020-06-02', '6791382_Souzan 20181205_205433.jpg');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `items_comment` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_comment` FOREIGN KEY (`user_id`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `Cat_1` FOREIGN KEY (`Cat_ID`) REFERENCES `categories` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_1` FOREIGN KEY (`Member_ID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
