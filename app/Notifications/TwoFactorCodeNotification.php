<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TwoFactorCodeNotification extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your Two-Factor Authentication Code')
            ->line('Your verification code is: ' . $notifiable->two_factor_code)
            ->line('This code will expire in 10 minutes.')
            ->line('If you didn\'t request this, please ignore this message.');
    }
}
