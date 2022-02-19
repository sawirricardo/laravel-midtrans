<?php

namespace Sawirricardo\Midtrans\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Sawirricardo\Midtrans\Midtrans
 * @method static \Sawirricardo\Midtrans\Midtrans new()
 */
class Midtrans extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-midtrans';
    }
}
