<?php

namespace Sawirricardo\Midtrans\Laravel;

class Midtrans
{
    private $client;

    public function __construct(
        $serverKey,
        $clientKey,
        $isProduction = false,
        $is3ds = false,
        $isSanitized = false
    ) {
        $this->client = new \Sawirricardo\Midtrans\Midtrans($serverKey, $clientKey, $isProduction, $is3ds, $isSanitized);
    }

    public static function makeFromConfig($config)
    {
        return new static(
            $config['is_production'] ? $config['server_key'] : $config['sandbox_server_key'],
            $config['is_production'] ? $config['client_key'] : $config['sandbox_client_key'],
            $config['is_production'],
            $config['is_3ds'],
            $config['is_sanitized']
        );
    }

    public function new(): \Sawirricardo\Midtrans\Midtrans
    {
        return $this->client;
    }

    public static function snapScripts(): string
    {
        if (config('midtrans.is_production', false)) {
            return '<script src="' . \Sawirricardo\Midtrans\Midtrans::SNAP_JS_PRODUCTION_URL . '" data-client-key="' . config('midtrans.client_key') . '"></script>';
        }

        return '<script src="' . \Sawirricardo\Midtrans\Midtrans::SNAP_JS_SANDBOX_URL . '" data-client-key="' . config('midtrans.sandbox_client_key') . '"></script>';
    }

    public static function cardScripts($scriptId = "midtrans-script"): string
    {
        return '<script type="text/javascript"
        src="https://api.midtrans.com/v2/assets/js/midtrans-new-3ds.min.js"
        id="' . $scriptId . '"
        data-environment="' . (config('midtrans.is_production', false) ? 'production' : 'sandbox') . '"
        data-client-key="' . config('midtrans.is_production', false) ? config('midtrans.client_key') : config('midtrans.sandbox_client_key') . '"></script>';
    }
}
