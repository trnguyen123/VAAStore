-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 28, 2024 at 09:03 AM
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
-- Database: `vaa_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` varchar(255) NOT NULL,
  `category_name` varchar(255) DEFAULT NULL,
  `category_status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `category_status`) VALUES
('CAT00', 'TOPS', 'YES'),
('CAT01', 'BOTTOMS', 'YES'),
('CAT02', 'OUTWEAR', 'YES'),
('CAT03', 'ACCESSORIES', 'YES');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` varchar(255) NOT NULL,
  `comment_date` datetime DEFAULT NULL,
  `comment_content` varchar(255) DEFAULT NULL,
  `comment_reply` varchar(255) DEFAULT NULL,
  `customer_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` varchar(255) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` varchar(255) NOT NULL,
  `customer_id` varchar(255) DEFAULT NULL,
  `payment_id` varchar(255) DEFAULT NULL,
  `shipping_id` varchar(255) DEFAULT NULL,
  `order_note` varchar(255) DEFAULT NULL,
  `shipping_date` date DEFAULT NULL,
  `order_status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `order_id` varchar(255) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` varchar(255) NOT NULL,
  `payment_date` datetime DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_status` varchar(20) DEFAULT NULL,
  `transaction_id` varchar(100) DEFAULT NULL,
  `payment_gateway` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` varchar(255) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `product_description` varchar(255) DEFAULT NULL,
  `product_price` int(11) DEFAULT NULL,
  `product_img` varchar(255) DEFAULT NULL,
  `product_amount` int(11) DEFAULT NULL,
  `product_date` date DEFAULT NULL,
  `is_favorited` tinyint(1) DEFAULT NULL,
  `category_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_description`, `product_price`, `product_img`, `product_amount`, `product_date`, `is_favorited`, `category_id`) VALUES
('PRD00', 'Authentic Raglan Boxy 2.0 Tee', 'ÁO FORM BOXY 2.0 CÓ ĐỘ DÀI ĐƯỢC CẢI TIẾN TỪ FORM BOXY, DẠNG NHƯ CHIẾC HỘP VUÔNG, CHIỀU DÀI ÁO NGẮN HƠN THẮT LƯNG, DỄ PHỐI ĐỒ, GIÚP DÁNG NGƯỜI ĐƯỢC THON GỌN VÀ CAO RÁO. THIẾT KẾ ÁO TỐI GIẢN, PHÙ HỢP ĐỂ SỬ DỤNG HẰNG NGÀY', 380000, 'authentic_2.0_tee.jpg', 150, '2024-10-03', NULL, 'CAT00'),
('PRD01', 'Cargo ShortPants', 'Form shortpants dáng suông thẳng vừa, không quá ôm, không quá rộng mà vẫn đảm bảo mang đến sự thuận tiện và thoải mái cho hoạt động của người mặc một cách tốt nhất.', 410000, 'cargo_short_pants.jpg', 150, '2024-10-03', NULL, 'CAT01'),
('PRD02', 'Nylon Cargo Short', 'Form dáng thể hiện sự năng động và hiện đại. Với chất liệu dù, Nylon Cargo Short mang lại cảm giác nhẹ nhàng , thoáng mát cho người sử dụng', 410000, 'nylon_cargo_short.jpg', 150, '2024-10-03', NULL, 'CAT01'),
('PRD03', 'Classic Semi Oversized Polo', 'Form Semi Oversized được cải tiến và kết hợp từ form Oversized, Boxy. Với độ dài dưới thắt lưng và chiều rộng vừa phải, áo Polo Form Semi Oversized sẽ không quá rộng nhưng vẫn sẽ được giữ được sự thoải mái cho người mặc', 410000, 'classic_oversize_polo.jpg', 150, '2024-10-03', NULL, 'CAT00'),
('PRD04', 'Crocodile Hoodie', 'Form Hoodie Oversize có độ dài phù hợp, Form dáng rộng rãi tạo cảm giác thoải mái, thoáng mát khi mặc', 610000, 'crocodile_hoodie.jpg', 150, '2024-10-03', NULL, 'CAT02'),
('PRD05', 'Woman Denim Short Jeans', 'Form Women Short với phần lưng cao, độ dài trên gối tạo cảm giác trẻ trung, năng động, phù hợp nhiều outfits', 420000, 'women_short_jeans.jpg', 150, '2024-10-03', NULL, 'CAT01'),
('PRD06', 'Straight Washed Jeans', 'Form Straight với dáng suông vừa phải, không quá ôm tạo nên sự cân đối và thoải mái. Form quần phù hợp với nhiều kiểu dáng cơ thể và dễ dáng phối với nhiều quần áo khác nhau', 610000, 'straight_washed_jeans', 150, '2024-10-03', NULL, 'CAT01'),
('PRD07', 'Knit Beanie', 'Form mũ beanie cổ điển, thanh lịch, nhô cao, ôm gọn 2/3 đầu và không rộng vành. Được làm từ chất liệu len mềm cao cấp, ôm gọn phần đầu, không rộng vành mũ tạo cảm giác thon gọn và thanh lịch. Form beanie với thiết kế cổ điển cùng tag Levents chữ đen nền t', 350000, 'knit_beanie.jpg', 150, '2024-10-03', NULL, 'CAT03');

-- --------------------------------------------------------

--
-- Table structure for table `shipments`
--

CREATE TABLE `shipments` (
  `shipping_id` varchar(255) NOT NULL,
  `shipping_status` varchar(255) DEFAULT NULL,
  `shipping_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `payment_id` (`payment_id`),
  ADD KEY `shipping_id` (`shipping_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`order_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `shipments`
--
ALTER TABLE `shipments`
  ADD PRIMARY KEY (`shipping_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`payment_id`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`shipping_id`) REFERENCES `shipments` (`shipping_id`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
