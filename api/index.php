<?php

// Show raw errors for debugging
ini_set('display_errors', '1');
error_reporting(E_ALL);

// Redirect storage path to /tmp for Vercel's read-only filesystem
$_ENV['LARAVEL_STORAGE_PATH'] = '/tmp/storage';
$_SERVER['LARAVEL_STORAGE_PATH'] = '/tmp/storage';

// Ensure storage directories exist in /tmp
$storageDirs = [
    '/tmp/storage',
    '/tmp/storage/app',
    '/tmp/storage/app/public',
    '/tmp/storage/framework',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/views',
    '/tmp/storage/logs',
];

foreach ($storageDirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Also ensure bootstrap/cache is writable by symlinking to /tmp
$bootstrapCache = __DIR__ . '/../bootstrap/cache';
$tmpBootstrapCache = '/tmp/bootstrap-cache';
if (!is_dir($tmpBootstrapCache)) {
    mkdir($tmpBootstrapCache, 0755, true);
}
// Copy existing cache files to tmp if they exist and tmp versions don't
foreach (['services.php', 'packages.php'] as $cacheFile) {
    $src = $bootstrapCache . '/' . $cacheFile;
    $dst = $tmpBootstrapCache . '/' . $cacheFile;
    if (file_exists($src) && !file_exists($dst)) {
        copy($src, $dst);
    }
}

// Register early error handler to catch boot failures
$earlyErrors = [];
set_exception_handler(function (\Throwable $e) {
    http_response_code(500);
    header('Content-Type: text/plain');
    echo "=== EARLY EXCEPTION ===\n";
    echo "Class: " . get_class($e) . "\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n\n";

    $prev = $e->getPrevious();
    while ($prev) {
        echo "=== CAUSED BY ===\n";
        echo "Class: " . get_class($prev) . "\n";
        echo "Message: " . $prev->getMessage() . "\n";
        echo "File: " . $prev->getFile() . ":" . $prev->getLine() . "\n\n";
        $prev = $prev->getPrevious();
    }

    echo "=== DIAGNOSTICS ===\n";
    echo "PHP Version: " . PHP_VERSION . "\n";
    echo "CWD: " . getcwd() . "\n";
    echo "bootstrap/cache exists: " . (is_dir(__DIR__ . '/../bootstrap/cache') ? 'yes' : 'no') . "\n";
    echo "bootstrap/cache writable: " . (is_writable(__DIR__ . '/../bootstrap/cache') ? 'yes' : 'no') . "\n";
    echo "vendor/autoload.php exists: " . (file_exists(__DIR__ . '/../vendor/autoload.php') ? 'yes' : 'no') . "\n";
    echo "config dir exists: " . (is_dir(__DIR__ . '/../config') ? 'yes' : 'no') . "\n";
    echo "resources/views exists: " . (is_dir(__DIR__ . '/../resources/views') ? 'yes' : 'no') . "\n";
    echo "storage exists: " . (is_dir(__DIR__ . '/../storage') ? 'yes' : 'no') . "\n";
    echo "/tmp/storage exists: " . (is_dir('/tmp/storage') ? 'yes' : 'no') . "\n";
    echo "/tmp/storage/framework/views exists: " . (is_dir('/tmp/storage/framework/views') ? 'yes' : 'no') . "\n";
    echo "LARAVEL_STORAGE_PATH: " . ($_ENV['LARAVEL_STORAGE_PATH'] ?? 'NOT SET') . "\n";

    echo "\n=== FULL TRACE ===\n";
    echo $e->getTraceAsString() . "\n";
});

try {
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    http_response_code(500);
    header('Content-Type: text/plain');
    echo "=== LARAVEL ERROR ===\n";
    echo "Class: " . get_class($e) . "\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n\n";

    $prev = $e->getPrevious();
    while ($prev) {
        echo "=== CAUSED BY ===\n";
        echo "Class: " . get_class($prev) . "\n";
        echo "Message: " . $prev->getMessage() . "\n";
        echo "File: " . $prev->getFile() . ":" . $prev->getLine() . "\n\n";
        $prev = $prev->getPrevious();
    }

    echo "=== DIAGNOSTICS ===\n";
    echo "PHP Version: " . PHP_VERSION . "\n";
    echo "bootstrap/cache writable: " . (is_writable(__DIR__ . '/../bootstrap/cache') ? 'yes' : 'no') . "\n";
    echo "resources/views exists: " . (is_dir(__DIR__ . '/../resources/views') ? 'yes' : 'no') . "\n";
    echo "/tmp/storage exists: " . (is_dir('/tmp/storage') ? 'yes' : 'no') . "\n";
    echo "/tmp/storage/framework/views exists: " . (is_dir('/tmp/storage/framework/views') ? 'yes' : 'no') . "\n";

    echo "\n=== FULL TRACE ===\n";
    echo $e->getTraceAsString() . "\n";
}
