-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 07, 2018 at 12:32 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aditya_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `brand` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `brand`) VALUES
(1, 'Levis'),
(2, 'Nike'),
(3, 'Polo');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `items` text COLLATE utf8_unicode_ci NOT NULL,
  `expire_date` datetime NOT NULL,
  `paid` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `items`, `expire_date`, `paid`) VALUES
(35, '[{"id":"2","size":"small","quantity":"3"},{"id":"2","size":"large","quantity":"2"}]', '2018-03-24 10:04:07', 0);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`, `parent`) VALUES
(1, 'Men', 0),
(2, 'Women', 0),
(3, 'Boys', 0),
(4, 'Girls', 0),
(5, 'Shirts', 1),
(6, 'Pants', 1),
(7, 'Shoes', 1),
(8, 'Accessories', 1),
(9, 'Shirts', 2),
(10, 'Pants', 2),
(11, 'Shoes', 2),
(12, 'Dresses', 2),
(13, 'Shirts', 3),
(14, 'Pants', 3),
(15, 'Dresses', 4),
(16, 'Shoes', 4),
(17, 'Skirts', 2),
(18, 'Accessories', 2),
(19, 'Hoodies', 3),
(20, 'Bra', 2);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `list_price` decimal(10,2) NOT NULL,
  `brand` int(11) NOT NULL,
  `categories` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `featured` tinyint(4) NOT NULL,
  `sizes` text COLLATE utf8_unicode_ci NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `price`, `list_price`, `brand`, `categories`, `image`, `description`, `featured`, `sizes`, `deleted`) VALUES
(1, 'Levi&#039;s Jeans', '39.99', '59.99', 1, '6', '/E-commerce/images/products/d368c8fc6b623359bd3773f3132dfac0.png', 'These jeans are amazing! They are straight leg, fit great and look awesome. Get a pair while they last!', 1, '28:3,32:5,36:1', 0),
(2, 'Beautiful Shirt', '9.99', '19.99', 1, '5', '	\r\n/E-commerce/images/products/men1.png', 'what a beautiful shirt... blah blah blah. Please buy me. We spent too much on our site and we are broken', 1, 'small:3,medium:6,large:9', 0),
(3, 'High Heels', '59.99', '89.99', 2, '11', '/E-commerce/images/products/2b47845f8da674e486ad41b9a3ac392a.jpg', 'Steve Madden Irenee Ankle Strap Sandal (Women)', 1, '28:11,30:9,32:7,36:14', 0),
(4, 'Long Skirt', '55.99', '99.99', 3, '17', '/E-commerce/images/products/760d9b08c480cde8b3806d4875b44eac.png', 'Adding a godet to a piece of clothing also gives the wearer a wider range of motion.', 1, 'Small:12,Medium:6,Large:15,Extra Larage:34', 0),
(5, 'Shift Dresses', '39.99', '69.99', 1, '15', '/E-commerce/images/products/ea6ce25e4634fe42a4f7bb14d6885605.png', 'The hemline of an asymmetric dress doesn&rsquo;t have a regular pattern. This can be a flowy flare or a bodycon.\r\nOff Shoulder Dresses', 1, 'Small:11,Meduim:7,Large:14,Extra Large:10', 0),
(6, 'Dressing Gowns', '59.99', '79.99', 3, '12', '/E-commerce/images/products/49483720711f63f71da75cdda5974358.png', 'western dress designs are from latest fashion trends \r\n- pick a new style every day.', 1, 'Small:8,Medium:10,Large:9,Extra Large:12', 0),
(7, 'Louis Vuitton', '29.99', '49.99', 3, '18', '/E-commerce/images/products/68953c339dff97da91a4a2e56adbd020.png', 'Louis Vuitton In absolutely amazing condition Only 18 months old 100% authentic Made in Spain', 1, 'Small:13,Medium:26', 0),
(8, 'Logo Hoodies', '19.99', '39.99', 1, '19', '/E-commerce/images/products/66152e39bc17c27fff69993dd761d0a3.png', 'Personalised Childs Hoodie Custom Printed Kids Hoody Childrens Hooded Jumper', 1, 'Small:16,Medium:26', 0);

-- --------------------------------------------------------

--
-- Table structure for table `transations`
--

CREATE TABLE `transations` (
  `id` int(11) NOT NULL,
  `charge_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cart_id` int(11) NOT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(175) COLLATE utf8_unicode_ci NOT NULL,
  `street` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `street2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(175) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(175) COLLATE utf8_unicode_ci NOT NULL,
  `zip_code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(175) COLLATE utf8_unicode_ci NOT NULL,
  `sub_total` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL,
  `grand_total` decimal(10,2) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `txn_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `txn_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(175) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `join_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` datetime NOT NULL,
  `permission` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `join_date`, `last_login`, `permission`) VALUES
(1, 'Ajay Kumar Yadav', 'ajau43@gmail.com', '$2y$10$5i/oCZWYlDLHPHWCOIOyqORbRTIH7lFydLpfX20FbBM3PYhBOlppa', '2018-02-13 23:48:24', '2018-02-28 11:24:08', 'admin,editor'),
(3, 'test abc 1', 'test@gmail.com', '$2y$10$dGyTw4X5Gogj5wjEy0Q9P.iA.PmVBwsviB6hmky/tgzU7OMQOwur.', '2018-02-15 20:19:50', '2018-02-15 20:27:24', 'editor'),
(4, 'Test Shop Keeper ', 'shop@gmail.com', '$2y$10$WadBT.nEzPeOL4d01r8PDe82qHSBmCXYhzfaNagEC3xPmMwlXl142', '2018-02-15 20:43:46', '2018-02-15 20:43:46', 'editor'),
(6, 'A B C', 'abc@gmail.com', '$2y$10$8UFZ.PHqsSqxn8850uPfz.0NmKK.eDsGy4FGeN9eLY1dPxgfZuaIq', '2018-02-15 20:51:44', '2018-02-15 21:00:24', 'editor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transations`
--
ALTER TABLE `transations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `transations`
--
ALTER TABLE `transations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
