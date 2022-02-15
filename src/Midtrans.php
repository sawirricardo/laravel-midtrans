<?php

namespace Sawirricardo\Midtrans;

class Midtrans
{
    public const SANDBOX_BASE_URL = 'https://api.sandbox.midtrans.com';
    public const PRODUCTION_BASE_URL = 'https://api.midtrans.com';
    public const SNAP_SANDBOX_BASE_URL = 'https://app.sandbox.midtrans.com/snap/v1';
    public const SNAP_PRODUCTION_BASE_URL = 'https://app.midtrans.com/snap/v1';
    public const SNAP_JS_SANDBOX_URL = 'https://app.sandbox.midtrans.com/snap/snap.js';
    public const SNAP_JS_PRODUCTION_URL = 'https://app.midtrans.com/snap/snap.js';

    public function __construct()
    {
        \Midtrans\Config::$isProduction = config('midtrans.is_production', false);
        if (config('midtrans.is_production')) {
            \Midtrans\Config::$serverKey = config('midtrans.server_key');
            \Midtrans\Config::$clientKey = config('midtrans.client_key');
        } else {
            \Midtrans\Config::$serverKey = config('midtrans.sandbox_server_key');
            \Midtrans\Config::$clientKey = config('midtrans.sandbox_client_key');
        }
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized', true);
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds', true);
        if (! is_null(config('midtrans.append_notif_url'))) {
            \Midtrans\Config::$isProduction = config('midtrans.append_notif_url');
        }
        if (! is_null(config('midtrans.overrideNotifUrl'))) {
            \Midtrans\Config::$overrideNotifUrl = config('midtrans.overrideNotifUrl');
        }
        if (! is_null(config('midtrans.payment_idempotency_key'))) {
            \Midtrans\Config::$paymentIdempotencyKey = config('midtrans.payment_idempotency_key');
        }
        if (! is_null(config('midtrans.curl_options'))) {
            \Midtrans\Config::$curlOptions = config('midtrans.curl_options');
        }
    }

    public static function snap()
    {
        return new Snap();
    }

    public function coreApi()
    {
        return new \Midtrans\CoreApi();
    }

    public function notification($inputSource = 'php://input')
    {
        return new \Midtrans\Notification($inputSource);
    }

    public function transaction()
    {
        new static();

        return new \Midtrans\Transaction();
    }

    public function sanitizer()
    {
        return new \Midtrans\Sanitizer();
    }

    public static function make()
    {
        return new static();
    }

    protected function getSignatureKey($orderId, $statusCode, $grossAmount)
    {
        $serverKey = config('midtrans.is_production') ? config('midtrans.server_key') : config('midtrans.sandbox_server_key');

        return openssl_digest(join('', [$orderId, $statusCode, $grossAmount, $serverKey]), 'sha512');
    }

    public function verifyNotification($notification)
    {
        return hash_equals($notification['signature_key'], $this->getSignatureKey($notification['order_id'], $notification['status_code'], $notification['gross_amount']));
    }

    public static function snapScripts()
    {
        if (config('midtrans.is_production', false)) {
            return '<script src="' . self::SNAP_JS_PRODUCTION_URL . '" data-client-key="' . config('midtrans.client_key') . '"></script>';
        }

        return '<script src="' . self::SNAP_JS_SANDBOX_URL . '" data-client-key="' . config('midtrans.sandbox_client_key') . '"></script>';
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
