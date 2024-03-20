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

            if (Auth::attempt($credentials)) {
                $user = User::where('email', $request->email)->first();
                $token = $user->createToken('authToken')->plainTextToken;
                return response()->json(['token' => $token]);
            }

            return response()->json(['error' => 'Unauthorized'], 401);
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            Log::error('Login failed: ' . $errorMessage);
            return response()->json(['error' => $errorMessage], 500);
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

            $token = $user->createToken('authToken')->plainTextToken;

            Log::info('Token created successfully');

            return response()->json(['token' => $token], 201);
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            Log::error('Registration failed: ' . $errorMessage);
            return response()->json(['error' => $errorMessage], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return response()->json(['message' => 'Logged out']);
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            Log::error('Logout failed: ' . $errorMessage);
            return response()->json(['error' => $errorMessage], 500);
        }
    }
}
