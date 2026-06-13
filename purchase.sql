-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2025 at 08:02 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jeffersonfong`
--

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `mid` int(5) NOT NULL,
  `category` varchar(10) NOT NULL,
  `itemN` varchar(12) NOT NULL,
  `price` int(6) NOT NULL,
  `quantity` int(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `purchase`
--
INSERT INTO `purchase` (`mid`, `category`, `itemN`, `price`, `quantity`) VALUES
(1, 'clothes', 'ancientShirt', 100, 0),
(2, 'clothes', 'cap',           20, 0),
(3, 'clothes', 'cultureShirt',  50, 0),
(4, 'clothes', 'poloShirt',     60, 0),
(5, 'neces', 'calendar',  20, 0),
(6, 'neces', 'fan',       30, 0),
(7, 'neces', 'mugs',  	  40, 0),
(8, 'neces', 'umbrella',  30, 0),
(9,  'orna', 'brooch',    40, 0),
(10, 'orna', 'crystal',   40, 0),
(11, 'orna', 'earRings',  60, 0),
(12, 'orna', 'necklace',  60, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`mid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `mid` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
