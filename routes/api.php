<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('categories', CategoryController::class);
Route::apiResource('meals', MealController::class);
Route::apiResource('orders', OrderController::class);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
