<?php
namespace App\Models;
use App\Core\Model;
use PDO;

class Settings extends Model {
    public function getByUserId($userId) {
        $stmt = $this->db->prepare("SELECT * FROM user_settings WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($userId, $data) {
        $stmt = $this->db->prepare("UPDATE user_settings SET 
            font_family = :font_family, 
            font_size = :font_size, 
            primary_color = :primary_color, 
            secondary_color = :secondary_color, 
            sidebar_bg = :sidebar_bg, 
            header_bg = :header_bg 
            WHERE user_id = :user_id");
        
        $data['user_id'] = $userId;
        return $stmt->execute($data);
    }
}
