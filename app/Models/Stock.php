<?php
namespace App\Models;
use App\Core\Model;
use PDO;

class Stock extends Model {
    public function getAll() {
        $sql = "SELECT s.*, w.name as warehouse_name, p.name as product_name, p.sku 
                FROM stock s 
                JOIN warehouses w ON s.warehouse_id = w.id 
                JOIN products p ON s.product_id = p.id 
                ORDER BY s.id DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM stock WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO stock (warehouse_id, product_id, batch_number, quantity, expiry_date) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$data['warehouse_id'], $data['product_id'], $data['batch_number'], $data['quantity'], $data['expiry_date']]);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE stock SET warehouse_id = ?, product_id = ?, batch_number = ?, quantity = ?, expiry_date = ? WHERE id = ?");
        return $stmt->execute([$data['warehouse_id'], $data['product_id'], $data['batch_number'], $data['quantity'], $data['expiry_date'], $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM stock WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
