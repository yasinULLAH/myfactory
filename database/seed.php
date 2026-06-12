<?php
require_once __DIR__ . '/../app/Core/Database.php';

use App\Core\Database;

try {
    $db = Database::getInstance()->getConnection();

    // 1. Seed Factories
    $db->exec("INSERT IGNORE INTO factories (id, name, location, contact_number) VALUES 
        (1, 'Main Plant Alpha', 'Industrial Zone A, Sector 1', '+1-555-0101'),
        (2, 'Assembly Plant Beta', 'Tech Park North', '+1-555-0102')");

    // 2. Seed Products (Raw Materials & Finished Goods)
    $db->exec("INSERT IGNORE INTO products (id, sku, name, type, price) VALUES 
        (1, 'RM-STEEL-001', 'Steel Sheets 5mm', 'raw_material', 45.50),
        (2, 'RM-PLSTC-002', 'Polycarbonate Pellets', 'raw_material', 12.00),
        (3, 'RM-ELEC-003', 'Microcontroller Unit V2', 'raw_material', 5.50),
        (4, 'RM-WIRE-004', 'Copper Wiring 2mm', 'raw_material', 2.20),
        (5, 'FG-WIDGET-X', 'Smart Widget X100', 'finished_good', 299.99),
        (6, 'FG-WIDGET-PRO', 'Smart Widget Pro', 'finished_good', 499.99)");

    // 3. Seed Suppliers
    $db->exec("INSERT IGNORE INTO suppliers (id, name, email, phone, address) VALUES 
        (1, 'Global Metals Inc.', 'sales@globalmetals.com', '+1-800-METALS', '100 Foundry Road'),
        (2, 'ElectroParts Supply', 'orders@electroparts.net', '+1-800-ELECTRO', '200 Silicon Valley'),
        (3, 'Plastics Worldwide', 'contact@plasticsww.com', '+1-800-PLASTIC', '300 Polymer Ave')");

    // 4. Seed Warehouses
    $db->exec("INSERT IGNORE INTO warehouses (id, factory_id, name, location) VALUES 
        (1, 1, 'Raw Material Storage A', 'Plant Alpha - North Wing'),
        (2, 1, 'Finished Goods Hub', 'Plant Alpha - South Wing')");

    // 5. Seed Initial Stock
    $db->exec("INSERT IGNORE INTO stock (warehouse_id, product_id, batch_number, quantity) VALUES 
        (1, 1, 'BATCH-S-01', 5000),
        (1, 2, 'BATCH-P-01', 12000),
        (1, 3, 'BATCH-E-01', 500),
        (2, 5, 'BATCH-W-01', 150)");

    // 6. Seed BOM (Smart Widget X100)
    $db->exec("INSERT IGNORE INTO boms (id, product_id, name) VALUES (1, 5, 'Standard Assembly X100')");
    $db->exec("INSERT IGNORE INTO bom_items (bom_id, material_id, quantity) VALUES 
        (1, 1, 2.5),
        (1, 2, 0.5),
        (1, 3, 1),
        (1, 4, 0.2)");

    // 7. Seed Machines
    $db->exec("INSERT IGNORE INTO machines (id, factory_id, name, code, status) VALUES 
        (1, 1, 'CNC Milling Machine A1', 'CNC-001', 'operational'),
        (2, 1, 'Plastic Injection Molder', 'PIM-001', 'operational'),
        (3, 2, 'Automated Assembly Line 1', 'AAL-001', 'under_maintenance')");

    echo "Seed data inserted successfully.\n";

} catch (PDOException $e) {
    die("Seeding failed: " . $e->getMessage() . "\n");
}
