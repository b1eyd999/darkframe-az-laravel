<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            \App\Http\Middleware\TrackOnline::class,
        ]);
        $middleware->alias([
            'admin' => \App\Http\Middleware\EnsureIsAdmin::class,
        ]);
        $middleware->validateCsrfTokens(except: [
            'api/heartbeat',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

// Paylaşılan hostinqdə document root-u dəyişmək mümkün olmadığı üçün
// (cPanel Git deployment .cpanel.yml vasitəsilə) public/ qovluğunun məzmunu
// təhlükəsizlik məqsədilə kənara ("public_html") çıxarılır — buna görə
// public_path() də faktiki veb kökünə yönləndirilir.
$app->usePublicPath(dirname($app->basePath()).'/public_html');

return $app;
