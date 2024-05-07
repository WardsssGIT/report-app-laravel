<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\employeedetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EmployeeDetailsController extends Controller
{
    // Method to add details
//     public function add(Request $request)
// {
//     try {
//         $validatedData = $request->validate([
//             'user_id' => 'required',
//             'birthday' => 'required|date',
//             'gender' => 'required',
//             'address' => 'required',
//             'contact_number' => 'required',
//             'first_name' => 'required',
//             'last_name' => 'required',
//         ]);

//         // Create the employee details with the validated data
//         $employeeDetails = employeedetails::create($validatedData);

//         return response()->json(['message' => 'Employee details added successfully', 'data' => $employeeDetails], 200);
//     } catch (\Exception $e) {
//         Log::error('Error adding employee details: ' . $e->getMessage());
//         return response()->json(['error' => $e->getMessage()], 500);
//     }
// }

    public function add(Request $request)
    {
        try {
            $user_id = auth()->id();
            
            // Check if employee details already exist for this user
            $existingDetails = employeedetails::where('user_id', $user_id)->first();
            if ($existingDetails) {
                return response()->json(['error' => 'Employee details already exist for this user'], 400);
            }

            $validatedData = $request->validate([
                'birthday' => 'required|date',
                'gender' => 'required',
                'address' => 'required',
                'contact_number' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
            ]);
            $validatedData['user_id'] = $user_id;
            $employeeDetails = employeedetails::create($validatedData);
            return response()->json(['message' => 'Employee details added successfully', 'data' => $employeeDetails], 200);
        } catch (\Exception $e) {
            Log::error('Error adding employee details: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }





    // Method to show details
    public function show()
    {
        $details = employeedetails::where('user_id', Auth::id())->first();
        return $details ? response()->json(['data' => $details], 200) : response()->json(['message' => 'Employee details not found for the authenticated user'], 404);
    }
    
    }
