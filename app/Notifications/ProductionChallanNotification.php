<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProductionChallanNotification extends Notification
{
    use Queueable;

        protected $proChallan, $type;

    /**
     * Create a new notification instance.
     */
    public function __construct($proChallan, $type)
    {
        $this->proChallan = $proChallan;
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
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {

        if ($this->type === 'pending') {
             return [
            'title'                    => 'Production Challan Pending',
            'message'                  => 'New Production Challan Submitted (Challan No: ' . $this->proChallan->pro_challan_no . ')',
            'no'            => $this->proChallan->pro_challan_no,
            'production_work_order_id' => $this->proChallan->production_work_order_id,
            'user_id'                  => $this->proChallan->user_id,
            'created_by'               => $this->proChallan->created_by,
            'created_at'               => now(),
            ];
        }

        if ($this->type === 'recommended') {
            return [
            'title'                    => 'Production Challan Recommended',
            'message'                  => 'New Production Challan Recommended (Challan No: ' .$this->proChallan->pro_challan_no . ')',
            'no'                       => $this->proChallan->pro_challan_no,
            'production_work_order_id' => $this->proChallan->production_work_order_id,
            'user_id'                  => $this->proChallan->user_id,
            'approved_by'              => auth()->id(),
            ];
        }

        if ($this->type === 'approved') {
            return [
                'title'                => 'Production Challan Approved',
                'message'              => 'New Production Challan Approved (Challan No: ' . $this->proChallan->pro_challan_no . ')',
                'no'                   => $this->proChallan->pro_challan_no,
                'production_work_order_id' => $this->proChallan->production_work_order_id,
                'user_id'              => $this->proChallan->user_id,
                'approved_by'          => auth()->id(),
            ];
        }

        return [
            //
        ];
    }
}
