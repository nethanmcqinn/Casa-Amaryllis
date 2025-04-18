<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification
{
    use Queueable;

    public function __construct()
    {
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Welcome to Casa Amaryllis!')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Welcome to Casa Amaryllis! We\'re delighted to have you join our floral family.')
            ->line('At Casa Amaryllis, we offer the finest selection of fresh flowers for every occasion.')
            ->action('Start Shopping', url('/'))
            ->line('Thank you for choosing Casa Amaryllis - where beauty blooms!');
    }
}
