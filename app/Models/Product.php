<?php
namespace App\Models;
use App\Core\Model;
use PDO;

class Product extends Model {
    public function getAll() {
        return $this->db->query("SELECT * FROM products ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO products (sku, name, type, reorder_level, price, status) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$data['sku'], $data['name'], $data['type'], $data['reorder_level'], $data['price'], $data['status']]);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE products SET sku = ?, name = ?, type = ?, reorder_level = ?, price = ?, status = ? WHERE id = ?");
        return $stmt->execute([$data['sku'], $data['name'], $data['type'], $data['reorder_level'], $data['price'], $data['status'], $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
