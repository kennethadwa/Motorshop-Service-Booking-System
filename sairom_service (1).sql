-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 03, 2024 at 09:01 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sairom_service`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `age` int(11) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `sex` varchar(10) DEFAULT NULL,
  `contact_no` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile` varchar(255) DEFAULT NULL,
  `account_type` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `first_name`, `last_name`, `age`, `birthday`, `sex`, `contact_no`, `address`, `email`, `password`, `profile`, `account_type`) VALUES
(1, 'Kenneth', 'Lorenzo', 21, '2003-12-11', 'Male', '09376298340', 'Bunny Village', 'kennetics1@gmail.com', '$2y$10$.unEkaeHkQqZHrAngbKmROZyjYkB9FGL5lAKraU1kJdKT1cdbXsCS', 'uploads/admin_profile/bunny.jpg', 0),
(3, 'Spongebob', 'Lorenzo', 20, '1993-06-18', 'Male', '09111111111', 'Krusty Krab', 'spongebob@gmail.com', '$2y$10$ZSVfmOo7O0UsIubbU06zlONbwOZBzrMWy01WoFqqI/IhVUFbHBvey', 'uploads/admin_profile/dog.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `booking_request`
--

CREATE TABLE `booking_request` (
  `request_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `model_name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `request_date` date DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `age` int(11) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `sex` varchar(10) DEFAULT NULL,
  `contact_no` varchar(20) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile` varchar(255) DEFAULT NULL,
  `account_type` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `first_name`, `last_name`, `age`, `birthday`, `sex`, `contact_no`, `address`, `email`, `password`, `profile`, `account_type`, `created_at`) VALUES
(1, 'Kenneth', 'Lorenzo', 20, '2003-12-11', 'Male', '09123456789', 'Meow Village', 'kenneth@gmail.com', '$2y$10$NPOhQHYxgCSE.74h20HTg.E9k.ODAFRkXKmqzAJGBJjYBOWXBsrxS', 'uploads/customer_profile/bunny.jpg', 2, '2024-09-26 11:22:57'),
(3, 'Trisha Mae', 'Quiras', 22, '2003-10-21', 'Female', '09633874702', 'Cat Village', 'faye@gmail.com', '$2y$10$N8wHyADZCqgDyl.QgFT9Q.5Yj.pnPoT9mA7hIwRPFN5YoOOKJbEaC', 'uploads/customer_profile/1727586871_dog.jpg', 2, '2024-09-29 05:14:31'),
(4, 'Hachiko', 'Lorenzo', 6, '2018-07-08', 'Male', '09999999999', 'Dog Village', 'hachi@gmail.com', '$2y$10$dU9pKgQwXnIfQayNdGJJi.MxxY4PFnhU8MQXm38twsZEuE9RsenPG', 'uploads/customer_profile/1727587151_dog.jpg', 2, '2024-09-29 05:19:11');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employee_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `age` int(11) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `sex` varchar(10) DEFAULT NULL,
  `contact_no` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile` varchar(255) DEFAULT NULL,
  `account_type` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employee_id`, `first_name`, `last_name`, `age`, `birthday`, `sex`, `contact_no`, `address`, `email`, `password`, `profile`, `account_type`) VALUES
(3, 'Mew', 'Lorenzo', 2, '2022-11-10', 'Male', '09876543212', 'Meow Village, Lipa City', 'mew@gmail.com', '$2y$10$1GVbdDmKf/Gc2hpUW1ibFOu8zE3kSPJkGfClhNoJGyHNvAVBRUr0e', 'uploads/employee_profile/bunny.jpg', 1),
(4, 'Cherry', 'Lorenzo', 2, '2022-07-14', 'Female', '09888888888', 'Cat Village', 'cherry@gmail.com', '$2y$10$EhA/T8PWd9nnc673t0UqOejYtsdRjIHBoU7uKC5UcJJVlpQ.Xfs/m', 'uploads/employee_profile/1727587266_mew_profile.jpg', 1),
(5, 'Trisha Mae', 'Quiras', 21, '2024-10-21', 'Female', '09123456789', 'Lynville, Latag', 'trishana@gmail.com', '$2y$10$fK9YMJhYeaj6q8cA4QnPce6sYmR5e97e6.uCZyfHYYx4lXPYTH9ue', 'uploads/employee_profile/1727885889_mew_profile.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `payment_method` varchar(255) DEFAULT 'Gcash',
  `amount` decimal(10,2) NOT NULL,
  `proof_of_payment` varchar(255) DEFAULT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `schedule_id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `booking_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_requests`
--

CREATE TABLE `service_requests` (
  `request_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(255) DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `scheduled_date` date DEFAULT NULL,
  `deposit_amount` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT 'Gcash',
  `deposit_status` varchar(255) DEFAULT 'pending',
  `transaction_status` varchar(255) DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `booking_request`
--
ALTER TABLE `booking_request`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employee_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `transaction_id` (`transaction_id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`schedule_id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `service_requests`
--
ALTER TABLE `service_requests`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `vehicle_id` (`vehicle_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `request_id` (`request_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `booking_request`
--
ALTER TABLE `booking_request`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_requests`
--
ALTER TABLE `service_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking_request`
--
ALTER TABLE `booking_request`
  ADD CONSTRAINT `booking_request_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`transaction_id`) ON DELETE CASCADE;

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `schedule_ibfk_2` FOREIGN KEY (`booking_id`) REFERENCES `booking_request` (`request_id`) ON DELETE CASCADE;

--
-- Constraints for table `service_requests`
--
ALTER TABLE `service_requests`
  ADD CONSTRAINT `service_requests_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `service_requests_ibfk_2` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`vehicle_id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `service_requests` (`request_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
