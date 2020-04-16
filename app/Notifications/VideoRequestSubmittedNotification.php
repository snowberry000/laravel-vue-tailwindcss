<?php

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VideoRequestSubmittedNotification extends Notification
{
    use Queueable;

    protected $user;
    protected $data;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, array $data)
    {
        $this->user = $user;
        $this->data = $data;
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
        $user = $this->user;
        $data = $this->data;
        return (new MailMessage)
            ->subject("{$user->name}/{$user->username} Submitted video request")
            ->line("Contributor {$user->name} just submitted KYC files.")
            ->line("UID: {$user->uid}")
            ->line("USERNAME: {$user->username}")
            ->line("E-MAIL: {$user->email}")
            ->line("PORTFOLIO: {$data['portfolio']} VIDEO COUNT: {$data['number_of_videos']}")
            ->line("INFORMATION: {$data['information']}")
            ->action('View Portfolio', $data['portfolio']);
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