<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Post\PostResourceController;
use App\Http\Controllers\User\UserResourceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function (): void {
        Route::get('me', [AuthController::class, 'me']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});

Route::resources([
    'users' => UserResourceController::class,
    'posts' => PostResourceController::class,
]);
