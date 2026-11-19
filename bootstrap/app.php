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
        $middleware->trustProxies(at: '*');

        $middleware->alias([
            'admin' => \App\Http\Middleware\EnsureAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (\Illuminate\Session\TokenMismatchException $e, $request) {
            if ($request->is('login')) {
                return redirect()->route('login')->with('error', 'Sesi Anda telah kedaluwarsa (419). Silakan masuk kembali.');
            }

            return redirect()->back()->withInput($request->except('password', '_token'))->with('error', 'Sesi halaman Anda telah kedaluwarsa (419). Silakan coba kembali.');
        });
    })->create();
