<?php

namespace Modules\Raffle\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Raffle\Database\Factories\RaffleFactory;

class Raffle extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): RaffleFactory
    // {
    //     // return RaffleFactory::new();
    // }
}
