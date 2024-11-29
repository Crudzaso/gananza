<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Helpers\DiscordNotifier;

class SendLoginNotification
{
    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        DiscordNotifier::notifyEvent('User Logged In', [
            'user_id' => $event->user->id,
            'email' => $event->user->email,
        ]);
    }
}
