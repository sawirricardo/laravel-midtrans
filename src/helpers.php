<?php

use Sawirricardo\Midtrans\Laravel\Facades\Midtrans as LaravelMidtrans;

if (! function_exists('midtrans')) {
    function midtrans(): \Sawirricardo\Midtrans\Midtrans
    {
        return app(LaravelMidtrans::class)::new();
    }
}
