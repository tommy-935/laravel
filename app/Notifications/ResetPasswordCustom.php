<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordCustom extends Notification
{
    use Queueable;
    public string $token;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $token)
    {
        // Initialize the token property
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        /*
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
            */

            $frontendUrl = config('app.url', 'http://localhost:8000');
            $resetLink = $frontendUrl . '/reset-password?token=' . $this->token . '&email=' . urlencode($notifiable->email);
    
            return (new MailMessage)
                ->subject('Reset Password Notification')
                ->line('You requested to reset your password.')
                ->action('Reset Password', $resetLink)
                ->line('If you did not request a password reset, no further action is required.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
