<?php

namespace Modules\Reward\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reward extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables de forma masiva.
     */
    protected $fillable = [
        'user_id',         // ID del usuario al que se le asignan los puntos
        'points',          // Puntos acumulados
        'redeemed_points', // Puntos canjeados
    ];

    /**
     * Relación con el modelo User.
     * Un usuario puede tener una recompensa.
     */
       public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}
}
