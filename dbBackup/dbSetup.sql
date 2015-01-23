-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Jan 23, 2015 at 09:09 PM
-- Server version: 5.5.34
-- PHP Version: 5.5.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `glide`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `admin_password` varchar(100) NOT NULL,
  `admin_email` varchar(100) NOT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `company_id_2` (`company_id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=55 ;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `company_id`, `admin_password`, `admin_email`, `is_deleted`) VALUES
(48, 53, '994422d7abf05e6fc67ce5c25f3d3639eac5476c', 'admin@glide.com', 0),
(49, 54, '994422d7abf05e6fc67ce5c25f3d3639eac5476c', 'admin@sony.com', 0),
(50, 55, '1a699dc22b174a93ef6a734ee2d2949866d7faec', 'Admin@nixatel.com', 0),
(51, 56, '1a699dc22b174a93ef6a734ee2d2949866d7faec', 'Admin@pfizer.com', 0),
(52, 57, '1a699dc22b174a93ef6a734ee2d2949866d7faec', 'Admin@ucc.ie', 0),
(53, 58, '1a699dc22b174a93ef6a734ee2d2949866d7faec', 'Admin@residentadvisor.com', 0),
(54, 59, '0b6bcb20e39f1e70a0a3f87d2710d59b0200803c', 'Thisisatest@gmail.com', 0);

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `company_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(100) NOT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`company_id`),
  KEY `company_id` (`company_id`),
  KEY `company_id_2` (`company_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=61 ;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`company_id`, `company_name`, `is_deleted`) VALUES
(53, 'glide', 0),
(54, 'sony', 0),
(55, 'Nixatel', 0),
(56, 'Pfizer', 0),
(57, 'Ucc', 0),
(58, 'Resident Advisor', 0),
(59, 'Thisisatest', 0),
(60, 'Thisisatest', 0);

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `expense_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `merchant_id` int(11) NOT NULL,
  `receipt_id` int(11) NOT NULL,
  `expense_category` varchar(100) NOT NULL,
  `expense_cost` float NOT NULL DEFAULT '0',
  `expense_status` varchar(100) DEFAULT 'Unprocessed',
  `expense_comment` varchar(200) DEFAULT NULL,
  `expense_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `account` varchar(150) DEFAULT NULL,
  `is_deleted` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`expense_id`),
  KEY `user_id` (`user_id`),
  KEY `merchant_id` (`merchant_id`),
  KEY `receipt_id` (`receipt_id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=456 ;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`expense_id`, `admin_id`, `user_id`, `merchant_id`, `receipt_id`, `expense_category`, `expense_cost`, `expense_status`, `expense_comment`, `expense_date`, `account`, `is_deleted`) VALUES
