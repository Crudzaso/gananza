<?php

namespace Modules\Lottery\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Lottery\Database\Factories\LotteryFactory;
use Modules\Raffle\Models\Raffle;
use Modules\Draws\Models\Draws;

class Lottery extends Model
{
    use HasFactory;

    public function raffles()
{
    return $this->hasMany(Raffle::class, 'lottery_id');
}

public function draws()
{
    return $this->hasMany(Draws::class, 'lottery_id');
}

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'description',
        'url_imagen'
    ];

     protected static function newFactory()
    {
        return \Modules\Lottery\Database\Factories\LotteryFactory::new();
    }
}

