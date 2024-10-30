<?php

namespace Modules\Reward\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Reward\Database\Factories\RewardFactory;

class Reward extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): RewardFactory
    // {
    //     // return RewardFactory::new();
    // }
}
