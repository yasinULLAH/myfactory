<?php
$config = require __DIR__ . '/../config/database.php';

try {
    // Connect without dbname first to create it
    $dsn = "mysql:host=" . $config['host'] . ";charset=" . $config['charset'];
    $db = new PDO($dsn, $config['username'], $config['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $sql = file_get_contents(__DIR__ . '/schema.sql');
    $db->exec($sql);
    echo "Base schema executed successfully.\n";

} catch (PDOException $e) {
    die("Setup failed: " . $e->getMessage() . "\n");
}
