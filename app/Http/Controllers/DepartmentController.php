<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departments;
use Illuminate\Support\Facades\Log;

class Departmentcontroller extends Controller
{
    // Function to add a department
    public function addDepartment(Request $request)
    {
        try {
            $validatedData = $request->validate(['department_name' => 'required']);
            $existingDepartment = Departments::where('department_name', $validatedData['department_name'])->first();
            if ($existingDepartment) return response()->json(['error' => 'Department already exists'], 400);
            $newDepartment = Departments::create($validatedData);
            return response()->json(['message' => 'Department created successfully', 'report' => $newDepartment], 201);
        } catch (\Exception $e) {
            Log::error('Error storing department: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()],404);
        }
    }
    


    public function showall()
    {
        $departments = Departments::all();
        return response(compact('departments'),200);
    }

}

