<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('products', [ProductController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [UserController::class, 'show']);
});
