<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
// این خط باید به Exception پکیج Spatie اشاره کند
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // اینجا هم باید نوع Exception صحیح باشد
        $exceptions->render(function (UnauthorizedException $e, Request $request) {
            return response()->json([
                'status' => false,
                'message' => 'شما دسترسی لازم برای انجام این عملیات را ندارید.',
                'data' => null
            ], 403);
        });

         // مدیریت خطای یافت نشدن مسیر (404)  <-- این قسمت جدید است
         $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            // فقط برای درخواست‌های API این پاسخ را برگردان
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => false,
                    'message' => 'مسیر مورد نظر یافت نشد.',
                    'data' => null
                ], 404);
            }
        });

        $exceptions->render(function (MethodNotAllowedHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => false,
                    'message' => 'متد HTTP استفاده شده برای این مسیر مجاز نیست.',
                    'data' => null
                ], 405);
            }
        });


            $exceptions->render(function (AuthenticationException $e, Request $request) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return response()->json([
                    'status' => false,
                    'message' => 'شما احراز هویت نشده‌اید..',
                    'data' => null
                ], 401);
            }
        });
    })->create();
