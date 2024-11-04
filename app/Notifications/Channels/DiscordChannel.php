<?php

namespace App\Notifications\Channels;

use App\Notifications\DiscordNotification;
use GuzzleHttp\Client;

class DiscordChannel
{
    public function send($notifiable, DiscordNotification $notification)
    {
        if (method_exists($notification, 'toDiscord')) {
            $message = $notification->toDiscord($notifiable);

            $client = new Client();
            $response = $client->post(config('services.discord.webhook_url'), [
                'headers' => ['Content-Type' => 'application/json'],
                'json' => $message
            ]);

            return $response;
        }
    }
}
