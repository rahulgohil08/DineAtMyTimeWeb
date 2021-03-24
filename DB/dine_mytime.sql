-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2021 at 11:23 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dine_mytime`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_login`
--

CREATE TABLE `admin_login` (
  `admin_id` int(5) NOT NULL,
  `admin_name` varchar(50) NOT NULL,
  `admin_email` varchar(50) NOT NULL,
  `admin_password` varchar(15) NOT NULL,
  `admin_contact` bigint(10) NOT NULL,
  `admin_address` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin_login`
--

INSERT INTO `admin_login` (`admin_id`, `admin_name`, `admin_email`, `admin_password`, `admin_contact`, `admin_address`) VALUES
(1, 'Avani', 'avani@gmail.com', 'avani', 9106493275, 'Manjalpur, Vadodara'),
(2, 'Dhruv', 'dhruv@gmail.com', 'Dhruv', 7574949277, 'Petlad, Anand'),
(3, 'Sarvesh', 'admin', 'admin', 7405762589, 'Bharuch');

-- --------------------------------------------------------

--
-- Table structure for table `customer_registration`
--

CREATE TABLE `customer_registration` (
  `cust_id` int(5) NOT NULL,
  `cust_name` varchar(50) NOT NULL,
  `cust_email` varchar(30) NOT NULL,
  `cust_password` varchar(15) NOT NULL,
  `cust_contact` bigint(10) NOT NULL,
  `cust_address` longtext NOT NULL,
  `registration_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer_registration`
--

INSERT INTO `customer_registration` (`cust_id`, `cust_name`, `cust_email`, `cust_password`, `cust_contact`, `cust_address`, `registration_time`) VALUES
(1, 'Dhruv', 'dhruv@gmail.com', 'dhruv', 7574949277, 'nariyapada, petlad', '2020-12-17 04:10:01'),
(2, 'Avani', 'avani@gmail.com', 'avani', 7574949278, 'manjalpur', '2020-12-17 04:10:01'),
(9, 'rohit', 'rohit@gmail.com', 'cm9oaXQ=', 7864654684, 'fatehgaunj', '2020-12-18 04:54:12'),
(12, 'rohit4', 'rohit12@gmail.com', 'cm9oaXQ0MQ==', 7864654689, 'fatehgaunj', '2020-12-18 14:32:57'),
(13, 'rohit5', 'rohit123@gmail.com', 'cm9oaXQ0MTI=', 7864654690, 'fatehgaunj', '2020-12-31 06:21:40'),
(14, 'hello', 'hello@gmail.com', 'aGVsbG8=', 7576498545, 'anand', '2020-12-31 12:33:30'),
(15, 'hello1', 'hello1@gmail.com', 'aGVsbG8x', 7886487675, 'manjalpur', '2020-12-31 13:06:09'),
(16, 'hello3', 'hello3@gmail.com', 'aGVsbG8z', 7546598645, 'alkapuri', '2020-12-31 13:56:02'),
(17, 'b', 'b', 'Yg==', 1234567890, 'address', '2021-03-23 07:34:25');

-- --------------------------------------------------------

--
-- Table structure for table `manage_offers`
--

CREATE TABLE `manage_offers` (
  `offer_id` bigint(20) NOT NULL,
  `res_id` bigint(20) NOT NULL,
  `promo_code` varchar(10) NOT NULL,
  `min_purchase` int(11) NOT NULL DEFAULT 0,
  `discount_amount` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `manage_offers`
--

INSERT INTO `manage_offers` (`offer_id`, `res_id`, `promo_code`, `min_purchase`, `discount_amount`, `is_active`, `created_at`) VALUES
(2, 1, 'ABC', 5000, 10, 1, '2021-03-23 09:16:11'),
(3, 1, 'BBB', 1000, 300, 1, '2021-03-23 09:57:03');

-- --------------------------------------------------------

--
-- Table structure for table `manage_order`
--

CREATE TABLE `manage_order` (
  `Order_id` int(5) NOT NULL,
  `Customer_id` int(5) NOT NULL,
  `Res_T_id` int(5) DEFAULT NULL,
  `Res_id` int(5) NOT NULL,
  `Order_items` varchar(255) DEFAULT NULL,
  `Order_type` varchar(20) NOT NULL,
  `Order_status` int(2) NOT NULL,
  `Order_bill` int(20) DEFAULT NULL,
  `Payment_status` tinyint(2) DEFAULT NULL,
  `Booking_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `manage_order`
--

INSERT INTO `manage_order` (`Order_id`, `Customer_id`, `Res_T_id`, `Res_id`, `Order_items`, `Order_type`, `Order_status`, `Order_bill`, `Payment_status`, `Booking_time`) VALUES
(1, 10, 5, 12, 'paneer butter masala, paneer bhurji', 'online', 0, 360, 0, '2021-01-02 12:02:41');

-- --------------------------------------------------------

--
-- Table structure for table `manage_payment`
--

CREATE TABLE `manage_payment` (
  `Payment_id` int(5) NOT NULL,
  `Res_id` int(5) NOT NULL,
  `Customer_id` int(5) NOT NULL,
  `Payment_status` tinyint(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `menu_id` bigint(20) NOT NULL,
  `res_id` bigint(20) NOT NULL,
  `menu_name` varchar(30) NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`menu_id`, `res_id`, `menu_name`, `amount`) VALUES
(1, 1, 'Paneer - 3', 1000),
(2, 1, 'Pani Poori', 500),
(4, 1, 'Paw Bhaji', 450);

-- --------------------------------------------------------

--
-- Table structure for table `my_order`
--

CREATE TABLE `my_order` (
  `order_id` bigint(20) NOT NULL,
  `res_id` bigint(20) NOT NULL,
  `table_id` bigint(20) NOT NULL,
  `menu` text NOT NULL,
  `cust_id` bigint(20) NOT NULL,
  `amount` int(11) NOT NULL,
  `discount` int(11) NOT NULL DEFAULT 0,
  `is_expired` tinyint(1) NOT NULL DEFAULT 0,
  `booking_date_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `my_order`
--

INSERT INTO `my_order` (`order_id`, `res_id`, `table_id`, `menu`, `cust_id`, `amount`, `discount`, `is_expired`, `booking_date_time`, `created_at`) VALUES
(1, 2, 1, 'one, two', 1, 100, 0, 0, '2021-03-15 19:33:02', '2021-03-15 10:54:55'),
(8, 2, 1, 'Paneer - 3', 14, 1000, 0, 0, '2021-03-16 06:24:00', '2021-03-16 10:54:59'),
(9, 1, 1, 'one, two', 1, 100, 0, 0, '2021-03-17 10:30:00', '2021-03-17 10:06:26'),
(10, 3, 1, 'one, two', 1, 100, 0, 0, '2021-03-17 10:35:00', '2021-03-17 10:18:52'),
(11, 1, 1, 'one, two', 1, 100, 0, 0, '2021-03-17 10:50:00', '2021-03-17 10:18:54'),
(12, 1, 1, 'one, two', 1, 100, 0, 0, '2021-03-23 10:15:00', '2021-03-17 10:48:31'),
(14, 1, 2, 'Paneer - 3, Pani Poori', 17, 1500, 300, 0, '2021-03-24 08:49:00', '2021-03-23 10:25:48'),
(15, 1, 1, 'Paneer - 3, Paw Bhaji', 17, 1450, 300, 0, '2021-03-24 09:05:00', '2021-03-23 10:28:29'),
(16, 1, 2, 'one, two', 1, 100, 10, 0, '2021-03-24 09:16:19', '2021-03-23 10:50:19'),
(23, 1, 1, 'Paneer - 3, Pani Poori, Paw Bhaji', 17, 1950, 10, 0, '2021-03-24 07:00:00', '2021-03-24 10:08:10'),
(24, 1, 1, 'one, two', 1, 100, 10, 0, '2021-03-24 13:25:00', '2021-03-24 10:13:27');

-- --------------------------------------------------------

--
-- Table structure for table `my_table`
--

CREATE TABLE `my_table` (
  `table_id` bigint(20) NOT NULL,
  `res_id` bigint(20) NOT NULL,
  `table_no` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `my_table`
--

INSERT INTO `my_table` (`table_id`, `res_id`, `table_no`) VALUES
(1, 1, 1),
(2, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_registration`
--

CREATE TABLE `restaurant_registration` (
  `res_id` int(5) NOT NULL,
  `res_name` varchar(50) NOT NULL,
  `res_email` varchar(30) NOT NULL,
  `res_password` varchar(15) NOT NULL,
  `res_contact` bigint(10) NOT NULL,
  `res_address` longtext NOT NULL,
  `registration_status` tinyint(1) DEFAULT 0,
  `res_image` varchar(255) DEFAULT NULL,
  `seat_image` varchar(100) DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected') NOT NULL DEFAULT 'Pending',
  `registration_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `restaurant_registration`
--

INSERT INTO `restaurant_registration` (`res_id`, `res_name`, `res_email`, `res_password`, `res_contact`, `res_address`, `registration_status`, `res_image`, `seat_image`, `status`, `registration_time`) VALUES
(1, 'Hotel Atithi', 'rb', 'rb', 7864654690, 'Petlad', 0, 'image.jpg', '1_seat_map.jpg', 'Approved', '2021-01-02 11:23:37'),
(2, 'Hotel Saffron', 'saffron@gmail.com', 'c2FmZnJvbg==', 7864654691, 'Petlad', 0, 'image1.jpg', NULL, 'Approved', '2021-01-02 11:24:41'),
(3, 'ABC', 'ab2', 'rb2', 1234567890, 'ABC', 0, '95502ebb7eea5108dc43ed65970151a8.jpg', NULL, 'Approved', '2021-01-06 06:58:49'),
(6, 'N', 'n', 'n', 11, 'n', 0, 'f4d7517b4690240c7d53c301f1276142.jpg', NULL, 'Pending', '2021-03-23 07:52:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_login`
--
ALTER TABLE `admin_login`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `customer_registration`
--
ALTER TABLE `customer_registration`
  ADD PRIMARY KEY (`cust_id`);

--
-- Indexes for table `manage_offers`
--
ALTER TABLE `manage_offers`
  ADD PRIMARY KEY (`offer_id`);

--
-- Indexes for table `manage_order`
--
ALTER TABLE `manage_order`
  ADD PRIMARY KEY (`Order_id`);

--
-- Indexes for table `manage_payment`
--
ALTER TABLE `manage_payment`
  ADD PRIMARY KEY (`Payment_id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `my_order`
--
ALTER TABLE `my_order`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `my_table`
--
ALTER TABLE `my_table`
  ADD PRIMARY KEY (`table_id`);

--
-- Indexes for table `restaurant_registration`
--
ALTER TABLE `restaurant_registration`
  ADD PRIMARY KEY (`res_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_login`
--
ALTER TABLE `admin_login`
  MODIFY `admin_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customer_registration`
--
ALTER TABLE `customer_registration`
  MODIFY `cust_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `manage_offers`
--
ALTER TABLE `manage_offers`
  MODIFY `offer_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `manage_order`
--
ALTER TABLE `manage_order`
  MODIFY `Order_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `manage_payment`
--
ALTER TABLE `manage_payment`
  MODIFY `Payment_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `menu_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `my_order`
--
ALTER TABLE `my_order`
  MODIFY `order_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `my_table`
--
ALTER TABLE `my_table`
  MODIFY `table_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `restaurant_registration`
--
ALTER TABLE `restaurant_registration`
  MODIFY `res_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
