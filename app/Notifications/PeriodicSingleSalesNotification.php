<?php

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PeriodicSingleSalesNotification extends Notification
{
    use Queueable;

    protected $user;
    protected $value;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, int $value)
    {
        $this->user = $user;
        $this->value = $value;
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
        $value = number_format($this->value, 2);

        return (new MailMessage)
            ->greeting("Hello {$this->user->name}")
            ->line("During last week your images made __$ {$value}__. Visit contributor portal to view your earnings and payout information in more detail.")
            ->action('Visit Contributor Portal', url(route('home')))
            ->line('More images means more sales, why not too upload more.')
            ->line('Thanks for choosing us as your partner.');
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