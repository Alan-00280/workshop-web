<?php

return [
    'sandbox_server_key' => env('SERVER_MIDTRANS_KEY'),
    'sandbox_client_key' => env('MIDTRANS_SB_CLIENT_KEY'),

    'is_production' => false,
    'is_sanitized' => true,
    'is_3ds' => true,

    'append_notif_url' => null,
    'overrideNotifUrl' => null,
    'payment_idempotency_key' => null,

    'curl_options' => null,
];