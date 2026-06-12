<?php
session_start();
require_once __DIR__ . '/../app/Helpers/AppHelper.php';

$config = app_config();
date_default_timezone_set($config['timezone'] ?? 'UTC');

require_once __DIR__ . '/../app/Core/Application.php';
$app = new App\Core\Application();
$app->run();
