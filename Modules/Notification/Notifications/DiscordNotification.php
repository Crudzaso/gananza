<?php

namespace Modules\Notification\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Modules\Notification\Channel\DiscordChannel as ChannelDiscordChannel;

class DiscordNotification extends Notification
{
    use Queueable;

    public $message;

  
    public function __construct($message)
    {
        $this->message = $message;
    }

    public function via($notifiable)

    {
        return [ChannelDiscordChannel::class];
    }
   
    public function toDiscord($notifiable)
    
     {
        return [
        'content' => $this->message,
        'username' => 'Sistema de notificaciones',
       ];
    }
}
