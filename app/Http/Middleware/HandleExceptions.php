<?php

namespace App\Http\Middleware;

use Closure;
use Throwable;
use App\Helpers\DiscordNotifier;

class HandleExceptions
{
    public function handle($request, Closure $next)
    {
        try {
            return $next($request);
        } catch (Throwable $e) {
            $this->reportToDiscord($e); // Enviar notificación a Discord
            throw $e; // Rethrow para permitir que el sistema maneje la excepción
        }
    }

    protected function reportToDiscord(Throwable $exception)
    {
        $message = "**🚨 Excepción Crítica**\n"
            . "**Mensaje:** {$exception->getMessage()}\n"
            . "**Archivo:** {$exception->getFile()}:{$exception->getLine()}\n"
            . "**Trace:** ```" . substr($exception->getTraceAsString(), 0, 1800) . "```";

        DiscordNotifier::send($message);
    }
}
