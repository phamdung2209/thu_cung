<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PayoutNotification extends Notification
{
    use Queueable;

    protected $user;
    protected $amount;
    protected $status;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $amount, $status = '')
    {
        $this->user = $user;
        $this->amount = $amount;
        $this->status = $status;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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
            'user_id'        => $this->user['id'],
            'user_type'      => $this->user['user_type'],
            'name'           => $this->user['name'],
            'payment_amount' => $this->amount, 
            'status'         => $this->status
        ];
    }
}
