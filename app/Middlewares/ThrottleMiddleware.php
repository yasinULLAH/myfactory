<?php

namespace App\Middlewares;

use App\Core\Application;
use App\Core\Middleware;

class ThrottleMiddleware extends Middleware
{
    public function execute()
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $key = "throttle_$ip";
        $attempts = Application::$app->session->get($key) ?: 0;
        $last_attempt = Application::$app->session->get($key . "_time") ?: 0;

        if ($attempts > 100 && (time() - $last_attempt) < 60) {
            http_response_code(429);
            echo "Too Many Requests";
            exit;
        }

        Application::$app->session->set($key, $attempts + 1);
        Application::$app->session->set($key . "_time", time());
    }
}
