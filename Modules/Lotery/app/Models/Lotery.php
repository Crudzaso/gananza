<?php

namespace Modules\Lotery\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Lotery\Database\Factories\LoteryFactory;

class Lotery extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): LoteryFactory
    // {
    //     // return LoteryFactory::new();
    // }
}
