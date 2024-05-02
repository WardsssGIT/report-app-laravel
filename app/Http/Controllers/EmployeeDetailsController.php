<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\employee_details;

class EmployeeDetailsController extends Controller
{
    // Method to add details
    public function add(Request $request)
    {
        // Validate request data
        $validatedData = $request->validate([
            'user_id' => 'required',
            'birthday' => 'required|date',
            'address' => 'required',
            'contact_number' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
        ]);

        // Create a new employee_details instance
        $employeeDetails = employee_details::create($validatedData);

        // Return success response
        return response()->json(['message' => 'Employee details added successfully', 'data' => $employeeDetails], 200);
    }

    // Method to show details
    public function show($id)
    {
        // Find the employee_details instance by ID
        $employeeDetails = employee_details::find($id);

        // If employee details not found, return error response
        if (!$employeeDetails) {
            return response()->json(['message' => 'Employee details not found'], 404);
        }

        // Return employee details
        return response()->json(['data' => $employeeDetails], 200);
    }

    // Method to modify details
    public function modify(Request $request, $id)
    {
        // Validate request data
        $validatedData = $request->validate([
            'user_id' => 'required',
            'birthday' => 'required|date',
            'address' => 'required',
            'contact_number' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
        ]);

        // Find the employee_details instance by ID
        $employeeDetails = employee_details::find($id);

        // If employee details not found, return error response
        if (!$employeeDetails) {
            return response()->json(['message' => 'Employee details not found'], 404);
        }

        // Update employee details with validated data
        $employeeDetails->update($validatedData);

        // Return success response
        return response()->json(['message' => 'Employee details updated successfully', 'data' => $employeeDetails], 200);
    }
}
