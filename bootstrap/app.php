<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

// If bootstrap/cache is not writable (Vercel serverless), redirect to /tmp
if (!is_writable($app->bootstrapPath('cache'))) {
    $tmpBootstrap = '/tmp/bootstrap';

    // Create /tmp/bootstrap directory
    if (!is_dir($tmpBootstrap)) {
        mkdir($tmpBootstrap, 0755, true);
    }

    // Copy providers.php to /tmp/bootstrap
    $providersFile = $app->bootstrapPath('providers.php');
    if (file_exists($providersFile) && !file_exists($tmpBootstrap . '/providers.php')) {
        copy($providersFile, $tmpBootstrap . '/providers.php');
    }

    // Create cache directory and copy cache files
    $cacheDir = $tmpBootstrap . '/cache';
    if (!is_dir($cacheDir)) {
        mkdir($cacheDir, 0755, true);
    }
    foreach (glob($app->bootstrapPath('cache') . '/*.php') as $file) {
        $dst = $cacheDir . '/' . basename($file);
        if (!file_exists($dst)) {
            copy($file, $dst);
        }
    }

    // Redirect bootstrap path to /tmp
    $app->useBootstrapPath($tmpBootstrap);
}

return $app;