(5, 48, 1, 1, 1, 'accommodation', 16, 'processed', 'only stayed 1 night', '2014-08-08 23:00:00', NULL, 1),
(6, 48, 2, 1, 2, 'food', 34, 'processed', 'meeting with evening echo', '2014-08-08 23:00:00', NULL, 1),
(7, 49, 3, 1, 3, 'accommodation', 320, 'awaiting processing', 'lease meeting room for cork business fundraiser', '2014-08-08 23:00:00', NULL, 0),
(8, 48, 1, 1, 1, 'accommodation', 163, 'unprocessed', 'had meeting with jim early saturday', '2014-10-14 23:00:00', NULL, 1),
(9, 48, 1, 1, 2, 'food', 11, 'processed', 'bla bla bla', '2014-10-27 00:00:00', NULL, 1),
(10, 48, 1, 1, 2, 'entertainment', 154, 'unprocessed', 'dinner with clients', '2014-10-12 23:00:00', NULL, 1),
(11, 48, 1, 1, 1, 'phone', 12, 'processed', 'bla bla bla', '2014-10-20 23:00:00', NULL, 1),
(12, 48, 2, 1, 1, 'accommodation', 123, 'processed', 'blablabla', '2014-10-22 23:00:00', NULL, 1),
(13, 48, 2, 1, 1, 'accommodation', 123, 'processed', 'blablabla', '2014-10-22 23:00:00', NULL, 1),
(14, 48, 1, 1, 1, 'accommodation', 120, 'processed', 'blablabla', '2014-10-12 23:00:00', NULL, 1),
(15, 48, 1, 1, 1, 'accommodation', 120, 'processed', 'blablabla', '2014-10-12 23:00:00', NULL, 1),
(16, 48, 1, 1, 1, 'food', 120, 'unprocessed', 'blablabla', '2014-10-25 23:00:00', NULL, 1),
(17, 48, 1, 1, 1, 'food', 120, 'unprocessed', 'blablabla', '2014-10-25 23:00:00', NULL, 1),
(19, 48, 1, 1, 1, 'food', 43, 'unprocessed', 'this is a comment', '2014-10-10 23:00:00', NULL, 1),
(23, 48, 1, 1, 0, 'food', 343, 'unprocessed', 'this is a commenbt', '2014-10-10 23:00:00', NULL, 1),
(24, 48, 1, 1, 0, 'food', 343, NULL, 'this better work', NULL, NULL, 1),
(25, 48, 1, 1, 0, 'food', 343, NULL, 'i took out receipt id', NULL, NULL, 1),
(26, 48, 1, 1, 0, 'food', 343, 'unprocessed', 'i took out status', NULL, NULL, 1),
(27, 48, 1, 1, 0, 'food', 33, 'unprocessed', 'i took out is deleted and date', '2014-10-10 23:00:00', NULL, 1),
(28, 48, 1, 1, 0, 'entertainment', 21, 'unprocessed', 'i took out id', '2014-10-10 23:00:00', NULL, 1),
(29, 48, 2, 1, 0, 'travel', 20, 'unprocessed', 'meeting with tom from panorama', '2014-10-16 23:00:00', NULL, 1),
(30, 48, 2, 1, 0, 'travel', 20, 'unprocessed', 'meeting with tom from panorama', '2014-10-16 23:00:00', NULL, 1),
(31, 48, 2, 1, 0, 'travel', 20, 'unprocessed', 'meeting with tom from panorama', '2014-10-16 23:00:00', NULL, 1),
(32, 48, 2, 1, 0, 'travel', 20, 'unprocessed', 'meeting with tom from panorama', '2014-10-16 23:00:00', NULL, 1),
(33, 48, 2, 1, 0, 'travel', 20, 'unprocessed', 'meeting with tom from panorama', '2014-10-16 23:00:00', NULL, 1),
(34, 48, 2, 1, 0, 'entertainment', 21, 'unprocessed', 'testing merchant', '2014-10-16 23:00:00', NULL, 1),
(35, 48, 2, 1, 0, 'entertainment', 21, 'unprocessed', 'testing merchant', '2014-10-16 23:00:00', NULL, 1),
(36, 48, 2, 1, 0, 'entertainment', 21, 'unprocessed', 'testing merchant', '2014-10-16 23:00:00', NULL, 1),
(37, 48, 2, 1, 0, 'entertainment', 21, 'unprocessed', 'testing merchant', '2014-10-16 23:00:00', NULL, 1),
(38, 48, 2, 1, 0, 'entertainment', 21, 'unprocessed', 'testing merchant', '2014-10-16 23:00:00', NULL, 1),
(39, 48, 2, 1, 0, 'entertainment', 21, 'unprocessed', 'testing merchant', '2014-10-16 23:00:00', NULL, 1),
(40, 48, 2, 1, 0, 'entertainment', 21, 'unprocessed', 'testing merchant', '2014-10-16 23:00:00', NULL, 1),
(41, 48, 2, 1, 0, 'entertainment', 21, 'unprocessed', 'testing merchant', '2014-10-16 23:00:00', NULL, 1),
(42, 48, 2, 1, 0, 'entertainment', 21, 'unprocessed', 'testing merchant', '2014-10-16 23:00:00', NULL, 1),
(43, 48, 2, 1, 0, 'entertainment', 21, 'unprocessed', 'testing merchant', '2014-10-16 23:00:00', NULL, 1),
(44, 48, 2, 1, 0, 'entertainment', 21, 'unprocessed', 'testing merchant', '2014-10-16 23:00:00', NULL, 1),
(45, 48, 2, 1, 0, 'entertainment', 21, 'unprocessed', 'testing merchant', '2014-10-16 23:00:00', NULL, 1),
(46, 48, 2, 1, 0, 'entertainment', 21, 'unprocessed', 'testing merchant', '2014-10-16 23:00:00', NULL, 1),
(47, 48, 2, 1, 0, 'entertainment', 21, 'unprocessed', 'testing merchant', '2014-10-16 23:00:00', NULL, 1),
(48, 48, 2, 1, 0, 'entertainment', 21, 'unprocessed', 'testing merchant', '2014-10-16 23:00:00', NULL, 1),
(49, 48, 2, 1, 0, 'entertainment', 21, 'unprocessed', 'testing merchant', '2014-10-16 23:00:00', NULL, 1),
(50, 48, 2, 1, 0, 'entertainment', 21, 'unprocessed', 'testing merchant', '2014-10-16 23:00:00', NULL, 1),
(51, 48, 2, 1, 0, 'entertainment', 21, 'unprocessed', 'testing merchant', '2014-10-16 23:00:00', NULL, 1),
(52, 48, 2, 1, 0, 'entertainment', 21, 'unprocessed', 'testing merchant', '2014-10-16 23:00:00', NULL, 1),
(53, 48, 2, 1, 0, 'entertainment', 21, 'unprocessed', 'testing merchant', '2014-10-16 23:00:00', NULL, 1),
(54, 48, 2, 1, 0, 'entertainment', 21, 'unprocessed', 'testing merchant', '2014-10-16 23:00:00', NULL, 1),
(55, 48, 2, 1, 0, 'entertainment', 21, 'unprocessed', 'testing merchant', '2014-10-16 23:00:00', NULL, 1),
(56, 48, 2, 1, 0, 'entertainment', 21, 'unprocessed', 'testing merchant', '2014-10-16 23:00:00', NULL, 1),
(57, 48, 2, 1, 0, 'entertainment', 21, 'unprocessed', 'testing merchant', '2014-10-16 23:00:00', NULL, 1),
(58, 48, 2, 1, 0, 'entertainment', 21, 'unprocessed', 'testing merchant', '2014-10-16 23:00:00', NULL, 1),
(59, 48, 2, 1, 0, 'entertainment', 21, 'unprocessed', 'testing merchant', '2014-10-16 23:00:00', NULL, 1),
(60, 48, 2, 1, 0, 'entertainment', 21, 'unprocessed', 'testing merchant', '2014-10-16 23:00:00', NULL, 1),
(61, 48, 2, 1, 0, 'entertainment', 21, 'unprocessed', 'testing merchant', '2014-10-16 23:00:00', NULL, 1),
(62, 48, 2, 1, 0, 'entertainment', 21, 'unprocessed', 'testing merchant', '2014-10-16 23:00:00', NULL, 1),
(63, 48, 2, 1, 0, 'entertainment', 21, 'unprocessed', 'testing merchant', '2014-10-16 23:00:00', NULL, 1),
(64, 48, 2, 1, 0, 'entertainment', 21, 'unprocessed', 'testing merchant', '2014-10-16 23:00:00', NULL, 1),
(65, 48, 2, 1, 0, 'entertainment', 21, 'unprocessed', 'testing merchant', '2014-10-16 23:00:00', NULL, 1),
(66, 48, 2, 1, 0, 'entertainment', 21, 'unprocessed', 'testing merchant', '2014-10-16 23:00:00', NULL, 1),
(67, 48, 2, 1, 0, 'entertainment', 21, 'unprocessed', 'testing merchant', '2014-10-16 23:00:00', NULL, 1),
(68, 48, 2, 1, 0, 'entertainment', 21, 'unprocessed', 'testing merchant', '2014-10-16 23:00:00', NULL, 1),
(69, 48, 2, 1, 0, 'entertainment', 21, 'unprocessed', 'testing merchant', '2014-10-16 23:00:00', NULL, 1),
(70, 48, 2, 1, 0, 'entertainment', 21, 'unprocessed', 'testing merchant', '2014-10-16 23:00:00', NULL, 1),
(71, 48, 2, 1, 0, 'entertainment', 21, 'unprocessed', 'testing merchant', '2014-10-16 23:00:00', NULL, 1),
(72, 48, 2, 1, 0, 'entertainment', 21, 'unprocessed', 'testing merchant', '2014-10-16 23:00:00', NULL, 1),
(73, 48, 2, 1, 0, 'entertainment', 21, 'unprocessed', 'testing merchant', '2014-10-16 23:00:00', NULL, 1),
(74, 48, 2, 1, 0, 'entertainment', 21, 'unprocessed', 'testing merchant', '2014-10-16 23:00:00', NULL, 1),
(75, 48, 2, 1, 0, 'entertainment', 21, 'unprocessed', 'testing merchant', '2014-10-16 23:00:00', NULL, 1),
(76, 48, 2, 1, 0, 'entertainment', 21, 'unprocessed', 'testing merchant', '2014-10-16 23:00:00', NULL, 1),
(77, 48, 2, 1, 0, 'entertainment', 21, 'unprocessed', 'testing merchant', '2014-10-16 23:00:00', NULL, 1),
(78, 48, 2, 1, 0, 'entertainment', 21, 'unprocessed', 'testing merchant', '2014-10-16 23:00:00', NULL, 1),
(79, 48, 2, 4, 0, 'accommodation', 20, 'unprocessed', 'flight to liverpool to meet john about adds', '2014-10-16 23:00:00', NULL, 1),
(81, 48, 2, 5, 0, 'phone', 400, 'unprocessed', 'ringing australia', '2014-10-16 23:00:00', NULL, 1),
(82, 48, 2, 6, 0, 'food', 6, 'unprocessed', 'nice', '2014-10-18 23:00:00', NULL, 1),
(83, 48, 2, 7, 0, 'food', 10, 'unprocessed', 'this is a comment', '2014-10-18 23:00:00', NULL, 1),
(84, 48, 2, 8, 0, 'phone', 23, 'unprocessed', 'this is a comment', '2014-10-18 23:00:00', NULL, 1),
(85, 48, 11, 9, 0, 'accommodation', 104, 'unprocessed', 'had meeting in cork city', '2014-10-18 23:00:00', NULL, 1),
(87, 48, 12, 10, 0, 'entertainment', 100, 'unprocessed', '', '2014-10-21 23:00:00', NULL, 1),
(89, 48, 12, 1, 0, 'accommodation', 20000, 'unprocessed', '', '2014-10-21 23:00:00', NULL, 1),
(90, 48, 13, 1, 0, 'accommodation', 100, 'unprocessed', '', '2014-10-21 23:00:00', NULL, 0),
(91, 48, 13, 11, 0, 'travel', 204, 'unprocessed', 'trip to berlin for meeting with qualten', '2014-10-21 23:00:00', NULL, 0),
(92, 48, 16, 1, 0, 'phone', 24, 'unprocessed', 'monthly bill', '2014-10-21 23:00:00', NULL, 1),
(93, 48, 19, 1, 0, 'entertainment', 321, 'unprocessed', 'meal and drinks with clients', '2014-10-21 23:00:00', NULL, 1),
(94, 48, 13, 12, 0, 'entertainment', 134, 'unprocessed', 'drinks with clients', '2014-10-21 23:00:00', NULL, 1),
(95, 48, 20, 1, 0, 'accommodation', 103, 'unprocessed', '', '2014-10-21 23:00:00', NULL, 1),
(96, 48, 13, 13, 0, 'food', 145, 'unprocessed', 'meeting with client from ibm', '2014-10-21 23:00:00', NULL, 0),
(97, 48, 26, 1, 0, 'Travel', 143, 'unprocessed', 'Had A Meeting With Tim From Supervalue.', '2014-10-22 23:00:00', NULL, 0),
(98, 50, 28, 14, 0, 'Food', 331, 'Unprocessed', 'Meal With John From Imb', '2014-10-23 23:00:00', NULL, 1),
(99, 50, 28, 1, 0, 'Food', 0, 'Processed', 'What A Night', '2014-10-23 23:00:00', NULL, 1),
(100, 50, 28, 15, 0, 'Food', 0, 'Unprocessed', 'New Comment Update', '2014-10-23 23:00:00', NULL, 1),
(101, 50, 28, 14, 0, 'Accommodation', 20, 'Unprocessed', 'Trip To Ardmore, Not Great.', '2014-10-23 23:00:00', NULL, 1),
(102, 50, 28, 17, 0, 'Accommodation', 20, 'Processed', 'Meeting With John.', '2014-10-23 23:00:00', NULL, 1),
(103, 50, 28, 18, 0, 'Travel', 200, 'Processed', 'Flight To New York.', '2014-10-23 23:00:00', NULL, 1),
(104, 50, 28, 18, 4, 'Phone', 0, 'Processed', 'New Expense Dfd', '2014-10-24 23:00:00', NULL, 1),
(105, 50, 28, 18, 4, 'Travel', 343, 'Unprocessed', 'new expense', '2014-10-24 23:00:00', NULL, 1),
(106, 50, 27, 19, 0, 'Accommodation', 0, 'Processed', 'Stayed Two Nights.', '2014-10-24 23:00:00', NULL, 0),
(107, 50, 28, 20, 0, 'Phone', 0, 'Processed', '', '2014-10-24 23:00:00', NULL, 1),
(108, 50, 27, 21, 0, 'Accommodation', 346, 'Unprocessed', '', '2014-10-24 23:00:00', NULL, 0),
(109, 50, 27, 22, 0, 'Accommodation', 199, 'Unprocessed', '', '2014-10-24 23:00:00', NULL, 0),
(110, 50, 27, 1, 0, 'Accommodation', 199, 'Unprocessed', '', '2014-10-24 23:00:00', NULL, 0),
(111, 50, 27, 1, 0, 'Accommodation', 199, 'Unprocessed', '', '2014-10-24 23:00:00', NULL, 0),
(112, 50, 27, 23, 0, 'Travel', 12, 'Unprocessed', '', '2014-10-24 23:00:00', NULL, 0),
(113, 50, 27, 24, 0, 'Travel', 0, 'Processed', '', '2014-10-24 23:00:00', NULL, 0),
(117, 50, 27, 25, 0, 'Accommodation', 34, 'Unprocessed', 'Dfasdf', '2014-10-24 23:00:00', NULL, 0),
(118, 50, 27, 1, 0, 'Accommodation', 34, 'Unprocessed', 'Dfasdf', '2014-10-24 23:00:00', NULL, 1),
(119, 50, 27, 1, 0, 'Accommodation', 34, 'Unprocessed', 'Dfasdf', '2014-10-24 23:00:00', NULL, 1),
(120, 50, 27, 1, 0, 'Accommodation', 34, 'Unprocessed', 'Dfasdf', '2014-10-24 23:00:00', NULL, 1),
(121, 50, 27, 1, 0, 'Accommodation', 34, 'Unprocessed', 'Dfasdf', '2014-10-24 23:00:00', NULL, 1),
(122, 50, 27, 1, 0, 'Accommodation', 34, 'Unprocessed', 'Dfasdf', '2014-10-24 23:00:00', NULL, 1),
(123, 50, 27, 1, 0, 'Accommodation', 34, 'Unprocessed', 'Dfasdf', '2014-10-24 23:00:00', NULL, 1),
(124, 50, 27, 1, 0, 'Accommodation', 34, 'Unprocessed', 'Dfasdf', '2014-10-24 23:00:00', NULL, 1),
(125, 50, 27, 1, 0, 'Accommodation', 34, 'Unprocessed', 'Dfasdf', '2014-10-24 23:00:00', NULL, 1),
(126, 50, 27, 1, 0, 'Accommodation', 34, 'Unprocessed', 'Dfasdf', '2014-10-24 23:00:00', NULL, 1),
(127, 50, 27, 1, 0, 'Accommodation', 34, 'Unprocessed', 'Dfasdf', '2014-10-24 23:00:00', NULL, 1),
(128, 50, 27, 1, 0, 'Accommodation', 34, 'Unprocessed', 'Dfasdf', '2014-10-24 23:00:00', NULL, 1),
(129, 50, 27, 1, 0, 'Accommodation', 34, 'Unprocessed', 'Dfasdf', '2014-10-24 23:00:00', NULL, 1),
(130, 50, 27, 1, 0, 'Accommodation', 34, 'Unprocessed', 'Dfasdf', '2014-10-24 23:00:00', NULL, 1),
(131, 50, 27, 1, 0, 'Accommodation', 34, 'Unprocessed', 'Dfasdf', '2014-10-24 23:00:00', NULL, 1),
(132, 50, 27, 26, 0, 'Travel', 43, 'Unprocessed', 'New', '2014-10-24 23:00:00', NULL, 1),
(133, 50, 27, 1, 0, 'Travel', 43, 'Unprocessed', 'New', '2014-10-24 23:00:00', NULL, 1),
(134, 50, 27, 1, 0, 'Travel', 43, 'Unprocessed', 'New', '2014-10-24 23:00:00', NULL, 1),
(135, 50, 27, 27, 0, 'Phone', 45, 'Unprocessed', 'Dfdfd', '2014-10-24 23:00:00', NULL, 0),
(136, 50, 27, 1, 0, 'Food', 54, 'Unprocessed', 'Dfdf', '2014-10-24 23:00:00', NULL, 0),
(137, 50, 27, 1, 0, 'Food', 54, 'Unprocessed', 'Dfdf', '2014-10-24 23:00:00', NULL, 0),
(138, 50, 27, 1, 0, 'Food', 54, 'Unprocessed', 'Dfdf', '2014-10-24 23:00:00', NULL, 0),
(139, 50, 27, 28, 0, 'Entertainment', 45, 'Unprocessed', 'Dfdsafsd', '2014-10-24 23:00:00', NULL, 0),
(140, 50, 27, 1, 0, 'Entertainment', 45, 'Unprocessed', 'Dfdsafsd', '2014-10-24 23:00:00', NULL, 0),
(141, 50, 27, 1, 0, 'Entertainment', 45, 'Unprocessed', 'Dfdsafsd', '2014-10-24 23:00:00', NULL, 0),
(142, 50, 27, 29, 0, 'Accommodation', 5666, 'Unprocessed', 'Gghhhhh', '2014-10-24 23:00:00', NULL, 0),
(143, 50, 27, 30, 0, 'Entertainment', 24, 'Unprocessed', 'Had Meeting With Tim From Audi.', '2014-10-25 23:00:00', NULL, 0),
(144, 50, 27, 31, 0, 'Entertainment', 0, 'Processed', 'Meeting With John', '2014-10-25 23:00:00', NULL, 0),
(145, 50, 27, 1, 0, 'Phone', 53, 'Unprocessed', '', '2014-10-25 23:00:00', NULL, 0),
(146, 50, 27, 32, 0, 'Entertainment', 433, 'Unprocessed', 'Night Out With Clients', '2014-10-25 23:00:00', NULL, 0),
(147, 50, 27, 33, 0, 'Entertainment', 4556, 'Unprocessed', 'Tghfg', '2014-10-25 23:00:00', NULL, 0),
(148, 50, 27, 34, 0, 'Entertainment', 566, 'Unprocessed', 'Gghhhhh', '2014-10-25 23:00:00', NULL, 0),
(149, 50, 27, 35, 0, 'Accommodation', 66, 'Unprocessed', 'Tyhhuutf', '2014-10-25 23:00:00', NULL, 0),
(150, 50, 27, 36, 0, 'Accommodation', 0, 'Processed', 'Ttyuuhhgg', '2014-10-25 23:00:00', NULL, 1),
(151, 50, 27, 58, 0, 'Accommodation', 566, 'Unprocessed', 'Yhvhhhj', '2014-11-02 00:00:00', NULL, 0),
(152, 50, 27, 59, 31, 'Accommodation', 566, 'Unprocessed', 'Ghgcghh', '2014-11-02 00:00:00', NULL, 1),
(154, 50, 27, 61, 32, 'Accommodation', 0, 'Processed', 'Refresh Comment', '2014-11-02 00:00:00', NULL, 0),
(155, 50, 27, 62, 33, 'Accommodation', 0, 'Processed', 'Xmas Prize', '2014-11-02 00:00:00', NULL, 0),
(352, 50, 27, 7, 34, 'Accommodation', 5677, 'Unprocessed', 'Gghhhvv', '2014-11-02 00:00:00', NULL, 0),
(355, 50, 28, 77, 1, 'Entertainment', 45325, 'Unprocessed', 'Ghfdghfg', '2014-11-02 00:00:00', NULL, 0),
(356, 50, 28, 77, 1, 'Entertainment', 45325, 'Unprocessed', 'Ghfdghfg', '2014-11-02 00:00:00', NULL, 0),
(357, 50, 28, 7, 1, 'Accommodation', 3434, 'Unprocessed', 'Dfasdfd', '2014-11-02 00:00:00', NULL, 1),
(358, 50, 27, 7, 1, 'Travel', 325, 'Unprocessed', 'Expensive', '2014-11-02 00:00:00', NULL, 0),
(359, 50, 27, 80, 1, 'Entertainment', 0, 'Processed', 'Fadsfsd', '2014-11-02 00:00:00', NULL, 0),
(360, 50, 27, 81, 35, 'Entertainment', 5673, 'Unprocessed', 'Upload Working', '2014-11-02 00:00:00', NULL, 1),
(361, 50, 27, 82, 36, 'Phone', 0, 'Unprocessed', 'Working...dfdafsd', '2014-11-02 00:00:00', NULL, 0),
(362, 50, 27, 83, 37, 'Accommodation', 0, 'Processed', 'Tghhfdghhh', '2014-11-07 00:00:00', NULL, 0),
(363, 50, 27, 84, 38, 'Accommodation', 46, 'Unprocessed', 'Nive', '2014-11-08 00:00:00', NULL, 0),
(365, 50, 27, 1, 39, 'Phone', 46, 'Unprocessed', '', NULL, NULL, 0),
(366, 50, 27, 86, 40, 'Phone', 43, 'Unprocessed', '', NULL, NULL, 0),
(367, 50, 27, 87, 41, 'Phone', 14, 'Unprocessed', 'Nrw', NULL, NULL, 0),
(368, 50, 27, 88, 47, 'Accommodation', 667, 'Unprocessed', 'Ghhfhhh', NULL, NULL, 0),
(369, 50, 27, 89, 48, 'Accommodation', 5666, 'Unprocessed', 'Fggfhhv', NULL, NULL, 0),
(370, 50, 27, 90, 49, 'Food', 5677, 'Unprocessed', 'Tyhffyhh', NULL, NULL, 0),
(371, 50, 27, 91, 50, 'Accommodation', 666, 'Unprocessed', 'Tggggh', NULL, NULL, 0),
(372, 50, 27, 92, 51, 'Phone', 566, 'Unprocessed', 'Fhhgghhhgf', NULL, NULL, 0),
(373, 50, 27, 93, 53, 'Entertainment', 56677, 'Unprocessed', 'Tycghhhu', NULL, NULL, 0),
(374, 50, 27, 94, 54, 'Phone', 567, 'Unprocessed', 'Fhhggh', NULL, NULL, 0),
(375, 50, 27, 95, 55, 'Phone', 566, 'Unprocessed', 'Tggfghh', NULL, NULL, 0),
(376, 50, 27, 96, 56, 'Entertainment', 47, 'Unprocessed', 'This Is A Comment', NULL, NULL, 0),
(377, 50, 27, 97, 57, 'Phone', 5678, 'Unprocessed', 'Fgyrghhh', NULL, NULL, 0),
(378, 50, 27, 98, 60, 'Food', 8888, 'Unprocessed', 'Water', NULL, NULL, 0),
(379, 50, 27, 1, 61, 'Food', 0, 'Unprocessed', 'Gghgg', NULL, NULL, 1),
(380, 50, 27, 99, 62, 'Phone', 0, 'Unprocessed', 'Ghfghhhgff', NULL, NULL, 1),
(381, 50, 27, 100, 63, 'Accommodation', 0, 'Unprocessed', 'Tygfhhhgff', NULL, NULL, 1),
(382, 50, 27, 101, 64, 'Accommodation', 0, 'Unprocessed', 'Ghgghhf', NULL, NULL, 1),
(383, 50, 27, 102, 65, 'Entertainment', 1.98, 'Unprocessed', 'This Is Clean Comment', NULL, NULL, 0),
(384, 50, 27, 103, 66, 'Entertainment', 29.291, 'Unprocessed', 'Ghgffh', NULL, NULL, 1),
(385, 50, 27, 104, 67, 'Accommodation', 91, 'Unprocessed', 'Ghgjjkrff Dgh', '2015-01-04 18:49:31', '', 0),
(386, 50, 27, 105, 68, 'Phone', 5.99, 'Unprocessed', 'Fhggh', '2015-01-04 19:29:50', NULL, 0),
(387, 50, 28, 1, 1, 'Accommodation', 199, 'Unprocessed', 'No Comment', '2015-01-04 22:10:56', NULL, 0),
(388, 50, 28, 106, 1, 'Entertainment', 499.99, 'Processed', 'Meal With Team', '2015-01-04 22:13:01', NULL, 0),
(389, 50, 27, 1, 69, 'Entertainment', 200.21, 'Unprocessed', 'Meeting With Eddie', '2015-02-10 22:20:22', NULL, 0),
(390, 50, 28, 1, 1, 'Entertainment', 99.99, 'Unprocessed', '', '2015-01-04 22:32:38', NULL, 0),
(391, 50, 28, 1, 1, 'Entertainment', 199.21, 'Unprocessed', '', '2015-02-24 22:35:09', NULL, 0),
(392, 50, 28, 1, 1, 'Entertainment', 1099.32, 'Unprocessed', '', '2015-03-01 22:38:10', NULL, 0),
(397, 50, 28, 106, 1, 'Entertainment', 10119.2, 'Unprocessed', '', '2015-04-30 22:00:05', NULL, 0),
(398, 50, 28, 106, 1, 'Entertainment', 11200, 'Unprocessed', 'Meeting With Irish Examiner', '2015-06-15 22:09:21', NULL, 0),
(399, 50, 28, 18, 1, 'Travel', 199.99, 'Processed', 'Flight To London For Meeting With Tim.', '2015-01-04 23:10:20', NULL, 1),
(400, 50, 27, 18, 70, 'Travel', 590.99, 'Unprocessed', 'Flight To Boston', '2015-01-04 23:15:42', NULL, 0),
(401, 50, 28, 1, 1, 'Phone', 390.03, 'Unprocessed', 'Team Night Out.', '2015-01-04 23:19:35', 'X1', 0),
(402, 50, 28, 107, 1, 'Food', 590.43, 'Unprocessed', '', '2015-01-04 23:21:06', 'Dfdf', 1),
(403, 50, 28, 108, 1, 'Entertainment', 20.09, 'Unprocessed', '', '2015-01-04 23:23:29', NULL, 1),
(404, 50, 28, 1, 1, 'Entertainment', 190.32, 'Unprocessed', '', '2015-01-04 23:24:14', NULL, 1),
(405, 50, 28, 110, 1, 'Entertainment', 29.45, 'Unprocessed', 'Cork Airport Drinks.', '2015-01-04 23:26:32', NULL, 1),
(406, 50, 28, 111, 1, 'Accommodation', 19.99, 'Unprocessed', 'Fgsdfg', '2015-01-08 16:37:13', 'X1trsd', 1),
(407, 50, 27, 112, 71, 'Phone', 23.64, 'Unprocessed', '', '2015-01-08 18:03:01', 'X1', 1),
(408, 50, 47, 113, 72, 'Phone', 12.65, 'Unprocessed', NULL, '2015-01-09 23:03:06', 'Zx', 1),
(409, 50, 48, 114, 73, 'Accommodation', 23.65, 'Processed', 'Dfasdfsadf', '2015-01-10 00:00:05', 'Zx', 0),
(410, 50, 28, 115, 1, 'Travel', 12.56, 'Unprocessed', '', '2015-01-13 11:36:33', '', 1),
(411, 50, 27, 115, 1, 'Accommodation', 87, 'Unprocessed', NULL, '2015-01-13 21:21:52', '', 1),
(412, 50, 27, 115, 1, 'Accommodation', 87, 'Unprocessed', '', '2015-01-13 21:21:53', 'Xs', 1),
(413, 50, 27, 78, 1, 'Travel', 34.87, 'Processed', '', '2015-01-13 21:40:04', '', 1),
(414, 50, 27, 78, 1, 'Travel', 34.87, 'Unprocessed', NULL, '2015-01-13 21:40:04', '', 1),
(415, 50, 28, 106, 1, 'Food', 199, 'Unprocessed', '', '2015-01-13 21:43:41', '', 1),
(416, 50, 28, 106, 1, 'Entertainment', 199, 'Unprocessed', NULL, '2015-01-13 21:43:41', '', 1),
(417, 50, 28, 116, 1, 'Travel', 23.98, 'Unprocessed', NULL, '2015-01-13 21:49:08', '', 1),
(418, 50, 28, 116, 1, 'Travel', 23.98, 'Unprocessed', NULL, '2015-01-13 21:49:08', '', 1),
(419, 50, 28, 117, 1, 'Phone', 2.87, 'Unprocessed', NULL, '2015-01-13 21:58:33', '', 1),
(420, 50, 28, 117, 1, 'Food', 9.99, 'Unprocessed', '', '2015-01-13 21:58:33', '', 1),
(421, 50, 28, 118, 1, 'Travel', 200.09, 'Unprocessed', '', '2015-01-13 22:04:22', '', 0),
(422, 50, 28, 118, 1, 'Travel', 2.09, 'Unprocessed', NULL, '2015-01-13 22:04:22', '', 1),
(423, 50, 28, 119, 1, 'Travel', 23.87, 'Unprocessed', NULL, '2015-01-13 22:11:23', '', 1),
(424, 50, 28, 119, 1, 'Travel', 23.87, 'Unprocessed', NULL, '2015-01-13 22:11:23', '', 1),
(425, 50, 28, 119, 1, 'Travel', 23.87, 'Unprocessed', NULL, '2015-01-13 22:11:23', '', 1),
(426, 50, 28, 119, 1, 'Travel', 23.87, 'Unprocessed', NULL, '2015-01-13 22:11:23', '', 1),
(427, 50, 28, 120, 1, 'Travel', 23.09, 'Unprocessed', NULL, '2015-01-13 22:13:46', '', 1),
(428, 50, 28, 120, 1, 'Travel', 23.09, 'Unprocessed', NULL, '2015-01-13 22:13:46', '', 1),
(429, 50, 28, 121, 1, 'Accommodation', 32.09, 'Unprocessed', NULL, '2015-01-13 22:16:07', '', 1),
(430, 50, 28, 121, 1, 'Accommodation', 32.09, 'Unprocessed', NULL, '2015-01-13 22:16:11', '', 1),
(431, 50, 28, 122, 1, 'Phone', 32.09, 'Unprocessed', NULL, '2015-01-13 22:20:30', '', 1),
(432, 50, 28, 122, 1, 'Phone', 32.09, 'Unprocessed', NULL, '2015-01-13 22:20:32', '', 1),
(433, 50, 28, 123, 1, 'Travel', 2.4, 'Unprocessed', NULL, '2015-01-13 22:23:10', '', 1),
(434, 50, 28, 123, 1, 'Travel', 2.4, 'Unprocessed', NULL, '2015-01-13 22:23:15', '', 1),
(435, 50, 28, 124, 1, 'Travel', 2.98, 'Unprocessed', NULL, '2015-01-13 22:28:04', '', 1),
(436, 50, 28, 124, 1, 'Travel', 2.98, 'Unprocessed', NULL, '2015-01-13 22:28:07', '', 1),
(437, 50, 28, 125, 1, 'Travel', 32.74, 'Unprocessed', NULL, '2015-01-13 22:35:08', '', 1),
(438, 50, 28, 125, 1, 'Travel', 32.74, 'Unprocessed', NULL, '2015-01-13 22:35:11', '', 1),
(439, 50, 28, 126, 1, 'Entertainment', 23.09, 'Unprocessed', NULL, '2015-01-13 22:41:41', '', 1),
(440, 50, 28, 127, 1, 'Entertainment', 3.99, 'Unprocessed', NULL, '2015-01-13 22:50:38', '', 1),
(441, 50, 28, 128, 1, 'Entertainment', 23.09, 'Unprocessed', NULL, '2015-01-13 22:52:43', '', 1),
(442, 50, 28, 128, 1, 'Entertainment', 23.09, 'Unprocessed', NULL, '2015-01-13 22:53:21', '', 1),
(443, 50, 28, 128, 1, 'Travel', 123.09, 'Unprocessed', '', '2015-01-13 22:54:19', '', 0),
(444, 50, 28, 128, 1, 'Entertainment', 23.09, 'Unprocessed', NULL, '2015-01-13 22:54:52', '', 1),
(445, 50, 28, 129, 1, 'Phone', 3.09, 'Unprocessed', NULL, '2015-01-13 22:56:21', '', 1),
(446, 50, 28, 129, 1, 'Phone', 3.09, 'Unprocessed', NULL, '2015-01-13 22:56:24', '', 1),
(447, 50, 28, 130, 1, 'Entertainment', 2.3, 'Unprocessed', NULL, '2015-01-13 22:59:15', '', 1),
(448, 50, 28, 27, 1, 'Phone', 2.3, 'Unprocessed', NULL, '2015-01-13 23:07:12', '', 1),
(449, 50, 28, 131, 1, 'Accommodation', 49.99, 'Processed', '', '2015-01-13 23:08:48', '', 1),
(450, 50, 28, 132, 1, 'Entertainment', 43.21, 'Unprocessed', 'Dfasdfsadasdf', '2015-01-13 23:41:17', '', 1),
(451, 50, 28, 115, 1, 'Food', 1000.34, 'Processed', '', '2015-01-13 23:50:58', 'Googlexvalx', 0),
(452, 50, 28, 106, 1, 'Food', 199.32, 'Unprocessed', 'Dinning With Googlex Team', '2015-01-13 23:53:56', 'Googlex', 1),
(453, 50, 28, 133, 1, 'Accommodation', 34, 'Unprocessed', '', '2015-01-15 17:55:21', '', 1),
(454, 50, 48, 134, 74, 'Entertainment', 54.78, 'Processed', '', '2015-01-15 19:51:11', '', 1),
(455, 50, 27, 135, 1, 'Food', 1000.12, 'Unprocessed', '', '2015-01-22 09:54:34', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `journeys`
--

CREATE TABLE `journeys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `origin` varchar(150) NOT NULL,
  `destination` varchar(150) NOT NULL,
  `distance` decimal(10,2) NOT NULL,
  `journey_time` time NOT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(100) DEFAULT 'Unprocessed',
  `comment` varchar(300) DEFAULT NULL,
  `account` varchar(150) DEFAULT NULL,
  `is_deleted` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

--
-- Dumping data for table `journeys`
--

INSERT INTO `journeys` (`id`, `admin_id`, `user_id`, `origin`, `destination`, `distance`, `journey_time`, `date`, `status`, `comment`, `account`, `is_deleted`) VALUES
(1, 48, 3, '85 lus na meala, banduff, cork', 'popes quay, cork', 5.00, '00:20:14', '2014-10-19 23:00:00', '', 'had meeting with john from supervalue', NULL, 1),
(2, 48, 2, 'here', 'there', 5.00, '00:20:14', '2014-10-13 23:00:00', '', 'bla bla', NULL, 1),
(3, 48, 1, '85 lus na meala, banduff, cork', 'main street dublin', 234.00, '00:00:02', '2014-10-13 23:00:00', 'processed', 'meeting with tim in dublin', NULL, 1),
(4, 48, 1, 'patricks street cork city', 'main street waterford city', 150.00, '00:00:01', '2014-10-19 23:00:00', 'unprocessed', 'meeting with john', NULL, 1),
(5, 48, 1, 'merchants quay, cork city', '85 lus na meala, banduff, cork', 5.00, '00:00:15', '2014-10-21 23:00:00', 'processed', 'blablabla', NULL, 1),
(6, 48, 1, '13 south douglas road, cork city', 'patricks street cork city', 3.00, '00:00:05', '2014-10-29 00:00:00', 'processed', 'blablabla', NULL, 1),
(7, 48, 1, '39 cross douglas road', 'dublin', 290.00, '00:00:02', '2014-10-14 23:00:00', 'processed', '', NULL, 1),
(8, 48, 1, 'here', 'there', 4.00, '00:00:43', '2014-10-15 23:00:00', 'processed', 'blablabla', NULL, 1),
(9, 48, 1, 'here ', 'there', 343.00, '00:00:45', '2014-10-20 23:00:00', 'processed', 'blablabbla', NULL, 1),
(10, 48, 1, 'here', 'there', 3.00, '00:00:04', '2014-10-06 23:00:00', 'processed', 'blablabla', NULL, 1),
(11, 48, 1, 'here ', 'there', 34.00, '00:00:21', '2014-10-28 00:00:00', 'unprocessed', 'blablabla', NULL, 1),
(12, 48, 2, 'here ', 'there', 200.00, '00:02:00', '2014-10-17 13:26:30', 'Unprocessed', 'testing', NULL, 1),
(13, 48, 2, 'xxxxxxxx', 'xxxxxxxx', 2000.00, '00:20:00', '2014-10-17 13:31:20', 'Unprocessed', 'xxxxxxx', NULL, 1),
(14, 48, 2, 'yyyyyyyy', 'yyyyyyy', 200.00, '00:03:00', '0000-00-00 00:00:00', 'Unprocessed', 'this is a comment', NULL, 1),
(15, 48, 2, 'here', 'there', 0.00, '00:00:19', '2014-10-19 10:34:53', 'Unprocessed', 'this is a comment', NULL, 1),
(16, 48, 9, 'here', 'there', 343.00, '00:00:23', '2014-10-19 10:45:09', 'Unprocessed', 'this is a comment', NULL, 1),
(17, 48, 9, 'here', 'there', 343.00, '04:53:24', '2014-10-19 11:14:04', 'Unprocessed', 'this is a comment', NULL, 1),
(18, 48, 9, 'here', 'there', 343.00, '04:53:24', '2014-10-19 11:14:09', 'Unprocessed', 'this is a comment', NULL, 1),
(19, 48, 9, 'here', 'there', 343.00, '04:53:24', '2014-10-19 11:14:09', 'Unprocessed', 'this is a comment', NULL, 1),
(20, 48, 9, 'here', 'there', 343.00, '04:53:24', '2014-10-19 11:14:21', 'Unprocessed', 'this is a comment', NULL, 1),
(21, 48, 9, 'here', 'there', 343.00, '04:53:24', '2014-10-19 11:14:21', 'Unprocessed', 'this is a comment', NULL, 1),
(22, 48, 9, 'here', 'there', 343.00, '04:53:24', '2014-10-19 11:14:21', 'Unprocessed', 'this is a comment', NULL, 1),
(23, 48, 11, 'lus na meala', 'patricks street', 5.00, '00:00:03', '2014-10-19 11:19:35', 'Unprocessed', 'this is a comment', NULL, 1),
(24, 48, 12, '85 lus na meala, banduff, co cork', 'main st waterford', 154.00, '00:00:01', '2014-10-22 11:21:09', 'Unprocessed', '', NULL, 1),
(25, 48, 13, '85 lus na meala, banduff, co cork', 'main st,waterford', 150.00, '00:00:01', '2014-10-22 13:05:51', 'Unprocessed', 'had meeting with tim from...', NULL, 0),
(26, 48, 13, '68 barracks st, cork city', 'tron house, docklands, dublin', 320.00, '00:00:03', '2014-10-22 13:07:42', 'Unprocessed', 'meeting', NULL, 0),
(27, 48, 17, '74 popes quay, cork city', '10 air square, galway city', 240.00, '00:00:02', '2014-10-22 13:09:57', 'Unprocessed', 'sales', NULL, 0),
(28, 48, 21, '12 lotabeg, mayfield, cork', 'main st , kilkenny town, kilkenny', 190.00, '00:01:56', '2014-10-22 13:14:46', 'Unprocessed', 'meeting with....', NULL, 0),
(29, 48, 20, '10 grove place, clyone, co cork', '9 patricks street, cork city', 21.00, '00:00:15', '2014-10-22 13:17:03', 'Unprocessed', 'meeting with...', NULL, 1),
(30, 50, 27, '85 Lus Na Meala, Banduff, Cork City', '10 Patricks Street, Cork Citaaa', 0.00, '00:00:00', '2014-10-23 08:49:33', 'Processed', 'New New New', NULL, 1),
(31, 50, 27, '10 Popes Quay, Cork City', 'South Wall, Dublin Docklands', 0.00, '00:00:00', '2014-10-23 08:51:45', 'Processed', 'Meeting With Sean From Ibm.', NULL, 1),
(32, 50, 28, '43 Upper Lotabeg Drive, Co Cork', '99 Fairhill, Cork City', 10.00, '00:00:00', '2014-10-23 08:53:10', 'Processed', 'Meeting With Timmy.', 'X1', 1),
(33, 50, 27, '', '', 0.00, '00:00:00', '2014-11-07 23:08:33', 'Processed', '', NULL, 1),
(34, 50, 27, '', '', 0.00, '00:00:00', '2014-11-07 23:12:02', 'Unprocessed', '', NULL, 1),
(35, 50, 27, 'Here', 'There', 0.00, '00:00:21', '2014-11-07 23:13:04', 'Unprocessed', 'Dfasdfasd', NULL, 1),
(36, 50, 27, '86 Lus Na Meala, Co. Cork, Ireland', '86 Lus Na Meala, Co. Cork, Ireland', 0.00, '00:00:00', '2014-11-07 23:20:57', 'Processed', 'Meeting With Tim', NULL, 1),
(37, 50, 27, '86 Lus Na Meala, Co. Cork, Ireland', '85 Lus Na Meala, Co. Cork, Ireland', 0.00, '00:10:43', '2014-11-07 23:27:11', 'Unprocessed', 'Meeting With Tim', NULL, 1),
(38, 50, 27, 'There', 'Here', 0.00, '00:00:00', '2014-11-07 23:30:08', 'Unprocessed', 'Dfadsfsd', NULL, 1),
(39, 50, 27, '49 Lus Na Meala, Co. Cork, Ireland', '85 Lus Na Meala, Co. Cork, Ireland', 100.00, '00:01:00', '2014-11-07 23:43:16', 'Unprocessed', 'Ghcbvcbv', '', 1),
(40, 50, 27, '87 Lus Na Meala, Co. Cork, Ireland', '87 Lus Na Meala, Co. Cork, Ireland', 0.00, '00:00:07', '2014-11-08 00:03:13', 'Unprocessed', 'Meeting With Tim', NULL, 1),
(41, 50, 27, '85 Lus Na Meala, Co. Cork, Ireland', '85 Lus Na Meala, Co. Cork, Ireland', 15.00, '00:00:30', '2015-01-04 17:49:48', 'Unprocessed', 'Meeting With Timmy From Evening Echo.', '', 0),
(42, 50, 27, '85-86 Lus Na Meala, Co. Cork, Ireland', '85 Lus Na Meala, Co. Cork, Ireland', 0.00, '00:00:21', '2015-01-04 18:05:46', 'Unprocessed', 'Clean Comment', NULL, 1),
(43, 50, 27, '85 Lus Na Meala, Co. Cork, Ireland', '85-86 Lus Na Meala, Co. Cork, Ireland', 0.00, '00:00:19', '2015-01-04 18:08:50', 'Unprocessed', 'Clean Comment 2', NULL, 1),
(44, 50, 27, '86 Lus Na Meala, Co. Cork, Ireland', '85 Lus Na Meala, Co. Cork, Ireland', 0.00, '00:00:13', '2015-01-04 19:45:14', 'Unprocessed', 'New Comment', NULL, 1),
(45, 50, 28, 'Here', 'There', 12.00, '00:10:26', '2015-01-08 17:10:34', 'Unprocessed', '', 'Project X', 1),
(46, 50, 28, 'Dfsdfdfdfasdf', 'Theresadfasdf', 10.00, '00:00:10', '2015-01-08 17:14:51', 'Processed', 'Bla Bla', 'Test Projects', 0),
(47, 50, 27, '86 Lus Na Meala, Co. Cork, Ireland', '86 Lus Na Meala, Co. Cork, Ireland', 0.00, '00:00:32', '2015-01-08 18:10:15', 'Processed', '', 'X1', 1),
(48, 50, 28, 'Here', 'There', 1.00, '00:32:23', '2015-01-13 22:28:49', 'Unprocessed', '', '', 1),
(49, 50, 28, '85 Lus Na Meala, Cork City', '32 Patrick\\''s St, Cork City', 4.00, '00:20:34', '2015-01-14 18:58:54', 'Unprocessed', '', '', 1),
(50, 50, 27, '85 Lus Na Meala, Cork City', 'Popes Quay, Cork', 0.00, '00:30:00', '2015-01-14 21:06:22', 'Processed', '', '', 1),
(51, 50, 28, 'Sdfssdfdfasd', 'Dfdfasdfssdf', 15.00, '00:00:01', '2015-01-15 11:35:52', 'Processed', 'Sdff', 'Asdfdf', 0),
(52, 50, 48, '82-83 Lus Na Meala, Co. Cork, Ireland', '82-83 Lus Na Meala, Co. Cork, Ireland', 10.00, '00:00:04', '2015-01-15 20:14:17', 'Unprocessed', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `merchants`
--

CREATE TABLE `merchants` (
  `merchant_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL,
  `merchant_name` varchar(100) NOT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`merchant_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=136 ;

--
-- Dumping data for table `merchants`
--

INSERT INTO `merchants` (`merchant_id`, `admin_id`, `merchant_name`, `is_deleted`) VALUES
(1, 50, 'clarion hotel', 0),
(2, 48, 'clarion hotelghfdh', 0),
(3, 48, 'clarion hotelghfdhtdfgd', 0),
(4, 48, 'ryanair', 0),
(5, 48, 'vodafone', 0),
(6, 48, 'kfcs', 0),
(7, 48, 'fish wife', 0),
(8, 48, '3 mobile', 0),
(9, 48, 'jurys hotel', 0),
(10, 48, 'soho', 0),
(11, 48, 'aerlingus', 0),
(12, 48, 'electric bar', 0),
(13, 48, 'market lane', 0),
(14, 50, 'Cliff House Hotel', 0),
(15, 50, 'Meteor', 0),
(16, 50, 'United Airlines', 0),
(17, 50, 'Kcs', 0),
(18, 50, 'British Airways', 0),
(19, 50, 'Travel Lodge', 0),
(20, 50, 'Emobile', 0),
(21, 50, 'Imperial Hotel', 0),
(22, 50, 'Grand Parade Hotel', 0),
(23, 50, 'Eircom', 0),
(24, 50, 'Buseireann', 0),
(25, 50, 'Dfdf', 0),
(26, 50, 'Thereee', 0),
(27, 50, 'Dfadsf', 0),
(28, 50, 'Dfdsafd', 0),
(29, 50, 'Thhhhhh', 0),
(30, 50, 'Corner House', 0),
(31, 50, 'Anglers', 0),
(32, 50, 'Opera House', 0),
(33, 50, 'Qw', 0),
(34, 50, 'We', 0),
(35, 50, 'Er', 0),
(36, 50, 'Rty', 0),
(37, 50, 'Tyyuuu', 0),
(38, 50, 'Tthhj', 0),
(39, 50, 'Thhjjj', 0),
(40, 50, 'Yyhhh', 0),
(41, 50, 'Tyhhjj', 0),
(42, 50, 'Tyyu', 0),
(43, 50, 'Ghhhgghb', 0),
(44, 50, 'Gghh', 0),
(45, 50, 'Gghhhhgf', 0),
(46, 50, 'Gggg', 0),
(47, 50, 'Fgbbh', 0),
(48, 50, '', 0),
(49, 50, 'Gghhgh', 0),
(50, 50, 'Ghgchh', 0),
(51, 50, 'Ghhvv', 0),
(52, 50, 'Fggv', 0),
(53, 50, 'Fggggh', 0),
(54, 50, 'Ggggg', 0),
(55, 50, 'Gghb', 0),
(56, 50, 'Ggbbh', 0),
(57, 50, 'Ghh', 0),
(58, 50, 'Fghhhhcff', 0),
(59, 50, 'Fvccv', 0),
(60, 50, 'Ghhb', 0),
(61, 50, 'Juhhhjj', 0),
(62, 50, 'Primetime', 0),
(63, 50, 'Dfasdgfhga', 0),
(64, 50, 'Pier25', 0),
(65, 50, 'Pidfasdfgsg', 0),
(66, 50, 'Pidfasdfgsgdfdsfsd', 0),
(67, 50, 'Pidfasdfgsgdf', 0),
(68, 50, 'Pidfasdfgsgdfdfdfd', 0),
(69, 50, 'Munch', 0),
(70, 50, 'Dfasdfsd', 0),
(71, 50, 'Hereres', 0),
(72, 50, 'Dfhsdfgh', 0),
(73, 50, 'Fasdofuaso', 0),
(74, 50, 'Dfasdfsadf', 0),
(75, 50, 'Ghgghhhjjh', 0),
(76, 50, 'Dfasdfasdfhgh', 0),
(77, 50, 'Dfjgdhdfgh', 0),
(78, 50, 'Herethere', 0),
(79, 50, 'Virgin Train', 0),
(80, 50, 'Sextant', 0),
(81, 50, 'Me', 0),
(82, 50, 'Ghvbhjh', 0),
(83, 50, 'Tayto', 0),
(84, 50, 'Glideee', 0),
(85, 50, '4mobile', 0),
(86, 50, '65mobile', 0),
(87, 50, 'Whocall', 0),
(88, 50, 'Gghgghhgff', 0),
(89, 50, 'Fgffhfdf', 0),
(90, 50, 'Fgggggv', 0),
(91, 50, 'Gggghssssssssds', 0),
(92, 50, 'Fgffhh', 0),
(93, 50, 'Fggcg', 0),
(94, 50, 'Fggdgguuiijfdd', 0),
(95, 50, 'Pppppplhggf', 0),
(96, 50, 'Merchats Name Df', 0),
(97, 50, 'Fggfhgfddghh', 0),
(98, 50, 'Irish Water', 0),
(99, 50, 'Dgdgghjjuuytr', 0),
(100, 50, 'Fgffhghvfdf', 0),
(101, 50, 'Tgggggfgg', 0),
(102, 50, 'Hmvmusic', 0),
(103, 50, 'Painttttt', 0),
(104, 50, 'Fhfghfeesdiio', 0),
(105, 50, 'Fhgghfggfghdss', 0),
(106, 50, 'Jacobs On The Mall', 0),
(107, 50, 'East Village Bar', 0),
(108, 50, 'The Corner Public House', 0),
(109, 50, 'The Bru Bar And Hostel', 0),
(110, 50, 'The Last Call Pub', 0),
(111, 50, 'Bar25', 0),
(112, 50, 'Fgghhgrrok', 0),
(113, 50, 'P4u', 0),
(114, 50, 'Tyuuui', 0),
(115, 50, 'Aer Lingus', 0),
(116, 50, 'Dfhfgh', 0),
(117, 50, 'Fghsdfg', 0),
(118, 50, 'Dfasdfasd', 0),
(119, 50, 'Dfaouoadf', 0),
(120, 50, 'Ourad', 0),
(121, 50, 'Oidf7dfa', 0),
(122, 50, 'Dfagsfagdf', 0),
(123, 50, 'Ddf43ggu', 0),
(124, 50, 'Dfasd98df', 0),
(125, 50, 'Dfasdfasdfa', 0),
(126, 50, 'Dfasdf45fad', 0),
(127, 50, 'Dfasd45g', 0),
(128, 50, 'Dfasd', 0),
(129, 50, 'Dfadf4dash', 0),
(130, 50, 'Dfasdf454', 0),
(131, 50, 'The Half Way House', 0),
(132, 50, 'Dfd', 0),
(133, 50, 'Dfaddfqwe', 0),
(134, 50, 'Fgfggffhvxder', 0),
(135, 50, 'Biabia', 0);

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `note_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL,
  `note` varchar(5000) DEFAULT NULL,
  `note_datetime` datetime NOT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`note_id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `receipts`
--

CREATE TABLE `receipts` (
  `receipt_id` int(11) NOT NULL AUTO_INCREMENT,
  `receipt_image` varchar(100) NOT NULL DEFAULT '../uploads/receiptImages/defaultReceipt.png',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`receipt_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=75 ;

--
-- Dumping data for table `receipts`
--

INSERT INTO `receipts` (`receipt_id`, `receipt_image`, `is_deleted`) VALUES
(1, 'default', 0),
(2, 'receipt for mike larry goes here', 0),
(3, 'timmys receipt image goes here', 0),
(4, '../uploads/receiptImages/defaultReceipt.png', 0),
(5, '../../uploads/receiptImages/1414952251591.jpg', 0),
(6, '../../uploads/receiptImages/1414952496806.jpg', 0),
(7, '../../uploads/receiptImages/1414952787205.jpg', 0),
(8, '../../uploads/receiptImages/1414952901799.jpg', 0),
(9, '../../uploads/receiptImages/1414953010714.jpg', 0),
(10, '../../uploads/receiptImages/1414953106919.jpg', 0),
(11, '../../uploads/receiptImages/1414953434231.jpg', 0),
(12, '../../uploads/receiptImages/1414957574751.jpg', 0),
(13, '../../uploads/receiptImages/1414957992075.jpg', 0),
(14, '../../uploads/receiptImages/1414958235211.jpg', 0),
(15, '../../uploads/receiptImages/1414958478073.jpg', 0),
(16, '../../uploads/receiptImages/1414958704611.jpg', 0),
(17, '../../uploads/receiptImages/1414959095729.jpg', 0),
(18, '../../uploads/receiptImages/1414959277542.jpg', 0),
(19, '../../uploads/receiptImages/1414959582588.jpg', 0),
(20, '../../uploads/receiptImages/1414959727311.jpg', 0),
(21, '../../uploads/receiptImages/1414960038052.jpg', 0),
(22, '../../uploads/receiptImages/1414960145764.jpg', 0),
(23, '../../uploads/receiptImages/1414960276301.jpg', 0),
(24, '../../uploads/receiptImages/1414960438393.jpg', 0),
(25, '../../uploads/receiptImages/1414960556749.jpg', 0),
(26, '../../uploads/receiptImages/1414960694858.jpg', 0),
(27, '../../uploads/receiptImages/1414960805605.jpg', 0),
(28, '../../uploads/receiptImages/1414960935731.jpg', 0),
(29, '../../uploads/receiptImages/1414961052363.jpg', 0),
(30, '../../uploads/receiptImages/1414961344192.jpg', 0),
(31, '../../uploads/receiptImages/1414961586213.jpg', 0),
(32, '../uploads/receiptImages/1414962236666.jpg', 0),
(33, '../uploads/receiptImages/1414962362533.jpg', 0),
(34, '../uploads/receiptImages/1414965971829.jpg', 0),
(35, '../uploads/receiptImages/1414967727163.jpg', 0),
(36, '../uploads/receiptImages/1414969635523.jpg', 0),
(37, '../uploads/receiptImages/1415398423928.jpg', 0),
(38, '../uploads/receiptImages/1415405278321.jpg', 0),
(39, '../uploads/receiptImages/1419104474519.jpg', 0),
(40, '../uploads/receiptImages/1419104533540.jpg', 0),
(41, '../uploads/receiptImages/1420223276522.jpg', 0),
(42, '../uploads/receiptImages/1420298121815.jpg', 0),
(43, '../uploads/receiptImages/1420299175115.jpg', 0),
(44, '../uploads/receiptImages/1420299285290.jpg', 0),
(45, '../uploads/receiptImages/1420299503886.jpg', 0),
(46, '../uploads/receiptImages/1420300414346.jpg', 0),
(47, '../uploads/receiptImages/1420301246482.jpg', 0),
(48, '../uploads/receiptImages/1420301760451.jpg', 0),
(49, '../uploads/receiptImages/1420301981323.jpg', 0),
(50, '../uploads/receiptImages/1420302463790.jpg', 0),
(51, '../uploads/receiptImages/1420302855134.jpg', 0),
(52, '../uploads/receiptImages/1420302904322.jpg', 0),
(53, '../uploads/receiptImages/1420303177819.jpg', 0),
(54, '../uploads/receiptImages/1420303215561.jpg', 0),
(55, '../uploads/receiptImages/1420304298253.jpg', 0),
(56, '../uploads/receiptImages/1420304399807.jpg', 0),
(57, '../uploads/receiptImages/1420304628853.jpg', 0),
(58, '../uploads/receiptImages/1420304893358.jpg', 0),
(59, '../uploads/receiptImages/1420389454600.jpg', 0),
(60, '../uploads/receiptImages/1420389487501.jpg', 0),
(61, '../uploads/receiptImages/1420389586196.jpg', 0),
(62, '../uploads/receiptImages/1420389841422.jpg', 0),
(63, '../uploads/receiptImages/1420390046481.jpg', 0),
(64, '../uploads/receiptImages/1420390327985.jpg', 0),
(65, '../uploads/receiptImages/1420394790651.jpg', 0),
(66, '../uploads/receiptImages/1420394877524.jpg', 0),
(67, '../uploads/receiptImages/1420397741985.jpg', 0),
(68, '../uploads/receiptImages/1420400136066.jpg', 0),
(69, '../uploads/receiptImages/1420410264375.jpg', 0),
(70, '../uploads/receiptImages/1420413691884.jpg', 0),
(71, '../uploads/receiptImages/1420740564409.jpg', 0),
(72, '../uploads/receiptImages/1420844962306.jpg', 0),
(73, '../uploads/receiptImages/1420848388302.jpg', 0),
(74, '../uploads/receiptImages/1421351892234.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL,
  `user_password` varchar(200) DEFAULT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_mobile` varchar(100) DEFAULT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_type` varchar(100) DEFAULT 'Stardard',
  `user_mileage_rate` decimal(10,2) NOT NULL,
  `user_activation_code` varchar(100) DEFAULT NULL,
  `is_deleted` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`user_id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=56 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `admin_id`, `user_password`, `user_name`, `user_mobile`, `user_email`, `user_type`, `user_mileage_rate`, `user_activation_code`, `is_deleted`) VALUES
(1, 48, NULL, 'dave o sullivan', NULL, 'davesull@hotmail.com', NULL, 0.00, 'dfadsfsdfdsfsdfsdf', 1),
(2, 48, NULL, 'mike larry', NULL, 'mikeLarry@hotmail.com', NULL, 0.00, 'dfdsfl459745erf', 1),
(3, 49, NULL, 'timmy sheehan', NULL, 'timmy@gmail.com', NULL, 0.00, 'df459745ih4o5', 0),
(4, 48, NULL, 'dave mac', NULL, 'davemac@hotmail.com', NULL, 0.00, NULL, 1),
(5, 48, NULL, 'dave mac', NULL, 'dfasda@efasdfas.com', NULL, 0.00, NULL, 1),
(6, 48, NULL, 'jimmy', NULL, 'jimmy@hotmail.com', NULL, 0.00, NULL, 1),
(7, 48, NULL, 'jimmy murphy', NULL, 'jimmymurphy@gmail.com', NULL, 0.00, NULL, 1),
(8, 48, NULL, 'michael anderson', NULL, 'anderson.j.michael@outlook.com', NULL, 0.00, NULL, 1),
(9, 48, NULL, 'mike anderson', NULL, 'mike@hotmail.com', NULL, 0.00, NULL, 1),
(10, 48, NULL, 'jdfasdf', NULL, 'dfasdfsad', NULL, 0.00, NULL, 1),
(11, 48, NULL, 'jimmy shea', NULL, 'jimmyshea@gmail.com', NULL, 0.00, NULL, 1),
(12, 48, NULL, 'michael anderson', NULL, 'michael.anderson@nixatel.com', NULL, 0.00, NULL, 1),
(13, 48, NULL, 'michael anderson', NULL, 'michael.anderson@hotmail.com', NULL, 0.00, NULL, 0),
(14, 48, NULL, 'john smith', NULL, 'john.smith@hotmail.com', NULL, 0.00, NULL, 0),
(15, 48, NULL, 'martin sullivan', NULL, 'martin.sullivan@hotmail.com', NULL, 0.00, NULL, 0),
(16, 48, NULL, 'john barry', NULL, 'john.barry@gmail.com', NULL, 0.00, NULL, 0),
(17, 48, NULL, 'john horgan', NULL, 'john.horgan@gmail.com', NULL, 0.00, NULL, 0),
(18, 48, NULL, 'anthony callaghan', NULL, 'anthony.callaghan@yahoo.com', NULL, 0.00, NULL, 0),
(19, 48, NULL, 'kim dineen', NULL, 'kim.dineen@hotmail.com', NULL, 0.00, NULL, 0),
(20, 48, NULL, 'jean sullivan', NULL, 'jean.sullivan@gmail.com', NULL, 0.00, NULL, 0),
(21, 48, NULL, 'tommy smith', NULL, 'tommy.smith@yahoo.com', NULL, 0.00, NULL, 0),
(22, 48, NULL, 'robert anderson', NULL, 'robert.anderson.outlook.com', NULL, 0.00, NULL, 1),
(23, 48, NULL, 'james mahony', NULL, 'james.mahony@hotmail.com', NULL, 0.00, NULL, 0),
(24, 48, NULL, 'Kerrie anderson', NULL, 'Kerandersonn@hotmail.com', NULL, 0.00, NULL, 0),
(25, 48, NULL, 'Tommy walsh', NULL, 'Tommy.walsh@gmail.com', NULL, 0.00, NULL, 0),
(26, 48, NULL, 'Carey Shea', NULL, 'Carey.shea@outlook.com', NULL, 0.00, NULL, 0),
(27, 50, NULL, 'Michael Jackson', '0', 'Michael.jackson@outlook.com', 'Standard User', 10.00, NULL, 0),
(28, 50, NULL, 'Paddy Anderson', '0', 'Panderson@cit.ie', 'Standard User', 10.00, NULL, 0),
(29, 50, NULL, 'Michael Anderson', '0', 'Anderson.j.michael@outlook.com', 'Su', 0.00, NULL, 1),
(30, 50, NULL, '', NULL, '', 'Pm', 0.00, NULL, 1),
(31, 50, NULL, 'Michael Anderson', '871272117', 'Michael.anderson@umail.ie', 'Pm', 0.00, NULL, 1),
(32, 50, NULL, 'Jackson Brown', '0871112222', 'Jacksonbrown@hotmail.com', 'Standard User', 0.00, NULL, 0),
(33, 50, NULL, 'Jimmy Mac', '0872758773', 'Jimmymac@eircom.net', 'Standard User', 0.00, NULL, 1),
(34, 50, NULL, 'Jimmy Mac', '08727584675', 'Jimmymac@bnet.com', 'Standard User', 0.00, NULL, 1),
(35, 50, NULL, 'Sean Mahony', '0879999999', 'Seanm123@gmail.com', 'Standard User', 0.00, NULL, 1),
(36, 50, NULL, 'David Smith', '0871212121', 'Dsmith@gmail.com', 'Standard User', 0.00, NULL, 1),
(37, 50, NULL, 'John Andy', '08795847663', 'Jandy@hotmail.com', 'Standard User', 0.00, NULL, 1),
(38, 50, NULL, 'Dave Sull', '0821327884', 'Dsull@net.com', 'Standard User', 0.00, NULL, 1),
(39, 50, NULL, 'Linda Smith', '0875709884', 'Linda.s@net.com', 'Project Manager', 0.00, NULL, 0),
(40, 50, NULL, 'Tom Lions', '0860985774', 'Tlions@gmail.com', 'Standard User', 0.00, NULL, 1),
(41, 50, 'efecb8b39f259177496f012e0d1bd82fbb498acd', 'Shane Oshea', '0838747663', 'Shane.oshea@eircom.net', 'Standard User', 0.00, NULL, 0),
(42, 50, '3671a524c0db791a874a27ddee2b09072393a47f', 'John J Neary', '09847873664', 'Johnjn@hotmail.com', 'Project Manager', 0.00, NULL, 0),
(43, 50, 'e49112a8ac6a58ba124631be2dcdbb427fc055c1', 'Patrick Sullivan', '0872738221', 'Psull@gmail.com', 'Project Manager', 0.00, NULL, 0),
(44, 50, 'd51191388b4663c4d692bb67ab673a9bab170479', 'Jim Neary', '0862783776', 'J.neary@eircom.net', 'Standard User', 0.00, NULL, 0),
(45, 50, 'e6aa3fe839d59ac5ae8bf5c676b11fc3e820997b', 'Marty Mar', '0875674663', 'Marty.mar@hotmail.com', 'Project Manager', 0.00, NULL, 1),
(46, 50, 'ff14db20882cc54336ed821aa7d49d10f3f43854', 'Timmy Neil', '0874687332', 'Timmy.neil@gmail.com', 'Standard User', 0.00, NULL, 1),
(47, 50, '071e9176b7ffe480ab0c408fda07f720f0a7123d', 'Paddy Jackson', '0873764776', 'P.jackson@eircom.net', 'Project Manager', 0.00, NULL, 1),
(48, 50, 'be7e939f481c3de4e354053e4c7431cd5a2e5767', 'Kevin Horgan', '0873674665', 'Khorgan@eircom.net', 'Standard User', 0.00, NULL, 0),
(49, 50, '0b9908e1003cffaf007786df311994c3a946d290', 'Dfads', '0873674665', 'Dfas', 'Project Manager', 12.00, NULL, 1),
(50, 50, '61da7da3db3fcacb663312ced380d828399940c3', 'Dfdfafgsda', '134234234234', 'Dfa@dfdlf.com', 'Standard User', 0.00, NULL, 0),
(51, 50, 'pass', 'kevin anderson', '0874736552', 'ka@hmail.com', 'Stardard', 0.00, NULL, 0),
(52, 50, '0483ccecd575b067a03aa6658c5ee49de7a5238d', 'John Flynn', '0873872633', 'Jflynn@mail.com', 'Standard User', 0.00, NULL, 1),
(53, 50, '0ea745f305b0b191bad11e7e311a9ce0774403ea', 'James Doherty', '0874837264873', 'J.d@gmail.com', 'Standard User', 0.00, NULL, 0),
(54, 50, '8b6a86dd644ddf263470ad32b658256aa43cb4d6', 'Martin Henry', '0639877665', 'Martin.henry@outlook.com', 'Standard User', 0.00, NULL, 0),
(55, 50, '04c7089b1c775a293a757e9d1a52c90366765c5a', 'Michael Anderson', '0873762776', 'Michael.j.anderson@outlook.com', 'Project Manager', 1.00, NULL, 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `admins_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`company_id`);

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `expenses_ibfk_2` FOREIGN KEY (`merchant_id`) REFERENCES `merchants` (`merchant_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `expenses_ibfk_3` FOREIGN KEY (`receipt_id`) REFERENCES `receipts` (`receipt_id`),
  ADD CONSTRAINT `expenses_ibfk_4` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`admin_id`);

--
-- Constraints for table `journeys`
--
ALTER TABLE `journeys`
  ADD CONSTRAINT `journeys_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`admin_id`),
  ADD CONSTRAINT `journeys_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`admin_id`);
