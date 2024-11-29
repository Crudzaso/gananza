<?php

namespace App\Exceptions;

use Throwable;
use App\Helpers\DiscordNotifier;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    protected $dontReport = [
        \Illuminate\Validation\ValidationException::class,
        \Illuminate\Session\TokenMismatchException::class,
    ];

    public function report(Throwable $exception)
    {
        // Notifica a Discord si no está en la lista de exclusión
        if ($this->shouldReport($exception)) {
            try {
                $this->notifyDiscord($exception);
            } catch (Throwable $e) {
                // Evitar que fallos en la notificación rompan el flujo
                logger()->error("Error al enviar notificación a Discord: " . $e->getMessage());
            }
        }

        parent::report($exception);
    }

    protected function notifyDiscord(Throwable $exception)
{
    $details = [
        'message' => $exception->getMessage(),
        'file' => "{$exception->getFile()}:{$exception->getLine()}",
        'trace' => substr($exception->getTraceAsString(), 0, 1800), 
    ];

    // Logea el error antes de enviarlo a Discord
    logger()->error('Excepción capturada', $details);

    // Envía la notificación a Discord
    DiscordNotifier::notifyEvent(
        'Excepción en el sistema 🚨',
        $details,
        asset('images/logo.png') 
    );
}
}
