<?php
namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;
use App\Helpers\DiscordNotifier;
use Illuminate\Support\Facades\Log;

class Handler extends ExceptionHandler
{
    /**
     * Report the exception.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);

        // Log para depuración
        Log::info('Se está reportando una excepción: ' . $exception->getMessage());

        // Captura excepciones personalizadas y envíalas a Discord
        if ($this->shouldReport($exception)) {
            DiscordNotifier::notifyException($exception); // Notificar a Discord
        }

        // Captura errores HTTP (como 404, 500, etc.) y envíalos a Discord
        if ($exception instanceof HttpException) {
            // Aquí puedes poner un log adicional o realizar otra acción si es necesario.
            Log::info("Capturado error HTTP: " . $exception->getStatusCode());
            DiscordNotifier::notifyEvent("HTTP Error: " . $exception->getStatusCode(), [
                'Status Code' => $exception->getStatusCode(),
                'Error Message' => $exception->getMessage(),
                'URL' => request()->url(),
                'Timestamp' => now()->toDateTimeString(),
            ]);
        }
    }

    /**
     * Determine if the exception should be reported.
     *
     * @param  \Throwable  $exception
     * @return bool
     */
    public function shouldReport(Throwable $exception)
    {
        // Reportar todos los errores HTTP, incluyendo 404 y 500
        if ($exception instanceof HttpException) {
            return true;  // Se reporta cualquier error HTTP (404, 500, etc.)
        }

        // Puedes agregar más excepciones personalizadas aquí si es necesario
        return parent::shouldReport($exception);
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        // Renderizar errores HTTP (como 404, 500) de forma personalizada
        if ($exception instanceof HttpException) {
            return response()->json([
                'message' => 'Error HTTP detectado.',
                'error' => $exception->getMessage(),
            ], $exception->getStatusCode());
        }

        return parent::render($request, $exception);
    }
}
