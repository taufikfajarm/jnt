<?php

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

// Copy cached config/views if they exist
$sourceStorage = __DIR__ . '/../storage';
if (is_dir($sourceStorage . '/framework/views')) {
    $views = glob($sourceStorage . '/framework/views/*.php');
    foreach ($views as $view) {
        copy($view, '/tmp/storage/framework/views/' . basename($view));
    }
}

// Forward to Laravel
require __DIR__ . '/../public/index.php';
