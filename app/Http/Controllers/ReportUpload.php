<?php

namespace App\Http\Controllers;

use App\Models\Report_table;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Access\Response;
use App\Models\User;
use App\Notifications\EmailNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class ReportUpload extends Controller
{
    public function index()
    {
        try {
            $reports = Report_table::with('department')->where('is_active', true)->get();
            return response()->json($reports);
        } catch (\Exception $e) {
            Log::error('Error fetching reports: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch reports'], 500);
        }
    }
    
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'date_of_report' => 'required',
                'report_type' => 'required',
                'report_name' => 'required',
                'department_id' => 'required',
                'description' => 'required',
                'is_active' => '1',
            ]);
    
            // Get the user ID of the currently logged-in user
            $user_id = Auth::id();
    
            // Include the user_id in the validated data
            $validatedData['user_id'] = $user_id;
            $validatedData['is_Active'] = true;
    
            // Create the report with the validated data
            $report = Report_table::create($validatedData);
    
            // Generate PDF for the created report
            $pdfPath = $this->generate_pdf($report->id);
    
            return response()->json(['message' => 'Report created successfully', 'report' => $report, 'pdf_path' => $pdfPath], 201);
        } catch (\Exception $e) {
            Log::error('Error storing report: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

public function storetemporary(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'date_of_report' => 'required',
                'report_type' => 'required',
                'report_name' => 'required',
                'department_id' => 'required',
                'description' => 'required',
                'is_active' => '0',
            ]);

    
            // Get the user ID of the currently logged-in user
        $user_id = Auth::id();

        // Include the user_id in the validated data
        $validatedData['user_id'] = $user_id;
        $validatedData['is_active'] = false;

        // Create the report with the validated data
        $report = Report_table::create($validatedData);

        return response()->json(['message' => 'Temporary Report saved', 'report' => $report], 201);
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
                'report_type' => 'required',
                'department_id' => 'required',
                'reportdata' => 'required',
                'report_pdf' =>'available',
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
            $report->update(['is_active' => false]); // Set the report as archived
            return response()->json(['message' => 'Report archived successfully']);
        } catch (\Exception $e) {
            Log::error('Error archiving report: ' . $e->getMessage());
            return response()->json(['error' => 'Report not found'], 404);
        }
    }

    public function approve_report(Request $request, $id)
{
    try {
        $user_id = $request->user()->id;
        $report = Report_table::findOrFail($id);
        $report->update([
            'User_verify_id' => $user_id,
            'Report_status' => '1',
            'Remarks' => 'Approved'
        ]);

        // Retrieve the user associated with the report
        $user = User::find($report->user_id);
        if ($user && $user->email) {
            $details = [
                'greeting' => 'This is feedback from your Report',
                'body' => 'Your Report was approved',
                'actiontext' => 'Check your email',
                'actionurl' => '/',
                'lastline' => 'CREDITS: REPORTING APP',
            ];

            // Send notification to user
            $user->notify(new EmailNotification($details));
        }

        return response()->json(['message'=> 'Report Approved Success']);
    } catch (\Exception $e) {
        Log::error('Error approving report'. $e->getMessage());
        return response()->json(['error'=> $e->getMessage()], 500);
    }
}


    
    public function disapprove_report(Request $request, $id){
        try{
            $user_id = $request->user()->id;
            $report = Report_table::findOrFail($id);
            $report->update([
               'User_verify_id' => $user_id,
                'Report_status' => '1',
                'Remarks' => 'Disapproved'
            ]);
        // Retrieve the user associated with the report
        $user = User::find($report->user_id);
        if ($user && $user->email) {
            $details = [
                'greeting' => 'This is feedback from your Report',
                'body' => 'Your Report was Disapproved',
                'actiontext' => 'Check your email',
                'actionurl' => '/',
                'lastline' => 'CREDITS: REPORTING APP',
            ];

            // Send notification to user
            $user->notify(new EmailNotification($details));
        }


            return response()->json(['message'=> 'Report disapprove Success']);
        } catch (\Exception $e) {
            Log::error('Error disapproving report report'. $e->getMessage());
            return response()->json(['error'=> $e->getMessage()], 500);
        }
    }



   
    public function generate_pdf($reportId)
    {
        try {
            // Get report data
            $report_data = Report_table::find($reportId);
            
            // Load PDF view with report data
            $pdf = Pdf::loadView('pdf-template', compact('report_data'));
            
            // Generate filename for PDF using report ID
            $pdfFilename = 'report_' . $reportId . '.pdf';
            $pdfPath = 'reportsPDF/' . $pdfFilename;
            
            // Save PDF to storage
            $pdf->save(public_path($pdfPath));
            
            return $pdfPath;
        } catch (\Throwable $th) {
            Log::error('Error generating PDF: ' . $th->getMessage());
            throw new \Exception('Failed to generate PDF');
        }
    }
    

    public function showPdf($reportId)
    {
        try {
            // Find the report by ID
            $report = Report_table::findOrFail($reportId);
    
            // Generate the PDF path
            $pdfPath = 'reportsPDF/report_' . $reportId . '.pdf'; // Modified path
    
            // Check if PDF exists
            if (!file_exists(public_path($pdfPath))) {
                throw new \Exception('PDF not found');
            }
    
            // Return the PDF file
            return response()->file(public_path($pdfPath), [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . basename($pdfPath) . '"'
            ]);
        } catch (\Exception $e) {
            Log::error('Error showing PDF: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }


}
