<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
            Log::error("Error in REGISTER endpoint: " . $e->getMessage());
            // Handle any exceptions that occur during registration
            return response()->json([
                'message' => 'Error occurred during registration',
            ], 500);
        }
    }

    /**
     * Handle user login.
     *
     * @param  \App\Http\Requests\LoginUserRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginUserRequest $request)
    {
        try {
            // Validate the request using LoginUserRequest
            // The request is already validated by LoginUserRequest
            // Check if the user exists in the database
            $user = User::where('email', $request['email'])->first();

            // If the user exists and the password is correct
            // Verify the password using password_verify
            if ($user && password_verify($request['password'], $user->password)) {
                // Create a new token for the user
                // The token is created using the user's name and a custom string
                // The token is a plain text token
                $token = $user
                    ->createToken($user->name . '_auth-token')
                    ->plainTextToken;

                // Return a JSON response with the token
                // The response includes a success message and the token
                // The status code is set to 200 (OK)
                return response()->json([
                    'message' => 'User logged in successfully',
                    'token' => $token,
                ], 200);
            }
        } catch (\Exception $e) {
            Log::error("Error in LOGIN endpoint: " . $e->getMessage());
            // Handle any exceptions that occur during registration
            return response()->json([
                'message' => 'Error occurred during login',
            ], 500);
        }
    }

    /**
     * Handle user logout.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        try {
            // Get the authenticated user
            $user = Auth::user();

            // Revoke all tokens for the user
            $user->tokens()->delete();

            // Return a JSON response indicating successful logout
            return response()->json([
                'message' => 'User logged out successfully',
            ], 200);
        } catch (\Exception $e) {
            Log::error("Error in LOGOUT endpoint: " . $e->getMessage());
            // Handle any exceptions that occur during logout
            return response()->json([
                'message' => 'Error occurred during logout',
            ], 500);
        }
    }
}
