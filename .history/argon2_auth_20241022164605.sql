-- phpMyAdmin SQL Dump
-- version 5.2.0
-- Host: localhost:3306
-- Generation Time: Oct 22, 2024 at 04:30 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- 
-- Database: `argon2_auth`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `users`
-- 

CREATE TABLE `users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  `salt` VARCHAR(32) NOT NULL,
  `pepper` VARCHAR(32) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 
-- Dumping sample data for table `users`
-- 

INSERT INTO `users` (`username`, `password_hash`, `salt`, `pepper`, `created_at`) 
VALUES 
('adminpldt', 
 '$argon2id$v=19$m=65536,t=4,p=1$SUtsUW1DdURYNTJTdGlHcQ$5ZuD2TdpAFM6Ys/Q2BbORNQbXrrsytj2BFm9JEqFZ4U', 
 'ab1c2d3e4f5g6h7i8j9k0lmn', 
 'my_pepper_value', 
 '2024-10-17 18:45:37');

-- 
-- AUTO_INCREMENT for table `users`
-- 

ALTER TABLE `users`
  MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
