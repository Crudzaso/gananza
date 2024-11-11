<?php

namespace Modules\Raffle\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User; // Importar User para la relación
use Modules\Lottery\Models\Lottery; // Importar Lottery para la relación
use Modules\Multimedia\Models\Multimedia;
use Modules\Ticket\Models\Ticket;

class Raffle extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'organizer_id',
        'lottery_id',
        'ticket_price',
        'total_tickets',
        'tickets_sold',
        'description',
        'start_date',
        'end_date',
    ];

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function lottery()
    {
        return $this->belongsTo(Lottery::class, 'lottery_id');
    }
        public function multimedia()
{
    return $this->hasMany(Multimedia::class);
}

public function tickets()
{
    return $this->hasMany(Ticket::class, 'raffle_id');
}
}
