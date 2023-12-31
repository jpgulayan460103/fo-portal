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

    'ad' => [
        'host' => env('AD_HOST'),
        'domain' => env('AD_DOMAIN'),
        'search' => env('AD_SEARCH'),
        'default_password' => env('AD_DEFAULT_PASSWORD'),
    ],

    'google' => [
        'client_id' => env('GOOGLE_AUTH_CLIENT_ID'),
        'client_secret' => env('GOOGLE_AUTH_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_AUTH_REDIRECT_URL'),
    ],

    'sms' => [
        'gateway' => env('SMS_GATEWAY_URL'),
        'api_key' => env('SMS_API_KEY'),
        'client_id' => env('SMS_CLIENT_ID'),
        'sender_id' => env('SMS_SENDER_ID'),
    ]

];
