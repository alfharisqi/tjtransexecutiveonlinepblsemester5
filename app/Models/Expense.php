<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    // pastikan ticket_id boleh di-mass assign
    protected $fillable = [
        'date', 'ticket_id', 'category', 'amount', 'note',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    // (opsional) relasi
    public function ticket()
    {
        return $this->belongsTo(\App\Models\Ticket::class);
    }
}
