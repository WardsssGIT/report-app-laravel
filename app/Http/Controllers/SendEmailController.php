<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\EmailNotification;
use Illuminate\Http\Request;

class SendEmailController extends Controller //approve report
{
    public function sendnotification()
    {
        $users = User::all();

        $details = [
            'greeting' => 'This is feedback from your Report',
            'body' => 'Your Report was approved',
            'actiontext' => 'Check your email',
            'actionurl' => '/',
            'lastline' => 'CREDITS: REPORTING APP',
        ];

        foreach ($users as $user) {
            $user->notify(new EmailNotification($details));
        }

        dd('done');
    }


    public function rejected(){
        $users = User::all();

        $details = [
            'greeting' => 'This is feedback from your Report',
            'body' => 'Your Report was disapproved',
            'actiontext' => 'Check your email',
            'actionurl' => '/',
            'lastline' => 'CREDITS: REPORTING APP',
        ];

        foreach ($users as $user) {
            $user->notify(new EmailNotification($details));
        }

        dd('done');

        
    }
}

   
