<?php
$db = require __DIR__ . '/config/database.php';
$pdo = new PDO("mysql:host={$db['host']};dbname={$db['database']}", $db['username'], $db['password']);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS roles (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL UNIQUE,
        description TEXT
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS role_permissions (
        id INT AUTO_INCREMENT PRIMARY KEY,
        role_id INT NOT NULL,
        module VARCHAR(100) NOT NULL,
        can_create BOOLEAN DEFAULT FALSE,
        can_read BOOLEAN DEFAULT FALSE,
        can_update BOOLEAN DEFAULT FALSE,
        can_delete BOOLEAN DEFAULT FALSE,
        FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
        UNIQUE KEY role_module (role_id, module)
    )");

    // Add role_id to users if not exists
    $stmt = $pdo->query("SHOW COLUMNS FROM users LIKE 'role_id'");
    if ($stmt->rowCount() == 0) {
        $pdo->exec("ALTER TABLE users ADD COLUMN role_id INT NULL AFTER role");
        $pdo->exec("ALTER TABLE users ADD FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE SET NULL");
    }

    // Insert Super Admin and User roles
    $pdo->exec("INSERT IGNORE INTO roles (id, name, description) VALUES (1, 'Super Admin', 'Full access to all modules')");
    $pdo->exec("INSERT IGNORE INTO roles (id, name, description) VALUES (2, 'User', 'Standard access')");

    // Give Super Admin full permissions to all current modules
    $modules = ['Master Data', 'Inventory', 'Procurement', 'Production', 'QC', 'Maintenance', 'Sales', 'HR', 'Reports', 'Settings', 'User Management'];
    $stmt = $pdo->prepare("INSERT IGNORE INTO role_permissions (role_id, module, can_create, can_read, can_update, can_delete) VALUES (1, ?, 1, 1, 1, 1)");
    foreach ($modules as $module) {
        $stmt->execute([$module]);
    }

    // Update existing admin user to be Super Admin
    $pdo->exec("UPDATE users SET role_id = 1 WHERE username = 'admin'");
    
    echo "Migration successful.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
