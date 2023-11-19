-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2023 at 04:29 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `password`) VALUES
('alkis', 'alkis'),
('antreas', 'antreas'),
('damianos', 'damianos'),
('kyrios', 'kyrios');

--
-- Triggers `admin`
--
DELIMITER $$
CREATE TRIGGER `after_delete_admin` AFTER DELETE ON `admin` FOR EACH ROW BEGIN
    DELETE FROM combined_data WHERE username = OLD.username;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tr_admin_after_insert` AFTER INSERT ON `admin` FOR EACH ROW BEGIN
    INSERT INTO combined_data (username, password, table_name)
    VALUES (NEW.username, NEW.password, 'admin');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `base_storage`
--

CREATE TABLE `base_storage` (
  `id` int(11) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `item` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `base_storage`
--

INSERT INTO `base_storage` (`id`, `category`, `item`, `quantity`) VALUES
(1, 'Electronics', 'Laptop', 10),
(2, 'Clothing', 'T-Shirt', 50),
(3, 'Electronics', 'Smartphone', 20),
(4, 'Food', 'Canned Beans', 100),
(5, 'Medical', 'First Aid Kit', 5);

-- --------------------------------------------------------

--
-- Table structure for table `citizens`
--

CREATE TABLE `citizens` (
  `full_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` int(11) NOT NULL,
  `latitude` float NOT NULL,
  `longitude` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `citizens`
--

INSERT INTO `citizens` (`full_name`, `username`, `password`, `phone`, `latitude`, `longitude`) VALUES
('Poustonios Kyrios', 'malakas', '123', 123, 38.2356, 21.7262),
('Eimai kleutis', 'paki', 'paki', 999, 38.2493, 21.735),
('John Papas', 'papas123', 'papas', 123123123, 38.2306, 21.739),
('Nai kala', 'sasgamaw', 'antreas', 7878, 38.2717, 21.7582);

--
-- Triggers `citizens`
--
DELIMITER $$
CREATE TRIGGER `after_delete_citizen` AFTER DELETE ON `citizens` FOR EACH ROW BEGIN
    DELETE FROM combined_data WHERE username = OLD.username;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tr_citizens_after_insert` AFTER INSERT ON `citizens` FOR EACH ROW BEGIN
    INSERT INTO combined_data (username, password, table_name)
    VALUES (NEW.username, NEW.password, 'citizens');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `citizen_offer`
--

CREATE TABLE `citizen_offer` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `item` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `time_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `accepted` varchar(4) DEFAULT 'NO',
  `time_accepted` timestamp NULL DEFAULT NULL,
  `rescuer_username` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `citizen_offer`
--

INSERT INTO `citizen_offer` (`id`, `username`, `category`, `item`, `quantity`, `time_created`, `accepted`, `time_accepted`, `rescuer_username`) VALUES
(1, 'paki', 'Clothing', 'T-Shirt', 3, '2023-11-18 09:09:20', 'NO', NULL, NULL),
(2, 'sasgamaw', 'Electronics', 'Laptop', 2, '2023-11-18 09:09:20', 'YES', '2023-11-18 08:45:50', 'resquer1');

-- --------------------------------------------------------

--
-- Table structure for table `citizen_request`
--

CREATE TABLE `citizen_request` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `item` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `time_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `accepted` varchar(4) DEFAULT 'NO',
  `time_accepted` timestamp NULL DEFAULT NULL,
  `rescuer_username` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `citizen_request`
--

