-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 12, 2026 at 03:32 PM
-- Server version: 8.2.0
-- PHP Version: 8.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myfactory_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `module` varchar(100) DEFAULT NULL,
  `action` varchar(100) DEFAULT NULL,
  `old_values` json DEFAULT NULL,
  `new_values` json DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `boms`
--

CREATE TABLE `boms` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `version` varchar(20) DEFAULT '1.0',
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `boms`
--

INSERT INTO `boms` (`id`, `product_id`, `name`, `version`, `status`, `created_at`) VALUES
(1, 5, 'Standard Assembly X100', '1.0', 'active', '2026-06-12 13:47:03');

-- --------------------------------------------------------

--
-- Table structure for table `bom_items`
--

CREATE TABLE `bom_items` (
  `id` int NOT NULL,
  `bom_id` int NOT NULL,
  `material_id` int NOT NULL,
  `quantity` decimal(15,4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bom_items`
--

INSERT INTO `bom_items` (`id`, `bom_id`, `material_id`, `quantity`) VALUES
(1, 1, 1, 2.5000),
(2, 1, 2, 0.5000),
(3, 1, 3, 1.0000),
(4, 1, 4, 0.2000);

-- --------------------------------------------------------

--
-- Table structure for table `factories`
--

CREATE TABLE `factories` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `contact_number` varchar(50) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `factories`
--

INSERT INTO `factories` (`id`, `name`, `location`, `contact_number`, `status`, `created_at`) VALUES
(1, 'Main Plant Alpha', 'Industrial Zone A, Sector 1', '+1-555-0101', 'active', '2026-06-12 13:47:03'),
(2, 'Assembly Plant Beta', 'Tech Park North', '+1-555-0102', 'active', '2026-06-12 13:47:03');

-- --------------------------------------------------------

--
-- Table structure for table `machines`
--

CREATE TABLE `machines` (
  `id` int NOT NULL,
  `factory_id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(50) DEFAULT NULL,
  `status` enum('operational','breakdown','under_maintenance') DEFAULT 'operational',
  `last_maintenance` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `machines`
--

INSERT INTO `machines` (`id`, `factory_id`, `name`, `code`, `status`, `last_maintenance`) VALUES
(1, 1, 'CNC Milling Machine A1', 'CNC-001', 'operational', NULL),
(2, 1, 'Plastic Injection Molder', 'PIM-001', 'operational', NULL),
(3, 2, 'Automated Assembly Line 1', 'AAL-001', 'under_maintenance', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `po_items`
--

CREATE TABLE `po_items` (
  `id` int NOT NULL,
  `po_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` decimal(15,2) NOT NULL,
  `unit_price` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `production_orders`
--

CREATE TABLE `production_orders` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `bom_id` int NOT NULL,
  `quantity` decimal(15,2) NOT NULL,
  `order_date` date NOT NULL,
  `status` enum('planned','in_progress','completed','cancelled') DEFAULT 'planned',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `sku` varchar(100) NOT NULL,
  `name` varchar(150) NOT NULL,
  `type` enum('raw_material','finished_good','semi_finished') NOT NULL,
  `reorder_level` decimal(15,2) DEFAULT '0.00',
  `price` decimal(15,2) DEFAULT '0.00',
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `sku`, `name`, `type`, `reorder_level`, `price`, `status`, `created_at`) VALUES
(1, 'RM-STEEL-001', 'Steel Sheets 5mm', 'raw_material', 0.00, 45.50, 'active', '2026-06-12 13:47:03'),
(2, 'RM-PLSTC-002', 'Polycarbonate Pellets', 'raw_material', 0.00, 12.00, 'active', '2026-06-12 13:47:03'),
(3, 'RM-ELEC-003', 'Microcontroller Unit V2', 'raw_material', 0.00, 5.50, 'active', '2026-06-12 13:47:03'),
(4, 'RM-WIRE-004', 'Copper Wiring 2mm', 'raw_material', 0.00, 2.20, 'active', '2026-06-12 13:47:03'),
(5, 'FG-WIDGET-X', 'Smart Widget X100', 'finished_good', 0.00, 299.99, 'active', '2026-06-12 13:47:03'),
(6, 'FG-WIDGET-PRO', 'Smart Widget Pro', 'finished_good', 0.00, 499.99, 'active', '2026-06-12 13:47:03');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_orders`
--

CREATE TABLE `purchase_orders` (
  `id` int NOT NULL,
  `supplier_id` int NOT NULL,
  `po_number` varchar(100) NOT NULL,
  `order_date` date NOT NULL,
  `total_amount` decimal(15,2) DEFAULT '0.00',
  `status` enum('pending','approved','received','cancelled') DEFAULT 'pending',
  `created_by` int NOT NULL,
  `approved_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `qc_records`
--

CREATE TABLE `qc_records` (
  `id` int NOT NULL,
  `reference_type` enum('po','production') NOT NULL,
  `reference_id` int NOT NULL,
  `inspector_id` int NOT NULL,
  `inspection_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` enum('passed','failed') NOT NULL,
  `remarks` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`) VALUES
(1, 'Super Admin', 'Full access to all modules'),
(2, 'User', 'Standard access');

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `id` int NOT NULL,
  `role_id` int NOT NULL,
  `module` varchar(100) NOT NULL,
  `can_create` tinyint(1) DEFAULT '0',
  `can_read` tinyint(1) DEFAULT '0',
  `can_update` tinyint(1) DEFAULT '0',
  `can_delete` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`id`, `role_id`, `module`, `can_create`, `can_read`, `can_update`, `can_delete`) VALUES
(1, 1, 'Master Data', 1, 1, 1, 1),
(2, 1, 'Inventory', 1, 1, 1, 1),
(3, 1, 'Procurement', 1, 1, 1, 1),
(4, 1, 'Production', 1, 1, 1, 1),
(5, 1, 'QC', 1, 1, 1, 1),
(6, 1, 'Maintenance', 1, 1, 1, 1),
(7, 1, 'Sales', 1, 1, 1, 1),
(8, 1, 'HR', 1, 1, 1, 1),
(9, 1, 'Reports', 1, 1, 1, 1),
(10, 1, 'Settings', 1, 1, 1, 1),
(11, 1, 'User Management', 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `id` int NOT NULL,
  `warehouse_id` int NOT NULL,
  `product_id` int NOT NULL,
  `batch_number` varchar(100) DEFAULT NULL,
  `quantity` decimal(15,2) DEFAULT '0.00',
  `expiry_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`id`, `warehouse_id`, `product_id`, `batch_number`, `quantity`, `expiry_date`) VALUES
(1, 1, 1, 'BATCH-S-01', 5000.00, NULL),
(2, 1, 2, 'BATCH-P-01', 12000.00, NULL),
(3, 1, 3, 'BATCH-E-01', 500.00, NULL),
(4, 2, 5, 'BATCH-W-01', 150.00, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `address` text,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `email`, `phone`, `address`, `status`, `created_at`) VALUES
(1, 'Global Metals Inc.', 'sales@globalmetals.com', '+1-800-METALS', '100 Foundry Road', 'active', '2026-06-12 13:47:03'),
(2, 'ElectroParts Supply', 'orders@electroparts.net', '+1-800-ELECTRO', '200 Silicon Valley', 'active', '2026-06-12 13:47:03'),
(3, 'Plastics Worldwide', 'contact@plasticsww.com', '+1-800-PLASTIC', '300 Polymer Ave', 'active', '2026-06-12 13:47:03');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'User',
  `role_id` int DEFAULT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `status` enum('active','inactive','locked') DEFAULT 'active',
  `last_login` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `role_id`, `username`, `email`, `password`, `full_name`, `status`, `last_login`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 1, 'admin', 'admin@myfactory.local', '$2y$10$70NVqFqcUMG2aynBOzj2pOuU0nzeX8G9ReWY9Vg4kzxsN0HbdpE7G', 'System Admin', 'active', NULL, '2026-06-12 13:47:02', '2026-06-12 14:17:52');

-- --------------------------------------------------------

--
-- Table structure for table `user_settings`
--

CREATE TABLE `user_settings` (
  `user_id` int NOT NULL,
  `font_family` varchar(50) DEFAULT 'Inter',
  `font_size` varchar(20) DEFAULT '14px',
  `primary_color` varchar(20) DEFAULT '#3b82f6',
  `secondary_color` varchar(20) DEFAULT '#1e293b',
  `sidebar_bg` varchar(20) DEFAULT '#ffffff',
  `header_bg` varchar(20) DEFAULT '#ffffff'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_settings`
--

INSERT INTO `user_settings` (`user_id`, `font_family`, `font_size`, `primary_color`, `secondary_color`, `sidebar_bg`, `header_bg`) VALUES
(1, 'Inter', '14px', '#3b82f6', '#1e293b', '#ffffff', '#ffffff');

-- --------------------------------------------------------

--
-- Table structure for table `warehouses`
--

CREATE TABLE `warehouses` (
  `id` int NOT NULL,
  `factory_id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `location` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `warehouses`
--

INSERT INTO `warehouses` (`id`, `factory_id`, `name`, `location`) VALUES
(1, 1, 'Raw Material Storage A', 'Plant Alpha - North Wing'),
(2, 1, 'Finished Goods Hub', 'Plant Alpha - South Wing');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `boms`
--
ALTER TABLE `boms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `bom_items`
--
ALTER TABLE `bom_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bom_id` (`bom_id`),
  ADD KEY `material_id` (`material_id`);

--
-- Indexes for table `factories`
--
ALTER TABLE `factories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `machines`
--
ALTER TABLE `machines`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `factory_id` (`factory_id`);

--
-- Indexes for table `po_items`
--
ALTER TABLE `po_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `po_id` (`po_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `production_orders`
--
ALTER TABLE `production_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `bom_id` (`bom_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sku` (`sku`);

--
-- Indexes for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `po_number` (`po_number`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `approved_by` (`approved_by`);

--
-- Indexes for table `qc_records`
--
ALTER TABLE `qc_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inspector_id` (`inspector_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_module` (`role_id`,`module`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`),
  ADD KEY `warehouse_id` (`warehouse_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `user_settings`
--
ALTER TABLE `user_settings`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `warehouses`
--
ALTER TABLE `warehouses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `factory_id` (`factory_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `boms`
--
ALTER TABLE `boms`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bom_items`
--
ALTER TABLE `bom_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `factories`
--
ALTER TABLE `factories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `machines`
--
ALTER TABLE `machines`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `po_items`
--
ALTER TABLE `po_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `production_orders`
--
ALTER TABLE `production_orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `qc_records`
--
ALTER TABLE `qc_records`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `warehouses`
--
ALTER TABLE `warehouses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `boms`
--
ALTER TABLE `boms`
  ADD CONSTRAINT `boms_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `bom_items`
--
ALTER TABLE `bom_items`
  ADD CONSTRAINT `bom_items_ibfk_1` FOREIGN KEY (`bom_id`) REFERENCES `boms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bom_items_ibfk_2` FOREIGN KEY (`material_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `machines`
--
ALTER TABLE `machines`
  ADD CONSTRAINT `machines_ibfk_1` FOREIGN KEY (`factory_id`) REFERENCES `factories` (`id`);

--
-- Constraints for table `po_items`
--
ALTER TABLE `po_items`
  ADD CONSTRAINT `po_items_ibfk_1` FOREIGN KEY (`po_id`) REFERENCES `purchase_orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `po_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `production_orders`
--
ALTER TABLE `production_orders`
  ADD CONSTRAINT `production_orders_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `production_orders_ibfk_2` FOREIGN KEY (`bom_id`) REFERENCES `boms` (`id`);

--
-- Constraints for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD CONSTRAINT `purchase_orders_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`),
  ADD CONSTRAINT `purchase_orders_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `purchase_orders_ibfk_3` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `qc_records`
--
ALTER TABLE `qc_records`
  ADD CONSTRAINT `qc_records_ibfk_1` FOREIGN KEY (`inspector_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `role_permissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`),
  ADD CONSTRAINT `stock_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `user_settings`
--
ALTER TABLE `user_settings`
  ADD CONSTRAINT `user_settings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `warehouses`
--
ALTER TABLE `warehouses`
  ADD CONSTRAINT `warehouses_ibfk_1` FOREIGN KEY (`factory_id`) REFERENCES `factories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
