<?php

namespace Sawirricardo\Midtrans\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Sawirricardo\Midtrans\Midtrans
 */
class Midtrans extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-midtrans';
    }
}
