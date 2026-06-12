<?php
namespace App\Core;
use PDO;
use PDOException;

class Database {
    private static $instance = null;
    private $connection;
    
    private function __construct() {
        $config = require __DIR__ . '/../../config/database.php';
        $dsn = "mysql:host=" . $config['host'] . ";dbname=" . $config['database'] . ";charset=" . $config['charset'];
        try {
            $this->connection = new PDO($dsn, $config['username'], $config['password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $e) {
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Database connection failed.']);
            exit;
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->connection;
    }
}