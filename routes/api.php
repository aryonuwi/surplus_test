<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ImagesController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::prefix('category')->group(function () {
        Route::get('', [CategoryController::class, 'List']);
        Route::get('/{id}', [CategoryController::class, 'Singel']);
        Route::post('', [CategoryController::class, 'Created']);
        Route::put('/{id}', [CategoryController::class, 'Updated']);
        Route::delete('/{id}', [CategoryController::class, 'Deleted']);
    });

    Route::prefix('product')->group(function () {
        Route::get('', [ProductController::class, 'List']);
        Route::get('/{id}', [ProductController::class, 'Singel']);
        Route::post('', [ProductController::class, 'Created']);
        Route::put('/{id}', [ProductController::class, 'updated']);
        Route::delete('/{id}', [ProductController::class, 'deleted']);

        Route::prefix('image')->group(function () {
            Route::post('/upload', [ImagesController::class, 'ProductUpload']);
            Route::post('/add', [ImagesController::class, 'Upload']);
            Route::delete('', [ImagesController::class, 'Upload']);
        });
    });

    Route::prefix('image')->group(function () {
        Route::get('', [ImagesController::class, 'Upload']);
        Route::get('/{id}', [ImagesController::class, 'Upload']);
        Route::post('', [ImagesController::class, 'Upload']);
        Route::delete('', [ImagesController::class, 'Upload']);
    });
});
