<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'hcaptcha' => [
        'site_key'  =>  env('HCAPTCHA_SITE_KEY'),
        'secret'    =>  env('HCAPTCHA_SECRET'),
    ],
    'google' => [
        'client_id' => env('OAUTH_GOOGLE_CLIENTID'),
        'client_secret' => env('OAUTH_GOOGLE_SECRET'),
        'redirect' => env('OAUTH_GOOGLE_REDIRECT_URL'),
    ],
];
