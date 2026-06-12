<?php
namespace App\Models;
use App\Core\Model;
class QC extends Model {
    public function getAll() {
        return $this->db->query("SELECT q.*, u.full_name as inspector_name FROM qc_records q LEFT JOIN users u ON q.inspector_id = u.id ORDER BY q.created_at DESC")->fetchAll();
    }
}