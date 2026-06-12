<?php
require_once __DIR__ . '/app/Core/Database.php';

$config = require __DIR__ . '/config/database.php';

try {
    // 1. Create Database
    $dsn = "mysql:host=" . $config['host'] . ";charset=" . $config['charset'];
    $pdo = new PDO($dsn, $config['username'], $config['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    
    $pdo->exec("DROP DATABASE IF EXISTS " . $config['database']);
    $pdo->exec("CREATE DATABASE " . $config['database']);
    echo "Database " . $config['database'] . " initialized fresh.\n";
    
    // 2. Run Schema
    $pdo->exec("USE " . $config['database']);
    $schema = file_get_contents(__DIR__ . '/database/schema.sql');
    $pdo->exec($schema);
    echo "Core schema imported successfully.\n";
    
    // 3. Run Advanced Schema
    if (file_exists(__DIR__ . '/database/update_schema.php')) {
        require_once __DIR__ . '/database/update_schema.php';
        echo "Advanced schema updated.\n";
    }
    
    // 4. Run Seeders
    if (file_exists(__DIR__ . '/database/seed.php')) {
        require_once __DIR__ . '/database/seed.php';
        echo "Seed data inserted.\n";
    }
    
    echo "\nSystem initialization complete!\n";
    echo "Login to: http://localhost/myfactory/\n";
    echo "Default Credentials:\n";
    echo "Username: admin\n";
    echo "Password: admin123\n";

} catch (PDOException $e) {
    die("Setup failed: " . $e->getMessage() . "\n");
}
