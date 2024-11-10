<?php

namespace Modules\Payment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Payment\Database\Factories\PaymentFactory;
use Modules\Raffle\Models\Raffle;
use App\Models\User;

class Payment extends Model
{
    use HasFactory;

    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

public function raffle()
{
    return $this->belongsTo(Raffle::class, 'raffle_id');
}

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): PaymentFactory
    // {
    //     // return PaymentFactory::new();
    // }
}
