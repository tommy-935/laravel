<?php
return [
    'sandbox_client_id' => env('PAYPAL_SANDBOX_CLIENT_ID'),
    'sandbox_client_secret' => env('PAYPAL_SANDBOX_CLIENT_SECRET'),
    'client_id' => env('PAYPAL_LIVE_CLIENT_ID'),
    'client_secret' => env('PAYPAL_LIVE_CLIENT_SECRET'),
    'mode' => env('PAYPAL_MODE', 'sandbox'), // 可选值: live 或 sandbox
];
