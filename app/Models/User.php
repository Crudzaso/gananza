<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Modules\Payment\Models\Payment;
use Modules\Raffle\Models\Raffle;
use Modules\Reward\Models\Reward;
use Modules\Ticket\Models\Ticket;

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

    public function payments()
{
    return $this->hasMany(Payment::class, 'user_id');
}

public function organizedRaffles()
{
    return $this->hasMany(Raffle::class, 'organizer_id');
}

public function tickets()
{
    return $this->hasMany(Ticket::class, 'user_id');
}

public function rewards()
{
    return $this->hasMany(Reward::class, 'user_id');
}
}
