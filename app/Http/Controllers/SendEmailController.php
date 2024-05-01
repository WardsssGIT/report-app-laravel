<?php

namespace App\Http\Controllers;

use App\Models\Report_table;
use App\Notifications\EmailNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class SendEmailController extends Controller
{
        public function sendnotification()
    {
        // Retrieve report data with user_id
        $reports = DB::table('report_table')->get();

        // Loop through each report
        foreach ($reports as $report) {
            // Retrieve user corresponding to the report
            $user = User::find($report->user_id);

            // Check if user exists and has an email
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
        }
    }

    public function rejected()
    {
        // Retrieve report data with user_id
        $reports = DB::table('report_table')->get();

        // Loop through each report
        foreach ($reports as $report) {
            // Retrieve user corresponding to the report
            $user = User::find($report->user_id);

            // Check if user exists and has an email
            if ($user && $user->email) {
                $details = [
                    'greeting' => 'This is feedback from your Report',
                    'body' => 'Your Report was disapproved',
                    'actiontext' => 'Check your email',
                    'actionurl' => '/',
                    'lastline' => 'CREDITS: REPORTING APP',
                ];

                // Send notification to user
                $user->notify(new EmailNotification($details));
            }
        }
    }

}    