-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 13, 2018 at 03:58 PM
-- Server version: 5.7.19
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aks_master`
--

-- --------------------------------------------------------

--
-- Table structure for table `test_results`
--

DROP TABLE IF EXISTS `test_results`;
CREATE TABLE IF NOT EXISTS `test_results` (
`user_id` varchar(25) NOT NULL,
'purchased' tinyint(1) NOT NULL DEFAULT '0',
'totalPassed' int(25) NOT NULL DEFAULT '0',
`A_result` tinyint(1) NOT NULL DEFAULT '0',
`B_result` tinyint(1) NOT NULL DEFAULT '0',
`C_result` tinyint(1) NOT NULL DEFAULT '0',
`D_result` tinyint(1) NOT NULL DEFAULT '0',
`E_result` tinyint(1) NOT NULL DEFAULT '0',
`F_result` tinyint(1) NOT NULL DEFAULT '0',
`G_result` tinyint(1) NOT NULL DEFAULT '0',
`H_result` tinyint(1) NOT NULL DEFAULT '0',
`I_result` tinyint(1) NOT NULL DEFAULT '0',
`J_result` tinyint(1) NOT NULL DEFAULT '0',
`K_result` tinyint(1) NOT NULL DEFAULT '0',
`L_result` tinyint(1) NOT NULL DEFAULT '0',
`M_result` tinyint(1) NOT NULL DEFAULT '0',
`N_result` tinyint(1) NOT NULL DEFAULT '0',
`O_result` tinyint(1) NOT NULL DEFAULT '0',
`P_result` tinyint(1) NOT NULL DEFAULT '0',
`FINAL_eligible` tinyint(1) NOT NULL DEFAULT '0',
`FINAL_passed` tinyint(1) NOT NULL DEFAULT '0',
PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`first_name` varchar(50) NOT NULL,
`last_name` varchar(50) NOT NULL,
`email` varchar(100) NOT NULL,
`password` varchar(100) NOT NULL,
`hash` varchar(32) NOT NULL,
`active` tinyint(1) NOT NULL DEFAULT '0',
PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;