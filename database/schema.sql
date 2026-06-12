-- File: /database/schema.sql
CREATE DATABASE IF NOT EXISTS myfactory_db;
USE myfactory_db;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role VARCHAR(50) NOT NULL DEFAULT 'User',
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(150) NOT NULL,
    status ENUM('active', 'inactive', 'locked') DEFAULT 'active',
    last_login DATETIME NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS user_settings (
    user_id INT PRIMARY KEY,
    font_family VARCHAR(50) DEFAULT 'Inter',
    font_size VARCHAR(20) DEFAULT '14px',
    primary_color VARCHAR(20) DEFAULT '#3b82f6',
    secondary_color VARCHAR(20) DEFAULT '#1e293b',
    sidebar_bg VARCHAR(20) DEFAULT '#ffffff',
    header_bg VARCHAR(20) DEFAULT '#ffffff',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS factories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    location VARCHAR(255),
    contact_number VARCHAR(50),
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sku VARCHAR(100) NOT NULL UNIQUE,
    name VARCHAR(150) NOT NULL,
    type ENUM('raw_material', 'finished_good', 'semi_finished') NOT NULL,
    reorder_level DECIMAL(15,2) DEFAULT 0,
    price DECIMAL(15,2) DEFAULT 0,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS suppliers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(100),
    phone VARCHAR(50),
    address TEXT,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS warehouses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    factory_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    location VARCHAR(255),
    FOREIGN KEY (factory_id) REFERENCES factories(id)
);

CREATE TABLE IF NOT EXISTS stock (
    id INT AUTO_INCREMENT PRIMARY KEY,
    warehouse_id INT NOT NULL,
    product_id INT NOT NULL,
    batch_number VARCHAR(100),
    quantity DECIMAL(15,2) DEFAULT 0,
    expiry_date DATE NULL,
    FOREIGN KEY (warehouse_id) REFERENCES warehouses(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

CREATE TABLE IF NOT EXISTS purchase_orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    supplier_id INT NOT NULL,
    po_number VARCHAR(100) NOT NULL UNIQUE,
    order_date DATE NOT NULL,
    total_amount DECIMAL(15,2) DEFAULT 0,
    status ENUM('pending', 'approved', 'received', 'cancelled') DEFAULT 'pending',
    created_by INT NOT NULL,
    approved_by INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (supplier_id) REFERENCES suppliers(id),
    FOREIGN KEY (created_by) REFERENCES users(id),
    FOREIGN KEY (approved_by) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS po_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    po_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity DECIMAL(15,2) NOT NULL,
    unit_price DECIMAL(15,2) NOT NULL,
    FOREIGN KEY (po_id) REFERENCES purchase_orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id)
);

CREATE TABLE IF NOT EXISTS machines (
    id INT AUTO_INCREMENT PRIMARY KEY,
    factory_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    code VARCHAR(50) UNIQUE,
    status ENUM('operational', 'breakdown', 'under_maintenance') DEFAULT 'operational',
    last_maintenance DATE,
    FOREIGN KEY (factory_id) REFERENCES factories(id)
);

CREATE TABLE IF NOT EXISTS audit_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    module VARCHAR(100),
    action VARCHAR(100),
    old_values JSON,
    new_values JSON,
    ip_address VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- admin / admin123
INSERT INTO users (role, username, email, password, full_name) VALUES 
('Admin', 'admin', 'admin@myfactory.local', '$2y$10$70NVqFqcUMG2aynBOzj2pOuU0nzeX8G9ReWY9Vg4kzxsN0HbdpE7G', 'System Admin');
INSERT INTO user_settings (user_id) VALUES (1);
