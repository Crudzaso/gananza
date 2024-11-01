<?php

namespace Modules\Ticket\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Ticket\Database\Factories\TicketFactory;

class Ticket extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): TicketFactory
    // {
    //     // return TicketFactory::new();
    // }
}
