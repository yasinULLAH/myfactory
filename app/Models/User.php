<?php
namespace App\Models;
use App\Core\Model;
use PDO;

class User extends Model {
    public function findByUsername($username) {
        $stmt = $this->db->prepare("SELECT u.*, r.name as role_name FROM users u LEFT JOIN roles r ON u.role_id = r.id WHERE u.username = ? LIMIT 1");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function updateLastLogin($userId) {
        $stmt = $this->db->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
        $stmt->execute([$userId]);
    }

    public function getUserSettings($userId) {
        $stmt = $this->db->prepare("SELECT * FROM user_settings WHERE user_id = ? LIMIT 1");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getAccessProfile($userId) {
        $db = \App\Core\Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            SELECT u.role_id, u.role, r.name AS role_name
            FROM users u
            LEFT JOIN roles r ON u.role_id = r.id
            WHERE u.id = ?
            LIMIT 1
        ");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public static function isSuperAdmin($userId) {
        $profile = self::getAccessProfile($userId);

        if (!$profile) {
            return false;
        }

        if ((int) ($profile['role_id'] ?? 0) === 1) {
            return true;
        }

        $roleTokens = array_map(
            static fn ($value) => strtolower(trim((string) $value)),
            [$profile['role'] ?? '', $profile['role_name'] ?? '']
        );

        foreach ($roleTokens as $token) {
            if (in_array($token, ['super admin', 'superadmin', 'admin'], true)) {
                return true;
            }
        }

        return false;
    }

    public static function hasPermission($userId, $module, $action = 'read') {
        $profile = self::getAccessProfile($userId);

        if (!$profile) {
            return false;
        }

        if (self::isSuperAdmin($userId)) {
            return true;
        }

        $roleId = (int) ($profile['role_id'] ?? 0);
        if ($roleId === 0) {
            return false;
        }

        $column = 'can_' . $action;
        if (!in_array($column, ['can_create', 'can_read', 'can_update', 'can_delete'])) {
            return false;
        }

        $db = \App\Core\Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT $column FROM role_permissions WHERE role_id = ? AND module = ? LIMIT 1");
        $stmt->execute([$roleId, $module]);
        $perm = $stmt->fetchColumn();
        
        return $perm ? true : false;
    }
}
