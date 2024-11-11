<?php

namespace Modules\Payment\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Raffle\Models\Raffle;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'raffle_id', 'amount', 'payment_method', 'payment_date'];

    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

public function raffle()
{
    return $this->belongsTo(Raffle::class, 'raffle_id');
}
}
