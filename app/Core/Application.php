<?php
namespace App\Core;

class Application {
    private $router;
    
    public function __construct() {
        require_once __DIR__ . '/Database.php';
        require_once __DIR__ . '/Router.php';
        require_once __DIR__ . '/Controller.php';
        require_once __DIR__ . '/Model.php';
        
        $this->router = new Router();
        $this->registerRoutes();
    }
    
    private function registerRoutes() {
        require_once __DIR__ . '/../../routes/web.php';
        $this->router->loadRoutes();
    }
    
    public function run() {
        $this->router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
    }
}