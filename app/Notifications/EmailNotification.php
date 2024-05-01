<?php

// App\Notifications\EmailNotification.php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class EmailNotification extends Notification
{
    public $details;

    public function __construct($details)
    {
        $this->details = $details;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting($this->details['greeting'])
            ->line($this->details['body'])
            ->action($this->details['actiontext'], $this->details['actionurl'])
            ->line($this->details['lastline']);
    }
}
