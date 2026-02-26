<?php

return [

    /*
    |--------------------------------------------------------------------------
    | SMS Configuration
    |--------------------------------------------------------------------------
    */
    'api_key'    => env('SMS4JAWALY_API_KEY', ''),
    'api_secret' => env('SMS4JAWALY_API_SECRET', ''),
    'base_url'   => env('SMS4JAWALY_BASE_URL', 'https://api-sms.4jawaly.com/api/v1'),
    'timeout'    => env('SMS4JAWALY_TIMEOUT', 30),

    /*
    |--------------------------------------------------------------------------
    | WhatsApp Configuration
    |--------------------------------------------------------------------------
    */
    'whatsapp' => [
        'app_key'    => env('SMS4JAWALY_WA_APP_KEY', ''),
        'api_secret' => env('SMS4JAWALY_WA_API_SECRET', ''),
        'project_id' => env('SMS4JAWALY_WA_PROJECT_ID', ''),
        'base_url'   => env('SMS4JAWALY_WA_BASE_URL', 'https://api-users.4jawaly.com/api/v1/whatsapp'),
        'timeout'    => env('SMS4JAWALY_WA_TIMEOUT', 30),
    ],

];
