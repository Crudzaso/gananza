<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
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

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function routeNotificationForWebhook()
    {
        return env('DISCORD_WEBHOOK_URL');
    }


    public function roles()
    {
        return $this->belongsToMany(
            Role::class,                 // El modelo relacionado
            'model_has_roles',           // Nombre de la tabla intermedia
            'model_id',                  // Columna que hace referencia al modelo "User"
            'role_id'                    // Columna que hace referencia al modelo "Role"
        )
        ->wherePivot('model_type', 'App\Models\User'); // Filtra por el tipo de modelo
    }

    /**
     * Relación con permisos
     */
    public function permissions()
    {
        return $this->belongsToMany(
            Permission::class,           // El modelo relacionado
            'model_has_permissions',     // Nombre de la tabla intermedia
            'model_id',                  // Columna que hace referencia al modelo "User"
            'permission_id'              // Columna que hace referencia al modelo "Permission"
        )
        ->wherePivot('model_type', 'App\Models\User'); // Filtra por el tipo de modelo
    }
}
