<?php

namespace App\Core;

class Auth
{
    public static function login($user)
    {
        Application::$app->session->set('user', $user['id']);
        Application::$app->session->set('user_role', $user['role_id']);
        Application::$app->session->set('login_time', time());
        Application::$app->session->set('last_activity', time());
        
        // Load theme settings
        $stmt = Application::$app->db->prepare("SELECT * FROM user_settings WHERE user_id = ?");
        $stmt->execute([$user['id']]);
        $settings = $stmt->fetch();
        if ($settings) {
            Application::$app->session->set('user_theme', $settings);
        }

        return true;
    }

    public static function logout()
    {
        Application::$app->session->remove('user');
        Application::$app->session->remove('user_role');
        Application::$app->session->remove('login_time');
        Application::$app->session->remove('last_activity');
        Application::$app->session->remove('user_theme');
    }

    public static function isGuest()
    {
        return !Application::$app->session->get('user');
    }

    public static function user()
    {
        $userId = Application::$app->session->get('user');
        if (!$userId) return null;

        static $user = null;
        if ($user === null) {
            $stmt = Application::$app->db->prepare("SELECT u.*, r.name as role_name FROM users u JOIN roles r ON u.role_id = r.id WHERE u.id = ?");
            $stmt->execute([$userId]);
            $user = $stmt->fetch();
        }
        return $user;
    }

    public static function hasPermission($permission)
    {
        $userId = Application::$app->session->get('user');
        if (!$userId) return false;

        $user = self::user();
        if ($user['role_name'] === 'Super Admin') return true;

        $stmt = Application::$app->db->prepare("
            SELECT p.name FROM permissions p
            JOIN role_permissions rp ON p.id = rp.permission_id
            WHERE rp.role_id = ? AND p.name = ?
        ");
        $stmt->execute([$user['role_id'], $permission]);
        return $stmt->fetch() !== false;
    }

    public static function checkSession()
    {
        if (self::isGuest()) return;

        $lastActivity = Application::$app->session->get('last_activity');
        $loginTime = Application::$app->session->get('login_time');

        // 40 minutes idle timeout
        if (time() - $lastActivity > 40 * 60) {
            self::logout();
            Application::$app->response->redirect('/login');
            exit;
        }

        // 8 hours absolute session limit
        if (time() - $loginTime > 8 * 3600) {
            self::logout();
            Application::$app->response->redirect('/login');
            exit;
        }

        Application::$app->session->set('last_activity', time());
    }
}
