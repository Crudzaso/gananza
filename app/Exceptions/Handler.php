<?php

namespace App\Exceptions;

use App\Helpers\DiscordNotifier;
use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * Lista de excepciones que no serán reportadas.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        \Illuminate\Validation\ValidationException::class,
        \Illuminate\Session\TokenMismatchException::class,
    ];

    /**
     * Reporta las excepciones.
     *
     * @param  \Throwable  $exception
     * @return void
     * @throws \Throwable
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);

        if ($this->shouldReportToDiscord($exception)) {
            DiscordNotifier::notifyException($exception);
        }
    }

    /**
     * Determina si la excepción debe reportarse a Discord.
     *
     * @param  \Throwable  $exception
     * @return bool
     */
    protected function shouldReportToDiscord(Throwable $exception): bool
    {
        // Filtrar excepciones no reportables
        return !$this->shouldntReport($exception);
    }
}
