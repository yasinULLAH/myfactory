<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\Settings;

class SettingsController extends Controller {
    public function index() {
        $this->checkAuth();
        $model = new Settings();
        $settings = $model->getByUserId($_SESSION['user_id']);
        $data = ['title' => 'UI Settings', 'settings' => $settings];
        $this->view('settings/index', $data);
    }

    public function save() {
        $this->checkAuth();
        $data = [
            'font_family' => $_POST['font_family'],
            'font_size' => $_POST['font_size'],
            'primary_color' => $_POST['primary_color'],
            'secondary_color' => $_POST['secondary_color'],
            'sidebar_bg' => $_POST['sidebar_bg'],
            'header_bg' => $_POST['header_bg']
        ];
        $model = new Settings();
        if ($model->update($_SESSION['user_id'], $data)) {
            $_SESSION['theme'] = $data;
            $this->json(['success' => true, 'message' => 'Settings updated successfully']);
        } else {
            $this->json(['success' => false, 'message' => 'Failed to update settings']);
        }
    }
}
