<?php
namespace App\Models;
use App\Core\Model;
use PDO;
use Exception;

class PurchaseOrder extends Model {
    public function getAll() {
        $stmt = $this->db->query("SELECT po.*, s.name as supplier_name, u.full_name as creator_name 
                                  FROM purchase_orders po 
                                  JOIN suppliers s ON po.supplier_id = s.id 
                                  JOIN users u ON po.created_by = u.id 
                                  ORDER BY po.created_at DESC");
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT po.*, s.name as supplier_name, s.email as supplier_email, s.phone as supplier_phone, s.address as supplier_address 
                                    FROM purchase_orders po 
                                    JOIN suppliers s ON po.supplier_id = s.id 
                                    WHERE po.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getItems($poId) {
        $stmt = $this->db->prepare("SELECT poi.*, p.name as product_name, p.sku 
                                    FROM po_items poi 
                                    JOIN products p ON poi.product_id = p.id 
                                    WHERE poi.po_id = ?");
        $stmt->execute([$poId]);
        return $stmt->fetchAll();
    }

    public function createWithItems($data, $items) {
        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare("INSERT INTO purchase_orders (supplier_id, po_number, order_date, total_amount, created_by) 
                                        VALUES (:supplier_id, :po_number, :order_date, :total_amount, :created_by)");
            $stmt->execute([
                'supplier_id' => $data['supplier_id'],
                'po_number' => $data['po_number'],
                'order_date' => $data['order_date'],
                'total_amount' => $data['total_amount'],
                'created_by' => $_SESSION['user_id']
            ]);
            
            $poId = $this->db->lastInsertId();

            $itemStmt = $this->db->prepare("INSERT INTO po_items (po_id, product_id, quantity, unit_price) 
                                            VALUES (?, ?, ?, ?)");
            foreach ($items as $item) {
                $itemStmt->execute([$poId, $item['product_id'], $item['quantity'], $item['unit_price']]);
            }

            $this->db->commit();
            return $poId;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function updateStatus($id, $status) {
        $stmt = $this->db->prepare("UPDATE purchase_orders SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }
}
