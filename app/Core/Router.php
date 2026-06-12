<?php
namespace App\Core;

class Router {
    private static $routes = [];
    
    public static function get($route, $action) {
        self::$routes['GET'][$route] = $action;
    }
    
    public static function post($route, $action) {
        self::$routes['POST'][$route] = $action;
    }
    
    public function loadRoutes() {
        // Routes are populated statically via web.php
    }
    
    public function dispatch($uri, $method) {
        $parsedUrl = parse_url($uri);
        $path = $parsedUrl['path'];

        $config = require __DIR__ . '/../../config/app.php';
        $configuredBasePath = '/' . trim((string) ($config['base_path'] ?? ''), '/');
        $configuredBasePath = $configuredBasePath === '/' ? '' : $configuredBasePath;

        $baseDirs = array_values(array_unique(array_filter([
            $configuredBasePath !== '' ? $configuredBasePath . '/public' : '',
            $configuredBasePath,
            '/myfactory/public',
            '/myfactory',
        ])));

        foreach ($baseDirs as $dir) {
            if (strpos($path, $dir) === 0) {
                $path = substr($path, strlen($dir));
            }
        }
        
        if ($path === '' || $path === '/') {
            $path = '/';
        }
        
        $method = strtoupper($method);
        
        foreach (self::$routes[$method] ?? [] as $route => $action) {
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<\1>[a-zA-Z0-9_]+)', $route);
            $pattern = '#^' . $pattern . '$#';
            
            if (preg_match($pattern, $path, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                list($controller, $methodName) = explode('@', $action);
                $controllerClass = "\\App\\Controllers\\" . $controller;
                
                require_once __DIR__ . '/../Controllers/' . $controller . '.php';
                $controllerInstance = new $controllerClass();
                call_user_func_array([$controllerInstance, $methodName], $params);
                return;
            }
        }
        
        header("HTTP/1.0 404 Not Found");
        echo "404 Not Found";
        exit;
    }
}
