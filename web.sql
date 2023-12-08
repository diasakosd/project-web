-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Εξυπηρετητής: 127.0.0.1
-- Χρόνος δημιουργίας: 08 Δεκ 2023 στις 19:38:04
-- Έκδοση διακομιστή: 10.4.28-MariaDB
-- Έκδοση PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Βάση δεδομένων: `web`
--

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `admin`
--

CREATE TABLE `admin` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `admin`
--

INSERT INTO `admin` (`username`, `password`) VALUES
('alkis', 'alkis'),
('antreas', 'antreas'),
('damianos', 'damianos'),
('kyrios', 'kyrios');

--
-- Δείκτες `admin`
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
-- Δομή πίνακα για τον πίνακα `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `date_written` datetime NOT NULL DEFAULT current_timestamp(),
  `status` varchar(255) NOT NULL DEFAULT 'NO',
  `admin` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `announcements`
--

INSERT INTO `announcements` (`id`, `title`, `body`, `date_written`, `status`, `admin`) VALUES
(1, 'asda', 'ssss', '2023-12-08 13:04:45', 'NO', 'damianos');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `base_storage`
--

CREATE TABLE `base_storage` (
  `id` int(11) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `item` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `base_storage`
--

INSERT INTO `base_storage` (`id`, `category`, `item`, `quantity`) VALUES
(1, 'Beverages', 'Water', 100),
(2, 'Beverages', 'Orange juice', 100),
(3, 'Food', 'Sardines', 100),
(4, 'Food', 'Canned corn', 100),
(5, 'Food', 'Bread', 100),
(6, 'Food', 'Chocolate', 100),
(7, 'Clothing', 'Men Sneakers', 100),
(8, '2d hacker', 'Test Product', 100),
(9, 'Flood', 'Test Val', 100),
(10, 'Food', 'Spaghetti', 100),
(11, 'Food', 'Croissant', 100),
(12, 'Food', 'Biscuits', 100),
(13, 'Medical Supplies', 'Bandages', 100),
(14, 'Medical Supplies', 'Disposable gloves', 100),
(15, 'Medical Supplies', 'Gauze', 100),
(16, 'Medical Supplies', 'Antiseptic', 100),
(17, 'Medical Supplies', 'First Aid Kit', 100),
(18, 'Medical Supplies', 'Painkillers', 100),
(19, 'Clothing', 'Blanket', 100),
(20, 'Food', 'Fakes', 100),
(21, 'Personal Hygiene ', 'Menstrual Pads', 100),
(22, 'Personal Hygiene ', 'Tampon', 100),
(23, 'Personal Hygiene ', 'Toilet Paper', 100),
(24, 'Personal Hygiene ', 'Baby wipes', 100),
(25, 'Personal Hygiene ', 'Toothbrush', 100),
(26, 'Personal Hygiene ', 'Toothpaste', 100),
(27, 'Medical Supplies', 'Vitamin C', 100),
(28, 'Medical Supplies', 'Multivitamines', 100),
(29, 'Medical Supplies', 'Paracetamol', 100),
(30, 'Medical Supplies', 'Ibuprofen', 100),
(31, 'Cleaning Supplies', 'Cleaning rag', 100),
(32, 'Cleaning Supplies', 'Detergent', 100),
(33, 'Cleaning Supplies', 'Disinfectant', 100),
(34, 'Cleaning Supplies', 'Mop', 100),
(35, 'Cleaning Supplies', 'Plastic bucket', 100),
(36, 'Cleaning Supplies', 'Scrub brush', 100),
(37, 'Cleaning Supplies', 'Dust mask', 100),
(38, 'Cleaning Supplies', 'Broom', 100),
(39, 'Tools', 'Hammer', 100),
(40, 'Tools', 'Skillsaw', 100),
(41, 'Tools', 'Prybar', 100),
(42, 'Tools', 'Shovel', 100),
(43, 'Tools', 'Flashlight', 100),
(44, 'Tools', 'Duct tape', 100),
(45, 'Clothing', 'Underwear', 100),
(46, 'Clothing', 'Socks', 100),
(47, 'Clothing', 'Warm Jacket', 100),
(48, 'Clothing', 'Raincoat', 100),
(49, 'Clothing', 'Gloves', 100),
(50, 'Clothing', 'Pants', 100),
(51, 'Clothing', 'Boots', 100),
(52, 'Kitchen Supplies', 'Dishes', 100),
(53, 'Kitchen Supplies', 'Pots', 100),
(54, 'Kitchen Supplies', 'Paring knives', 100),
(55, 'Kitchen Supplies', 'Pan', 100),
(56, 'Kitchen Supplies', 'Glass', 100),
(57, '2d hacker', 't22', 100),
(58, 'Beverages', 'Coca Cola', 100),
(59, 'Insect Repellents', 'spray', 100),
(60, 'Insect Repellents', 'Outdoor spiral', 100),
(61, 'Baby Essentials', 'Baby bottle', 100),
(62, 'Baby Essentials', 'Pacifier', 100),
(63, 'Food', 'Condensed milk', 100),
(64, 'Food', 'Cereal bar', 100),
(65, 'Tools', 'Pocket Knife', 100),
(66, 'Medical Supplies', 'Water Disinfection Tablets', 100),
(67, 'Electronic Devices', 'Radio', 100),
(68, 'Flood', 'Kitchen appliances', 100),
(69, 'Cold weather', 'Winter hat', 100),
(70, 'Cold weather', 'Winter gloves', 100),
(71, 'Cold weather', 'Scarf', 100),
(72, 'Cold weather', 'Thermos', 100),
(73, 'Beverages', 'Tea', 100),
(74, 'Animal Food', 'Dog Food ', 100),
(75, 'Animal Food', 'Cat Food', 100),
(76, 'Food', 'Canned', 100),
(77, 'Cleaning Supplies', 'Chlorine', 100),
(78, 'Cleaning Supplies', 'Medical gloves', 100),
(79, 'Clothing', 'T-Shirt', 100),
(80, 'Hot Weather', 'Cooling Fan', 100),
(81, 'Hot Weather', 'Cool Scarf', 100),
(82, 'Tools', 'Whistle', 100),
(83, 'Cold weather', 'Blankets', 100),
(84, 'Cold weather', 'Sleeping Bag', 100),
(85, 'Medical Supplies', 'Thermometer', 100),
(86, 'Food', 'Rice', 100),
(87, 'Cleaning Supplies', 'Towels', 100),
(88, 'Cleaning Supplies', 'Wet Wipes', 100),
(89, 'Tools', 'Fire Extinguisher', 22);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `citizens`
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
-- Άδειασμα δεδομένων του πίνακα `citizens`
--

INSERT INTO `citizens` (`full_name`, `username`, `password`, `phone`, `latitude`, `longitude`) VALUES
('Poustonios Kyrios', 'malakas', '123', 123, 38.2356, 21.7262),
('Eimai kleutis', 'paki', 'paki', 999, 38.2493, 21.735),
('John Papas', 'papas123', 'papas', 123123123, 38.2306, 21.739),
('Nai kala', 'sasgamaw', 'antreas', 7878, 38.2717, 21.7582),
('xaxaxa', 'xaxa', '123', 123, 38.2674, 21.7529);

--
-- Δείκτες `citizens`
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
-- Δομή πίνακα για τον πίνακα `citizen_offer`
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

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `citizen_request`
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

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `combined_data`
--

CREATE TABLE `combined_data` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `table_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `combined_data`
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
('sasgamaw', 'antreas', 'citizens'),
('rescuer3', 'rescuer3', 'rescuers'),
('xaxa', '123', 'citizens'),
('rescuer4', 'rescuer4', 'rescuers');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `rescuers`
--

