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
        $middleware->alias([
            'rol' => \App\Http\Middleware\VerificarRol::class,
            'area' => \App\Http\Middleware\VerificarArea::class,
            'multi.session' => \App\Http\Middleware\MultiSessionGuard::class,
        ]);
        
        // Agregar middlewares de seguridad al grupo 'web'
        $middleware->appendToGroup('web', [
            \App\Http\Middleware\SecurityHeaders::class,
            \App\Http\Middleware\SanitizeInput::class,
            \App\Http\Middleware\ValidatePdfUpload::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

// Forzar la vinculación del request ANTES de que Laravel lo necesite
$app->singleton('request', function () {
    return Illuminate\Http\Request::capture();
});

return $app;