<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OtherOrderSheetNotification extends Notification
{
    use Queueable;

    protected $otherordersheet, $type;
    /**
     * Create a new notification instance.
     */
    public function __construct($otherordersheet, $type)
    {
        $this->otherordersheet = $otherordersheet;
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
    // public function toMail(object $notifiable): MailMessage
    // {
    //     return (new MailMessage)
    //                 ->line('The introduction to the notification.')
    //                 ->action('Notification Action', url('/'))
    //                 ->line('Thank you for using our application!');
    // }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {

        if ($this->type === 'pending') {
             return [
            'title'             => 'Other Order Pending',
            'message'           => 'Other Order Submitted (Otherordersheet No: ' . $this->otherordersheet->other_order_no . ')',
            'requsition_no'    => $this->otherordersheet->other_order_no,
            'section_id'        => $this->otherordersheet->section_id,
            'user_id'           => $this->otherordersheet->user_id,
            'created_by'        => $this->otherordersheet->created_by,
            'created_at'        => now(),
            ];
        }

        if ($this->type === 'recommended') {
            return [
                'title'             => 'Other Order Recommended',
                'message'           => 'Other Order is recommended',
                'requsition_no'     => $this->otherordersheet->other_order_no,
                'section_id'        => $this->otherordersheet->section_id,
                'user_id'           => $this->otherordersheet->user_id,
                'approved_by'       => auth()->id(),
            ];
        }

        if ($this->type === 'approved') {
            return [
                'title'             => 'Other Order Approved',
                'message'           => 'Other Order is approved',
                'requsition_no'     => $this->otherordersheet->other_order_no,
                'section_id'        => $this->otherordersheet->section_id,
                'user_id'           => $this->otherordersheet->user_id,
                'approved_by'       => auth()->id(),
            ];
        }

        return [];
       
    }
}
