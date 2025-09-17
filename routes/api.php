<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SectionController; // <-- این خط اضافه شود
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// ### مسیرهای عمومی ###
Route::post('/login', [AuthController::class, 'login']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{category}', [CategoryController::class, 'show']);
Route::get('/sections', [SectionController::class, 'index']);


// ### مسیرهای محافظت شده (نیاز به لاگین) ###
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    // --- مسیرهای مخصوص نقش Admin ---
    Route::middleware('role:Admin')->group(function() {
        // Users
        Route::post('/register', [AuthController::class, 'register']);

        // Categories
        Route::post('/categories', [CategoryController::class, 'store']);
        Route::put('/categories/{category}', [CategoryController::class, 'update']);
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

        // Sections  <-- مسیرهای جدید اینجا اضافه شدند
        Route::get('/sections/{section}', [SectionController::class, 'show']);
        Route::post('/sections/{section}/sync-categories', [SectionController::class, 'syncCategories']);
    });

});
