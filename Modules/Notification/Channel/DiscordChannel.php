<?php

namespace Modules\Notification\Channel;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class DiscordChannel
{
    public function send($notifiable,$notification)
    {
        if (method_exists($notification, 'toDiscord')) {
            $data = $notification->toDiscord($notifiable);
            $webhookUrl = config('services.discord.webhook_url');

            Http::post($webhookUrl, $data);
        }
    }
}
