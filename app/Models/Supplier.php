<?php
namespace App\Models;
use App\Core\Model;
use PDO;

class Supplier extends Model {
    public function getAll() {
        return $this->db->query("SELECT * FROM suppliers ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM suppliers WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO suppliers (name, email, phone, address, status) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$data['name'], $data['email'], $data['phone'], $data['address'], $data['status']]);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE suppliers SET name = ?, email = ?, phone = ?, address = ?, status = ? WHERE id = ?");
        return $stmt->execute([$data['name'], $data['email'], $data['phone'], $data['address'], $data['status'], $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM suppliers WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
