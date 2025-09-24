<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderSeat extends Model
{
    protected $guarded = ['id'];

    public function order() { return $this->belongsTo(Order::class); }
    public function ticket() { return $this->belongsTo(Ticket::class); }
}
