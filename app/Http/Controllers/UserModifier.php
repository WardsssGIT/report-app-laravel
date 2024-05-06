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
            $useraccounts = User::join('employee_roles', 'users.id', '=', 'employee_roles.user_id')
                ->join('departments', 'employee_roles.department_id', '=', 'departments.id')
                ->get();
            return response(compact('useraccounts'), 200);
        } catch (\Exception $e) {
            Log::error('Error fetching users: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
