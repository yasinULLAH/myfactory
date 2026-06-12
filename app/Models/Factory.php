<?php
namespace App\Models;
use App\Core\Model;
use PDO;

class Factory extends Model {
    public function getAll() {
        return $this->db->query("SELECT * FROM factories ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM factories WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO factories (name, location, contact_number, status) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$data['name'], $data['location'], $data['contact_number'], $data['status']]);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE factories SET name = ?, location = ?, contact_number = ?, status = ? WHERE id = ?");
        return $stmt->execute([$data['name'], $data['location'], $data['contact_number'], $data['status'], $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM factories WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
