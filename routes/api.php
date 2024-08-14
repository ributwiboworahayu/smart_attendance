<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::middleware([HandleCors::class])->prefix('v1')->group(function () {

    /*
    | -------------------------------------------------------------------------
    | Private routes
    | -------------------------------------------------------------------------
    | The private routes are the routes that are accessible only with authentication. e.g. user profile, etc.
    | You can access these routes by sending a Bearer token in the Authorization header.
    */
    Route::middleware('auth:api')->group(function () {
        Route::get('user', function (Request $request) {
            return $request->user();
        });

        Route::prefix('auth')->group(function () {
            Route::post('logout', [AuthController::class, 'logout']);
            Route::post('refresh-token', [AuthController::class, 'refreshToken']);
        });
    });

    /*
    | -------------------------------------------------------------------------
    | Public routes
    | -------------------------------------------------------------------------
    | The public routes are the routes that are accessible without authentication. e.g. login, register, forgot password, etc.
    | You can access these routes without sending any token.
    */
    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('register', [AuthController::class, 'register']);
        Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
        Route::post('reset-password', [AuthController::class, 'resetPassword']);
    });
});
