<?php

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
        // Ensure userId is a number
        ->where('userId', '[0-9]+');

    // This route is for storing a new mood
    Route::post('/', [MoodController::class, 'store'])
        ->name('moods.store');

    // This route is for updating an existing mood
    Route::put('/{moodId}', [MoodController::class, 'update'])
        ->name('moods.update')
        ->where('moodId', '[0-9]+');

    // This route is for deleting a mood
    Route::delete('/{moodId}', [MoodController::class, 'delete'])
        ->name('moods.destroy')
        ->where('moodId', '[0-9]+');
});
