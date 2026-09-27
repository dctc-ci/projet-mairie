<?php

use App\Http\Middleware\EnsureModuleIsEnabled;
use App\Http\Middleware\EnsurePersonnelAccess;
use App\Http\Middleware\EnsureSessionIsActive;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'module.enabled' => EnsureModuleIsEnabled::class,
            'personnels.access' => EnsurePersonnelAccess::class,
        ]);

        $middleware->web(append: [EnsureSessionIsActive::class]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
