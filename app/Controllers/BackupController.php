<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Services\BackupService;

class BackupController extends Controller {
    public function index() {
        $this->checkPermission('Settings', 'read');
        $backupDir = __DIR__ . '/../../storage/backups/';
        $files = array_diff(scandir($backupDir), array('.', '..'));
        $backups = [];
        foreach ($files as $file) {
            $backups[] = [
                'filename' => $file,
                'size' => round(filesize($backupDir . $file) / 1024, 2) . ' KB',
                'date' => date('Y-m-d H:i:s', filemtime($backupDir . $file))
            ];
        }
        $data = ['title' => 'Database Backups', 'backups' => $backups];
        $this->view('settings/backups', $data);
    }

    public function create() {
        $this->checkPermission('Settings', 'create');
        $result = BackupService::createBackup();
        if ($result) {
            $this->json(['success' => true, 'message' => 'Backup created: ' . $result]);
        } else {
            $this->json(['success' => false, 'message' => 'Backup failed']);
        }
    }

    public function download() {
        $this->checkPermission('Settings', 'read');
        $file = $_GET['file'] ?? null;
        $path = __DIR__ . '/../../storage/backups/' . $file;
        if ($file && file_exists($path)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($path) . '"');
            readfile($path);
            exit;
        }
        die('File not found');
    }
}
