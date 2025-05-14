<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserAuthController;

// This is the API route file for user authentication
// It defines the routes for user registration, login, and logout
Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', [UserAuthController::class, 'register']);
    Route::post('/login', [UserAuthController::class, 'login']);
    Route::post('/logout', [UserAuthController::class, 'logout']);
});
