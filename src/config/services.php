<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Global Vars MwSpace Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials
    |
    */

    'api' => [
        'token' => env('MWSPACE_API_TOKEN'),
    ],

    'openai' => [
        'token' => env('OPENAI_API_KEY'),
    ],

    'html' => [
        'compress' => env('MWSPACE_DISABLE_COMPRESS_HTML', true),
    ],

    'form' => [

        'inbox' => env('MAIL_CONTACT_INBOX'),

        'disable' => [
            'privacy' => env('MWSPACE_DISABLE_PRIVACY_FORM', false),
            'recaptcha' => env('MWSPACE_DISABLE_RECAPTCHA', false),
        ]
    ],

    'slack' => [
        'webhook_url' => env('LOG_SLACK_WEBHOOK_URL'),
    ],

    'google' => [
        'analytics_id' => env('GOOGLE_ANALYTICS_ID'),
        'site_verification' => env('GOOGLE_SITE_VERIFICATION'),
        'recaptcha' => [
            'key' => env('GOOGLE_RECAPTCHA_SITE_KEY'),
            'secret' => env('GOOGLE_RECAPTCHA_SECRET_KEY'),
        ]
    ],

    'iubenda' => [
        'site_id' => env('IUBENDA_SITE_ID'),
        'policy_id' => env('IUBENDA_POLICY_ID'),
        'floating' => env('IUBENDA_FLOATING_PREFERENCE','anchored-center-right'),
    ],

];
