<?php

namespace App\Middlewares;

use App\Core\Application;
use App\Core\Middleware;
use App\Core\Auth;

class AuthMiddleware extends Middleware
{
    protected array $actions;

    public function __construct(array $actions = [])
    {
        $this->actions = $actions;
    }

    public function execute()
    {
        if (Auth::isGuest()) {
            if (empty($this->actions) || in_array(Application::$app->controller->action, $this->actions)) {
                Application::$app->response->redirect('/login');
                exit;
            }
        }
    }
}
