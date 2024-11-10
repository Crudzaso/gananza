<?php

namespace Modules\Draws\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Draws\Database\Factories\DrawsFactory;
use Modules\Lottery\Models\Lottery;

class Draws extends Model
{
    use HasFactory;

    public function lottery()
{
    return $this->belongsTo(Lottery::class, 'lottery_id');
}

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): DrawsFactory
    // {
    //     // return DrawsFactory::new();
    // }
}
