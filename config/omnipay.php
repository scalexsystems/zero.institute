<?php return [
    'default' => 'razorpay',

    'gateways' => [
        'razorpay' => [
            'driver' => 'Razorpay_Checkout',
            'key_id' => env('RAZORPAY_KEY'),
            'key_secret' => env('RAZORPAY_SECRET'),
        ],
    ],
];
