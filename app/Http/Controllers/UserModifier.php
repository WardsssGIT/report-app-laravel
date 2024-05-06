<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class UserModifier extends Controller
{
    public function indexuser()
    {
        try {
            // Retrieve all users with their associated department information
            $useraccounts = User::join('employee_roles', 'users.id', '=', 'employee_roles.user_id')
                ->join('departments', 'employee_roles.department_id', '=', 'departments.id')
                ->get();
            // Return the users with department information as JSON response
            return response(compact('useraccounts'), 200);
        } catch (\Exception $e) {
            // Log the actual exception message and stack trace
            Log::error('Error fetching users: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            // Return an error response with the actual exception message
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
