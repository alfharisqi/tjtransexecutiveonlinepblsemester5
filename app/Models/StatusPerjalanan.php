<?php

// app/Models/StatusPerjalanan.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusPerjalanan extends Model
{
    protected $table = 'status_perjalanan';

    protected $fillable = ['order_id', 'status'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // helper tampil badge
    public function getBadgeAttribute()
    {
        return match ($this->status) {
            'belum_dijemput' => 'badge-secondary',
            'perjalanan' => 'badge-info',
            'tiba_ditujuan' => 'badge-success',
            default => 'badge-light',
        };
    }

    public function getLabelAttribute()
    {
        return match ($this->status) {
            'belum_dijemput' => 'Belum dijemput',
            'perjalanan' => 'Perjalanan',
            'tiba_ditujuan' => 'Tiba di Tujuan',
            default => ucfirst($this->status ?? '-'),
        };
    }
}
