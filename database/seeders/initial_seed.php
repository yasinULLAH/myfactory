<?php

// Seed Roles
$roles = [
    ['Super Admin', 'Full system access'],
    ['Production Manager', 'Manage production orders and BOM'],
    ['Inventory Manager', 'Manage stock and warehouses'],
    ['QC Manager', 'Manage quality inspections']
];

foreach ($roles as $role) {
    $stmt = $pdo->prepare("INSERT OR IGNORE INTO roles (name, description) VALUES (?, ?)");
    $stmt->execute($role);
}

// Seed Users (password is 'admin123!')
$password = password_hash('admin123!', PASSWORD_BCRYPT);
$stmt = $pdo->prepare("INSERT OR IGNORE INTO users (role_id, username, email, password, full_name, status) VALUES (1, 'admin', 'admin@factory.com', ?, 'System Administrator', 'active')");
$stmt->execute([$password]);

// Seed User Settings for admin
$stmt = $pdo->prepare("INSERT OR IGNORE INTO user_settings (user_id) VALUES (1)");
$stmt->execute();

// Seed Master Data - Factories
$factories = [
    ['Main Assembly Plant', 'Industrial Zone A, NY', '123-456-7890'],
    ['Fabrication Unit', 'Industrial Zone B, NJ', '123-456-7891'],
    ['Packaging Facility', 'Warehouse District, CT', '123-456-7892'],
    ['R&D Lab', 'Innovation Park, MA', '123-456-7893']
];
foreach ($factories as $f) {
    $stmt = $pdo->prepare("INSERT OR IGNORE INTO factories (name, location, contact_number) VALUES (?, ?, ?)");
    $stmt->execute($f);
}

// Seed Units
$units = [['Kilogram', 'kg'], ['Liter', 'L'], ['Piece', 'pcs'], ['Meter', 'm']];
foreach ($units as $u) {
    $stmt = $pdo->prepare("INSERT OR IGNORE INTO units (name, short_name) VALUES (?, ?)");
    $stmt->execute($u);
}

// Seed Product Categories
$cats = [['Raw Materials', 'Base components'], ['Electronics', 'Electronic parts'], ['Packaging', 'Box and wraps'], ['Finished Goods', 'Ready for sale']];
foreach ($cats as $c) {
    $stmt = $pdo->prepare("INSERT OR IGNORE INTO product_categories (name, description) VALUES (?, ?)");
    $stmt->execute($c);
}

// Seed Products
$products = [
    [1, 1, 'RM-STEEL-001', 'High Grade Steel', 'raw_material', 100, 50.00],
    [1, 3, 'RM-PLASTIC-001', 'Polymer Pellets', 'raw_material', 500, 12.50],
    [4, 3, 'FG-WIDGET-001', 'Super Widget X1', 'finished_good', 20, 299.99],
    [2, 3, 'COMP-CHIP-001', 'Microcontroller A4', 'raw_material', 1000, 5.75]
];
foreach ($products as $p) {
    $stmt = $pdo->prepare("INSERT OR IGNORE INTO products (category_id, unit_id, sku, name, type, reorder_level, price) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute($p);
}

// Seed Suppliers
$suppliers = [
    ['Steel Co Inc', 'sales@steelco.com', '555-0101', '123 Iron St'],
    ['Global Polymers', 'info@globalpoly.com', '555-0102', '456 Plastic Ave'],
    ['Tech Components', 'order@techcomp.com', '555-0103', '789 Silicon Rd'],
    ['Reliable Packaging', 'contact@relpack.com', '555-0104', '321 Box Lane']
];
foreach ($suppliers as $s) {
    $stmt = $pdo->prepare("INSERT OR IGNORE INTO suppliers (name, email, phone, address) VALUES (?, ?, ?, ?)");
    $stmt->execute($s);
}

// Seed Warehouses
$stmt = $pdo->prepare("INSERT OR IGNORE INTO warehouses (factory_id, name, location) VALUES (1, 'Main Warehouse', 'Aisle 1-10')");
$stmt->execute();

// Seed Stock
$stmt = $pdo->prepare("INSERT OR IGNORE INTO stock (warehouse_id, product_id, batch_number, quantity) VALUES (1, 1, 'BATCH-001', 1500.00)");
$stmt->execute();

// Seed BOMs
$stmt = $pdo->prepare("INSERT OR IGNORE INTO boms (product_id, name) VALUES (3, 'Standard Widget X1 BOM')");
$stmt->execute();
