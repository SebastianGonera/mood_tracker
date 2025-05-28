<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\MoodController;

// This is the API route file for user authentication
// It defines the routes for user registration, login, and logout
Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', [UserAuthController::class, 'register']);
    Route::post('/login', [UserAuthController::class, 'login']);
    Route::post('/logout', [UserAuthController::class, 'logout']);
});

Route::group(['prefix' => 'moods'], function () {
    // This route is for fetching moods of a specific user
    Route::get('/{userId}', [MoodController::class, 'index'])
        ->name('moods.index')
        ->where('userId', '[0-9]+'); // Ensure userId is a number
    // This route is for storing a new mood
    Route::post('/', [MoodController::class, 'store'])
        ->name('moods.store');
});
