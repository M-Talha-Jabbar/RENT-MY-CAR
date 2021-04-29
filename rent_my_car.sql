-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2021 at 06:27 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rent_my_car`
--

-- --------------------------------------------------------

--
-- Table structure for table `bill`
--

CREATE TABLE `bill` (
  `Bill_no` varchar(13) NOT NULL,
  `Total_amt` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bill`
--

INSERT INTO `bill` (`Bill_no`, `Total_amt`) VALUES
('5fdc9c4612479', 10000),
('5fdc9c6b1e854', 4000),
('5fdcdc03adb3e', 10000),
('5fdceb7948b16', 7000),
('5fdcf57a01d5b', 4000),
('5fdd0cfd248ce', 6000),
('5fde0d7fc2299', 8000),
('5fdf0912baab9', 7000),
('5fdf3c7e66bc9', 15000),
('5fdf589fd60a2', 20000),
('5fe2d27a2f68d', 4000),
('5fe2d30491376', 10000),
('5fe2d3de46738', 2000),
('5fe2d461f2b79', 5000),
('5fe2d47864357', 2000),
('5fe2d4d507b02', 8000),
('5fe2ea8d94479', 8000),
('608921e9f314f', 17000),
('608922029cb41', 3000),
('608922479facf', 8000),
('608922a13c86b', 4000);

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `Book_ID` int(11) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `Cust_SSN` varchar(16) NOT NULL,
  `Bill_no` varchar(13) NOT NULL,
  `Car_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`Book_ID`, `from_date`, `to_date`, `Cust_SSN`, `Bill_no`, `Car_ID`) VALUES
(86, '2020-12-11', '2020-12-12', '42201-2363504-5', '5fdc9c4612479', 105),
(87, '2020-12-10', '2020-12-11', '42201-2363504-4', '5fdc9c6b1e854', 102),
(94, '2020-12-18', '2020-12-19', '42201-2363504-6', '5fdcdc03adb3e', 101),
(97, '2020-12-18', '2020-12-19', '42201-2363504-8', '5fdceb7948b16', 103),
(99, '2020-12-11', '2020-12-12', '42201-2363504-7', '5fdcf57a01d5b', 102),
(100, '2020-12-09', '2020-12-11', '42201-2363504-5', '5fdd0cfd248ce', 102),
(101, '2020-12-11', '2020-12-12', '42201-2363504-3', '5fde0d7fc2299', 104),
(102, '2020-12-20', '2020-12-21', '42201-2363504-5', '5fdf0912baab9', 103),
(103, '2020-12-21', '2020-12-23', '42201-2363504-4', '5fdf3c7e66bc9', 101),
(104, '2020-12-22', '2020-12-25', '42101-5362428-8', '5fdf589fd60a2', 101),
(107, '2020-12-23', '2020-12-24', '42201-2363503-7', '5fe2d30491376', 101),
(109, '2020-12-24', '2020-12-24', '42201-2363503-8', '5fe2d3de46738', 102),
(111, '2020-12-24', '2020-12-24', '42201-2363503-6', '5fe2d461f2b79', 101),
(112, '2020-12-24', '2020-12-24', '42201-2363503-1', '5fe2d47864357', 102),
(113, '2020-12-24', '2020-12-24', '42201-2363503-0', '5fe2d4d507b02', 110),
(114, '2020-12-16', '2020-12-17', '42201-2363509-8', '5fe2ea8d94479', 104),
(117, '2021-04-29', '2021-04-30', '42101-5645323-44', '608921e9f314f', 109),
(118, '2021-04-29', '2021-04-30', '42101-5645323-44', '608922029cb41', 114),
(119, '2021-04-29', '2021-04-30', 'Ecec', '608922479facf', 104),
(120, '2021-04-29', '2021-04-30', 'Ecec', '608922a13c86b', 102);

-- --------------------------------------------------------

--
-- Table structure for table `car`
--

CREATE TABLE `car` (
  `Car_ID` int(11) NOT NULL,
  `RegNo` varchar(10) NOT NULL,
  `Car_name` varchar(25) NOT NULL,
  `no_of_seats` int(11) NOT NULL,
  `Rate_per_day` float NOT NULL,
  `Owner_ID` varchar(13) NOT NULL,
  `Availability` varchar(20) NOT NULL DEFAULT 'Available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `car`
--

INSERT INTO `car` (`Car_ID`, `RegNo`, `Car_name`, `no_of_seats`, `Rate_per_day`, `Owner_ID`, `Availability`) VALUES
(101, 'ADX-403', 'Corolla', 5, 5000, '1', 'Available'),
(102, 'ACY-986', 'Mehran', 4, 2000, '1', 'Booked'),
(103, 'DYZ-524', 'Meera', 5, 3500, '2', 'Available'),
(104, 'GHU-456', 'Civic', 5, 4000, '2', 'Booked'),
(105, 'UYT-978', 'Corolla', 5, 5000, '2', 'Available'),
(108, 'TYR-879', 'Honda BRV', 7, 8000, '1', 'Available'),
(109, 'FGH-963', 'Honda BRV2', 7, 8500, '1', 'Booked'),
(110, 'TYR-879', 'Honda BRV', 7, 8000, '1', 'Available'),
(111, 'ALE-231', 'BRV', 7, 10000, '5fdf59704d5dc', 'Available'),
(112, 'FGH-963', 'Honda BRV', 7, 8000, '1', 'Available'),
(113, 'Utf-567', 'Vigo', 7, 12000, '2', 'Available'),
(114, 'TYR-879', 'Honda BRV2', 5, 1500, '2', 'Booked');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `Cust_SSN` varchar(16) NOT NULL,
  `Name` varchar(25) NOT NULL,
  `Addr` varchar(50) NOT NULL,
  `Email` varchar(45) NOT NULL,
  `Phone` bigint(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`Cust_SSN`, `Name`, `Addr`, `Email`, `Phone`) VALUES
('42101-5362428-8', 'Usman Ahsan', 'R 48 sector 5L NK', 'usmanahsan650@gmail.com', 923343091970),
('42101-5645323-44', 'Ddfcd', 'xddd', 'usmanahsan650@gmail.com', 3332180571),
('42201-2363503-0', 'Safwan', 'Liyari', 'muhammadtalha11126@gmail.com', 3218704785),
('42201-2363503-1', 'Safwan', 'Liyari', 'muhammadtalha11126@gmail.com', 3218704785),
('42201-2363503-6', 'Safwan', 'Liyari', 'muhammadtalha11126@gmail.com', 3218704785),
('42201-2363503-7', 'Safwan', 'Liyari', 'muhammadtalha11126@gmail.com', 3218704785),
('42201-2363503-8', 'Safwan', 'Liyari', 'muhammadtalha11126@gmail.com', 3218704785),
('42201-2363504-3', 'Anas', 'A-102, 13d/1, karachi', 'muhammadtalha11126@gmail.com', 3212505408),
('42201-2363504-4', 'Huzaifa Jabbar', 'A-102, 13d/1, karachi', 'huzaifajabbar@gmail.com', 3212505408),
('42201-2363504-5', 'Muhammad Talha', 'A-102, 13d/1, karachi', 'muhammadtalha11126@gmail.com', 3343091970),
('42201-2363504-6', 'Anas', 'A-102, 13d/1, karachi', 'huzaifajabbar@gmail.com', 3212505408),
('42201-2363504-7', 'Usman Ahsan ', 'A-102, 13d/1, karachi', 'usmanahsan650@gmail.com', 3343091970),
('42201-2363504-8', 'Usman Don', 'A-102, 13d/1, karachi', 'usmanahsan650@gmail.com', 3232186362),
('42201-2363509-7', 'Safwan', 'Liyari', 'muhammadtalha11126@gmail.com', 3218704785),
('42201-2363509-8', 'Safwan', 'Liyari', 'muhammadtalha11126@gmail.com', 3218704785),
('Ecec', 'fef', 'dvr', 'usmanahsan650@gmail.com', 58585);

-- --------------------------------------------------------

--
-- Table structure for table `owner`
--

CREATE TABLE `owner` (
  `Owner_ID` varchar(13) NOT NULL,
  `Own_name` varchar(25) NOT NULL,
  `Username` varchar(25) NOT NULL,
  `Password` varchar(20) NOT NULL,
  `Own_email` varchar(30) NOT NULL,
  `Own_addr` varchar(50) NOT NULL,
  `Own_phone` bigint(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `owner`
--

INSERT INTO `owner` (`Owner_ID`, `Own_name`, `Username`, `Password`, `Own_email`, `Own_addr`, `Own_phone`) VALUES
('1', 'Abdul Jabbar', 'Abd-Jabbar', 'abc1234', 'abduljabbar@gmail.com', 'A-14, 13D/3, Gulshan-e-Iq', 3223374181),
('2', 'Hammad Sheikh', 'Hammy', 'def567', 'hammadsheikh@gmail.com', 'University Road, Karachi', 3323042968),
('5fde466d88260', 'Usman', 'usmi', '1234', 'usmanahsan650@gmail.com', 'A-102, 13d/1, karachi', 3218704762),
('5fde46f92b00e', 'Talha', 'talo', '1234', 'usmanahsan650@gmail.com', 'A-102, 13d/1, karachi', 3218704762),
('5fde4ee8d9ad2', 'Zohair Ahsan', 'zohi', '123', 'ottoman@gmail.com', 'R 48 sector 5L NK', 3321506123),
('5fdf59704d5dc', 'Usman Ahsan', '18K-0139', 'qwerty', 'usmanahsan650@gmail.com', 'R 48 sector 5L NK', 923343091970),
('608922c16848f', 'Muhammad Talha', 'mtalha011', 'talha666', 'anas@gmail.com', 'Gulshan', 3232186360);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`Bill_no`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`Book_ID`),
  ADD KEY `Cust_SSN` (`Cust_SSN`),
  ADD KEY `booking_ibfk_1` (`Bill_no`),
  ADD KEY `booking_ibfk_2` (`Car_ID`);

--
-- Indexes for table `car`
--
ALTER TABLE `car`
  ADD PRIMARY KEY (`Car_ID`),
  ADD KEY `Owner_ID` (`Owner_ID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`Cust_SSN`);

--
-- Indexes for table `owner`
--
ALTER TABLE `owner`
  ADD PRIMARY KEY (`Owner_ID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `Book_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `car`
--
ALTER TABLE `car`
  MODIFY `Car_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`Bill_no`) REFERENCES `bill` (`Bill_no`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`Car_ID`) REFERENCES `car` (`Car_ID`),
  ADD CONSTRAINT `booking_ibfk_3` FOREIGN KEY (`Cust_SSN`) REFERENCES `customer` (`Cust_SSN`);

--
-- Constraints for table `car`
--
ALTER TABLE `car`
  ADD CONSTRAINT `car_ibfk_1` FOREIGN KEY (`Owner_ID`) REFERENCES `owner` (`Owner_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
