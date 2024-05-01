<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class UserModifier extends Controller
{
    public function indexuser()
    {
            try {
                // Retrieve all reports without the is_Active rule
                $useraccount = User::get();
                
                // Return the reports as JSON response
                return response()->json($useraccount);
            } catch (\Exception $e) {
                // Handle any exceptions that may occur during retrieval
                Log::error('Error fetching reports: ' . $e->getMessage());
                // Return an error response
                return response()->json(['error' => 'Failed to fetch reports'], 500);
            }
        }
        
}
