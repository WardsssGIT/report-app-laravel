<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');
    
            if (!Auth::attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized', 'token' => null], 401);
            }
    
            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('authToken')->plainTextToken;
            return response()->json(['user' => $user, 'token' => $token]);
        } catch (\Exception $e) {
            Log::error('Login failed: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage(), 'token' => null], 500);
        }
    }
    



    public function register(Request $request)
    {
        try {
            Log::info('Attempting user registration');

            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:users,email',
                'password' => 'required|string|min:6',
            ]);

            Log::info('Validation successful');

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            Log::info('User created successfully');

            //$token = $user->createToken('authToken')->plainTextToken;

            Log::info('Token created successfully');

            return response(compact('user'), 200);
        } catch (\Exception $e) {
            $error = $e->getMessage();
            Log::error('Registration failed: ' . $error);
            return response(compact('error'), 404);;
        }
    }

    public function logout(Request $request)
    {
        try {
            // Retrieve the authenticated user
            $user = $request->user();

            // Check if the user is authenticated
            if ($user) {
                // Delete the user's current access token
                $user->currentAccessToken()->delete();
                return response()->json(['message' => 'Logged out']);
            } else {
                // If the user is not authenticated, return a 401 Unauthorized response
                return response()->json(['message' => 'No user to log out'], 401);
            }
        } catch (\Exception $e) {
            // If an exception occurs, log the error and return a 500 Internal Server Error response
            $errorMessage = $e->getMessage();
            Log::error('Logout failed: ' . $errorMessage);
            return response()->json(['error' => $errorMessage], 500);
        }
    }
}
