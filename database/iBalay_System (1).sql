-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 23, 2024 at 04:13 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `iBalay_System`
--

-- --------------------------------------------------------

--
-- Table structure for table `bh_information`
--

CREATE TABLE `bh_information` (
  `bh_id` int(11) NOT NULL,
  `landlord_id` int(11) NOT NULL,
  `BH_name` varchar(100) NOT NULL,
  `BH_address` varchar(255) DEFAULT NULL,
  `Document1` varchar(255) DEFAULT NULL,
  `Document2` varchar(255) DEFAULT NULL,
  `monthly_payment_rate` varchar(50) DEFAULT NULL,
  `number_of_kitchen` int(11) DEFAULT NULL,
  `number_of_living_room` int(11) DEFAULT NULL,
  `number_of_students` int(11) DEFAULT NULL,
  `number_of_cr` int(11) DEFAULT NULL,
  `number_of_beds` int(11) DEFAULT NULL,
  `number_of_rooms` int(11) DEFAULT NULL,
  `bh_max_capacity` int(11) DEFAULT NULL,
  `gender_allowed` enum('male','female','all') NOT NULL,
  `Status` enum('0','1','2') DEFAULT '0',
  `longitude` double DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `warnings` tinyint(1) DEFAULT 0,
  `close_account` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bh_information`
--

INSERT INTO `bh_information` (`bh_id`, `landlord_id`, `BH_name`, `BH_address`, `Document1`, `Document2`, `monthly_payment_rate`, `number_of_kitchen`, `number_of_living_room`, `number_of_students`, `number_of_cr`, `number_of_beds`, `number_of_rooms`, `bh_max_capacity`, `gender_allowed`, `Status`, `longitude`, `latitude`, `warnings`, `close_account`) VALUES
(12, 1, 'Cord Ian\'s Boarding House', 'brgy. imelda, tolosa, leyte', '/opt/lampp/htdocs/iBalay/uploads/documents/landlord_1/663ae38bbe1b3_Letter-of-intent-ADAS.pdf', '/opt/lampp/htdocs/iBalay/uploads/documents/landlord_1/663ae38bbe3f2_Letter-of-intent-ADAS.pdf', '1000 - 3243', 2, 2, 2, 2, 2, 2, 2, 'all', '1', 125.01156818078637, 11.097570201927695, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `bookmark`
--

CREATE TABLE `bookmark` (
  `bookmark_id` bigint(20) UNSIGNED NOT NULL,
  `tenant_id` int(11) DEFAULT NULL,
  `room_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookmark`
--

INSERT INTO `bookmark` (`bookmark_id`, `tenant_id`, `room_id`) VALUES
(1046, 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `inquiry`
--

CREATE TABLE `inquiry` (
  `inquiry_id` int(11) NOT NULL,
  `room_id` bigint(20) UNSIGNED DEFAULT NULL,
  `landlord_id` int(11) DEFAULT NULL,
  `tenant_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `sent_by` enum('landlord','tenant') DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inquiry`
--

INSERT INTO `inquiry` (`inquiry_id`, `room_id`, `landlord_id`, `tenant_id`, `message`, `sent_by`, `timestamp`) VALUES
(22, 5, 1, 1, 'wqewe', 'tenant', '2024-05-21 17:45:06'),
(23, 5, 1, 1, 'wqewqe', 'landlord', '2024-05-21 17:45:37');

-- --------------------------------------------------------

--
-- Table structure for table `landlord_acc`
--

CREATE TABLE `landlord_acc` (
  `landlord_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `landlord_acc`
--

INSERT INTO `landlord_acc` (`landlord_id`, `first_name`, `last_name`, `email`, `password`, `phone_number`, `address`) VALUES
(1, 'cord', 'moraleta', 'cordmorale101@gmail.com', '$2y$10$LPvuQzOxb/v/DC41/P9RyeQUkML8.EASXDR9jL6jXvttD0eo4BIzG', '234', 'wqe'),
(2, 'aoi', 'aoi', 'aoi@gmail.com', '$2y$10$VaHE1JwmJ/oQ3IqVgmmap.0tAvszc20n6bZz0zkOReruImqq7p87q', '423432', 'dfsdfs'),
(3, 'test', 'test', 'test@gmail.com', '$2y$10$jfb71UblvWH6BWL9zuRQ7O/KUQm5r6vkvza7PiXA.9oAYZC.cQuOG', '32432', '324fsf'),
(4, 'testing2', 'testing2', 'testing2@gmail.com', '$2y$10$e9JMlTK9kp39LvQANyuZneXZ3rYfNKlYqTTVe0MCCXjz1Vfs2cM8G', '293482934893', 'jdknfdg');

-- --------------------------------------------------------

--
-- Table structure for table `previous_landlords`
--

CREATE TABLE `previous_landlords` (
  `previous_landlord_id` int(11) NOT NULL,
  `tenant_id` int(11) DEFAULT NULL,
  `landlord_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `previous_landlords`
--

INSERT INTO `previous_landlords` (`previous_landlord_id`, `tenant_id`, `landlord_id`) VALUES
(1, 1, 1),
(2, 1, 1),
(3, 1, 1),
(4, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `rented_rooms`
--

CREATE TABLE `rented_rooms` (
  `rented_id` int(11) NOT NULL,
  `room_id` bigint(20) UNSIGNED DEFAULT NULL,
  `TenantID` int(11) DEFAULT NULL,
  `landlord_id` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rented_rooms`
--

INSERT INTO `rented_rooms` (`rented_id`, `room_id`, `TenantID`, `landlord_id`, `start_date`, `end_date`) VALUES
(7, NULL, 1, 1, '2024-05-14', '2024-10-15'),
(8, NULL, 1, 1, '2024-05-19', '2024-07-20'),
(9, NULL, 1, 1, '2024-05-19', '2024-07-20'),
(10, NULL, 1, 1, '2024-05-19', '2024-07-20'),
(11, NULL, 1, 1, '2024-05-19', '2024-07-20'),
(12, NULL, 1, 1, '2024-05-19', '2024-07-20'),
(13, NULL, 1, 1, '2024-05-19', '2024-07-20'),
(14, NULL, 1, 1, '2024-05-19', '2024-07-20'),
(15, NULL, 1, 1, '2024-07-17', '2024-07-22'),
(16, NULL, 1, 1, '2024-05-23', '2024-06-17'),
(17, 4, 1, 1, '2024-05-23', '2024-08-23');

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `ReportID` int(11) NOT NULL,
  `room_id` int(11) DEFAULT NULL,
  `TenantID` int(11) DEFAULT NULL,
  `ReportDate` date DEFAULT NULL,
  `ReportText` text DEFAULT NULL,
  `Acknowledge` tinyint(1) DEFAULT 0,
  `Notified` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `report`
--

INSERT INTO `report` (`ReportID`, `room_id`, `TenantID`, `ReportDate`, `ReportText`, `Acknowledge`, `Notified`) VALUES
(1, 4, 1, '2024-05-22', 'wqewqewqewqe', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `reserved_room`
--

CREATE TABLE `reserved_room` (
  `reserved_id` int(11) NOT NULL,
  `room_id` bigint(20) UNSIGNED DEFAULT NULL,
  `TenantID` int(11) DEFAULT NULL,
  `declined` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reserved_room`
--

INSERT INTO `reserved_room` (`reserved_id`, `room_id`, `TenantID`, `declined`) VALUES
(17, NULL, NULL, 1),
(18, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `landlord_id` int(11) DEFAULT NULL,
  `room_number` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `room_price` decimal(10,2) DEFAULT NULL,
  `room_photo1` varchar(255) DEFAULT NULL,
  `room_photo2` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`room_id`, `landlord_id`, `room_number`, `description`, `capacity`, `room_price`, `room_photo1`, `room_photo2`) VALUES
(4, 1, 11, 'sdsadsdsad', 17, 232332.00, 'photo_663cd60b3785e.jpg', 'photo_663cd3e9c2019.jpeg'),
(5, 1, 2, 'sdsadas', 22, 23213.00, 'photo_663cd3fb38c24.jpeg', 'photo_663cd3fb38df2.jpeg'),
(6, 1, 3, 'swewqqw', 1, 2.00, 'photo_663cd4063b720.jpeg', 'photo_663cd4063b817.jpeg'),
(7, 1, 1, 'A boarding house offers a shared living experience with private rooms and communal amenities. Ideal for students, young professionals, or travelers, it\'s an affordable and convenient housing option where residents share common spaces like kitchens and bathrooms. With flexible rental terms, boarding houses promote a sense of community and provide a supportive environment for those seeking a home away from home.', 2, 1000.00, 'photo_663d787f7df82.jpg', 'photo_663d787f7dfa3.jpeg'),
(8, 1, 4, 'A boarding house offers a shared living experience with private rooms and communal amenities. Ideal for students, young professionals, or travelers, it\'s an affordable and convenient housing option where residents share common spaces like kitchens and bathrooms. With flexible rental terms, boarding houses promote a sense of community and provide a supportive environment for those seeking a home away from home.', 2, 1000.00, 'photo_663d78954db98.jpeg', 'photo_663d78954dbad.jpeg'),
(9, 1, 5, 'A boarding house offers a shared living experience with private rooms and communal amenities. Ideal for students, young professionals, or travelers, it\'s an affordable and convenient housing option where residents share common spaces like kitchens and bathrooms. With flexible rental terms, boarding houses promote a sense of community and provide a supportive environment for those seeking a home away from home.', 2, 1000.00, 'photo_663d78a6d8157.jpeg', 'photo_663d78a6d816d.jpeg'),
(10, 1, 6, 'A boarding house offers a shared living experience with private rooms and communal amenities. Ideal for students, young professionals, or travelers, it\'s an affordable and convenient housing option where residents share common spaces like kitchens and bathrooms. With flexible rental terms, boarding houses promote a sense of community and provide a supportive environment for those seeking a home away from home.', 2, 1000.00, 'photo_663d78bc4f26d.jpg', 'photo_663d78bc4f287.jpg'),
(11, 1, 7, 'A boarding house offers a shared living experience with private rooms and communal amenities. Ideal for students, young professionals, or travelers, it\'s an affordable and convenient housing option where residents share common spaces like kitchens and bathrooms. With flexible rental terms, boarding houses promote a sense of community and provide a supportive environment for those seeking a home away from home.', 2, 1000.00, 'photo_663d78ccbf58f.jpg', 'photo_663d78ccbf5a4.jpg'),
(12, 1, 8, 'A boarding house offers a shared living experience with private rooms and communal amenities. Ideal for students, young professionals, or travelers, it\'s an affordable and convenient housing option where residents share common spaces like kitchens and bathrooms. With flexible rental terms, boarding houses promote a sense of community and provide a supportive environment for those seeking a home away from home.', 2, 1000.00, 'photo_663d78dd3273e.jpg', 'photo_663d78dd32753.jpg'),
(13, 1, 9, 'A boarding house offers a shared living experience with private rooms and communal amenities. Ideal for students, young professionals, or travelers, it\'s an affordable and convenient housing option where residents share common spaces like kitchens and bathrooms. With flexible rental terms, boarding houses promote a sense of community and provide a supportive environment for those seeking a home away from home.', 2, 500.00, 'photo_663d7927d78b0.jpg', 'photo_663d7927d78c6.jpeg'),
(14, 1, 10, 'A boarding house offers a shared living experience with private rooms and communal amenities. Ideal for students, young professionals, or travelers, it\'s an affordable and convenient housing option where residents share common spaces like kitchens and bathrooms. With flexible rental terms, boarding houses promote a sense of community and provide a supportive environment for those seeking a home away from home.', 5, 100.00, 'photo_663d79344ef36.jpg', 'photo_663d79344ef4e.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `room_reviews`
--

CREATE TABLE `room_reviews` (
  `review_id` int(11) NOT NULL,
  `room_id` bigint(20) UNSIGNED DEFAULT NULL,
  `TenantID` int(11) DEFAULT NULL,
  `review_comment` varchar(255) DEFAULT NULL,
  `room_rating` int(11) DEFAULT NULL,
  `bh_rating` int(11) DEFAULT NULL,
  `cr_rating` int(11) DEFAULT NULL,
  `beds_rating` int(11) DEFAULT NULL,
  `kitchen_rating` int(11) DEFAULT NULL,
  `review_date` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_reviews`
--

INSERT INTO `room_reviews` (`review_id`, `room_id`, `TenantID`, `review_comment`, `room_rating`, `bh_rating`, `cr_rating`, `beds_rating`, `kitchen_rating`, `review_date`) VALUES
(2, 14, 1, 'Great room with beautiful viewsdfdsfsd fdsfsdfsdf sdfsdfs fsd fsd fsdfsd fdsf sdf dsf ds', 5, 5, 4, 5, 4, '2024-05-11'),
(11, 14, 2, 'Spacious and clean Great room with beautiful viewGreat room with beautiful viewGreat room with beautiful view', 4, 3, 5, 4, 5, '2024-05-11'),
(12, 14, 3, 'Nice and cozy Great room with beautiful viewGreat room with beautiful viewGreat room with beautiful view', 4, 4, 3, 4, 3, '2024-05-11'),
(13, 14, 2, 'Room was good, but needed some repairs', 3, 3, 3, 3, 2, '2024-05-11'),
(14, 4, 1, 'weqwe', 2, 3, 1, 2, 3, '2024-05-14');

-- --------------------------------------------------------

--
-- Table structure for table `saso`
--

CREATE TABLE `saso` (
  `saso_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `saso`
--

INSERT INTO `saso` (`saso_id`, `username`, `password`, `photo`) VALUES
(3, 'saso', '$2y$10$gxhZAUk0BumQb0BZz08v/uw57SlAEM8SOsNfElwcw5IWN5o0kYNMm', '663058c2b18da_evsu_favicon.png'),
(4, 'test', '$2y$10$ww9NbTtwAj4ccWZNJg1Ah.oBTt/Q76.X.at2mvLohIn48LuSwDzfy', '664c113b9ef42_Screenshot from 2024-05-20 13-45-18.png'),
(5, 'saso', '$2y$10$AyRV8UlVJqigY4kEFq507e.k/ocw16k/dZrwgIzlYgNyczAygtR7a', '664d3da91950e_Screenshot from 2024-05-20 13-45-25.png'),
(6, 'saso', '$2y$10$jFau8vNEEEzoHQcFOfXUi.N2FltYsR3utaFhv0V.Tq5L68VZwpiWG', '');

-- --------------------------------------------------------

--
-- Table structure for table `tenant`
--

CREATE TABLE `tenant` (
  `TenantID` int(11) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `PhoneNumber` varchar(20) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `student_id` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `checked_out` tinyint(1) DEFAULT 0,
  `Evsu_student` tinyint(1) DEFAULT 0,
  `ProfilePhoto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tenant`
--

INSERT INTO `tenant` (`TenantID`, `FirstName`, `LastName`, `Email`, `PhoneNumber`, `Password`, `student_id`, `address`, `gender`, `checked_out`, `Evsu_student`, `ProfilePhoto`) VALUES
(1, 'cord', 'sadkasmdk', 'cordmorale101@gmail.com', '423432', '$2y$10$dQC6eDkXVkrYsJbPXkypHeAsSM5nKQOF252LAUGpuUXrRiQ2UUtca', '232321', 'dsadas', 'Male', 0, 1, '1_664d3cb141ea1.png'),
(2, 'John', 'Doe', 'john.doe@example.com', '123-456-7890', 'password123', 'S12345', '123 Main St', 'Male', 0, 1, NULL),
(3, 'Jane', 'Smith', 'jane.smith@example.com', '098-765-4321', 'password123', 'S54321', '456 Elm St', 'Female', 0, 1, NULL),
(4, 'Emily', 'Johnson', 'emily.johnson@example.com', '555-555-5555', 'password123', 'S67890', '789 Pine St', 'Female', 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tenant_payments`
--

CREATE TABLE `tenant_payments` (
  `payment_id` int(11) NOT NULL,
  `rented_id` int(11) DEFAULT NULL,
  `TenantID` int(11) DEFAULT NULL,
  `room_id` bigint(20) UNSIGNED DEFAULT NULL,
  `landlord_id` int(11) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tenant_payments`
--

INSERT INTO `tenant_payments` (`payment_id`, `rented_id`, `TenantID`, `room_id`, `landlord_id`, `payment_date`, `amount`) VALUES
(7, 7, 1, 4, 1, '2024-05-14', 213213.00),
(8, 7, 1, 4, 1, '2024-05-15', 2321.00),
(9, 7, 1, 4, 1, '2024-05-15', 23232321.00),
(10, 7, 1, 4, 1, '2024-05-15', 9999.00),
(11, 15, 1, 4, 1, '2024-05-21', 453454.00),
(12, 16, 1, 6, 1, '2024-05-23', 34234.00),
(13, 17, 1, 4, 1, '2024-05-23', 2321321.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bh_information`
--
ALTER TABLE `bh_information`
  ADD PRIMARY KEY (`bh_id`),
  ADD KEY `landlord_id` (`landlord_id`);

--
-- Indexes for table `bookmark`
--
ALTER TABLE `bookmark`
  ADD PRIMARY KEY (`bookmark_id`);

--
-- Indexes for table `inquiry`
--
ALTER TABLE `inquiry`
  ADD PRIMARY KEY (`inquiry_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `landlord_id` (`landlord_id`),
  ADD KEY `tenant_id` (`tenant_id`);

--
-- Indexes for table `landlord_acc`
--
ALTER TABLE `landlord_acc`
  ADD PRIMARY KEY (`landlord_id`),
  ADD UNIQUE KEY `unique_email` (`email`);

--
-- Indexes for table `previous_landlords`
--
ALTER TABLE `previous_landlords`
  ADD PRIMARY KEY (`previous_landlord_id`),
  ADD KEY `tenant_id` (`tenant_id`),
  ADD KEY `landlord_id` (`landlord_id`);

--
-- Indexes for table `rented_rooms`
--
ALTER TABLE `rented_rooms`
  ADD PRIMARY KEY (`rented_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `TenantID` (`TenantID`),
  ADD KEY `landlord_id` (`landlord_id`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`ReportID`);

--
-- Indexes for table `reserved_room`
--
ALTER TABLE `reserved_room`
  ADD PRIMARY KEY (`reserved_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `TenantID` (`TenantID`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`room_id`),
  ADD KEY `fk_landlord` (`landlord_id`);

--
-- Indexes for table `room_reviews`
--
ALTER TABLE `room_reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `TenantID` (`TenantID`);

--
-- Indexes for table `saso`
--
ALTER TABLE `saso`
  ADD PRIMARY KEY (`saso_id`);

--
-- Indexes for table `tenant`
--
ALTER TABLE `tenant`
  ADD PRIMARY KEY (`TenantID`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `student_id` (`student_id`),
  ADD UNIQUE KEY `idx_tenant_email` (`Email`),
  ADD UNIQUE KEY `idx_tenant_student_id` (`student_id`);

--
-- Indexes for table `tenant_payments`
--
ALTER TABLE `tenant_payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `rented_id` (`rented_id`),
  ADD KEY `TenantID` (`TenantID`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `landlord_id` (`landlord_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bh_information`
--
ALTER TABLE `bh_information`
  MODIFY `bh_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `bookmark`
--
ALTER TABLE `bookmark`
  MODIFY `bookmark_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1047;

--
-- AUTO_INCREMENT for table `inquiry`
--
ALTER TABLE `inquiry`
  MODIFY `inquiry_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `landlord_acc`
--
ALTER TABLE `landlord_acc`
  MODIFY `landlord_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `previous_landlords`
--
ALTER TABLE `previous_landlords`
  MODIFY `previous_landlord_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rented_rooms`
--
ALTER TABLE `rented_rooms`
  MODIFY `rented_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `ReportID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reserved_room`
--
ALTER TABLE `reserved_room`
  MODIFY `reserved_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `room_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `room_reviews`
--
ALTER TABLE `room_reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `saso`
--
ALTER TABLE `saso`
  MODIFY `saso_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tenant`
--
ALTER TABLE `tenant`
  MODIFY `TenantID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tenant_payments`
--
ALTER TABLE `tenant_payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bh_information`
--
ALTER TABLE `bh_information`
  ADD CONSTRAINT `bh_information_ibfk_1` FOREIGN KEY (`landlord_id`) REFERENCES `landlord_acc` (`landlord_id`) ON DELETE CASCADE;

--
-- Constraints for table `inquiry`
--
ALTER TABLE `inquiry`
  ADD CONSTRAINT `inquiry_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `room` (`room_id`),
  ADD CONSTRAINT `inquiry_ibfk_2` FOREIGN KEY (`landlord_id`) REFERENCES `landlord_acc` (`landlord_id`),
  ADD CONSTRAINT `inquiry_ibfk_3` FOREIGN KEY (`tenant_id`) REFERENCES `tenant` (`TenantID`);

--
-- Constraints for table `previous_landlords`
--
ALTER TABLE `previous_landlords`
  ADD CONSTRAINT `previous_landlords_ibfk_1` FOREIGN KEY (`tenant_id`) REFERENCES `tenant` (`TenantID`),
  ADD CONSTRAINT `previous_landlords_ibfk_2` FOREIGN KEY (`landlord_id`) REFERENCES `landlord_acc` (`landlord_id`);

--
-- Constraints for table `rented_rooms`
--
ALTER TABLE `rented_rooms`
  ADD CONSTRAINT `rented_rooms_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `room` (`room_id`),
  ADD CONSTRAINT `rented_rooms_ibfk_2` FOREIGN KEY (`TenantID`) REFERENCES `tenant` (`TenantID`),
  ADD CONSTRAINT `rented_rooms_ibfk_3` FOREIGN KEY (`landlord_id`) REFERENCES `landlord_acc` (`landlord_id`);

--
-- Constraints for table `reserved_room`
--
ALTER TABLE `reserved_room`
  ADD CONSTRAINT `reserved_room_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `room` (`room_id`),
  ADD CONSTRAINT `reserved_room_ibfk_2` FOREIGN KEY (`TenantID`) REFERENCES `tenant` (`TenantID`);

--
-- Constraints for table `room`
--
ALTER TABLE `room`
  ADD CONSTRAINT `fk_landlord` FOREIGN KEY (`landlord_id`) REFERENCES `landlord_acc` (`landlord_id`);

--
-- Constraints for table `room_reviews`
--
ALTER TABLE `room_reviews`
  ADD CONSTRAINT `room_reviews_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `room` (`room_id`),
  ADD CONSTRAINT `room_reviews_ibfk_2` FOREIGN KEY (`TenantID`) REFERENCES `tenant` (`TenantID`);

--
-- Constraints for table `tenant_payments`
--
ALTER TABLE `tenant_payments`
  ADD CONSTRAINT `tenant_payments_ibfk_1` FOREIGN KEY (`rented_id`) REFERENCES `rented_rooms` (`rented_id`),
  ADD CONSTRAINT `tenant_payments_ibfk_2` FOREIGN KEY (`TenantID`) REFERENCES `tenant` (`TenantID`),
  ADD CONSTRAINT `tenant_payments_ibfk_3` FOREIGN KEY (`room_id`) REFERENCES `room` (`room_id`),
  ADD CONSTRAINT `tenant_payments_ibfk_4` FOREIGN KEY (`landlord_id`) REFERENCES `landlord_acc` (`landlord_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
