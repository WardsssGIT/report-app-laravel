<?php

namespace App\Http\Controllers;

use App\Models\Report_table;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class ReportUpload extends Controller
{
    public function index()
    {
        $reports = Report_table::where('is_Active', true)->get();
        return response()->json($reports);
    }
    

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'Date_of_report' => 'required',
                'Report_type' => 'required',
                'Report_name' => 'required',
                'Department_involved' => 'required',
                'Description' => 'required',
                'is_Active' => '1',
                
            ]);
            // Add Report_status_active with default value true
            $validatedData['is_Active'] = true;
    
            $report = Report_table::create($validatedData);
    
            return response()->json(['message' => 'Report created successfully', 'report' => $report], 201);
        } catch (\Exception $e) {
            Log::error('Error storing report: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    

    public function show($id)
    {
        try {
            $report = Report_table::findOrFail($id);
            return response()->json(['report' => $report]);
        } catch (\Exception $e) {
            Log::error('Error fetching report: ' . $e->getMessage());
            return response()->json(['error' => 'Report not found'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $report = Report_table::findOrFail($id);

            $validatedData = $request->validate([
                'Date_of_report' => 'required',
                'Report_type' => 'required',
                'Report_name' => 'required',
                'Department_involved' => 'required',
                'Description' => 'required',
                
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
            $report = Report_table::findOrFail($id);
            $report->update(['Report_status_active' => false]); // Set the report as archived
            return response()->json(['message' => 'Report archived successfully']);
        } catch (\Exception $e) {
            Log::error('Error archiving report: ' . $e->getMessage());
            return response()->json(['error' => 'Report not found'], 404);
        }
    }

    function generate_pdf($data)
    {
        try {
            // Upload Data
            $report_data = Report_table::find($data);
            $pdf = PDF::loadView('pdf-template', compact('report_data'));
            return $pdf->stream();
        } catch (\Throwable $th) {
            return response(['error' => $th->getMessage()], 500);
        }
    }
}

