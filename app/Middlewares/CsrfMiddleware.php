<?php

namespace App\Middlewares;

use App\Core\Application;
use App\Core\Middleware;

class CsrfMiddleware extends Middleware
{
    public function execute()
    {
        if (Application::$app->request->isPost()) {
            $token = Application::$app->request->getBody()['_csrf'] ?? '';
            if ($token !== Application::$app->session->get('_csrf_token')) {
                http_response_code(403);
                echo "Invalid CSRF Token";
                exit;
            }
        } else {
            if (!Application::$app->session->get('_csrf_token')) {
                Application::$app->session->set('_csrf_token', bin2hex(random_bytes(32)));
            }
        }
    }
}
