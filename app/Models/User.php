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
            DiscordNotifier::notifyEvent('User Created', [
                'id' => $model->id,
                'attributes' => $model->getAttributes(),
            ]);
        });

        // Evento cuando el modelo es actualizado
        static::updated(function ($model) {
            DiscordNotifier::notifyEvent('User Updated', [
                'id' => $model->id,
                'changes' => $model->getChanges(),
            ]);
        });

        // Evento cuando el modelo es eliminado
        static::deleted(function ($model) {
            DiscordNotifier::notifyEvent('User Deleted', [
                'id' => $model->id,
            ]);
        });
    }

}
