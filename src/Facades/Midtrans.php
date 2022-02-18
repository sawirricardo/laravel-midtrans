<?php

namespace Sawirricardo\MidtransClient\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Sawirricardo\Midtrans\Midtrans
 * @method static \Sawirricardo\Midtrans\Midtrans client()
 */
class Midtrans extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-midtrans';
    }
}
