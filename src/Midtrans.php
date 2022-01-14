<?php

namespace Sawirricardo\Midtrans;

class Midtrans
{
    public static function snap()
    {
        return new \Midtrans\Snap();
    }

    public static function coreApi()
    {
        return new \Midtrans\CoreApi();
    }
}
