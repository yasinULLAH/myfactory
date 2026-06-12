<?php
namespace App\Services;
use App\Core\Database;
use PDO;
use Exception;

class BackupService {
    private static $encryptionKey = 'factory-os-secure-key-2026';

    public static function createBackup() {
        $db = Database::getInstance()->getConnection();
        $tables = [];
        $result = $db->query("SHOW TABLES");
        while ($row = $result->fetch(PDO::FETCH_NUM)) {
            $tables[] = $row[0];
        }

        $sql = "SET FOREIGN_KEY_CHECKS=0;\n\n";
        foreach ($tables as $table) {
            $row2 = $db->query("SHOW CREATE TABLE $table")->fetch(PDO::FETCH_NUM);
            $sql .= "\n\n" . $row2[1] . ";\n\n";
            
            $result = $db->query("SELECT * FROM $table");
            while ($row = $result->fetch(PDO::FETCH_NUM)) {
                $sql .= "INSERT INTO $table VALUES(";
                for ($j = 0; $j < count($row); $j++) {
                    $row[$j] = addslashes($row[$j] ?? '');
                    $row[$j] = str_replace("\n", "\\n", $row[$j]);
                    if (isset($row[$j])) { $sql .= '"' . $row[$j] . '"'; } else { $sql .= 'NULL'; }
                    if ($j < (count($row) - 1)) { $sql .= ','; }
                }
                $sql .= ");\n";
            }
        }
        $sql .= "\n\nSET FOREIGN_KEY_CHECKS=1;";

        $encryptedSql = self::encrypt($sql);
        $filename = 'backup_' . date('Y-m-d_H-i-s') . '.fob'; // Factory OS Backup
        $path = __DIR__ . '/../../storage/backups/' . $filename;
        
        if (file_put_contents($path, $encryptedSql)) {
            return $filename;
        }
        return false;
    }

    private static function encrypt($data) {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted = openssl_encrypt($data, 'aes-256-cbc', self::$encryptionKey, 0, $iv);
        return base64_encode($encrypted . '::' . $iv);
    }

    public static function decrypt($data) {
        list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
        return openssl_decrypt($encrypted_data, 'aes-256-cbc', self::$encryptionKey, 0, $iv);
    }

    public static function restoreBackup($filepath) {
        $data = file_get_contents($filepath);
        $sql = self::decrypt($data);
        if (!$sql) return false;

        $db = Database::getInstance()->getConnection();
        try {
            $db->exec($sql);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