INSERT INTO `citizen_request` (`id`, `username`, `category`, `item`, `quantity`, `time_created`, `accepted`, `time_accepted`, `rescuer_username`) VALUES
(1, 'papas123', 'Clothing', 'T-Shirt', 2, '2023-11-18 08:45:57', 'YES', '2023-11-18 22:00:00', 'resquer2'),
(2, 'papas123', 'Electronics', 'Smartphone', 4, '2023-11-18 08:46:43', 'NO', NULL, NULL),
(3, 'papas123', 'Medical', 'First Aid Kit', 3, '2023-11-18 08:47:00', 'NO', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `combined_data`
--

CREATE TABLE `combined_data` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `table_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `combined_data`
--

INSERT INTO `combined_data` (`username`, `password`, `table_name`) VALUES
('alkis', 'alkis', 'admin'),
('antreas', 'antreas', 'admin'),
('damianos', 'damianos', 'admin'),
('kyrios', 'kyrios', 'admin'),
('resquer1', 'resquerpass', 'rescuers'),
('resquer2', 'resquerpass', 'rescuers'),
('papas123', 'papas', 'citizens'),
('paki', 'paki', 'citizens'),
('malakas', '123', 'citizens'),
('sasgamaw', 'antreas', 'citizens');

-- --------------------------------------------------------

--
-- Table structure for table `rescuers`
--

CREATE TABLE `rescuers` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` int(11) NOT NULL,
  `latitude` float DEFAULT NULL,
  `longitude` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rescuers`
--

INSERT INTO `rescuers` (`username`, `password`, `phone`, `latitude`, `longitude`) VALUES
('resquer1', 'resquerpass', 2147483647, 38.2631, 21.7442),
('resquer2', 'resquerpass', 2147483647, 38.2418, 21.7311);

--
-- Triggers `rescuers`
--
DELIMITER $$
CREATE TRIGGER `after_delete_rescuer` AFTER DELETE ON `rescuers` FOR EACH ROW BEGIN
    DELETE FROM combined_data WHERE username = OLD.username;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tr_rescuers_after_insert` AFTER INSERT ON `rescuers` FOR EACH ROW BEGIN
    INSERT INTO combined_data (username, password, table_name)
    VALUES (NEW.username, NEW.password, 'rescuers');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `rescuer_inventory`
--

CREATE TABLE `rescuer_inventory` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `item` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rescuer_inventory`
--

INSERT INTO `rescuer_inventory` (`id`, `username`, `category`, `item`, `quantity`) VALUES
(1, 'resquer1', 'Electronics', 'Laptop', 5),
(2, 'resquer2', 'Clothing', 'T-Shirt', 10),
(3, 'resquer2', 'Food', 'Canned Beans', 20);

-- --------------------------------------------------------

--
-- Table structure for table `storage_location`
--

CREATE TABLE `storage_location` (
  `latitude` float DEFAULT NULL,
  `longitude` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `storage_location`
--

INSERT INTO `storage_location` (`latitude`, `longitude`) VALUES
(38.2463, 21.7351);

--
-- Triggers `storage_location`
--
DELIMITER $$
CREATE TRIGGER `before_insert_storage_location` BEFORE INSERT ON `storage_location` FOR EACH ROW BEGIN
    DECLARE row_count INT;

    SELECT COUNT(*) INTO row_count
    FROM information_schema.tables
    WHERE table_schema = DATABASE()
    AND table_name = 'storage_location';

    IF row_count > 1 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Only one entry is allowed in the storage_location table.';
    END IF;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `base_storage`
--
ALTER TABLE `base_storage`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_category_item` (`category`,`item`);

--
-- Indexes for table `citizens`
--
ALTER TABLE `citizens`
  ADD PRIMARY KEY (`username`) USING HASH;

--
-- Indexes for table `citizen_offer`
--
ALTER TABLE `citizen_offer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`),
  ADD KEY `category` (`category`,`item`),
  ADD KEY `fk_citizen_offer_rescuer` (`rescuer_username`);

--
-- Indexes for table `citizen_request`
--
ALTER TABLE `citizen_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `citizen_request_ibfk_1` (`username`),
  ADD KEY `citizen_request_ibfk_2` (`category`,`item`),
  ADD KEY `fk_citizen_request_rescuer` (`rescuer_username`);

--
-- Indexes for table `combined_data`
--
ALTER TABLE `combined_data`
  ADD KEY `idx_combined_data` (`username`,`password`),
  ADD KEY `user_data` (`username`) USING HASH;

--
-- Indexes for table `rescuers`
--
ALTER TABLE `rescuers`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `rescuer_inventory`
--
ALTER TABLE `rescuer_inventory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rescuers_request_ibfk_1` (`username`),
  ADD KEY `rescuers_request_ibfk_2` (`category`,`item`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `base_storage`
--
ALTER TABLE `base_storage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `citizen_offer`
--
ALTER TABLE `citizen_offer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `citizen_request`
--
ALTER TABLE `citizen_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rescuer_inventory`
--
ALTER TABLE `rescuer_inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `citizen_offer`
--
ALTER TABLE `citizen_offer`
  ADD CONSTRAINT `citizen_offer_ibfk_1` FOREIGN KEY (`username`) REFERENCES `citizens` (`username`),
  ADD CONSTRAINT `citizen_offer_ibfk_2` FOREIGN KEY (`category`,`item`) REFERENCES `base_storage` (`category`, `item`),
  ADD CONSTRAINT `fk_citizen_offer_rescuer` FOREIGN KEY (`rescuer_username`) REFERENCES `rescuers` (`username`);

--
-- Constraints for table `citizen_request`
--
ALTER TABLE `citizen_request`
  ADD CONSTRAINT `citizen_request_ibfk_1` FOREIGN KEY (`username`) REFERENCES `citizens` (`username`) ON DELETE CASCADE,
  ADD CONSTRAINT `citizen_request_ibfk_2` FOREIGN KEY (`category`,`item`) REFERENCES `base_storage` (`category`, `item`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_citizen_request_rescuer` FOREIGN KEY (`rescuer_username`) REFERENCES `rescuers` (`username`);

--
-- Constraints for table `rescuer_inventory`
--
ALTER TABLE `rescuer_inventory`
  ADD CONSTRAINT `rescuers_request_ibfk_1` FOREIGN KEY (`username`) REFERENCES `rescuers` (`username`) ON DELETE CASCADE,
  ADD CONSTRAINT `rescuers_request_ibfk_2` FOREIGN KEY (`category`,`item`) REFERENCES `base_storage` (`category`, `item`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
