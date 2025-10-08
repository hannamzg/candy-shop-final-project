-- Products table for church website
-- This table stores product information including name, photo, price, and other details

CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `photo` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `stock_quantity` int(11) DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `weight` varchar(50) DEFAULT NULL,
  `dimensions` varchar(100) DEFAULT NULL,
  `material` varchar(100) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `tags` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `client_id` (`client_id`),
  KEY `category` (`category`),
  KEY `is_active` (`is_active`),
  KEY `featured` (`featured`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Product categories table for better organization
CREATE TABLE `product_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `client_id` (`client_id`),
  KEY `is_active` (`is_active`),
  CONSTRAINT `product_categories_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert some default categories for church products
INSERT INTO `product_categories` (`client_id`, `name`, `description`, `icon`, `sort_order`) VALUES
(1, 'Books & Bibles', 'Religious books, Bibles, and study materials', 'fas fa-book', 1),
(1, 'Jewelry & Accessories', 'Cross necklaces, bracelets, and religious jewelry', 'fas fa-gem', 2),
(1, 'Home Decor', 'Religious home decorations and wall art', 'fas fa-home', 3),
(1, 'Gifts & Souvenirs', 'Religious gifts and church souvenirs', 'fas fa-gift', 4),
(1, 'Clothing', 'Religious clothing and apparel', 'fas fa-tshirt', 5),
(1, 'Candles & Incense', 'Religious candles and incense', 'fas fa-fire', 6),
(1, 'Music & Media', 'Religious music CDs and DVDs', 'fas fa-music', 7),
(1, 'Children Items', 'Religious toys and items for children', 'fas fa-child', 8);

-- Sample products data
INSERT INTO `products` (`client_id`, `name`, `description`, `price`, `category`, `stock_quantity`, `featured`, `weight`, `material`, `color`, `tags`) VALUES
(1, 'Holy Bible - King James Version', 'Beautiful leather-bound King James Version Bible with gold-edged pages', 25.99, 'Books & Bibles', 50, 1, '2.5 lbs', 'Leather', 'Black', 'bible, holy, king james, leather'),
(1, 'Silver Cross Necklace', 'Elegant sterling silver cross pendant on a chain', 45.00, 'Jewelry & Accessories', 25, 1, '0.1 lbs', 'Sterling Silver', 'Silver', 'cross, necklace, silver, jewelry'),
(1, 'Prayer Candle Set', 'Set of 6 scented prayer candles in various colors', 12.99, 'Candles & Incense', 100, 0, '1.2 lbs', 'Wax', 'Multi-color', 'candles, prayer, scented, set'),
(1, 'Religious Wall Art', 'Beautiful framed religious artwork for home decoration', 35.50, 'Home Decor', 15, 1, '3.0 lbs', 'Wood, Glass', 'Multi-color', 'wall art, religious, framed, decoration'),
(1, 'Children Bible Stories Book', 'Illustrated Bible stories book for children', 18.99, 'Children Items', 30, 0, '1.0 lbs', 'Paper', 'Multi-color', 'children, bible stories, illustrated, book');
