<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\User;

class AuthController extends Controller {
    public function showLogin() {
        if (isset($_SESSION['user_id'])) {
            $this->redirect('/dashboard');
        }
        $this->view('auth/login');
    }
    
    public function processLogin() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['success' => false, 'message' => 'Invalid request'], 405);
        }
        
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $captcha = trim($_POST['captcha'] ?? '');
        
        if (empty($username) || empty($password) || empty($captcha)) {
            $this->json(['success' => false, 'message' => 'All fields are required.']);
        }
        
        if ($captcha !== ($_SESSION['captcha'] ?? '')) {
            $this->json(['success' => false, 'message' => 'Invalid CAPTCHA.']);
        }
        
        $userModel = new User();
        $user = $userModel->findByUsername($username);
        
        if ($user && password_verify($password, $user['password'])) {
            if ($user['status'] !== 'active') {
                $this->json(['success' => false, 'message' => 'Account is ' . $user['status']]);
            }
            
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['last_activity'] = time();
            
            $settings = $userModel->getUserSettings($user['id']);
            if ($settings) {
                $_SESSION['theme'] = $settings;
            }
            
            $userModel->updateLastLogin($user['id']);
            $this->json(['success' => true, 'redirect' => '/dashboard']);
        } else {
            $this->json(['success' => false, 'message' => 'Invalid username or password.']);
        }
    }
    
    public function logout() {
        session_unset();
        session_destroy();
        $this->redirect('/login');
    }
}