<?php

namespace App\Notifications;

use App\Payout;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PayoutRequested extends Notification
{
    use Queueable;

    protected $payout;
    protected $user;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Payout $payout, User $user)
    {
        $this->payout = $payout;
        $this->user = $user;
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
        $payout = $this->payout;
        $user = $this->user;
        return (new MailMessage)
            ->subject("{$user->name} requested a payout for ${amount}")
            ->line("---------------------------------------------------------------------------")
            ->line("UID: {$user->uid}")
            ->line("NAME: {$user->name}")
            ->line("EMAIL: {$user->email}")
            ->line("AMOUNT: $ {$amount}")
            ->line("MEMO: {$payout->memo}")
            ->line("---------------------------------------------------------------------------");
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