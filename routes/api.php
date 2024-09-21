<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\v1\Providers\HmoController;
use App\Http\Controllers\v1\Providers\OrderController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/**
 * API V1 routes
 * 
 * @note - These routes are versioned with the prefix for simplicity purposes 
 */
Route::group(['prefix' => 'v1'], function () {
    Route::get('/hmo/suggestions', [HmoController::class, 'search']);
    Route::post('/order', [OrderController::class, 'create']);
});
