<?php

namespace App\Http\Middleware;

use Closure;
use Throwable;
use App\Helpers\DiscordNotifier;
use Illuminate\Support\Facades\Log;

class HandleExceptions
{
    public function handle($request, Closure $next)
    {
        try {
            return $next($request);
        } catch (Throwable $e) {
            $this->reportToDiscord($e); // Enviar notificación a Discord
            throw $e; // Volver a lanzar la excepción para que el sistema maneje la excepción
        }
    }

    protected function reportToDiscord(Throwable $exception)
    {

        Log::info('Enviando excepción a Discord: ' . $exception->getMessage());

        $message = "**🚨 Excepción Crítica**\n"
            . "**Mensaje:** {$exception->getMessage()}\n"
            . "**Archivo:** {$exception->getFile()}:{$exception->getLine()}\n"
            . "**Trace:** ```" . substr($exception->getTraceAsString(), 0, 1800) . "```";

        DiscordNotifier::send($message); // Enviar a Discord
    }
}
