<?php

use App\Http\Middleware\CheckUserAuth;
use App\Http\Middleware\RedirectIfAuthenticated;
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
        $middleware->alias([
            'AuthUser' => CheckUserAuth::class,
            'guard' => RedirectIfAuthenticated::class,
            'admin.timeout' => \App\Http\Middleware\AdminInactivityTimeout::class,
        ]);

        $middleware->validateCsrfTokens(except: [
            'myaccount/logout',
            'adranayas753/logout',
            'ranayasshop/logout',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
