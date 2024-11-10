<?php

namespace Modules\Raffle\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Raffle\Database\Factories\RaffleFactory;
use Modules\Multimedia\Models\Multimedia;
use App\Models\User;
use Modules\Ticket\Models\Ticket;
use Modules\Lottery\Models\Lottery;

class Raffle extends Model
{
    use HasFactory;


    public function multimedia()
{
    return $this->hasMany(Multimedia::class);
}

public function organizer()
{
    return $this->belongsTo(User::class, 'organizer_id');
}

public function lottery()
{
    return $this->belongsTo(Lottery::class, 'lottery_id');
}

public function tickets()
{
    return $this->hasMany(Ticket::class, 'raffle_id');
}


    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'ticket_price',
        'total_tickets',
        'tickets_sold',
        'description',
        'start_date',
        'end_date'
    ];

    // protected static function newFactory(): RaffleFactory
    // {
    //     // return RaffleFactory::new();
    // }
}
