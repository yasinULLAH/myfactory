<?php

namespace App\Helpers;

use App\Core\Application;

class Html
{
    public static function csrf()
    {
        $token = Application::$app->session->get('_csrf_token');
        return '<input type="hidden" name="_csrf" value="' . $token . '">';
    }
}
