<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Models\User;

class UserAuthController extends Controller
{
    /**
     * Handle user registration.
     *
     * @param  \App\Http\Requests\RegisterUserRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterUserRequest $request)
    {
        try {
            // Add new user to the database
            // The request is already validated by RegisterUserRequest
            $newUser = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => bcrypt($request['password']),
            ]);

            // Create a new token for the user
            // The token is created using the user's name and a custom string
            $token = $newUser
                ->createToken($newUser->name . '_auth-token')
                ->plainTextToken;

            // Return a JSON response with the token
            // The response includes a success message and the token
            // The status code is set to 201 (Created)
            return response()->json([
                'message' => 'User registered successfully',
                'token' => $token,
            ], 201);
        } catch (\Exception $e) {
            // Handle any exceptions that occur during registration
            return response()->json([
                'message' => 'Error occurred during registration',
            ], 500);
        }
    }
}
