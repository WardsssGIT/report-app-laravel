<?php

namespace App\Http\Controllers;

use App\Models\UploadReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReportUpload extends Controller
{
    public function index()
    {
        $reports = UploadReport::where('active', true)->get();
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

            $report = $request->all();
            $report['active'] = true; // By default, new reports are active

            $report = UploadReport::create($report);

            return response()->json(['message' => 'Report created successfully', 'report' => $report], 201);
        } catch (\Exception $e) {
            Log::error('Error storing report: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
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

    public function update(Request $request, $id)
    {
        try {
            $report = UploadReport::findOrFail($id);

            $validatedData = $request->validate([
                'dateofreport' => 'required',
                'reporttype' => 'required',
                'vesselname' => 'required',
                'departmentinvolved' => 'required',
                'description' => 'required',
                'rank' => 'required',
                'name' => 'required',
            ]);

            $report->update($request->all());

            return response()->json(['message' => 'Report updated successfully', 'report' => $report]);
        } catch (\Exception $e) {
            Log::error('Error updating report: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function archive($id)
    {
        try {
            $report = UploadReport::findOrFail($id);
            $report->update(['active' => false]); // Set the report as archived
            return response()->json(['message' => 'Report archived successfully']);
        } catch (\Exception $e) {
            Log::error('Error archiving report: ' . $e->getMessage());
            return response()->json(['error' => 'Report not found'], 404);
        }
    }
}