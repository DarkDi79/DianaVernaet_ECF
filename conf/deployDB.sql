-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 29, 2022 at 11:55 AM
-- Server version: 10.6.7-MariaDB-2ubuntu1.1
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecf`
--

-- --------------------------------------------------------

--
-- Table structure for table `centers`
--

CREATE TABLE `centers` (
  `ctr_id` int(11) NOT NULL,
  `ctr_name` varchar(255) NOT NULL,
  `ctr_usr_id` int(11) NOT NULL,
  `ctr_mail` varchar(255) NOT NULL,
  `ctr_opt_towel` tinyint(1) NOT NULL,
  `ctr_opt_drinks` tinyint(1) NOT NULL,
  `ctr_opt_planning` tinyint(1) NOT NULL,
  `ctr_opt_food` tinyint(1) NOT NULL,
  `ctr_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `centers`
--

INSERT INTO `centers` (`ctr_id`, `ctr_name`, `ctr_usr_id`, `ctr_mail`, `ctr_opt_towel`, `ctr_opt_drinks`, `ctr_opt_planning`, `ctr_opt_food`, `ctr_active`) VALUES
(1, 'Alesia', 4, 'alesia-paris14@mail.com', 0, 0, 1, 1, 0),
(3, 'la vilette', 16, 'pierre@mail.com', 0, 0, 0, 1, 1),
(4, 'La Pierre', 30, 'diana@mail.com', 0, 0, 0, 1, 1),
(5, 'Le Rocher', 16, 'contact@lerocher.com', 1, 0, 1, 0, 1),
(6, 'Denfert', 30, 'contact@denfert.com', 1, 0, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

CREATE TABLE `partners` (
  `ptr_id` int(11) NOT NULL,
  `ptr_name` varchar(255) NOT NULL,
  `ptr_mail` varchar(255) NOT NULL,
  `ptr_usr_id` int(11) NOT NULL,
  `ptr_opt_towel` tinyint(1) NOT NULL,
  `ptr_opt_drinks` tinyint(1) NOT NULL,
  `ptr_opt_planning` tinyint(1) NOT NULL,
  `ptr_opt_food` tinyint(1) NOT NULL,
  `ptr_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `partners`
--

INSERT INTO `partners` (`ptr_id`, `ptr_name`, `ptr_mail`, `ptr_usr_id`, `ptr_opt_towel`, `ptr_opt_drinks`, `ptr_opt_planning`, `ptr_opt_food`, `ptr_active`) VALUES
(1, 'Paris 14', 'paris14@mail.com', 2, 1, 0, 1, 1, 1),
(10, 'Super Franchise', 'moi@superfranchise.com', 27, 0, 0, 0, 1, 1),
(11, 'Dark Side', 'diana@mail.com', 26, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ptr_to_ctr`
--

CREATE TABLE `ptr_to_ctr` (
  `ptc_ptr_id` int(11) NOT NULL,
  `ptc_ctr_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ptr_to_ctr`
--

INSERT INTO `ptr_to_ctr` (`ptc_ptr_id`, `ptc_ctr_id`) VALUES
(1, 1),
(1, 6),
(11, 5);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `rol_id` varchar(255) NOT NULL,
  `rol_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`rol_id`, `rol_name`) VALUES
('CENT', 'Salle de Sport'),
('PART', 'Franchise'),
('TECH', 'Equipe Technique');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `usr_id` int(11) NOT NULL,
  `usr_name` varchar(255) NOT NULL,
  `usr_rol_id` varchar(255) NOT NULL,
  `usr_mail` varchar(255) NOT NULL,
  `usr_pw` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `usr_change_pw` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`usr_id`, `usr_name`, `usr_rol_id`, `usr_mail`, `usr_pw`, `usr_change_pw`) VALUES
(2, 'Pierre Dupont', 'PART', 'pierredupont@mail.com', 'motdepasse', 0),
(3, 'Paul Durand', 'PART', 'pauldurand@mail.com', 'testmodifPWD', 0),
(4, 'Joe Lille', 'CENT', 'joelille@mail.com', 'nouveaumdp', 0),
(16, 'Pierre', 'CENT', 'pierre@mail.com', 'motdepasse', 1),
(25, 'Ody', 'TECH', 'Odyssea@mail.com', '$2y$10$jbK.Ftl23psQQog0UsPlGunzK.kKLBXK79QifkJ6fwRjziqcnxhue', 0),
(26, 'Diana', 'PART', 'diana@mail.com', '$2y$10$H3c1LFuBQuyWFpn/u0aoN.9k21mnH1pLXs64xuImBOzGo8eIoZDGW', 1),
(27, 'toto', 'PART', 'toto@toto.com', '$2y$10$Hxoj4Kv4ehOyOWTEDr963.XD37NX0bEGoRtkFctTRBOkTdIIHR5Jq', 1),
(28, 'tata', 'CENT', 'tata@tata.com', '$2y$10$AfDIWEOJCc.JKm.Ksk7wwOA3Lt/xNz3Ke/1GNREw1K565jnwiFdEm', 1),
(29, 'Luis', 'PART', 'luis@mail.com', '$2y$10$BPLCDULcjLL5rYz12/RmlumMJiHGFP4Q2Du2dpjPhUBDrV8sfLGFm', 1),
(30, 'Greg', 'CENT', 'greg@mail.com', '$2y$10$pZIDnEnFLrbALZEVblIE9OcypTLjOg8ydnxBm4t6Q/YKZXC/R0DEK', 1),
(32, 'moi', 'PART', 'moi@gmail.com', '$2y$10$R8FuGjkjBhz70pNyS3NsDueADlTWO7h04r/9DxtdcR.NeuDjWVlt.', 1),
(33, 'coucou', 'PART', 'coucou@gmail.com', '$2y$10$BPyqgA31etDVqn.kO8fnWeN/C0gy/t15pMO2bE/.h8V7ODiaeFNqS', 1),
(34, 'lui', 'PART', 'lui@gmail.com', '$2y$10$yY2q1n3iw1rrl/HzfJySeOUpt9x.TSpxYJyVxgBWBluEtJ3Wbc2sq', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `centers`
--
ALTER TABLE `centers`
  ADD PRIMARY KEY (`ctr_id`),
  ADD UNIQUE KEY `ctr_mail` (`ctr_mail`),
  ADD KEY `ctr_usr_id` (`ctr_usr_id`);

--
-- Indexes for table `partners`
--
ALTER TABLE `partners`
  ADD PRIMARY KEY (`ptr_id`),
  ADD UNIQUE KEY `ptr_name` (`ptr_name`),
  ADD UNIQUE KEY `ptr_mail` (`ptr_mail`),
  ADD KEY `ptr_usr_id` (`ptr_usr_id`);

--
-- Indexes for table `ptr_to_ctr`
--
ALTER TABLE `ptr_to_ctr`
  ADD PRIMARY KEY (`ptc_ptr_id`,`ptc_ctr_id`),
  ADD KEY `ptr_to_ctr_ibfk_2` (`ptc_ctr_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`rol_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`usr_id`),
  ADD UNIQUE KEY `usr_mail` (`usr_mail`),
  ADD KEY `usr_rol_id` (`usr_rol_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `centers`
--
ALTER TABLE `centers`
  MODIFY `ctr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `partners`
--
ALTER TABLE `partners`
  MODIFY `ptr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `usr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `centers`
--
ALTER TABLE `centers`
  ADD CONSTRAINT `centers_ibfk_1` FOREIGN KEY (`ctr_usr_id`) REFERENCES `users` (`usr_id`);

--
-- Constraints for table `partners`
--
ALTER TABLE `partners`
  ADD CONSTRAINT `partners_ibfk_1` FOREIGN KEY (`ptr_usr_id`) REFERENCES `users` (`usr_id`);

--
-- Constraints for table `ptr_to_ctr`
--
ALTER TABLE `ptr_to_ctr`
  ADD CONSTRAINT `ptr_to_ctr_ibfk_1` FOREIGN KEY (`ptc_ptr_id`) REFERENCES `partners` (`ptr_id`),
  ADD CONSTRAINT `ptr_to_ctr_ibfk_2` FOREIGN KEY (`ptc_ctr_id`) REFERENCES `centers` (`ctr_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`usr_rol_id`) REFERENCES `roles` (`rol_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
