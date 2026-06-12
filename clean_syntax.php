<?php
function cleanDir($dir) {
    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        $path = $dir . DIRECTORY_SEPARATOR . $file;
        if (is_dir($path)) {
            cleanDir($path);
        } elseif (pathinfo($path, PATHINFO_EXTENSION) === 'php') {
            $content = file_get_contents($path);
            $newContent = str_replace('\\$', '$', $content);
            if ($content !== $newContent) {
                file_put_contents($path, $newContent);
                echo "Cleaned: $path\n";
            }
        }
    }
}

cleanDir(__DIR__ . '/app');
cleanDir(__DIR__ . '/public');
cleanDir(__DIR__ . '/routes');
echo "Cleanup complete.\n";
