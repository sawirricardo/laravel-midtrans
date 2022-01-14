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

    public static function notification()
    {
        return new \Midtrans\Notification;
    }

    public static function transaction()
    {
        return new \Midtrans\Transaction;
    }

    public static function sanitizer()
    {
        return new \Midtrans\Sanitizer;
    }

    public static function snapScripts()
    {
        if (config('midtrans.is_production', false)) {
            return '<script src="https://app.midtrans.com/snap/snap.js" data-client-key="' . config('midtrans.client_key') . '"></script>';
        }

        return '<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="' . config('midtrans.sandbox_client_key') . '"></script>';
    }

    public static function cardScripts($scriptId = "midtrans-script")
    {
        return '<script type="text/javascript"
        src="https://api.midtrans.com/v2/assets/js/midtrans-new-3ds.min.js"
        id="' . $scriptId . '"
        data-environment="' . (config('midtrans.is_production', false) ? 'production' : 'sandbox') . '"
        data-client-key="' . config('midtrans.is_production', false) ? config('midtrans.client_key') : config('midtrans.sandbox_client_key') . '"></script>';
    }
}
