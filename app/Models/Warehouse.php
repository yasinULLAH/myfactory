<?php
namespace App\Models;
use App\Core\Model;
use PDO;

class Warehouse extends Model {
    public function getAll() {
        return $this->db->query("SELECT w.*, f.name as factory_name FROM warehouses w JOIN factories f ON w.factory_id = f.id ORDER BY w.id DESC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM warehouses WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO warehouses (factory_id, name, location) VALUES (?, ?, ?)");
        return $stmt->execute([$data['factory_id'], $data['name'], $data['location']]);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE warehouses SET factory_id = ?, name = ?, location = ? WHERE id = ?");
        return $stmt->execute([$data['factory_id'], $data['name'], $data['location'], $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM warehouses WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
