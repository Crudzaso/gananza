<?php

namespace Modules\Ticket\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Ticket\Database\Factories\TicketFactory;
use Modules\Raffle\Models\Raffle;
use App\Models\User;
use Modules\Multimedia\Models\Multimedia;

class Ticket extends Model
{
    use HasFactory;

    public function raffle()
{
    return $this->belongsTo(Raffle::class, 'raffle_id');
}

public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

public function multimedia()
{
    return $this->morphMany(Multimedia::class, 'model');
}

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): TicketFactory
    // {
    //     // return TicketFactory::new();
    // }
}
