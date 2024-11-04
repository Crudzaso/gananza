<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class DiscordNotification extends Notification
{
    private $name;
    private $email;
    public function __construct($name, $email)
    {
        $this->name = $name;
        $this->email = $email;
    }
    public function via($notifiable)
    {
        return [\App\Notifications\Channels\DiscordChannel::class];
    }
    public function toDiscord($notifiable)
    {
        // Obtener la URL base de la aplicación
        // Construir la URL completa al logo
        $logoUrl = 'http://127.0.0.1:8000/assets/media/auth/Logo-Gananza1.svg';
        return [
            'content' => 'Nuevo registro de usuario',
            'embeds' => [
                [
                    'title' => 'Nuevo Registro de Usuario',
                    'type' => 'rich',
                    'color' => 7506394,
                    'description' => "Un nuevo usuario se ha registrado a través de Google.",
                    'thumbnail' => [
                        'url' => $logoUrl
                    ],
                    'fields' => [
                        [
                            'name' => 'Nombre',
                            'value' => $this->name,
                            'inline' => true
                        ],
                        [
                            'name' => 'Correo',
                            'value' => $this->email,
                            'inline' => true
                        ],
                        [
                            'name' => 'Fecha',
                            'value' => now()->format('Y-m-d H:i:s'),
                            'inline' => true
                        ]
                    ],
                    'footer' => [
                        'text' => 'Gananza',
                        'icon_url' => $logoUrl
                    ],
                    'timestamp' => now()->toIso8601String()
                ]
            ]
        ];
    }
}
