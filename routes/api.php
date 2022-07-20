<?php

use App\Http\Controllers\Auth\api\LoginController;
use App\Http\Controllers\Auth\api\RegisterController;
use App\Http\Controllers\Auth\frontend\LoginController as FrontLogin;
use App\Http\Controllers\Auth\frontend\RegisterController as FrontRegister;
use App\Http\Controllers\Auth\frontend\LogoutController as Frontlogout;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('/api')->group(function () {
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/frontend')->group(function () {
    Route::post('/login', FrontLogin::class);
    Route::post('/register', FrontRegister::class);
    Route::post('/logout', Frontlogout::class)->middleware('auth:sanctum');
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::apiResource('/users', UserController::class);
    Route::get('user/profile/{id}', [UserController::class, 'getProfilePicture']);
    Route::post('user/profile/{id}', [UserController::class, 'uploadProfilePicture']);
    Route::apiResource('products', ProductController::class);
    Route::apiResource('brands', BrandController::class);
});
