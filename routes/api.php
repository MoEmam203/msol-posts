<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\PostApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'guest'], function () {
    Route::post('register', [AuthApiController::class, 'register'])
        ->name('api.auth.register');

    Route::post('login', [AuthApiController::class, 'login'])
        ->name('api.auth.login');
});

Route::get('is-logged-in', [AuthApiController::class, 'isLoggedIn'])
    ->name('api.auth.is-logged-in');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('logout', [AuthApiController::class, 'logout'])
        ->name('api.auth.logout');

    Route::apiResource('posts', PostApiController::class);
});

Route::get('get-user', function (Request $request) {
    return response()->json([
        'user' => $request->user(),
    ]);
})->middleware('auth:sanctum');
