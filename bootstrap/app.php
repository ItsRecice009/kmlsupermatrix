<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Add session expiry check middleware for web routes
        $middleware->web(append: [
            \App\Http\Middleware\CheckSessionExpiry::class,
        ]);
        
        // Alias untuk middleware role
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);
        
        // Exclude session-close endpoint from CSRF verification
        $middleware->validateCsrfTokens(except: [
            'api/session-close',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
