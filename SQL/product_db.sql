-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 17, 2024 at 05:50 PM
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
-- Database: `product_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `buyer_directory`
--

CREATE TABLE `buyer_directory` (
  `buyer_id` int(11) NOT NULL,
  `buyer_name` varchar(255) NOT NULL,
  `product_needed` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `budget` decimal(10,2) NOT NULL,
  `contact_info` varchar(255) DEFAULT NULL,
  `profile_image_path` varchar(255) DEFAULT 'img/default-profile.png',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buyer_directory`
--

INSERT INTO `buyer_directory` (`buyer_id`, `buyer_name`, `product_needed`, `location`, `category`, `budget`, `contact_info`, `profile_image_path`, `created_at`) VALUES
(1, 'Md. Hasan Ali', 'Fresh Vegetables', 'Dhaka', 'Vegetables', 5000.00, 'hasan.ali@gmail.com', 'img/profile1.jpg', '2024-12-17 10:28:47'),
(2, 'Linkan', 'Hilsa Fish', 'Khulna', 'Fish', 15000.00, 'linkan75@gmail.com', 'img/profile2.jpg', '2024-12-17 10:28:47'),
(3, 'Rajib Hossain', 'Basmati Rice', 'Rajshahi', 'Grains', 8000.00, 'rajib.hossain@gmail.com', 'img/profile3.jpg', '2024-12-17 10:28:47'),
(4, 'Joy', 'Seasonal Fruits', 'Chittagong', 'Fruits', 10000.00, 'joy89@gmail.com', 'img/profile4.jpg', '2024-12-17 10:28:47'),
(5, 'Nazmul Kabir', 'Cow Milk', 'Barishal', 'Dairy', 12000.00, 'nazmul.kabir@gmail.com', 'img/profile5.jpg', '2024-12-17 10:28:47'),
(6, 'Sumaiya Akter', 'Soybean Oil', 'Rangpur', 'Oil', 7000.00, 'sumaiya.akter@gmail.com', 'img/profile6.jpg', '2024-12-17 10:28:47'),
(7, 'Samiha', 'Broiler Chicken', 'Sylhet', 'Poultry', 9000.00, 'samiha76@gmail.com', 'img/profile7.jpg', '2024-12-17 10:28:47'),
(8, 'Rafi', 'Beef Meat', 'Dinajpur', 'Meat', 20000.00, 'rafi@gmail.com', 'img/profile8.jpg', '2024-12-17 10:28:47'),
(9, 'Rakibul Hasan', 'Spices', 'Mymensingh', 'Condiments', 6000.00, 'rakibul.hasan@example.com', 'img/profile9.jpg', '2024-12-17 10:28:47'),
(10, 'Farhana Yeasmin', 'Organic Honey', 'Dhaka', 'Condiments', 5000.00, 'farhana.yeasmin@example.com', 'img/profile10.jpg', '2024-12-17 10:28:47');

-- --------------------------------------------------------

--
-- Table structure for table `seller_directory`
--

