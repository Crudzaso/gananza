<?php

namespace Modules\Multimedia\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Multimedia\Database\Factories\MultimediaFactory;

class Multimedia extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): MultimediaFactory
    // {
    //     // return MultimediaFactory::new();
    // }
}
