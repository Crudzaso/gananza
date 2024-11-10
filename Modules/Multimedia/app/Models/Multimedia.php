<?php

namespace Modules\Multimedia\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Multimedia\Database\Factories\MultimediaFactory;
use Modules\Raffle\Models\Raffle;

class Multimedia extends Model
{
    use HasFactory;

       public function raffle()
    {
        return $this->belongsTo(Raffle::class);
    }

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): MultimediaFactory
    // {
    //     // return MultimediaFactory::new();
    // }
}
