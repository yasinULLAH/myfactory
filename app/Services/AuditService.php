<?php
namespace App\Services;
use App\Core\Database;
use PDO;

class AuditService {
    public static function log($module, $action, $oldValues = null, $newValues = null) {
        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("INSERT INTO audit_logs (user_id, module, action, old_values, new_values, ip_address) 
                                    VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $_SESSION['user_id'] ?? null,
                $module,
                $action,
                $oldValues ? json_encode($oldValues) : null,
                $newValues ? json_encode($newValues) : null,
                $_SERVER['REMOTE_ADDR']
            ]);
        } catch (\Exception $e) {
            // Silently fail to not break business logic
        }
    }
}
