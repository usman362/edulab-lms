<?php

namespace Modules\LMS\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyCourseStatus extends Notification
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
        // entry alone if mail config is missing — see config/mail.php.
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
        $status = $this->data['course_status'] ?? '';
        $title  = $this->data['course_title'] ?? '';
        $slug   = $this->data['slug'] ?? '';
        $url    = $slug ? url('/course/' . $slug) : url('/');

        return (new MailMessage)
            ->subject('Course status update: ' . $title)
            ->greeting('Hi ' . ($notifiable->name ?? 'there') . ',')
            ->line('Your course "' . $title . '" status has been updated to: ' . $status . '.')
            ->action('View Course', $url)
            ->line('Thank you for using ACE Academic.');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable): array
    {
        return [
            'status' => $this->data['course_status'],
            'title' => $this->data['course_title'],
            'slug' => $this->data['slug'],
        ];
    }
}
