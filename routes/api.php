<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//public routes
Route::post('v1/login', [App\Http\Controllers\AuthController::class, 'login']);
Route::post('v1/register', [App\Http\Controllers\AuthController::class, 'register']);

//protected routes
Route::group(['middleware' => ['auth:sanctum'], 'prefix' => 'v1'], function () {
    Route::post('logout', [App\Http\Controllers\AuthController::class, 'logout']);
    Route::resource('tasks', App\Http\Controllers\TaskController::class);
});
