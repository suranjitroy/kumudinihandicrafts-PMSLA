<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StoreRequsitionNotification extends Notification
{
    use Queueable;

    protected $requsition, $type;

    /**
     * Create a new notification instance.
     */
    public function __construct($requsition, $type)
    {
        $this->requsition = $requsition;
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
    public function toDatabase(object $notifiable)
    {

        if ($this->type === 'pending') {
             return [
            'title'             => 'New Store Requisition Pending',
            'message'           => 'New Requisition Submitted (Requsition No: ' . $this->requsition->requsition_no . ')',
            'requsition_no'     => $this->requsition->requsition_no,
            'section_id'        => $this->requsition->section_id,
            'user_id'           => $this->requsition->user_id,
            'created_by'        => $this->requsition->created_by,
            'created_at'        => now(),
            ];
        }

        if ($this->type === 'recommended') {
            return [
                'title'             => 'Store Requisition Recommended',
                'message'           => 'Store Requisition is recommended',
                'requsition_no'     => $this->requsition->requsition_no,
                'section_id'        => $this->requsition->section_id,
                'user_id'           => $this->requsition->user_id,
                'approved_by'       => auth()->id(),
            ];
        }

        if ($this->type === 'approved') {
            return [
                'title'             => 'Store Requisition Approved',
                'message'           => 'Store Requisition is approved',
                'requsition_no'     => $this->requsition->requsition_no,
                'section_id'        => $this->requsition->section_id,
                'user_id'           => $this->requsition->user_id,
                'approved_by'       => auth()->id(),
            ];
        }

        return [];
       
    }
}
