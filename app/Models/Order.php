<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'selected_seats' => 'array', // <<— penting!
        'go_date'        => 'datetime',
    ];

    public function user()        { return $this->belongsTo(User::class); }
    public function ticket()      { return $this->belongsTo(Ticket::class); }
    public function transaction() { return $this->hasOne(Transaction::class); }
    public function passengers()  { return $this->hasMany(Passenger::class); }
    public function complaints()  { return $this->hasMany(Complaint::class); }
    public function seats()       { return $this->hasMany(\App\Models\OrderSeat::class); }
    public function transactions(){ return $this->hasMany(\App\Models\Transaction::class); } // kalau nggak dipakai, boleh dihapus
}
