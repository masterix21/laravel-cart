<?php

return [
    'models' => [
        'user' => \Illuminate\Foundation\Auth\User::class,
        'order' => \Masterix21\LaravelCart\Models\Order::class,
        'order_item' => \Masterix21\LaravelCart\Models\OrderItem::class,
    ],

    /**
     * Determs which cache store should be use: null for default.
     */
    'cache' => null,
];
