<?php
// app/Models/Driver.php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Driver extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'drivers';

    protected $fillable = [
        'nama_driver',
        'username',
        'email',
        'password',
        'no_telepon',
        'sim',
        'foto',
    ];

    protected $hidden = ['password', 'remember_token'];

    // Opsional (Laravel 10+): otomatis hash saat set password
    // protected $casts = [
    //     'password' => 'hashed',
    // ];
}
