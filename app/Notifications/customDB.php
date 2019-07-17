<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class CustomDB
{

  public function send($notifiable, Notification $notification)
  {
    $data = $notification->toDatabase($notifiable);
    return $notifiable->routeNotificationFor('database')->create([
        'id' => $notification->id,
        'type' => get_class($notification),
        //customize here
        'notification_date' => $data['notification_date'],
        'role_id' => \Auth::user()->role_id, //<-- comes from toDatabase() Method below
        'data' => $data,
        'read_at' => null,
    ]);
  }

}