CREATE TABLE `rescuers` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` int(11) NOT NULL,
  `latitude` float DEFAULT NULL,
  `longitude` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `rescuers`
--

INSERT INTO `rescuers` (`username`, `password`, `phone`, `latitude`, `longitude`) VALUES
('rescuer3', 'rescuer3', 123123123, 38.2568, 21.7417),
('rescuer4', 'rescuer4', 123, 38.2479, 21.7406),
('resquer1', 'resquerpass', 2147483647, 38.2631, 21.7442),
('resquer2', 'resquerpass', 2147483647, 38.2418, 21.7311);

--
-- Δείκτες `rescuers`
--
DELIMITER $$
CREATE TRIGGER `after_delete_rescuer` AFTER DELETE ON `rescuers` FOR EACH ROW BEGIN
    DELETE FROM combined_data WHERE username = OLD.username;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_rescuer_insert` AFTER INSERT ON `rescuers` FOR EACH ROW BEGIN
    INSERT INTO rescuer_inventory (username, category, item, quantity)
    VALUES (NEW.username, NULL, NULL, NULL);
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
-- Δομή πίνακα για τον πίνακα `rescuer_inventory`
--

CREATE TABLE `rescuer_inventory` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `item` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `rescuer_inventory`
--

INSERT INTO `rescuer_inventory` (`id`, `username`, `category`, `item`, `quantity`) VALUES
(1, 'resquer1', 'Food', 'Sardines', NULL),
(2, 'rescuer3', 'Food', 'Sardines', NULL),
(3, 'resquer1', 'Beverages', 'Water', NULL),
(4, 'rescuer3', '', NULL, NULL),
(7, 'rescuer4', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `storage_location`
--

CREATE TABLE `storage_location` (
  `latitude` float DEFAULT NULL,
  `longitude` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `storage_location`
--

INSERT INTO `storage_location` (`latitude`, `longitude`) VALUES
(38.2463, 21.7351);

--
-- Δείκτες `storage_location`
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
-- Ευρετήρια για άχρηστους πίνακες
--

--
-- Ευρετήρια για πίνακα `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`username`);

--
-- Ευρετήρια για πίνακα `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_anounce` (`admin`);

--
-- Ευρετήρια για πίνακα `base_storage`
--
ALTER TABLE `base_storage`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_category_item` (`category`,`item`);

--
-- Ευρετήρια για πίνακα `citizens`
--
ALTER TABLE `citizens`
  ADD PRIMARY KEY (`username`) USING HASH;

--
-- Ευρετήρια για πίνακα `citizen_offer`
--
ALTER TABLE `citizen_offer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`),
  ADD KEY `category` (`category`,`item`),
  ADD KEY `fk_citizen_offer_rescuer` (`rescuer_username`);

--
-- Ευρετήρια για πίνακα `citizen_request`
--
ALTER TABLE `citizen_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `citizen_request_ibfk_1` (`username`),
  ADD KEY `citizen_request_ibfk_2` (`category`,`item`),
  ADD KEY `fk_citizen_request_rescuer` (`rescuer_username`);

--
-- Ευρετήρια για πίνακα `combined_data`
--
ALTER TABLE `combined_data`
  ADD KEY `idx_combined_data` (`username`,`password`),
  ADD KEY `user_data` (`username`) USING HASH;

--
-- Ευρετήρια για πίνακα `rescuers`
--
ALTER TABLE `rescuers`
  ADD PRIMARY KEY (`username`);

--
-- Ευρετήρια για πίνακα `rescuer_inventory`
--
ALTER TABLE `rescuer_inventory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rescuers_request_ibfk_1` (`username`),
  ADD KEY `rescuers_request_ibfk_2` (`category`,`item`);

--
-- AUTO_INCREMENT για άχρηστους πίνακες
--

--
-- AUTO_INCREMENT για πίνακα `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT για πίνακα `base_storage`
--
ALTER TABLE `base_storage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT για πίνακα `citizen_offer`
--
ALTER TABLE `citizen_offer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT για πίνακα `citizen_request`
--
ALTER TABLE `citizen_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT για πίνακα `rescuer_inventory`
--
ALTER TABLE `rescuer_inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Περιορισμοί για άχρηστους πίνακες
--

--
-- Περιορισμοί για πίνακα `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `admin_anounce` FOREIGN KEY (`admin`) REFERENCES `admin` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Περιορισμοί για πίνακα `citizen_offer`
--
ALTER TABLE `citizen_offer`
  ADD CONSTRAINT `citizen_offer_ibfk_1` FOREIGN KEY (`username`) REFERENCES `citizens` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `citizen_offer_ibfk_2` FOREIGN KEY (`category`,`item`) REFERENCES `base_storage` (`category`, `item`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_citizen_offer_rescuer` FOREIGN KEY (`rescuer_username`) REFERENCES `rescuers` (`username`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Περιορισμοί για πίνακα `citizen_request`
--
ALTER TABLE `citizen_request`
  ADD CONSTRAINT `citizen_request_ibfk_1` FOREIGN KEY (`username`) REFERENCES `citizens` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `citizen_request_ibfk_2` FOREIGN KEY (`category`,`item`) REFERENCES `base_storage` (`category`, `item`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_citizen_request_rescuer` FOREIGN KEY (`rescuer_username`) REFERENCES `rescuers` (`username`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Περιορισμοί για πίνακα `rescuer_inventory`
--
ALTER TABLE `rescuer_inventory`
  ADD CONSTRAINT `rescuers_request_ibfk_1` FOREIGN KEY (`username`) REFERENCES `rescuers` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rescuers_request_ibfk_2` FOREIGN KEY (`category`,`item`) REFERENCES `base_storage` (`category`, `item`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
