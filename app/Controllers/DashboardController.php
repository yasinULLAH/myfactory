<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Core\Database;
use PDO;

class DashboardController extends Controller {
    public function index() {
        $this->checkAuth();
        $db = Database::getInstance()->getConnection();
        
        $stats = [
            'products' => $db->query("SELECT COUNT(*) FROM products")->fetchColumn(),
            'suppliers' => $db->query("SELECT COUNT(*) FROM suppliers")->fetchColumn(),
            'pending_pos' => $db->query("SELECT COUNT(*) FROM purchase_orders WHERE status = 'pending'")->fetchColumn(),
            'stock_value' => $db->query("SELECT SUM(quantity * 0) FROM stock")->fetchColumn() 
        ];

        $recent_pos = $db->query("SELECT po.*, s.name as supplier_name FROM purchase_orders po JOIN suppliers s ON po.supplier_id = s.id ORDER BY po.created_at DESC LIMIT 5")->fetchAll();

        $data = [
            'title' => 'Executive Dashboard',
            'user' => $_SESSION['full_name'],
            'role' => $_SESSION['role'],
            'stats' => $stats,
            'recent_pos' => $recent_pos
        ];
        $this->view('dashboard/index', $data);
    }
}
