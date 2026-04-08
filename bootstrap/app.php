<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

return Application::configure(basePath: dirname(__DIR__))
  ->withRouting(
    web: __DIR__ . "/../routes/web.php",
    api: __DIR__ . "/../routes/api.php",
    commands: __DIR__ . "/../routes/console.php",
    health: "/up"
  )
  ->withMiddleware(function (Middleware $middleware) {

    // CORS debe ir primero, en el stack global
    $middleware->prepend(
        \Illuminate\Http\Middleware\HandleCors::class,
    );

    $middleware->api(
        prepend: [
            \Illuminate\Http\Middleware\HandleCors::class, // también aquí por seguridad
        ],
        append: [
            EnsureFrontendRequestsAreStateful::class,
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
        ]
    );

    $middleware->alias([
        "verified" => \App\Http\Middleware\EnsureEmailIsVerified::class,
    ]);
})
  ->withExceptions(function (Exceptions $exceptions) {
    //
  })
  ->create();
