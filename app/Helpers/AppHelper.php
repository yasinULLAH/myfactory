<?php

if (!function_exists('app_config')) {
    function app_config() {
        static $config = null;

        if ($config === null) {
            $config = require __DIR__ . '/../../config/app.php';
        }

        return $config;
    }
}

if (!function_exists('app_path')) {
    function app_path() {
        $basePath = trim((string) (app_config()['base_path'] ?? ''), '/');

        return $basePath === '' ? '' : '/' . $basePath;
    }
}

if (!function_exists('app_url')) {
    function app_url($path = '/') {
        $basePath = app_path();
        $path = trim((string) $path);

        if ($path === '' || $path === '/') {
            return $basePath === '' ? '/' : $basePath . '/';
        }

        return ($basePath === '' ? '' : $basePath) . '/' . ltrim($path, '/');
    }
}

if (!function_exists('app_cookie_path')) {
    function app_cookie_path() {
        $basePath = app_path();

        return $basePath === '' ? '/' : $basePath;
    }
}

if (!function_exists('app_request_path')) {
    function app_request_path() {
        $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
        $basePath = app_path();

        foreach (array_filter([$basePath . '/public', $basePath], fn ($value) => $value !== '') as $prefix) {
            if (strpos($path, $prefix) === 0) {
                $path = substr($path, strlen($prefix));
                break;
            }
        }

        return $path === '' ? '/' : $path;
    }
}

if (!function_exists('app_path_is')) {
    function app_path_is($path) {
        return app_request_path() === $path;
    }
}

if (!function_exists('app_path_starts_with')) {
    function app_path_starts_with($path) {
        return strpos(app_request_path(), $path) === 0;
    }
}

if (!function_exists('sidebar_is_collapsed')) {
    function sidebar_is_collapsed() {
        return isset($_COOKIE['sidebar_collapsed']) && $_COOKIE['sidebar_collapsed'] === '1';
    }
}
