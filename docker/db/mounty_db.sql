-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 14, 2019 at 05:04 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mounty_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `pass`) VALUES
(1, 'a', 'a');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) NOT NULL,
  `pid` int(10) NOT NULL,
  `qty` int(10) NOT NULL,
  `cart_amt` decimal(10,2) NOT NULL,
  `ouser` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `addr1` varchar(255) NOT NULL,
  `addr2` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `pincode` int(10) NOT NULL,
  `discount` decimal(8,2) NOT NULL,
  `order_status` enum('Recieved','Processing','Dispatched','Cancelled','Delievered') NOT NULL DEFAULT 'Recieved',
  `read_s` enum('yes','no') NOT NULL DEFAULT 'no',
  `ord_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `pid`, `qty`, `cart_amt`, `ouser`, `email`, `mobile`, `addr1`, `addr2`, `city`, `state`, `pincode`, `discount`, `order_status`, `read_s`, `ord_date`, `update_date`) VALUES
(1, 7, 1, '650.00', 'Divesh Agarwal', 'devagarwal179@gmail.com', '9636611386', '16/218, Shyam Villa, CHB', '', 'Jodhpur', 'Rajasthan', 342008, '0.00', 'Dispatched', 'no', '2019-03-14 14:14:07', '2019-03-14 14:14:07'),
(2, 4, 1, '450.00', 'Divesh Agarwal', 'devagarwal179@gmail.com', '9636611386', '16/218, Shyam Villa, CHB', '', 'Jodhpur', 'Rajasthan', 342008, '0.00', 'Recieved', 'no', '2019-03-14 14:47:51', '2019-03-14 14:47:51'),
(3, 6, 5, '2000.00', 'Divesh Agarwal', 'devagarwal179@gmail.com', '9636611386', '16/218, Shyam Villa, CHB', '', 'Jodhpur', 'Rajasthan', 342008, '0.00', 'Recieved', 'no', '2019-03-14 14:48:18', '2019-03-14 14:48:18');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `pid` int(10) NOT NULL,
  `ptitle` varchar(255) NOT NULL,
  `pdesc` text NOT NULL,
  `pcost` decimal(9,2) NOT NULL,
  `psell` decimal(9,2) NOT NULL,
  `pimg` text NOT NULL,
  `visibility` enum('visible','hidden') NOT NULL DEFAULT 'visible',
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`pid`, `ptitle`, `pdesc`, `pcost`, `psell`, `pimg`, `visibility`, `date_added`) VALUES
(1, 'formal shirt', 'this is the description for formal shirt', '500.00', '400.00', '5c8981ec7cd04.jpg,5c8981ec7d0c5.jpg,5c8981ec7d3b8.jpg,5c8981ec7d687.jpg', 'visible', '2019-03-13 22:19:24'),
(2, 'kurta payjama for men', 'this is the description section any text related description can come into this section.', '1200.00', '1000.00', '5c898790d9613.jpg,5c898790d97ff.jpg,5c898790d9998.jpg', 'visible', '2019-03-13 22:43:28'),
(3, 'dress', 'Get a confident, bohemian look with this Heathers linen mini dress from Zimmermann. The piece was designed by the brand\'s two Australian sisters and features a light floral print embellished with a narrow ribbon. Long puffed sleeves, a cinched waist, ruffles, and a deep V-neck give this model a vintage, romantic charm. Pair the dress with wooden high heels for a sophisticated, gypset outfit.', '1500.00', '1400.00', '5c8988cb7c11d.jpg,5c8988cb7c2cb.jpg,5c8988cb7c3e7.jpg,5c8988cb7c559.jpg,5c8988cb7c65f.jpg', 'visible', '2019-03-13 22:48:43'),
(4, 'couple t-shirts', 'these are the couple t-shirts in white color.', '600.00', '450.00', '5c89891c3c27f.jpg,5c89891c3c51d.jpg,5c89891c3cdd9.jpg', 'visible', '2019-03-13 22:50:04'),
(5, 'jeans', 'brown colored jeans', '800.00', '700.00', '5c898a588bbde.jpg,5c898a588bd21.jpg,5c898a588beaf.jpg,5c898a588bfa1.jpg,5c898a588c0fa.jpg,5c898a588c205.jpg,5c898a588c3af.jpg,5c898a588c80c.jpg,5c898a588cbcf.jpg,5c898a588cdfa.jpg,5c898a588cf79.jpg', 'visible', '2019-03-13 22:55:20'),
(6, 'Blue shirt', 'This is a blue shirt', '500.00', '400.00', '5c8a229ac081e.jpg,5c8a229ac0b40.jpg,5c8a229ac0d8d.jpg,5c8a229ac0fcb.jpg', 'visible', '2019-03-14 09:44:58'),
(7, 'Black Hoodie', 'description of the black hoodie.', '800.00', '650.00', '5c8a22d04313c.jpg,5c8a22d04384d.jpg,5c8a22d043c81.jpg,5c8a22d043fef.jpg,5c8a22d044397.jpg', 'visible', '2019-03-14 09:45:52'),
(8, 'product ', 'this is a description for the product for male.', '900.00', '700.00', '5c8a2306dc2cd.jpg,5c8a2306dc437.jpg', 'visible', '2019-03-14 09:46:46'),
(9, 'checked shirt', 'black and gray checked shirts.', '700.00', '500.00', '5c8a23588f22b.jpg,5c8a23588f3ab.jpg,5c8a23588f4b3.jpg,5c8a23588f5b2.jpg,5c8a23588f6ac.jpg,5c8a23588f7a2.jpg', 'visible', '2019-03-14 09:48:08'),
(10, 'frock', 'this is a frock for the little girls in blue colour.', '1200.00', '1100.00', '5c8a2416ec052.jpg,5c8a2416ec20e.jpg', 'visible', '2019-03-14 09:51:18'),
(11, 'payjamas', 'a pack of multiple payjamas', '1500.00', '1000.00', '5c8a2467bd42e.jpg,5c8a2467bd5be.jpg,5c8a2467bd70b.jpg', 'visible', '2019-03-14 09:52:39'),
(12, 'shirts', 'a set of 5 shirts', '700.00', '500.00', '5c8a249724f33.jpg', 'visible', '2019-03-14 09:53:27'),
(13, 'cardigan', 'cardigan in skin color for women', '2000.00', '1900.00', '5c8a24be84bde.jpg', 'visible', '2019-03-14 09:54:06'),
(14, 'girl t-shirt', 'green t-shirt for girls', '250.00', '250.00', '5c8a2528630be.jpg', 'visible', '2019-03-14 09:55:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`pid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `pid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
