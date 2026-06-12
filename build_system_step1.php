<?php
// Script to generate the core files of the Factory Management System

$baseDir = __DIR__;

function makeDir($path) {
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }
}

makeDir($baseDir . '/app/Controllers');
makeDir($baseDir . '/app/Models');
makeDir($baseDir . '/app/Views/layouts');
makeDir($baseDir . '/app/Views/auth');
makeDir($baseDir . '/app/Views/dashboard');
makeDir($baseDir . '/app/Core');
makeDir($baseDir . '/app/Helpers');
makeDir($baseDir . '/app/Middlewares');
makeDir($baseDir . '/config');
makeDir($baseDir . '/public/assets/css');
makeDir($baseDir . '/public/assets/js');
makeDir($baseDir . '/routes');
makeDir($baseDir . '/storage/logs');
makeDir($baseDir . '/storage/uploads');
makeDir($baseDir . '/storage/backups');
makeDir($baseDir . '/database/migrations');

// 1. config.php
file_put_contents($baseDir . '/config/app.php', <<<EOT
<?php
return [
    'app_name' => 'Enterprise Factory Management',
    'base_url' => 'http://localhost/myfactory/public',
    'timezone' => 'UTC',
    'session_timeout' => 28800, // 8 hours
    'idle_timeout' => 2400, // 40 minutes
];
EOT
);

file_put_contents($baseDir . '/config/database.php', <<<EOT
<?php
return [
    'host' => '127.0.0.1',
    'dbname' => 'myfactory_db',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8mb4'
];
EOT
);

// 2. .htaccess
file_put_contents($baseDir . '/public/.htaccess', <<<EOT
Options -MultiViews
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*)$ index.php [QSA,L]
EOT
);

// 3. index.php
file_put_contents($baseDir . '/public/index.php', <<<EOT
<?php
session_start();
require_once __DIR__ . '/../app/Core/Application.php';
\$app = new App\Core\Application();
\$app->run();
EOT
);

echo "Base directories and config created.\n";
