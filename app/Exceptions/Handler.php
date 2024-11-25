<?php

namespace App\Exceptions;

use Throwable;
use App\Helpers\DiscordNotifier;
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

        // Reporta la excepción a Discord si debe reportarse
        if ($this->shouldReport($exception)) {
            DiscordNotifier::notifyException($exception);
        }
    }
}
