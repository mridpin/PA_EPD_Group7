-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2017 at 11:42 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `airlines`
--

-- --------------------------------------------------------

--
-- Table structure for table `airlines`
--

CREATE TABLE `airlines` (
  `code` int(10) NOT NULL,
  `name` varchar(50) COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `airlines`
--

INSERT INTO `airlines` (`code`, `name`) VALUES
(1, 'AEROUPO'),
(2, 'AIRPHP'),
(4, 'UPOLINES'),
(5, 'PHPIrl'),
(6, 'PALINES');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `city` varchar(100) COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`city`) VALUES
('Amsterdam'),
('Barcelona'),
('Dublin'),
('London'),
('Madrid'),
('Paris'),
('Rome'),
('Seville');

-- --------------------------------------------------------

--
-- Table structure for table `destinations`
--

CREATE TABLE `destinations` (
  `airline_code` int(10) NOT NULL,
  `destination_city` varchar(100) COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `destinations`
--

INSERT INTO `destinations` (`airline_code`, `destination_city`) VALUES
(1, 'Barcelona'),
(1, 'London'),
(1, 'Madrid'),
(1, 'Seville'),
(2, 'London'),
(2, 'Madrid'),
(4, 'Barcelona'),
(4, 'Madrid'),
(4, 'Seville'),
(5, 'Barcelona'),
(5, 'Madrid'),
(6, 'Amsterdam'),
(6, 'Barcelona'),
(6, 'London'),
(6, 'Madrid'),
(6, 'Rome');

-- --------------------------------------------------------

--
-- Table structure for table `flights`
--

CREATE TABLE `flights` (
  `airline_code` int(10) NOT NULL,
  `departure_city` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `arrival_city` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `duration` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `flights`
--

INSERT INTO `flights` (`airline_code`, `departure_city`, `arrival_city`, `duration`) VALUES
(1, 'Madrid', 'Barcelona', 70),
(1, 'Seville', 'Barcelona', 110),
(1, 'Seville', 'London', 220),
(1, 'Seville', 'Madrid', 120),
(2, 'London', 'Madrid', 170),
(2, 'Madrid', 'London', 170),
(5, 'Barcelona', 'Madrid', 90),
(5, 'Madrid', 'Barcelona', 90);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `name` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `user` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `password` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `last_access` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`name`, `user`, `password`, `last_access`) VALUES
('Aministrator', 'admin', 'admin', '2017-11-10 12:28:34'),
('Lola M', 'lola', '$2y$10$XTjPNXfd1cDTpmI5Eg6HO.yeZLKuEZalnbnJv6v6C7KWfjx2CmNx6', '2017-11-12 15:34:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `airlines`
--
ALTER TABLE `airlines`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`city`);

--
-- Indexes for table `destinations`
--
ALTER TABLE `destinations`
  ADD PRIMARY KEY (`airline_code`,`destination_city`),
  ADD KEY `fk_destination_city` (`destination_city`);

--
-- Indexes for table `flights`
--
ALTER TABLE `flights`
  ADD PRIMARY KEY (`airline_code`,`departure_city`,`arrival_city`),
  ADD KEY `fk_flights_departure_city` (`departure_city`),
  ADD KEY `fk_flights_arrival_city` (`arrival_city`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `airlines`
--
ALTER TABLE `airlines`
  MODIFY `code` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `destinations`
--
ALTER TABLE `destinations`
  ADD CONSTRAINT `fk_destination_city` FOREIGN KEY (`destination_city`) REFERENCES `cities` (`city`),
  ADD CONSTRAINT `fk_destinations_airline_code` FOREIGN KEY (`airline_code`) REFERENCES `airlines` (`code`);

--
-- Constraints for table `flights`
--
ALTER TABLE `flights`
  ADD CONSTRAINT `fk_flights_airline_code` FOREIGN KEY (`airline_code`) REFERENCES `airlines` (`code`),
  ADD CONSTRAINT `fk_flights_arrival_city` FOREIGN KEY (`arrival_city`) REFERENCES `cities` (`city`),
  ADD CONSTRAINT `fk_flights_departure_city` FOREIGN KEY (`departure_city`) REFERENCES `cities` (`city`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
