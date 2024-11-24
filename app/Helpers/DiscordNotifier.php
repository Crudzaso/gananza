<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class DiscordNotifier
{
    protected static $webhookUrl = 'https://discord.com/api/webhooks/1310023183461646406/m4tupDKnQ05qMoUs8eARIYzg0v2rLjTB1Degz98JQrOzWy2Z5mALup4RQOQlH3kC_o__';

    public static function send($message)
    {
        if (self::$webhookUrl) {
            Http::post(self::$webhookUrl, [
                'content' => $message,
            ]);
        }
    }

    public static function notifyException(\Throwable $exception)
    {
        $message = "**Exception Alert**\n"
            . "**Message:** {$exception->getMessage()}\n"
            . "**File:** {$exception->getFile()}:{$exception->getLine()}\n"
            . "**Trace:** ```{$exception->getTraceAsString()}```";
        
        self::send($message);
    }

    public static function notifyEvent($eventType, $details = [])
    {
        $message = "**Event Notification**\n"
            . "**Type:** {$eventType}\n"
            . "**Details:** " . json_encode($details, JSON_PRETTY_PRINT);
        
        self::send($message);
    }
}
