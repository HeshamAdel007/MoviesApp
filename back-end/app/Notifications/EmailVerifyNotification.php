<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailVerifyNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // Link Rouer Value
        $params =  [
            'id'      => $notifiable->getKey(),
            'hash'    => sha1($notifiable->getEmailForVerification()),
        ];

        // Link Front-End App + Api Router + Rouer Value
        $url = "http://localhost:3000/auth/email/verification?";

        // Add Value To Link
        foreach ($params as $key => $param) {
            $url .= "{$key}={$param}&";
        }

        return (new MailMessage)
                ->line('The Verify E-Mail')
                ->action('Verify Email', $url)
                ->line('Thank You For Using Our Application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
