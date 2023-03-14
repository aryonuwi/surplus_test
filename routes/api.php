<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;


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

Route::prefix('v1')->group(function(){
    Route::prefix('category')->group(function(){
        Route::get('',[CategoryController::class,'List']);
        Route::get('/{id}',[CategoryController::class,'Singel']);
        Route::post('',[CategoryController::class,'Created']);
        Route::put('/{id}',[CategoryController::class,'Updated']);
        Route::delete('/{id}',[CategoryController::class,'Deleted']);
    });

    Route::prefix('product')->group(function(){
        Route::get('',[ProductController::class,'List']);
        Route::get('/{id}',[ProductController::class,'Singel']);
        Route::post('',[ProductController::class,'Created']);
    });

});
