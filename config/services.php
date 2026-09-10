<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and LigdiCash.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    /*
    |--------------------------------------------------------------------------
    | LigdiCash
    |--------------------------------------------------------------------------
    */

    'ligdicash' => [
        'base_url' => env(
            'LIGDICASH_BASE_URL',
            'https://app.ligdicash.com'
        ),

        'api_key' => env('LIGDICASH_API_KEY'),

        'api_token' => env('LIGDICASH_API_TOKEN'),

        'callback_url' => env('LIGDICASH_CALLBACK_URL'),

        'return_url' => env('LIGDICASH_RETURN_URL'),

        'cancel_url' => env('LIGDICASH_CANCEL_URL'),
    ],

];