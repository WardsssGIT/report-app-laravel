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
        $reports = DB::table('report_table')->get();

        foreach ($reports as $report) {
            $user = User::find($report->user_id);

            if ($user && $user->email) {
                $details = [
                    'greeting' => 'This is feedback from your Report',
                    'body' => 'Your Report was approved',
                    'actiontext' => 'Check your email',
                    'actionurl' => '/',
                    'lastline' => 'CREDITS: REPORTING APP',
                ];
                $user->notify(new EmailNotification($details));
            }
        }
    }

    public function rejected()
    {
    
        $reports = DB::table('report_table')->get();

    
        foreach ($reports as $report) {
            
            $user = User::find($report->user_id);

        
            if ($user && $user->email) {
                $details = [
                    'greeting' => 'This is feedback from your Report',
                    'body' => 'Your Report was disapproved',
                    'actiontext' => 'Check your email',
                    'actionurl' => '/',
                    'lastline' => 'CREDITS: REPORTING APP',
                ];

            
                $user->notify(new EmailNotification($details));
            }
        }
    }

}    