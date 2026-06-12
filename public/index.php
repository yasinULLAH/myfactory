<?php
session_start();
require_once __DIR__ . '/../app/Core/Application.php';
$app = new App\Core\Application();
$app->run();