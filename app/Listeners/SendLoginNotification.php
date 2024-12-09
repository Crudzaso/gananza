<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Helpers\DiscordNotifier;
use Illuminate\Auth\Events\Logout;

class SendLoginNotification
{
    /**
     * Handle the event.
     *
     * @param  mixed  $event
     * @return void
     */
    public function handle($event)
    {
        if ($event instanceof Login) {
            DiscordNotifier::notifyEvent('User Logged In', [
                'User ID' => $event->user->id,
                'Email' => $event->user->email,
                'Login Time' => now()->toDateTimeString(),
            ], 'https://cdn0.iconfinder.com/data/icons/very-basic-android-l-lollipop-icon-pack/24/key-256.png'); 
        }

        if ($event instanceof Logout) {
            DiscordNotifier::notifyEvent('User Logged Out', [
                'User ID' => $event->user->id,
                'Email' => $event->user->email,
                'Logout Time' => now()->toDateTimeString(),
            ], 'https://cdn3.iconfinder.com/data/icons/remixicon-system/24/login-box-line-256.png');
        }
    }
}
