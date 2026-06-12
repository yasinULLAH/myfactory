<?php

require_once __DIR__ . '/../app/Core/Database.php';
$dbConfig = require __DIR__ . '/../config/database.php';

try {
    // Connect to database (SQLite creates the file automatically)
    $db = new \App\Core\Database($dbConfig);
    $pdo = $db->pdo;

    // Run schema
    $sql = file_get_contents(__DIR__ . '/schema.sql');
    // SQLite might have issues with multiple statements in one exec() depending on driver, 
    // but usually PDO::exec() handles it or we can split.
    $pdo->exec($sql);
    echo "Schema executed successfully.\n";

    // Run seeders
    require_once __DIR__ . '/seeders/initial_seed.php';
    echo "Seeding completed successfully.\n";

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage() . "\n");
}
