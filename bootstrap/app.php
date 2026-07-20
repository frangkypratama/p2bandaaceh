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
    ->withMiddleware(function (Middleware $middleware) {
        // Percayai header X-Forwarded-* dari reverse proxy (Codespaces, IDX,
        // atau proxy lain di depan container) agar skema/host URL yang
        // dihasilkan (asset(), url(), dst.) sesuai dengan yang diakses browser.
        $middleware->trustProxies(at: '*');

        $middleware->web(append: [
            \App\Http\Middleware\VerifyCsrfToken::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