CREATE TABLE `seller_directory` (
  `id` int(11) NOT NULL,
  `seller_name` varchar(100) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `category` varchar(50) NOT NULL,
  `location` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `contact_link` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seller_directory`
--

INSERT INTO `seller_directory` (`id`, `seller_name`, `product_name`, `category`, `location`, `price`, `image_path`, `contact_link`, `created_at`) VALUES
(1, 'Anwar Hossain', 'Potatoes', 'Vegetables', 'Rangpur', 30.00, 'img/potatoes.jpg', 'anwarhossain76@gmail.com', '2024-12-08 15:49:23'),
(2, 'Shafiqul Islam', 'Hilsha Fish', 'Fish', 'Barishal', 1200.00, 'img/hilsha.jpg', 'shafiqul72@gmail.com', '2024-12-08 15:49:23'),
(3, 'Rahima Begum', 'Tomatoes', 'Vegetables', 'Rajshahi', 45.00, 'img/tomatoes.jpg', 'rahima45@gmail.com', '2024-12-08 15:49:23'),
(4, 'Abdul Kader', 'Paddy', 'Grains', 'Mymensingh', 20.00, 'img/paddy.jpg', 'abdulkader54@gmail.com', '2024-12-08 15:49:23'),
(5, 'Jamal Uddin', 'Bananas', 'Fruits', 'Chittagong', 10.00, 'img/bananas.jpg', 'jamaluddin79@gmail.com', '2024-12-08 15:49:23'),
(6, 'Nurjahan Akter', 'Milk', 'Dairy', 'Sylhet', 60.00, 'img/milk.jpg', 'nurjahan98@gmail.com', '2024-12-08 15:49:23'),
(7, 'Kamal Hossain', 'Wheat', 'Grains', 'Dinajpur', 25.00, 'img/wheat.jpg', 'kamal87@gmail.com', '2024-12-08 15:49:23'),
(8, 'Fatema Khatun', 'Mustard Oil', 'Oil', 'Khulna', 250.00, 'img/mustard_oil.jpg', 'fatema20@gmail.com', '2024-12-08 15:49:23'),
(9, 'Sharmin Aktar', 'Mangoes', 'Fruits', 'Rajshahi', 120.00, 'img/mangoes.jpg', 'sharmin709@gmail.com', '2024-12-08 15:49:23'),
(10, 'Hasan Mahmud', 'Chickens', 'Poultry', 'Dhaka', 160.00, 'img/chickens.jpg', 'hasanmahmud@gmail.com', '2024-12-08 15:49:23'),
(11, 'Mahmudul Hasan', 'Apples', 'Fruits', 'Sylhet', 150.00, 'img/apples.jpg', 'mahmudul457@gmail.com', '2024-12-09 16:21:26'),
(12, 'Rokeya Sultana', 'Eggs', 'Poultry', 'Chittagong', 8.00, 'img/eggs.jpg', 'rokeyasultana@gmail.com', '2024-12-09 16:21:26'),
(13, 'Fazlur Rahman', 'Cauliflower', 'Vegetables', 'Comilla', 35.00, 'img/cauliflower.jpg', 'fazlurrahman46@gmail.com', '2024-12-09 16:21:26'),
(14, 'Minara Begum', 'Beef', 'Meat', 'Dhaka', 700.00, 'img/beef.jpg', 'minarabegum8@gmail.com', '2024-12-09 16:21:26'),
(15, 'Al Amin', 'Rice', 'Grains', 'Dhaka', 50.00, 'img/rice.jpg', 'alamin@gmail.com', '2024-12-09 16:21:26'),
(16, 'Salma Akter', 'Pineapples', 'Fruits', 'Mymensingh', 60.00, 'img/pineapples.jpg', 'salmaakther34@gmail.com', '2024-12-09 16:21:26'),
(17, 'Arman Hossain', 'Carrots', 'Vegetables', 'Rangpur', 40.00, 'img/carrots.jpg', 'armanh41@gmail.com', '2024-12-09 16:21:26'),
(18, 'Nurul Islam', 'Honey', 'Condiments', 'Dhaka', 400.00, 'img/honey.jpg', 'nurulislam@gmail.com', '2024-12-09 16:21:26'),
(19, 'Nasima Akter', 'Tilapia Fish', 'Fish', 'Barishal', 180.00, 'img/tilapia.jpg', 'nasimaakther54@gmail.com', '2024-12-09 16:21:26'),
(20, 'Jannatul Ferdous', 'Coconuts', 'Fruits', 'Khulna', 50.00, 'img/coconuts.jpg', 'jannatulferdous76@gmail.com', '2024-12-09 16:21:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buyer_directory`
--
ALTER TABLE `buyer_directory`
  ADD PRIMARY KEY (`buyer_id`);

--
-- Indexes for table `seller_directory`
--
ALTER TABLE `seller_directory`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buyer_directory`
--
ALTER TABLE `buyer_directory`
  MODIFY `buyer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `seller_directory`
--
ALTER TABLE `seller_directory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
