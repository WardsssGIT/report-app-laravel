<?php

namespace App\Http\Controllers;

use App\Models\Departments;
use App\Models\EmployeeRole;
use Illuminate\Support\Facades\DB;
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
            if (!Auth::attempt($credentials)) return response()->json(['error' => 'Unauthorized', 'token' => null], 401);
            
            $user = User::where('email', $request->email)->first();
            return response()->json(['user' => $user, 'token' => $user->createToken('authToken')->plainTextToken]);
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
                'department_id' => 'required|exists:departments,id',
                'userrole' => 'required|string', // Changed 'user_role' to 'userrole'
            ]);
    
            Log::info('Validation successful');
    
            DB::beginTransaction();
    
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
    
            $employeeRole = new EmployeeRole([
                'user_id' => $user->id,
                'department_id' => $request->department_id,
                'userrole' => $request->userrole, // Changed 'user_role' to 'userrole'
            ]);
            $employeeRole->save();
    
            DB::commit();
    
            Log::info('User created successfully');
    
            return response(compact('user'), 200);
        } catch (\Exception $e) {
            DB::rollback();
    
            $error = $e->getMessage();
            Log::error('Registration failed: ' . $error);
            return response(compact('error'), 404);
        }
    }
    

    public function logout(Request $request)
    {
        try {
            $user = $request->user();

            if ($user) {
                $user->currentAccessToken()->delete();
                return response()->json(['message' => 'Logged out']);
            } else {
                return response()->json(['message' => 'No user to log out'], 401);
            }
        } catch (\Exception $e) {
            Log::error('Logout failed: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


}
