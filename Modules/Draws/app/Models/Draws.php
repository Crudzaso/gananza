<?php

namespace Modules\Draws\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Lotery\Models\Lotery;

class Draws extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'lottery_id',
        'draw_date',
        'winning_numbers',
    ];

    /**
     * Get the lottery associated with the draw.
     */
    public function lottery()
    {
        return $this->belongsTo(Lotery::class);
    }
}
