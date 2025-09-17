<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// مسیرهای عمومی (برای نمایش دسته‌بندی‌ها)
// این مسیرها نیاز به لاگین ندارند
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{category}', [CategoryController::class, 'show']);
Route::post('/login', [AuthController::class, 'login']);

// مسیرهای محافظت شده
Route::middleware('auth:sanctum')->group(function () {
    // مسیر خروج
    Route::post('/logout', [AuthController::class, 'logout']);
    // مسیر ساخت کاربر جدید (فقط برای مدیر کل)
    Route::post('/register', [AuthController::class, 'register'])->middleware('role:Super Admin');
});

// مسیرهای خصوصی (فقط برای مدیران)
// این مسیرها نیاز به لاگین و نقش Super Admin دارند
Route::middleware(['auth:sanctum', 'role:Admin'])->group(function () {
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{category}', [CategoryController::class, 'update']);
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
