<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Auth
    |--------------------------------------------------------------------------
    */
    'defaults' => [
        'guard'     => 'web',
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    | web  : user aplikasi (admin/customer)
    | driver: akun driver (login terpisah)
    */
    'guards' => [
        'web' => [
            'driver'   => 'session',
            'provider' => 'users',
        ],

        'driver' => [
            'driver'   => 'session',
            'provider' => 'drivers',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    | Pastikan model Driver extends Authenticatable.
    */
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model'  => App\Models\User::class,
        ],

        'drivers' => [
            'driver' => 'eloquent',
            'model'  => App\Models\Driver::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Reset Brokers
    |--------------------------------------------------------------------------
    | Jika ingin fitur reset password khusus driver, gunakan broker 'drivers'.
    | Untuk Laravel 10+, table default reset token adalah 'password_reset_tokens'.
    */
    'passwords' => [
        'users' => [
            'provider' => 'users',
            // Sesuaikan dengan versi Laravel kamu:
            // 'table' => 'password_reset_tokens', // Laravel 10+
            'table'    => 'password_resets',       // Laravel <10
            'expire'   => 180,
            'throttle' => 60,
        ],

        'drivers' => [
            'provider' => 'drivers',
            // 'table' => 'password_reset_tokens',  // Laravel 10+
            'table'    => 'password_resets',        // Laravel <10
            'expire'   => 180,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    */
    'password_timeout' => 10800,

];
