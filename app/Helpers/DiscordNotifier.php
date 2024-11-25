<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class DiscordNotifier
{
    public static function send($message)
    {
        $webhookUrl = env('DISCORD_WEBHOOK_URL');

        if ($webhookUrl) {
            Http::post($webhookUrl, [
                'content' => $message,
            ]);
        }
    }

    public static function notifyException(\Throwable $exception)
    {
        $trace = substr($exception->getTraceAsString(), 0, 1800); // Límite ajustado para Discord
        $message = "**Exception Alert**\n"
            . "**Message:** {$exception->getMessage()}\n"
            . "**File:** {$exception->getFile()}:{$exception->getLine()}\n"
            . "**Trace:** ```{$trace}```";

        self::send($message);
    }

   public static function notifyEvent($eventType, $details = [])
{
    $webhookUrl = env('DISCORD_WEBHOOK_URL');

    if ($webhookUrl) {
        $logoUrl = 'https://755e-186-113-97-221.ngrok-free.app/gananza-logov1.png';
        $embed = [
            'title' => '🔔 Gananza Alerts',
            'description' => "Se ha detectado un evento: **{$eventType}**.",
            'color' => 7506394, // Color (ejemplo: azul)
            'fields' => [],
            'footer' => [
                'text' => 'Notificaciones del Sistema',
                'icon_url' => $logoUrl, // Cambiar al logo de tu sitio
            ],
            'timestamp' => now()->toIso8601String(),
        ];

        // Añadir los detalles al mensaje si están disponibles
        foreach ($details as $key => $value) {
            $embed['fields'][] = [
                'name' => ucfirst($key),
                'value' => $value,
                'inline' => true,
            ];
        }

        Http::post($webhookUrl, [
            'embeds' => [$embed],
            'username' => 'Sistema de Notificaciones', // Nombre personalizado
            'avatar_url' => $logoUrl, // Cambiar al logo de tu sitio
        ]);
    }
}
}
