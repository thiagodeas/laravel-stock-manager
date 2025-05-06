<?php

use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Entry\EntryController;
use App\Http\Controllers\Output\OutputController;
use App\Http\Controllers\Product\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'getAll']);
    Route::post('/', [CategoryController::class, 'create']);
    Route::get('/filter', [CategoryController::class, 'getByName']);
    Route::get('/{id}', [CategoryController::class, 'getById']);
    Route::delete('/{id}', [CategoryController::class, 'delete']);
});

Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'getAll']);
    Route::post('/', [ProductController::class, 'create']);
    Route::get('/{id}', [ProductController::class, 'getById']);
    Route::put('/{id}', [ProductController::class, 'update']);
    Route::delete('/{id}', [ProductController::class, 'delete']);
});

Route::prefix('entries')->group(function () {
    Route::get('/', [EntryController::class, 'getAll']);
    Route::post('/', [EntryController::class, 'create']);
    Route::get('/filter', [EntryController::class, 'getByDateRange']);
    Route::get('/{id}', [EntryController::class, 'getById']);
    Route::get('/product/{id}', [EntryController::class, 'getByProductId']);
});

Route::prefix('outputs')->group(function () {
    Route::get('/', [OutputController::class, 'getAll']);
    Route::post('/', [OutputController::class, 'create']);
    Route::get('/filter', [OutputController::class, 'getByDateRange']);
    Route::get('/{id}', [OutputController::class, 'getById']);
    Route::get('/product/{id}', [OutputController::class, 'getByProductId']);
});