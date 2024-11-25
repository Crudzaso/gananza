<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class DiscordNotifier
{
    public static function send($message, $embed = [])
    {
        $webhookUrl = env('DISCORD_WEBHOOK_URL');

        if ($webhookUrl) {
            $payload = [
                'content' => $message,
            ];

            if (!empty($embed)) {
                $payload['embeds'] = [$embed];
            }

            Http::post($webhookUrl, $payload);
        }
    }

    public static function notifyException(\Throwable $exception)
    {
        $trace = substr($exception->getTraceAsString(), 0, 1800); // Discord tiene límites.
        $message = "**🚨 Exception Alert**\n"
            . "**Mensaje:** {$exception->getMessage()}\n"
            . "**Archivo:** {$exception->getFile()}:{$exception->getLine()}\n"
            . "**Trace:** ```{$trace}```";

        self::send($message);
    }

    public static function notifyEvent($eventType, $details = [], $imageUrl = null)
    {
        $webhookUrl = env('DISCORD_WEBHOOK_URL');

        if ($webhookUrl) {
            $logoUrl = $imageUrl ?? asset('logo.png'); // Imagen por defecto
            $embed = [
                'title' => '🔔 Notificación del Sistema',
                'description' => "Se ha detectado un evento: **{$eventType}**.",
                'color' => 7506394, // Color (hex: #72A0C1)
                'fields' => [],
                'footer' => [
                    'text' => 'Notificaciones del Sistema',
                    'icon_url' => $logoUrl,
                ],
                'timestamp' => now()->toIso8601String(),
            ];

            // Agregar detalles al mensaje.
            foreach ($details as $key => $value) {
                $embed['fields'][] = [
                    'name' => ucfirst($key),
                    'value' => $value,
                    'inline' => true,
                ];
            }

            self::send('', $embed);
        }
    }
}
