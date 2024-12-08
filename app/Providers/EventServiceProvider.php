<?php

namespace App\Providers;

use App\Listeners\SendHttpErrorNotification;
use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Listeners\SendLoginNotification;
use Illuminate\Auth\Events\Logout;
use Symfony\Component\HttpKernel\Exception\HttpException;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Login::class => [
            SendLoginNotification::class,
        ],
        Logout::class => [
            SendLoginNotification::class,
        ],
    ];


    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
