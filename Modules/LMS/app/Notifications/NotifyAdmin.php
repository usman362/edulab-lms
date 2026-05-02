<?php

namespace Modules\LMS\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyAdmin extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected $data)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        // Email is delivered only when SMTP is configured. Falls back to database
        // entry alone if mail config is missing.
        $channels = ['database'];
        if (config('mail.default') && config('mail.mailers.' . config('mail.default') . '.host')) {
            $channels[] = 'mail';
        }
        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        $title = $this->data['title'] ?? 'Admin notification';
        $body  = $this->data['body'] ?? $this->data['message'] ?? 'You have a new notification on ACE Academic.';
        $url   = $this->data['url'] ?? url('/dashboard');

        return (new MailMessage)
            ->subject($title)
            ->greeting('Hi Admin,')
            ->line($body)
            ->action('Open Dashboard', $url)
            ->line('— ACE Academic');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable): array
    {
        return $this->data;
    }
}
