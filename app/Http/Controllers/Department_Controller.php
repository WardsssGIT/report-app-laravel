<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departments;
use Illuminate\Support\Facades\Log;

class Department_Controller extends Controller
{
    // Function to add a department
    public function addDepartment(Request $request)
{
    try {
        $validatedData = $request->validate([
            'department_involved' => 'required',
        ]);

        // Check if department already exists
        $existingDepartment = Departments::where('department_involved', $validatedData['department_involved'])->first();

        if ($existingDepartment) {
            return response()->json(['error' => 'Department already exists'], 400);
        }

        // If department doesn't exist, create it
        $newDepartment = Departments::create($validatedData);

        return response()->json(['message' => 'Department created successfully', 'report' => $newDepartment], 201);
    } catch (\Exception $e) {
        Log::error('Error storing department: ' . $e->getMessage());
        return response()->json(['error' => $e->getMessage()],404);
    }
}


public function showall()
{
    // Retrieve all departments from the database
    $departments = Departments::all();

    // Return the departments as a JSON response
    //return response()->json(['departments' => $departments], 200);
    return response(compact('department_involved'),200);
}

}

