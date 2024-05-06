<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\employee_details;

class EmployeeDetailsController extends Controller
{
    // Method to add details
    public function add(Request $request)
{
    $validatedData = $request->validate([
        'user_id' => 'required',
        'birthday' => 'required|date',
        'address' => 'required',
        'contact_number' => 'required',
        'first_name' => 'required',
        'last_name' => 'required',
    ]);

    $employeeDetails = employee_details::create($validatedData);

    return response()->json(['message' => 'Employee details added successfully', 'data' => $employeeDetails], 200);
}


    // Method to show details
    public function show($id)
    {
        $employeeDetails = employee_details::find($id);

        if (!$employeeDetails) {
            return response()->json(['message' => 'Employee details not found'], 404);
        }
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
        $employeeDetails = employee_details::find($id);

        if (!$employeeDetails) {
            return response()->json(['message' => 'Employee details not found'], 404);
        }
        $employeeDetails->update($validatedData);
        return response()->json(['message' => 'Employee details updated successfully', 'data' => $employeeDetails], 200);
    }
}
