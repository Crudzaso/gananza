<?php

namespace Modules\Raffle\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User; // Importar User para la relación
use Modules\Lotery\Models\Lotery;
use Modules\Lottery\Models\Lottery; // Importar Lottery para la relación

class Raffle extends Model
{
    use HasFactory;

    protected $fillable = [
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
        return $this->belongsTo(Lotery::class, 'lottery_id');
    }
}
