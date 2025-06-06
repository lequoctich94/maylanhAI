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
        // Đăng ký middleware alias
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);

        // Thêm middleware cho web group
        $middleware->web(append: [
            // Thêm middleware nếu cần
        ]);

        // Thêm middleware cho api group  
        $middleware->api(append: [
            // Thêm middleware nếu cần
        ]);
        //
        $middleware->validateCsrfTokens(except: [
            '/admin/posts/upload-image',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        
    })->create();
