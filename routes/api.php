<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Authentication
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/token', [AuthController::class, 'token']);

// Routes that need authentication
Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [UserController::class, 'show']);
});

// Application routes
Route::get('products', [ProductController::class, 'index']);
