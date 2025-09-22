<?php

return [

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'admin' => [
            'driver' => 'session',
            'provider' => 'Admins',
        ],
        // Define the seller admin guard
        'seller-admin' => [
            'driver' => 'session',
            'provider' => 'seller_admins', // Make sure to define this provider later
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
        'Admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],
        'seller_admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\SellerAdmin::class, // Make sure you have this model
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
        'admins' => [
        'provider' => 'Admins',
        'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
        'expire' => 60,
        'throttle' => 60,
    ],
    'selleradmins' => [
        'provider' => 'SellerAdmins',
        'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
        'expire' => 60,
        'throttle' => 60,
    ],
    ],

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),
];

