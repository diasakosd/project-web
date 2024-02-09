-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 09, 2024 at 06:09 PM
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
-- Table structure for table `announcements`
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
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `title`, `body`, `date_written`, `status`, `admin`) VALUES
(33, 'ddssdd', 'ssssd', '2024-02-09 18:55:49', 'NO', 'damianos');

-- --------------------------------------------------------

--
-- Table structure for table `announcements_items`
--

CREATE TABLE `announcements_items` (
  `id` int(11) NOT NULL,
  `announcement_id` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `item` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements_items`
--

INSERT INTO `announcements_items` (`id`, `announcement_id`, `category`, `item`) VALUES
(14, 33, 'Clothing', 'Blanket');

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
(89, 'Tools', 'Fire Extinguisher', 100),
(90, 'Food', 'Fruits', 100),
(91, 'Shoes', 'Αθλητικά', 100),
(92, 'Food', 'Πασατέμπος', 100),
(93, 'First Aid ', 'Bandages', 100),
(94, 'First Aid ', 'Betadine', 100),
(95, 'First Aid ', 'cotton wool', 100),
(96, 'Food', 'Crackers', 100),
(97, 'Personal Hygiene ', 'Sanitary Pads', 100),
(98, 'Personal Hygiene ', 'Sanitary wipes', 100),
(99, 'Medical Supplies', 'Electrolytes', 100),
(100, 'Medical Supplies', 'Pain killers', 100),
(101, 'Beverages', 'Juice', 100),
(102, 'Medical Supplies', 'Sterilized Saline', 100),
(103, 'Medical Supplies', 'Antihistamines', 100),
(104, 'Food', 'Instant Pancake Mix', 100),
(105, 'Food', 'Lacta', 100),
(106, 'Food', 'Canned Tuna', 100),
(107, 'Tools', 'Batteries', 100),
(108, 'First Aid ', 'Dust Mask', 100),
(109, 'Tools', 'Can Opener', 100),
(110, 'Food', 'Πατατάκια', 100),
(111, 'Personal Hygiene ', 'Σερβιέτες', 100),
(112, 'Food', 'Dry Cranberries', 100),
(113, 'Food', 'Dry Apricots', 100),
(114, 'Food', 'Dry Figs', 100),
(115, 'Food', 'Παξιμάδια', 100),
(116, 'Test', 'Test Item', 100),
(117, 'First Aid ', 'Painkillers', 100),
(118, 'Medical Supplies', 'Tampons', 100),
(119, 'pet supplies', 'plaster set', 100),
(120, 'pet supplies', 'elastic bandages', 100),
(121, 'pet supplies', 'traumaplast', 100),
(122, 'pet supplies', 'thermal blanket', 100),
(123, 'pet supplies', 'burn gel', 100),
(124, 'pet supplies', 'pet carrier', 100),
(125, 'pet supplies', 'pet dishes', 100),
(126, 'pet supplies', 'plastic bags', 100),
(127, 'pet supplies', 'toys', 100),
(128, 'pet supplies', 'burn pads', 100),
(129, 'Food', 'cheese', 100),
(130, 'Food', 'lettuce', 100),
(131, 'Food', 'eggs', 100),
(132, 'Food', 'steaks', 100),
(133, 'Food', 'beef burgers', 100),
(134, 'Food', 'tomatoes', 100),
(135, 'Food', 'onions', 100),
(136, 'Food', 'flour', 100),
(137, 'Food', 'pastel', 100),
(138, 'Food', 'nuts', 100),
(139, 'Μedicines', 'dramamines', 100),
(140, 'Μedicines', 'nurofen', 100),
(141, 'Μedicines', 'imodium', 100),
(142, 'Μedicines', 'emetostop', 100),
(143, 'Μedicines', 'xanax', 100),
(144, 'Μedicines', 'saflutan', 100),
(145, 'Μedicines', 'sadolin', 100),
(146, 'Μedicines', 'depon', 100),
(147, 'Μedicines', 'panadol', 100),
(148, 'Μedicines', 'ponstan ', 100),
(149, 'Μedicines', 'algofren', 100),
(150, 'Μedicines', 'effervescent depon', 100),
(151, 'Beverages', 'cold coffee', 100),
(152, 'Energy Drinks', 'Hell', 100),
(153, 'Energy Drinks', 'Monster', 100),
(154, 'Energy Drinks', 'Redbull', 100),
(155, 'Energy Drinks', 'Powerade', 100),
(156, 'Energy Drinks', 'PRIME', 100),
(157, 'Tools', 'Lighter', 100),
(158, 'Cold weather', 'isothermally shirts', 100),
(159, 'Hot Weather', 'Shorts', 100),
(160, 'Food', 'Chicken', 100),
(161, 'Personal Hygiene ', 'sanitary napkins', 100),
(162, 'Medical Supplies', 'COVID-19 Tests', 100),
(163, 'Beverages', 'Club Soda', 100),
(164, 'Disability and Assistance Items', 'Wheelchairs', 100),
(165, 'Communication items', 'mobile phones', 100),
(166, 'Kitchen Supplies', 'spoon', 100),
(167, 'Kitchen Supplies', 'fork', 100),
(168, 'Communication items', 'MOTOTRBO R7', 100),
(169, 'Communication items', 'RM LA 250 (VHF Linear Ενισχυτής 140-150MHz)', 100),
(170, 'Humanitarian Shelters', 'Humanitarian General Purpose Tent System (HGPTS)', 100),
(171, 'Humanitarian Shelters', 'CELINA Dynamic Small Shelter ', 100),
(172, 'Humanitarian Shelters', 'Multi-purpose Area Shelter System, Type-I', 100),
(173, 'Clothing', 'Trousers', 100),
(174, 'Clothing', 'Shoes', 100),
(175, 'Clothing', 'Hoodie', 100),
(176, 'Animal Care', 'dog food', 100),
(177, 'Animal Care', 'cat food', 100),
(178, 'Food', 'macaroni', 100),
(179, 'Clothing', 'scarf', 100),
(180, 'Earthquake Safety', 'Silver blanket', 100),
(181, 'Earthquake Safety', 'Helmet', 100),
(182, 'Earthquake Safety', 'Disposable toilet', 100),
(183, 'Earthquake Safety', 'Self-generated flashlight', 100);

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
('Giannis Papadopoulos', 'giannis', 'antreas', 7878, 38.2717, 21.7582),
('Prokopis Diasakos', 'paki', 'paki', 999, 38.2493, 21.735),
('John Papas', 'papas123', 'papas', 123123123, 38.2306, 21.739),
('Papadakis Kyrios', 'politis', '123', 123, 38.2356, 21.7262),
('Politis One', 'politis1', 'politis1', 123, 38.2505, 21.7419);

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
(76, 'politis', 'Beverages', 'Water', 1, '2024-02-09 16:56:14', 'YES', '2024-02-09 17:01:31', 'resquer1'),
(77, 'politis', 'Cleaning Supplies', 'Broom', 1, '2024-02-09 16:56:14', 'NO', NULL, NULL),
(79, 'papas123', 'Cleaning Supplies', 'Cleaning rag', 1, '2024-02-09 16:56:53', 'YES', '2024-02-09 16:59:47', 'rescuer5'),
(80, 'giannis', 'Cleaning Supplies', 'Scrub brush', 1, '2024-02-09 16:58:26', 'NO', NULL, NULL),
(81, 'giannis', 'Cleaning Supplies', 'Towels', 1, '2024-02-09 16:58:26', 'NO', NULL, NULL);

--
-- Triggers `citizen_offer`
--
DELIMITER $$
CREATE TRIGGER `prevent_update_trigger` BEFORE UPDATE ON `citizen_offer` FOR EACH ROW BEGIN
    -- Check if the accepted column is being updated to 'YES'
    IF NEW.accepted = 'YES' THEN
        SET @counting = 0;

        -- Query to get the count and store it in the variable
        SELECT COUNT(*) INTO @counting
        FROM (
            SELECT rescuer_username, accepted FROM citizen_offer
            UNION ALL
            SELECT rescuer_username, accepted FROM citizen_request
        ) AS combined
        WHERE combined.rescuer_username = NEW.rescuer_username AND combined.accepted NOT LIKE 'DONE';

        -- Check if the count is 4 or above when accepted is 'YES'
        IF @counting >= 4 THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Cannot update. Rescuer';
        END IF;
    END IF;

    -- For updates to 'NO' or 'DONE', allow the update without checking the count
END
$$
DELIMITER ;

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
(23, 'politis', 'Kitchen Supplies', 'Dishes', 7, '2024-02-09 16:56:26', 'YES', '2024-02-09 16:59:31', 'rescuer5'),
(24, 'politis', 'Humanitarian Shelters', 'CELINA Dynamic Small Shelter ', 4, '2024-02-09 16:56:35', 'NO', NULL, NULL),
(25, 'papas123', 'Disability and Assistance Items', 'Wheelchairs', 3, '2024-02-09 16:57:18', 'YES', '2024-02-09 16:59:27', 'rescuer5'),
(26, 'giannis', 'pet supplies', 'burn pads', 2, '2024-02-09 16:58:59', 'YES', '2024-02-09 16:59:35', 'rescuer5'),
(27, 'giannis', 'Insect Repellents', 'spray', 7, '2024-02-09 16:59:12', 'YES', '2024-02-09 17:00:00', 'rescuer3');

--
-- Triggers `citizen_request`
--
DELIMITER $$
CREATE TRIGGER `prevent_update_trigger_request` BEFORE UPDATE ON `citizen_request` FOR EACH ROW BEGIN
    -- Check if the accepted column is being updated to 'YES'
    IF NEW.accepted = 'YES' THEN
        SET @counting = 0;

        -- Query to get the count and store it in the variable
        SELECT COUNT(*) INTO @counting
        FROM (
            SELECT rescuer_username, accepted FROM citizen_offer
            UNION ALL
            SELECT rescuer_username, accepted FROM citizen_request
        ) AS combined
        WHERE combined.rescuer_username = NEW.rescuer_username AND combined.accepted NOT LIKE 'DONE';

        -- Check if the count is 4 or above when accepted is 'YES'
        IF @counting >= 4 THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Cannot update. Rescuer';
        END IF;
    END IF;

    -- For updates to 'NO' or 'DONE', allow the update without checking the count
END
$$
DELIMITER ;

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
('politis', '123', 'citizens'),
('giannis', 'antreas', 'citizens'),
('rescuer3', 'rescuer3', 'rescuers'),
('rescuer4', 'rescuer4', 'rescuers'),
('rescuer5', 'rescuer5', 'rescuers'),
('politis1', 'politis1', 'citizens');

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
('rescuer3', 'rescuer3', 123123123, 38.2462, 21.7367),
('rescuer4', 'rescuer4', 123, 38.2494, 21.7354),
('rescuer5', 'rescuer5', 662231, 38.2331, 21.7279),
('resquer1', 'resquerpass', 2147483647, 38.2487, 21.738),
('resquer2', 'resquerpass', 2147483647, 38.2411, 21.7425);

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
-- Table structure for table `rescuer_inventory`
--

CREATE TABLE `rescuer_inventory` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `item` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(38.2468, 21.7352);

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
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_anounce` (`admin`);

--
-- Indexes for table `announcements_items`
--
ALTER TABLE `announcements_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_announce` (`announcement_id`),
  ADD KEY `cat_item_announce` (`category`,`item`);

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
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `announcements_items`
--
ALTER TABLE `announcements_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `base_storage`
--
ALTER TABLE `base_storage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;

--
-- AUTO_INCREMENT for table `citizen_offer`
--
ALTER TABLE `citizen_offer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `citizen_request`
--
ALTER TABLE `citizen_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `rescuer_inventory`
--
ALTER TABLE `rescuer_inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `admin_anounce` FOREIGN KEY (`admin`) REFERENCES `admin` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `announcements_items`
--
ALTER TABLE `announcements_items`
  ADD CONSTRAINT `cat_item_announce` FOREIGN KEY (`category`,`item`) REFERENCES `base_storage` (`category`, `item`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_announce` FOREIGN KEY (`announcement_id`) REFERENCES `announcements` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `citizen_offer`
--
ALTER TABLE `citizen_offer`
  ADD CONSTRAINT `citizen_offer_ibfk_1` FOREIGN KEY (`username`) REFERENCES `citizens` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `citizen_offer_ibfk_2` FOREIGN KEY (`category`,`item`) REFERENCES `base_storage` (`category`, `item`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_citizen_offer_rescuer` FOREIGN KEY (`rescuer_username`) REFERENCES `rescuers` (`username`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `citizen_request`
--
ALTER TABLE `citizen_request`
  ADD CONSTRAINT `citizen_request_ibfk_1` FOREIGN KEY (`username`) REFERENCES `citizens` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `citizen_request_ibfk_2` FOREIGN KEY (`category`,`item`) REFERENCES `base_storage` (`category`, `item`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_citizen_request_rescuer` FOREIGN KEY (`rescuer_username`) REFERENCES `rescuers` (`username`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `rescuer_inventory`
--
ALTER TABLE `rescuer_inventory`
  ADD CONSTRAINT `rescuers_request_ibfk_1` FOREIGN KEY (`username`) REFERENCES `rescuers` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rescuers_request_ibfk_2` FOREIGN KEY (`category`,`item`) REFERENCES `base_storage` (`category`, `item`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
