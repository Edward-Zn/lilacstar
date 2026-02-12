<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

Route::post('/admin/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/admin/me', [AuthController::class, 'me']);
    Route::post('/admin/logout', [AuthController::class, 'logout']);
});

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{slug}/products', [CategoryController::class, 'products']);

Route::get('/products/{slug}', [ProductController::class, 'show']);

Route::get('/home/featured', [ProductController::class, 'featured']);
Route::get('/home/newest', [ProductController::class, 'newest']);
