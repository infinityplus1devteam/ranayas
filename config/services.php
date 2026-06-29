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

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'sms' => [
        'api_key' => env('SMS_API_KEY'),
        'client_id' => env('SMS_CLIENT_ID'),
        'sender_id' => env('SMS_SENDER_ID'),
        'dlt_otp_template_id' => env('SMS_DLT_OTP_TEMPLATE_ID'),
        // 'dlt_order_template_id' => env('SMS_DLT_ORDER_TEMPLATE_ID'),
        'dlt_shipped_template_id' => env('SMS_DLT_SHIPPED_TEMPLATE_ID'),
        'dlt_return_template_id' => env('SMS_DLT_RETURN_TEMPLATE_ID'),
        'dlt_cancel_template_id' => env('SMS_DLT_CANCEL_TEMPLATE_ID'),
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI'),
    ],

    // 'facebook' => [
    //     'client_id' => env('FACEBOOK_CLIENT_ID'),
    //     'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
    //     'redirect' => env('FACEBOOK_REDIRECT_URI'),
    // ],

];
