<?php

namespace App\Notifications;


namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class OtpNotification extends Notification
{
    public $otp;

    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    public function via($notifiable)
    {
        return ['mail']; // change to sms if you have SMS gateway
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Your OTP Code')
                    ->line('Your OTP code is: ' . $this->otp)
                    ->line('This code will expire in 10 minutes.');
    }
}
