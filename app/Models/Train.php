<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Train extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'layout' => 'array',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
