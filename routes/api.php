<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryAdminController;
use App\Http\Controllers\Admin\ProductAdminController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

Route::post('/admin/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/admin/me', [AuthController::class, 'me']);
    Route::post('/admin/logout', [AuthController::class, 'logout']);

    Route::get('/admin/categories', [CategoryAdminController::class, 'index']);
    Route::post('/admin/categories', [CategoryAdminController::class, 'store']);
    Route::get('/admin/categories/{category}', [CategoryAdminController::class, 'show']);
    Route::put('/admin/categories/{category}', [CategoryAdminController::class, 'update']);
    Route::delete('/admin/categories/{category}', [CategoryAdminController::class, 'destroy']);

    Route::get('/admin/products', [ProductAdminController::class, 'index']);
    Route::post('/admin/products', [ProductAdminController::class, 'store']);
    Route::get('/admin/products/{product}', [ProductAdminController::class, 'show']);
    Route::put('/admin/products/{product}', [ProductAdminController::class, 'update']);
    Route::delete('/admin/products/{product}', [ProductAdminController::class, 'destroy']);
});

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{slug}/products', [CategoryController::class, 'products']);

Route::get('/products/{slug}', [ProductController::class, 'show']);

Route::get('/home/featured', [ProductController::class, 'featured']);
Route::get('/home/newest', [ProductController::class, 'newest']);
