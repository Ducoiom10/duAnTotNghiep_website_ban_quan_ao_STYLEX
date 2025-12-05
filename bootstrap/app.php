<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__)) // @phpstan-ignore-line
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void { // @phpstan-ignore-line
        $middleware->alias([
            'isAuthenticated' => App\Http\Middleware\IsAuthenticated::class,
            'onlyAuthenticated' => App\Http\Middleware\OnlyAuthenticated::class,
            'onlyAdmin' => App\Http\Middleware\OnlyAdmin::class,
            'checkRole' => App\Http\Middleware\CheckRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void { // @phpstan-ignore-line
        //
    })->create();
