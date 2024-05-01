<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Temp_data;
use Illuminate\Support\Facades\Log;

class TempData extends Controller
{
    public function storetemporary(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'Date_of_report' => 'required',
                'Report_type' => 'required',
                'Report_name' => 'required',
                'Department_involved' => 'required',
                'Description' => 'required',
            ]);
    
            $report = Temp_data::create($validatedData);
    
            return response()->json(['message' => 'Temporary data saved successfully', 'report' => $report], 201);
        } catch (\Exception $e) {
            Log::error('Error storing report: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
