<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Core\Database;
use PDO;

class UserController extends Controller {
    public function index() {
        $this->checkPermission('User Management', 'read');
        $db = Database::getInstance()->getConnection();
        
        $users = $db->query("SELECT u.*, r.name as role_name FROM users u LEFT JOIN roles r ON u.role_id = r.id")->fetchAll(PDO::FETCH_ASSOC);
        $roles = $db->query("SELECT * FROM roles")->fetchAll(PDO::FETCH_ASSOC);
        
        // Modules for permissions
        $modules = ['Master Data', 'Inventory', 'Procurement', 'Production', 'QC', 'Maintenance', 'Sales', 'HR', 'Reports', 'Settings', 'User Management'];
        
        $data = [
            'title' => 'User & Role Management',
            'users' => $users,
            'roles' => $roles,
            'modules' => $modules
        ];
        
        $this->view('users/index', $data);
    }
    
    // User Methods
    public function getUser() {
        $this->checkPermission('User Management', 'read');
        if (!isset($_GET['id'])) $this->json(['error' => 'ID required'], 400);
        
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT id, username, email, full_name, role_id, status FROM users WHERE id = ?");
        $stmt->execute([$_GET['id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) $this->json($user);
        $this->json(['error' => 'Not found'], 404);
    }
    
    public function saveUser() {
        $id = $_POST['id'] ?? '';
        $this->checkPermission('User Management', $id ? 'update' : 'create');
        $db = Database::getInstance()->getConnection();
        
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $full_name = trim($_POST['full_name'] ?? '');
        $role_id = $_POST['role_id'] ?? null;
        $status = $_POST['status'] ?? 'active';
        $password = $_POST['password'] ?? '';
        
        if (empty($username) || empty($email) || empty($full_name) || empty($role_id)) {
            $this->json(['success' => false, 'message' => 'Required fields are missing.']);
        }
        
        try {
            if ($id) {
                if (!empty($password)) {
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $db->prepare("UPDATE users SET username=?, email=?, full_name=?, role_id=?, status=?, password=? WHERE id=?");
                    $stmt->execute([$username, $email, $full_name, $role_id, $status, $hash, $id]);
                } else {
                    $stmt = $db->prepare("UPDATE users SET username=?, email=?, full_name=?, role_id=?, status=? WHERE id=?");
                    $stmt->execute([$username, $email, $full_name, $role_id, $status, $id]);
                }
            } else {
                if (empty($password)) {
                    $this->json(['success' => false, 'message' => 'Password is required for new users.']);
                }
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $db->prepare("INSERT INTO users (username, email, full_name, role_id, status, password, role) VALUES (?, ?, ?, ?, ?, ?, 'User')");
                $stmt->execute([$username, $email, $full_name, $role_id, $status, $hash]);
                $id = $db->lastInsertId();
                $db->prepare("INSERT INTO user_settings (user_id) VALUES (?)")->execute([$id]);
            }
            $this->json(['success' => true]);
        } catch (\Exception $e) {
            $this->json(['success' => false, 'message' => 'Error: Duplicate username/email or DB issue.']);
        }
    }
    
    public function deleteUser() {
        $this->checkPermission('User Management', 'delete');
        $id = $_POST['id'] ?? '';
        if ($id == 1 || $id == $_SESSION['user_id']) {
            $this->json(['success' => false, 'message' => 'Cannot delete super admin or yourself.']);
        }
        $db = Database::getInstance()->getConnection();
        $db->prepare("DELETE FROM users WHERE id=?")->execute([$id]);
        $this->json(['success' => true]);
    }
    
    // Role Methods
    public function getRole() {
        $this->checkPermission('User Management', 'read');
        if (!isset($_GET['id'])) $this->json(['error' => 'ID required'], 400);
        
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM roles WHERE id = ?");
        $stmt->execute([$_GET['id']]);
        $role = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($role) {
            $stmt = $db->prepare("SELECT module, can_create, can_read, can_update, can_delete FROM role_permissions WHERE role_id = ?");
            $stmt->execute([$role['id']]);
            $role['permissions'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->json($role);
        }
        $this->json(['error' => 'Not found'], 404);
    }
    
    public function saveRole() {
        $id = $_POST['id'] ?? '';
        $this->checkPermission('User Management', $id ? 'update' : 'create');
        $db = Database::getInstance()->getConnection();
        
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $permissions = $_POST['permissions'] ?? []; // JSON string or array
        
        if (is_string($permissions)) {
            $permissions = json_decode($permissions, true);
        }
        
        if (empty($name)) {
            $this->json(['success' => false, 'message' => 'Role name is required.']);
        }
        
        try {
            $db->beginTransaction();
            if ($id) {
                if ($id == 1) {
                    $db->rollBack();
                    $this->json(['success' => false, 'message' => 'Cannot modify Super Admin role.']);
                }
                $stmt = $db->prepare("UPDATE roles SET name=?, description=? WHERE id=?");
                $stmt->execute([$name, $description, $id]);
            } else {
                $stmt = $db->prepare("INSERT INTO roles (name, description) VALUES (?, ?)");
                $stmt->execute([$name, $description]);
                $id = $db->lastInsertId();
            }
            
            // Delete old permissions
            $db->prepare("DELETE FROM role_permissions WHERE role_id=?")->execute([$id]);
            
            // Insert new permissions
            if (is_array($permissions)) {
                $stmt = $db->prepare("INSERT INTO role_permissions (role_id, module, can_create, can_read, can_update, can_delete) VALUES (?, ?, ?, ?, ?, ?)");
                foreach ($permissions as $module => $perms) {
                    $c = !empty($perms['create']) ? 1 : 0;
                    $r = !empty($perms['read']) ? 1 : 0;
                    $u = !empty($perms['update']) ? 1 : 0;
                    $d = !empty($perms['delete']) ? 1 : 0;
                    if ($c || $r || $u || $d) {
                        $stmt->execute([$id, $module, $c, $r, $u, $d]);
                    }
                }
            }
            
            $db->commit();
            $this->json(['success' => true]);
        } catch (\Exception $e) {
            $db->rollBack();
            $this->json(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        }
    }
    
    public function deleteRole() {
        $this->checkPermission('User Management', 'delete');
        $id = $_POST['id'] ?? '';
        if ($id == 1 || $id == 2) {
            $this->json(['success' => false, 'message' => 'Cannot delete default roles.']);
        }
        $db = Database::getInstance()->getConnection();
        
        // Check if users exist
        $stmt = $db->prepare("SELECT count(*) FROM users WHERE role_id=?");
        $stmt->execute([$id]);
        if ($stmt->fetchColumn() > 0) {
            $this->json(['success' => false, 'message' => 'Cannot delete role assigned to users.']);
        }
        
        $db->prepare("DELETE FROM roles WHERE id=?")->execute([$id]);
        $this->json(['success' => true]);
    }
}
