<?php
namespace App\Models;
use App\Core\Model;
class Machine extends Model {
    public function getAll() {
        return $this->db->query("SELECT * FROM machines ORDER BY id DESC")->fetchAll();
    }
}