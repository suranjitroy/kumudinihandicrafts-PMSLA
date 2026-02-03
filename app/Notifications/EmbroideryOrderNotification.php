<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmbroideryOrderNotification extends Notification
{
    use Queueable;

     protected $embOrder, $type;

    /**
     * Create a new notification instance.
     */
    public function __construct($embOrder, $type)
    {
        $this->embOrder = $embOrder;
        $this->type = $type;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {

            if ($this->type === 'pending') {
             return [
            'title'                    => 'Embroidery Order Pending',
            'message'                  => 'New Embroidery Order Submitted (Embroidery No: ' . $this->embOrder->emb_order_no . ')',
            'no'                       => $this->embOrder->emb_order_no,
            'user_id'                  => $this->embOrder->user_id,
            'created_by'               => $this->embOrder->created_by,
            'created_at'               => now(),
            ];
        }

        if ($this->type === 'recommended') {
            return [
            'title'                    => 'Embroidery Order Recommended',
            'message'                  => 'New Embroidery Order Recommended (Embroidery No: ' .$this->embOrder->emb_order_no . ')',
            'no'                       => $this->embOrder->emb_order_no,
            'user_id'                  => $this->embOrder->user_id,
            'approved_by'              => auth()->id(),
            ];
        }

        if ($this->type === 'approved') {
            return [
            'title'                    => 'Embroidery Order Approve',
            'message'                 => 'New Embroidery Order Approve (Embroidery No: ' .$this->embOrder->emb_order_no . ')',
            'no'                   => $this->embOrder->emb_order_no,
            'user_id'              => $this->embOrder->user_id,
            'approved_by'          => auth()->id(),
            ];
        }
        return [
            //
        ];
    }
}
