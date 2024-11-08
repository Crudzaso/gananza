<?php

namespace Modules\Ticket\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Raffle\Models\Raffle; // Importar el modelo de Raffle
use App\Models\User; // Importar el modelo de User

class Ticket extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'raffle_id', 
        'user_id', 
        'ticket_number', 
        'purchase_date', 
        'end_date', 
        'verification_code',
    ];

    /**
     * Relación de un ticket con una rifa (Raffle).
     * Un ticket pertenece a una rifa.
     */
    public function raffle()
    {
        return $this->belongsTo(Raffle::class, 'raffle_id');
    }

    /**
     * Relación de un ticket con un usuario (User).
     * Un ticket pertenece a un usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
