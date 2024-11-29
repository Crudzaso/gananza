<?php

namespace App\Models;

use App\Helpers\DiscordNotifier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasProfilePhoto, Notifiable, TwoFactorAuthenticatable;
    use HasRoles;

    protected $fillable = [
        'name',
        'lastname',
        'document',
        'document_type',
        'phone_number',
        'email',
        'password',
        'google_id',
        'github_id',
        'profile_photo_path',
        'document_image_path',

    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function routeNotificationForWebhook()
    {
        return env('DISCORD_WEBHOOK_URL');
    }

    protected static function boot()
    {
        parent::boot();

        // Evento cuando el modelo es creado
        static::created(function ($model) {
            $createdBy = auth()->user();
            DiscordNotifier::notifyEvent('Usuario Creado', [
                'ID Usuario Creado' => $model->id,
                'Nombre Usuario Creado' => $model->name,
                'ID Quien Creó' => $createdBy->id ?? 'Desconocido',
                'Nombre Quien Creó' => $createdBy->name ?? 'Desconocido',
            ],
                asset('images/logo.png')
            );
        });

        // Evento cuando el modelo es actualizado
        static::updated(function ($model) {
            DiscordNotifier::notifyEvent('Usuario actualizado', [
                'ID Usuario Actualizado' => $model->id,
                'Nombre Usuario Actualizado' => $model->name,
                'Cambios Realizados' => json_encode($model->getChanges()), // Cambios realizados en formato JSON
                'ID Quien Actualizó' => $updatedBy->id ?? 'Desconocido',
                'Nombre Quien Actualizó' => $updatedBy->name ?? 'Desconocido',
            ],
                asset('images/logo.png') 
            );
        });

        // Evento cuando el modelo es eliminado
        static::deleted(function ($model) {
        $deletedBy = auth()->user(); // Usuario autenticado
        DiscordNotifier::notifyEvent(
            'Usuario Borrado',
            [
                'ID Usuario Eliminado' => $model->id,
                'Nombre Usuario Eliminado' => $model->name,
                'ID Quien Eliminó' => $deletedBy->id ?? 'Desconocido',
                'Nombre Quien Eliminó' => $deletedBy->name ?? 'Desconocido',
            ],
            asset('images/logo.png') // Ruta de imagen pública
        );
    });
    }

}
