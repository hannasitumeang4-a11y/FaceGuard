<?php

use Laravel\Fortify\Features;

return [

    /*
    |--------------------------------------------------------------------------
    | Fortify Guard
    |--------------------------------------------------------------------------
    */

    'guard' => 'web',

    /*
    |--------------------------------------------------------------------------
    | Fortify Password Broker
    |--------------------------------------------------------------------------
    */

    'passwords' => 'users',

    /*
    |--------------------------------------------------------------------------
    | Username / Email
    |--------------------------------------------------------------------------
    */

    'username' => 'email',

    'email' => 'email',

    /*
    |--------------------------------------------------------------------------
    | Lowercase Usernames
    |--------------------------------------------------------------------------
    */

    'lowercase_usernames' => true,

    /*
    |--------------------------------------------------------------------------
    | Home Path
    |--------------------------------------------------------------------------
    */

    'home' => '/dashboard',

    /*
    |--------------------------------------------------------------------------
    | Fortify Routes Prefix / Subdomain
    |--------------------------------------------------------------------------
    */

    'prefix' => '',

    'domain' => null,

    /*
    |--------------------------------------------------------------------------
    | Fortify Routes Middleware
    |--------------------------------------------------------------------------
    */

    'middleware' => ['web'],

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    */

    'limiters' => [
        'login' => 'login',
        'two-factor' => 'two-factor',
        'passkeys' => 'passkeys',
    ],

    /*
    |--------------------------------------------------------------------------
    | Register View Routes
    |--------------------------------------------------------------------------
    |
    | DIUBAH: true -> false
    | Halaman login & register sudah kamu buat sendiri di routes/auth.php,
    | jadi Fortify tidak perlu membuat route view-nya (menghindari bentrok
    | route GET /login dan GET /register).
    |
    */

    'views' => false,

    /*
    |--------------------------------------------------------------------------
    | Passkeys
    |--------------------------------------------------------------------------
    */

    'passkeys' => [
        'relying_party_id' => parse_url(
            config('app.url'),
            PHP_URL_HOST
        ),

        'allowed_origins' => [
            config('app.url')
        ],

        'timeout' => 60000,
    ],

    /*
    |--------------------------------------------------------------------------
    | Features
    |--------------------------------------------------------------------------
    |
    | DIUBAH: Features::registration() dinonaktifkan karena registrasi
    | sudah ditangani routes/auth.php (RegisteredUserController).
    | Features::resetPasswords() memang tidak aktif, dan harus tetap
    | begitu karena reset password memakai ForgotPasswordController.
    |
    */

    'features' => [

        // Features::registration(),

        Features::updateProfileInformation(),

        Features::updatePasswords(),

        Features::twoFactorAuthentication([
            'confirm' => true,
            'confirmPassword' => false,
        ]),

        Features::passkeys([
            'confirmPassword' => true,
        ]),
    ],
];