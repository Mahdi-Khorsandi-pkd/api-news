<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\SectionController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\SocialPlatformController;
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// ### مسیرهای عمومی (بدون نیاز به لاگین) ###
//================================================
Route::post('/login', [AuthController::class, 'login']);

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{category}', [CategoryController::class, 'show']);

Route::get('/sections', [SectionController::class, 'index']);
Route::get('/sections/{section}', [SectionController::class, 'show']);

Route::get('/menus/{menu:location}', [MenuController::class, 'show']);

Route::get('/settings', [SettingController::class, 'index']); // <-- این مسیر باید اینجا باشد


// ### مسیرهای محافظت شده (نیاز به لاگین) ###
//================================================
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    // --- مسیرهای مخصوص نقش Admin ---
    Route::middleware('role:Admin')->prefix('admin')->group(function () {
        // Users
        Route::post('/register', [AuthController::class, 'register']);

        // Categories
        Route::post('/categories', [CategoryController::class, 'store']);
        Route::put('/categories/{category}', [CategoryController::class, 'update']);
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

        // Sections Management
        Route::post('/sections/{section}/sync-categories', [SectionController::class, 'syncCategories']);

        // Menu Management
        Route::get('/menus', [MenuController::class, 'index']);
        Route::post('/menus/{menu:location}/sync', [MenuController::class, 'sync']);

        // Settings Management
        Route::get('/settings', [SettingController::class, 'getAllForSettingsPanel']);
        Route::post('/settings', [SettingController::class, 'update']);


        Route::get('/social-platforms', [SocialPlatformController::class, 'index']);

        // in routes/api.php inside the admin group
        Route::delete('/settings/{group}/{key}', [SettingController::class, 'destroy']);
    });
});
