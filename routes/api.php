<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Middleware\CorsMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

    Route::post('/client-api-login', [AuthController::class, 'login'])->middleware(CorsMiddleware::class);
