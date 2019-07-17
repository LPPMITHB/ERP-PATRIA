<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PRApproval extends Notification
{
    use Queueable;
    public $purchaseRequisition;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($purchaseRequisition)
    {
        $this->purchaseRequisition = $purchaseRequisition;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        //Custom DB
        return [CustomDB::class];
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

    public function toDatabase($notifiable)
    {
        return [
            'text' => ' until '.$this->activity->name.' for project '.$this->activity->wbs->project->name.' planned start date',
            'title' => 'Activity',
            'url' => '/activity/show/'.$this->activity->id,
            'notification_date' => $this->activity->planned_start_date, //<-- send the id here
        ];
    }
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    // public function toArray($notifiable)
    // {
    //     return [
    //         'data' => $this->activity->name.' for project '.$this->activity->wbs->project->name.' planned start date is near'
    //     ];
    // }
}
