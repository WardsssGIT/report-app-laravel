<?php

namespace App\Http\Controllers;

use App\Models\Report_table;
use App\Notifications\EmailNotification;
use Illuminate\Http\Request;


class SendEmailController extends Controller
{
    public function sendNotification($reportId)
    {
        // Retrieve the report
        $report = Report_table::find($reportId);

        // Check if the report exists
        if ($report) {
            // Retrieve the user who created the report
            $user = $report->user_id;

            // Check if user exists and has an email
            if ($user && $user->email) {
                $details = [
                    'greeting' => 'This is feedback from your Report',
                    'body' => 'Your Report was approved',
                    'actionText' => 'Check your email',
                    'actionUrl' => '/',
                    'lastLine' => 'CREDITS: REPORTING APP',
                ];

                // Send notification to user
                $user->notify(new EmailNotification($details));

                return 'Notification sent to the creator of the report.';
            } else {
                return 'User does not exist or does not have an email.';
            }
        } else {
            return 'Report not found.';
        }
    }

    public function rejected($reportId)
    {
        // Retrieve the report
        $report = Report_table::find($reportId);

        // Check if the report exists
        if ($report) {
            // Retrieve the user who created the report
            $user = $report->user_id;

            // Check if user exists and has an email
            if ($user && $user->email) {
                $details = [
                    'greeting' => 'This is feedback from your Report',
                    'body' => 'Your Report was disapproved',
                    'actionText' => 'Check your email',
                    'actionUrl' => '/',
                    'lastLine' => 'CREDITS: REPORTING APP',
                ];

                // Send notification to user
                $user->notify(new EmailNotification($details));

                return 'Notification sent to the creator of the report.';
            } else {
                return 'User does not exist or does not have an email.';
            }
        } else {
            return 'Report not found.';
        }
    }
}
