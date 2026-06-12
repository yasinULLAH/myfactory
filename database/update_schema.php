<?php
require_once __DIR__ . '/../app/Core/Database.php';

use App\Core\Database;

try {
    $db = Database::getInstance()->getConnection();

    $queries = [
        "CREATE TABLE IF NOT EXISTS boms (
            id INT AUTO_INCREMENT PRIMARY KEY,
            product_id INT NOT NULL,
            name VARCHAR(150),
            version VARCHAR(20) DEFAULT '1.0',
            status ENUM('active', 'inactive') DEFAULT 'active',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (product_id) REFERENCES products(id)
        )",
        "CREATE TABLE IF NOT EXISTS bom_items (
            id INT AUTO_INCREMENT PRIMARY KEY,
            bom_id INT NOT NULL,
            material_id INT NOT NULL,
            quantity DECIMAL(15,4) NOT NULL,
            FOREIGN KEY (bom_id) REFERENCES boms(id) ON DELETE CASCADE,
            FOREIGN KEY (material_id) REFERENCES products(id)
        )",
        "CREATE TABLE IF NOT EXISTS production_orders (
            id INT AUTO_INCREMENT PRIMARY KEY,
            product_id INT NOT NULL,
            bom_id INT NOT NULL,
            quantity DECIMAL(15,2) NOT NULL,
            order_date DATE NOT NULL,
            status ENUM('planned', 'in_progress', 'completed', 'cancelled') DEFAULT 'planned',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (product_id) REFERENCES products(id),
            FOREIGN KEY (bom_id) REFERENCES boms(id)
        )",
        "CREATE TABLE IF NOT EXISTS qc_records (
            id INT AUTO_INCREMENT PRIMARY KEY,
            reference_type ENUM('po', 'production') NOT NULL,
            reference_id INT NOT NULL,
            inspector_id INT NOT NULL,
            inspection_date DATETIME DEFAULT CURRENT_TIMESTAMP,
            status ENUM('passed', 'failed') NOT NULL,
            remarks TEXT,
            FOREIGN KEY (inspector_id) REFERENCES users(id)
        )"
    ];

    foreach ($queries as $query) {
        $db->exec($query);
        echo "Executed query successfully.\n";
    }

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage() . "\n");
}
