<?php
namespace App\Core;

class Controller {
    protected function view($view, $data = []) {
        extract($data);
        $viewFile = __DIR__ . '/../Views/' . $view . '.php';
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            die("View $view not found.");
        }
    }
    
    protected function redirect($url) {
        header('Location: ' . app_url($url));
        exit;
    }

    protected function json($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    
    protected function checkAuth() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
        $config = require __DIR__ . '/../../config/app.php';
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $config['idle_timeout'])) {
            session_unset();
            session_destroy();
            $this->redirect('/login?expired=1');
        }
        $_SESSION['last_activity'] = time();
    }

    protected function checkPermission($module, $action = 'read') {
        $this->checkAuth();
        if (!\App\Models\User::hasPermission($_SESSION['user_id'], $module, $action)) {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                $this->json(['success' => false, 'message' => 'Permission denied.'], 403);
            }
            die("Access Denied. You do not have permission to perform this action.");
        }
    }
}
