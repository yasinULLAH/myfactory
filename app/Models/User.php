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

    public static function hasPermission($userId, $module, $action = 'read') {
        $db = \App\Core\Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT role_id FROM users WHERE id = ? LIMIT 1");
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$user || !$user['role_id']) return false;
        
        $roleId = $user['role_id'];
        
        // Super Admin (ID 1) check is usually done via role name, but we can do it via DB permissions
        // Or hardcode ID 1:
        if ($roleId == 1) return true;
        
        $column = 'can_' . $action;
        if (!in_array($column, ['can_create', 'can_read', 'can_update', 'can_delete'])) {
            return false;
        }

        $stmt = $db->prepare("SELECT $column FROM role_permissions WHERE role_id = ? AND module = ? LIMIT 1");
        $stmt->execute([$roleId, $module]);
        $perm = $stmt->fetchColumn();
        
        return $perm ? true : false;
    }
}