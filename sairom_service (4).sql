-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 18, 2024 at 05:58 AM
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
(1, 'Kenneth', 'Lorenzo', 21, '2003-12-11', 'Male', '09376298340', 'Bunny Village', 'kennetics1@gmail.com', '$2y$10$.unEkaeHkQqZHrAngbKmROZyjYkB9FGL5lAKraU1kJdKT1cdbXsCS', '../uploads/admin_profile/kenneth.jpg', 0),
(2, 'Spongebob', 'Lorenzo', 20, '1993-06-18', 'Male', '09111111111', 'Krusty Krab', 'spongebob@gmail.com', '$2y$10$ZSVfmOo7O0UsIubbU06zlONbwOZBzrMWy01WoFqqI/IhVUFbHBvey', '../uploads/admin_profile/dog.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `booking_images`
--

CREATE TABLE `booking_images` (
  `image_id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_images`
--

INSERT INTO `booking_images` (`image_id`, `request_id`, `image_path`) VALUES
(29, 24, '../uploads/booking_images/bunny.jpg'),
(30, 24, '../uploads/booking_images/dog.jpg'),
(31, 24, '../uploads/booking_images/mew_profile.jpg'),
(32, 25, '../uploads/booking_images/oil.jpg'),
(33, 25, '../uploads/booking_images/bunny.jpg'),
(34, 25, '../uploads/booking_images/dog.jpg'),
(35, 26, '../uploads/booking_images/oil.jpg'),
(36, 26, '../uploads/booking_images/bunny.jpg'),
(37, 26, '../uploads/booking_images/dog.jpg'),
(38, 26, '../uploads/booking_images/mew_profile.jpg'),
(39, 27, '../uploads/booking_images/bunny.jpg'),
(40, 27, '../uploads/booking_images/dog.jpg'),
(41, 27, '../uploads/booking_images/mew_profile.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `booking_request`
--

CREATE TABLE `booking_request` (
  `request_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `package_id` int(11) DEFAULT NULL,
  `model_name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `request_date` date DEFAULT NULL,
  `request_time` time DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT 'pending',
  `date_requested` timestamp NOT NULL DEFAULT current_timestamp(),
  `viewed` tinyint(4) DEFAULT 0,
  `is_new` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_request`
--

INSERT INTO `booking_request` (`request_id`, `customer_id`, `package_id`, `model_name`, `address`, `request_date`, `request_time`, `description`, `status`, `date_requested`, `viewed`, `is_new`) VALUES
(24, 3, 2, 'Mio', 'Sabang, Lipa City', '2024-10-31', '10:00:00', 'pa change oil po ng aking mio and then papalitan na rin po ng gulong', 'completed', '2024-10-17 09:18:09', 1, 0),
(25, 3, 1, 'TOYOTA', 'Sabang, Lipa City', '2024-10-20', '10:30:00', 'pa change oil and then pahanginan na rin ng gulong ', 'completed', '2024-10-17 09:23:57', 1, 0),
(26, 3, 1, 'Ford', 'Cat Village', '2024-10-25', '10:20:00', 'paays nga nito idol', 'completed', '2024-10-17 13:47:10', 1, 1),
(27, 3, 2, 'Honda Mitsubishi', 'Sabang, Lipa City', '2024-10-20', '09:00:00', 'paayos ng Honda Mitsubishi', 'completed', '2024-10-17 17:04:53', 0, 1),
(35, 3, 4, 'Barako', 'Sabang, Lipa City', '2024-10-20', '10:30:00', 'asdasdasd', 'approved', '2024-10-18 03:33:50', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(2, 'Oil'),
(4, 'Motorcycle Parts'),
(5, 'Accessories'),
(6, 'Tires & Wheels'),
(7, 'Oils & Lubricants'),
(8, 'Battery'),
(9, 'Electrical Components'),
(10, 'Suspension & Brakes'),
(11, 'Maintenance Services'),
(12, 'Performance Upgrades'),
(13, 'ustom Builds & Modifications');

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
(1, 'Kenneth', 'Lorenzo', 20, '2003-12-11', 'Male', '09123456789', 'Meow Village', 'kenneth@gmail.com', '$2y$10$NPOhQHYxgCSE.74h20HTg.E9k.ODAFRkXKmqzAJGBJjYBOWXBsrxS', '../uploads/customer_profile/bunny.jpg', 2, '2024-09-26 03:22:57'),
(2, 'Trisha Mae', 'Quiras', 22, '2003-10-21', 'Female', '09633874702', 'Cat Village', 'faye@gmail.com', '$2y$10$N8wHyADZCqgDyl.QgFT9Q.5Yj.pnPoT9mA7hIwRPFN5YoOOKJbEaC', '../uploads/customer_profile/1727586871_dog.jpg', 3, '2024-09-28 21:14:31'),
(3, 'Hachiko', 'Lorenzo', 6, '2018-07-08', 'Male', '09999999999', 'Dog Village', 'hachi@gmail.com', '$2y$10$dU9pKgQwXnIfQayNdGJJi.MxxY4PFnhU8MQXm38twsZEuE9RsenPG', '../uploads/customer_profile/1727587151_dog.jpg', 2, '2024-09-28 21:19:11');

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
(1, 'Mew', 'Lorenzo', 2, '2022-11-10', 'Male', '09876543212', 'Meow Village, Lipa City', 'mew@gmail.com', '$2y$10$1GVbdDmKf/Gc2hpUW1ibFOu8zE3kSPJkGfClhNoJGyHNvAVBRUr0e', '../uploads/employee_profile/bunny.jpg', 1),
(2, 'Cherry', 'Lorenzo', 2, '2022-07-14', 'Female', '09888888888', 'Cat Village', 'cherry@gmail.com', '$2y$10$EhA/T8PWd9nnc673t0UqOejYtsdRjIHBoU7uKC5UcJJVlpQ.Xfs/m', '../uploads/employee_profile/1727587266_mew_profile.jpg', 1),
(3, 'Trisha Mae', 'Quiras', 21, '2024-10-21', 'Female', '09123456789', 'Lynville, Latag', 'trishana@gmail.com', '$2y$10$fK9YMJhYeaj6q8cA4QnPce6sYmR5e97e6.uCZyfHYYx4lXPYTH9ue', '../uploads/employee_profile/1727885889_mew_profile.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `package_id` int(11) NOT NULL,
  `package_name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `duration` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`package_id`, `package_name`, `price`, `duration`, `description`, `status`) VALUES
(1, 'Standard Maintenance', 5000.00, 3, 'Inclusions:\r\nOil Change\r\nFluid Check (brake, coolant, transmission)\r\nTire Rotation\r\nBasic Inspection', 'active'),
(2, 'Express Service Package', 3000.00, 2, 'Inclusions:\r\nOil Change\r\nProducts Needed: Engine Oil, Oil Filter\r\nTire Pressure Check\r\nProducts Needed: Tire Pressure Gauge\r\nWindshield Wiper Replacement\r\nProducts Needed: Wiper Blades\r\nAir Filter Check\r\nProducts Needed: Air Filter', 'active'),
(3, 'Comprehensive Service', 3500.00, 5, 'Inclusions:\r\nOil Change\r\nProducts Needed: Engine Oil, Oil Filter\r\nTire Rotation and Alignment\r\nProducts Needed: Tire Pressure Gauge, Alignment Tools\r\nBrake Inspection\r\nProducts Needed: Brake Pads, Brake Fluid\r\nBattery Check\r\nProducts Needed: Battery Tester\r\nFluid Flush (coolant, brake, transmission)\r\nProducts Needed: Coolant, Brake Fluid, Transmission Fluid\r\nPremium Repair Package', 'inactive'),
(4, 'Advanced Maintenance', 7600.00, 6, 'Engine Diagnostic\r\nProducts Needed: Diagnostic Scanner\r\nOil Change\r\nProducts Needed: Engine Oil, Oil Filter\r\nBrake Replacement\r\nProducts Needed: Brake Pads, Brake Rotors\r\nSuspension Inspection\r\nProducts Needed: Suspension Components\r\nTire Replacement\r\nProducts Needed: New Tires\r\nRoad Ready Package', 'active'),
(5, 'hello world', 23.00, 5, 'asdasdas', 'active'),
(6, 'cat', 999.00, 3, 'sdasdasdas', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `package_products`
--

CREATE TABLE `package_products` (
  `package_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `package_products`
--

INSERT INTO `package_products` (`package_id`, `product_id`) VALUES
(5, 1),
(5, 2),
(6, 1),
(6, 2),
(6, 3);

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
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `category_id`, `product_name`, `description`, `price`, `quantity`, `image`) VALUES
(1, NULL, 'P Diddy Oil', 'For changing motorcycle oil', 250.00, 10, '../uploads/product_imagesoil.jpg'),
(2, NULL, 'Dog', 'aw aw', 456.00, 15, '../uploads/product_imagesdog.jpg'),
(3, NULL, 'bunny', 'buny', 9000.00, 10, '../uploads/product_imagesbunny.jpg'),
(4, 4, 'Water Jug', 'asdasdasdasdasd', 333.00, 151, '../uploads/product_imagesmew_profile.jpg'),
(6, 2, 'Oily', 'asdasdasdasdas', 23.00, 10, '../uploads/product_imagesoil.jpg'),
(7, 7, 'Water Jug', 'asdasdasdasas', 123.00, 233, '../uploads/product_imagesoil.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `schedule_id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `booking_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`schedule_id`, `employee_id`, `booking_id`) VALUES
(11, 3, 24),
(12, 3, 25),
(13, 3, 26),
(14, 3, 27);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `deposit_amount` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT 'Gcash',
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
-- Indexes for table `booking_images`
--
ALTER TABLE `booking_images`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `request_id` (`request_id`);

--
-- Indexes for table `booking_request`
--
ALTER TABLE `booking_request`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `fk_package` (`package_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

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
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`package_id`);

--
-- Indexes for table `package_products`
--
ALTER TABLE `package_products`
  ADD PRIMARY KEY (`package_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `transaction_id` (`transaction_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`schedule_id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `request_id` (`request_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `booking_images`
--
ALTER TABLE `booking_images`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `booking_request`
--
ALTER TABLE `booking_request`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `package_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking_images`
--
ALTER TABLE `booking_images`
  ADD CONSTRAINT `booking_images_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `booking_request` (`request_id`);

--
-- Constraints for table `booking_request`
--
ALTER TABLE `booking_request`
  ADD CONSTRAINT `booking_request_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`),
  ADD CONSTRAINT `fk_package` FOREIGN KEY (`package_id`) REFERENCES `packages` (`package_id`);

--
-- Constraints for table `package_products`
--
ALTER TABLE `package_products`
  ADD CONSTRAINT `package_products_ibfk_1` FOREIGN KEY (`package_id`) REFERENCES `packages` (`package_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `package_products_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`transaction_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `booking_request` (`request_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
