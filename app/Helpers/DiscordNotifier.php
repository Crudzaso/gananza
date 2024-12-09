<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class DiscordNotifier
{
    public static function send($message, $embed = [])
    {
        $webhookUrl = env('DISCORD_WEBHOOK_URL');
    
        if ($webhookUrl) {
            $payload = [
                'content' => $message,
                'embeds' => $embed ? [$embed] : [],
            ];
    
            try {
                $response = Http::post($webhookUrl, $payload);
    
                if ($response->successful()) {
                    Log::info('Notificación enviada a Discord correctamente.');
                } else {
                    Log::error('Error al enviar notificación a Discord. Código de error: ' . $response->status());
                }
            } catch (\Exception $e) {
                Log::error('Error al intentar enviar la solicitud a Discord: ' . $e->getMessage());
            }
        } else {
            Log::error('La URL del Webhook de Discord no está configurada.');
        }
    }
    
    
    

    public static function notifyException(Throwable $exception)
    {
        $webhookUrl = env('DISCORD_WEBHOOK_URL');
    
        if ($webhookUrl) {
            // Construir el mensaje de la excepción
            $message = "**🚨 Excepción Crítica**\n"
                . "**Mensaje:** {$exception->getMessage()}\n"
                . "**Archivo:** {$exception->getFile()}:{$exception->getLine()}\n"
                . "**Trace:** ```" . substr($exception->getTraceAsString(), 0, 1800) . "```";
    
            // Crear el embed para Discord
            $embed = [
                'title' => '🚨 Error Crítico del Sistema',
                'description' => $message,
                'color' => 16711680, // Rojo para alertas
                'footer' => [
                    'text' => 'Notificaciones de Excepciones',
                    'icon_url' => asset('images/logo.png'), // Asegúrate de que esta URL sea válida
                ],
                'timestamp' => now()->toIso8601String(),
            ];
    
            // Enviar el embed a Discord
            self::send('', $embed);
        }
    }
    
    
    
    
    
    public static function notifyEvent($eventType, $details = [], $imageUrl = null)
    {
        $webhookUrl = env('DISCORD_WEBHOOK_URL');
    
        if ($webhookUrl) {
            $logoUrl = $imageUrl ?? asset('https://gananza.crudzaso.com/assets/media/auth/agency-dark.png'); // Imagen por defecto
            $embed = [
                'title' => "🔔 {$eventType}",
                'description' => "Un nuevo evento ha sido detectado: **{$eventType}**.",
                'color' => 7506394,
                'fields' => [],
                'footer' => [
                    'text' => 'Sistema de Notificaciones',
                    'icon_url' => $logoUrl,
                ],
                'timestamp' => now()->toIso8601String(),
                'thumbnail' => [
                    'url' => $logoUrl, 
                ],
            ];
    
            foreach ($details as $key => $value) {
                $embed['fields'][] = [
                    'name' => ucfirst($key),
                    'value' => $value,
                    'inline' => true,
                ];
            }

            
    
            // Enviar el mensaje a Discord
            self::send('', $embed);
        }
    }
    
}
