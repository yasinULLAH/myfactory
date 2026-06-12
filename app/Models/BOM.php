<?php
namespace App\Models;
use App\Core\Model;
use PDO;
use Exception;

class BOM extends Model {
    public function getAll() {
        $stmt = $this->db->query("SELECT b.*, p.name as product_name, p.sku 
                                  FROM boms b 
                                  JOIN products p ON b.product_id = p.id 
                                  ORDER BY b.created_at DESC");
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT b.*, p.name as product_name FROM boms b JOIN products p ON b.product_id = p.id WHERE b.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getItems($bomId) {
        $stmt = $this->db->prepare("SELECT bi.*, p.name as material_name, p.sku 
                                    FROM bom_items bi 
                                    JOIN products p ON bi.material_id = p.id 
                                    WHERE bi.bom_id = ?");
        $stmt->execute([$bomId]);
        return $stmt->fetchAll();
    }

    public function createWithItems($data, $items) {
        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare("INSERT INTO boms (product_id, name, version) VALUES (:product_id, :name, :version)");
            $stmt->execute([
                'product_id' => $data['product_id'],
                'name' => $data['name'],
                'version' => $data['version'] ?? '1.0'
            ]);
            
            $bomId = $this->db->lastInsertId();

            $itemStmt = $this->db->prepare("INSERT INTO bom_items (bom_id, material_id, quantity) VALUES (?, ?, ?)");
            foreach ($items as $item) {
                $itemStmt->execute([$bomId, $item['material_id'], $item['quantity']]);
            }

            $this->db->commit();
            return $bomId;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }
}
