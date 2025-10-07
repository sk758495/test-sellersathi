<?php

return [
    'hdfc' => [
        'api_key' => env('HDFC_API_KEY', 'EC285E7792F4395BEBF026D2B48991'),
        'merchant_id' => env('HDFC_MERCHANT_ID', 'SG3589'),
        'payment_page_client_id' => env('HDFC_PAYMENT_PAGE_CLIENT_ID', 'hdfcmaster'),
        'base_url' => env('HDFC_BASE_URL', 'https://smartgatewayuat.hdfcbank.com'),
        'response_key' => env('HDFC_RESPONSE_KEY', '644422D1B204FCFB1AFE95C9DAC8CE'),
        'enable_logging' => env('HDFC_ENABLE_LOGGING', true),
        'logging_path' => env('HDFC_LOGGING_PATH', storage_path('logs/payment.log')),
        'timeout' => [
            'connection' => 30,
            'request' => 120,
            'upi' => 180,
            'card' => 150
        ],
        'retry' => [
            'attempts' => 3,
            'delay' => 2000
        ]
    ]
];