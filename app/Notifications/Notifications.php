<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Notifications extends Notification
{
    use Queueable;
    private $title;
    private $body;
    private $property_id;

    public function __construct($title,$body,$property_id)
    {
        $this->title = $title;
        $this->body = $body;
        $this->property_id = $property_id;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->title,
            'body'=> $this->body,
            'property_id'=> $this->property_id
        ];
    }
}
