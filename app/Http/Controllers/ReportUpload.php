<?php

namespace App\Http\Controllers;

use App\Models\UploadReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReportUpload extends Controller
{
    public function index()
    {
        $reports = UploadReport::all();

        return response()->json($reports);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'dateofreport' => 'required',
                'reporttype' => 'required',
                'vesselname' => 'required',
                'departmentinvolved' => 'required',
                'description' => 'required',
                'rank' => 'required',
                'name' => 'required',
            ]);

            $report = array(
                'dateofreport'=> $request->dateofreport,
                'reporttype'=> $request->reporttype,
                'vesselname'=> $request->vesselname,
                'departmentinvolved'=> $request->departmentinvolved,
                'description'=> $request->description,
                'rank' => $request->rank,
                'name' => $request->name,
            );

            $report = UploadReport::create($validatedData);

            return response()->json(['message' => 'Report created successfully', 'report' => $report], 201);
        } catch (\Exception $e) {
            Log::error('Error storing report: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to store report'], 500);
        }
    }

    public function show($id)
    {
        try {
            $report = UploadReport::findOrFail($id);
            return response()->json(['report' => $report]);
        } catch (\Exception $e) {
            Log::error('Error fetching report: ' . $e->getMessage());
            return response()->json(['error' => 'Report not found'], 404);
        }
    }
}
