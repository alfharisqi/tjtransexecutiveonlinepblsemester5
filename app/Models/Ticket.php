<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Driver; // tambahkan import Driver

class Ticket extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'departure_at' => 'datetime',
        'arrival_at'   => 'datetime',
    ];

    public function getDepartureAtLocalAttribute()
    {
        return $this->departure_at?->timezone('Asia/Jakarta');
    }

    public function getArrivalAtLocalAttribute()
    {
        return $this->arrival_at?->timezone('Asia/Jakarta');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function train()
    {
        return $this->belongsTo(Train::class);
    }

    public function track()
    {
        return $this->belongsTo(Track::class);
    }

    public function price()
    {
        return $this->hasOne(Price::class);
    }

    // === BARU: relasi Driver ===
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['train_id'] ?? false, function ($query, $train_id) {
            return $query->where('train_id', '=', $train_id);
        });

        // (opsional) filter driver_id jika ingin dipakai:
        $query->when($filters['driver_id'] ?? false, function ($query, $driver_id) {
            return $query->where('driver_id', '=', $driver_id);
        });
    }
}
