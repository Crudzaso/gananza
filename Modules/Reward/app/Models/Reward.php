<?php

namespace Modules\Reward\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Reward\Database\Factories\RewardFactory;
use App\Models\User;

class Reward extends Model
{
    use HasFactory;

    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): RewardFactory
    // {
    //     // return RewardFactory::new();
    // }
}
