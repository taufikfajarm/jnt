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

try {
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    // Output raw error without depending on Laravel's view system
    http_response_code(500);
    header('Content-Type: text/plain');
    echo "=== LARAVEL ERROR ===\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n\n";
    echo "=== PREVIOUS ERROR ===\n";
    $prev = $e->getPrevious();
    if ($prev) {
        echo "Message: " . $prev->getMessage() . "\n";
        echo "File: " . $prev->getFile() . ":" . $prev->getLine() . "\n\n";
        $prev2 = $prev->getPrevious();
        if ($prev2) {
            echo "=== ROOT CAUSE ===\n";
            echo "Message: " . $prev2->getMessage() . "\n";
            echo "File: " . $prev2->getFile() . ":" . $prev2->getLine() . "\n";
        }
    }
    echo "\n=== STACK TRACE ===\n";
    echo $e->getTraceAsString() . "\n";
}
