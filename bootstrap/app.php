<?php

use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Auth\AuthenticationException;

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

        // مدیریت خطای دسترسی (403 Forbidden)
        $exceptions->render(function (UnauthorizedException $e, Request $request) {
            return response()->json([
                'status' => false,
                'message' => 'شما دسترسی لازم برای انجام این عملیات را ندارید.',
                'data' => null
            ], 403);
        });

        // مدیریت خطای یافت نشدن مسیر (404 Not Found)
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => false,
                    'message' => 'مسیر مورد نظر یافت نشد.',
                    'data' => null
                ], 404);
            }
        });

        // مدیریت خطای متد HTTP نامعتبر (405 Method Not Allowed)
        $exceptions->render(function (MethodNotAllowedHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => false,
                    'message' => 'متد HTTP استفاده شده برای این مسیر مجاز نیست.',
                    'data' => null
                ], 405);
            }
        });

        // مدیریت خطای احراز هویت (401 Unauthorized)
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => false,
                    'message' => 'شما احراز هویت نشده‌اید. لطفا ابتدا وارد شوید.',
                    'data' => null
                ], 401);
            }
        });

    })->create();
