<?php

use Sawirricardo\Midtrans\Laravel\Facades\Midtrans as LaravelMidtrans;
use Sawirricardo\Midtrans\Laravel\Midtrans;

if (!function_exists('midtrans')) {
    function midtrans(): Midtrans
    {
        return app(LaravelMidtrans::class)::new();
    }
}
