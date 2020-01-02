<?php

namespace App\Notifications;

use App\Payout;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PayoutRequestedClient extends Notification
{
    use Queueable;

    protected $payout;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Payout $payout)
    {
        $this->payout = $payout;
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
        $amount = number_format($this->payout->amount / 100, 2);

        return (new MailMessage)
            ->subject("We received your payout request for $ {$amount}")
            ->greeting('Hello!')
            ->line("Thank you for requesting payout of $ {$amount}")
            ->line("We will inform you when the status of your payout will change.");
        // ->action('Notification Action', url('/'))

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