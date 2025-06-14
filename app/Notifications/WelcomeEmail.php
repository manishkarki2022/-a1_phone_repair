<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeEmail extends Notification implements ShouldQueue
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Welcome to Our Platform')
                    ->greeting('Hello ' . $notifiable->first_name . '!')
                    ->line('Welcome to our platform. We are excited to have you on board.')
                    ->line('You can now log in to your account and start exploring.')
                    ->action('Login to Your Account', url('/login'))
                    ->line('Thank you for joining us!');
    }
}
