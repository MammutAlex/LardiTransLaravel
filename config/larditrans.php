<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Lardi-Trans Integration
    |--------------------------------------------------------------------------
    |
    | Lardi-Trans auth params
    |
    */
    'login' => env('LARDI_TRANS_LOGIN', 'YOUR-LOGIN'),
    'password' => env('LARDI_TRANS_PASSWORD', 'YOUR-PASSWORD'),

    /*
    |--------------------------------------------------------------------------
    | Is password in md5
    |--------------------------------------------------------------------------
    */
    'is_password_hash' => false,
];