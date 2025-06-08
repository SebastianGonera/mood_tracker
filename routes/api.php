<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\MoodController;
use App\Http\Middleware\ValidateNumericRouteParam;

// This is the API route file for user authentication
// It defines the routes for user registration, login, and logout
Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', [UserAuthController::class, 'register']);
    Route::post('/login', [UserAuthController::class, 'login']);
    Route::post('/logout', [UserAuthController::class, 'logout']);
});

// It defines the routes for managing moods of a user
// The routes are protected by the 'auth:sanctum' middleware to ensure that only authenticated users can access them
// The 'moods' prefix is used for all mood-related routes
// The routes include fetching moods, storing a new mood, updating an existing mood, and deleting a mood
Route::group(['prefix' => 'moods', 'middleware' => 'auth:sanctum'], function () {
    // This route is for fetching moods of a specific user
    Route::get('/{userId}', [MoodController::class, 'index'])
        ->middleware('validate_id:userId') // Ensure userId is a number
        ->name('moods.index');

    // This route is for storing a new mood
    Route::post('/', [MoodController::class, 'store'])
        ->name('moods.store');

    // This route is for updating an existing mood
    Route::put('/{moodId}', [MoodController::class, 'update'])
        ->name('moods.update')
        ->where('moodId', '[0-9]+');

    // This route is for deleting a mood
    Route::delete('/{moodId}', [MoodController::class, 'delete'])
        ->middleware('validate_id:moodId') // Ensure moodId is a number
        ->name('moods.destroy');
});
