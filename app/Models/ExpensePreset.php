<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpensePreset extends Model
{
    protected $fillable = [
        'name',
        'vehicle_type',
        'amount',
        'is_active',
        'amortization_cycles'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
